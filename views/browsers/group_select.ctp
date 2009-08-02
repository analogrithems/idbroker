<?php

	function getOptions( $lists, $type = null ){
		if(empty($lists)){ return; }
		if(is_array($lists)){
			foreach($lists as $item){
				if(isset($item['displayname'])){
					$label = $item['displayname'];
				}elseif(isset($item['cn'])){
					$label = $item['cn'];
				}elseif(isset($item['uid'])){
					$label = $item['uid'];
				}else{
					$label = $item['dn'];
				}
				if($type=='groupofuniquenames'){
					$data[$item['dn']] = $label;
				}elseif($type == 'posixgroup'){
					$data[$item['uid']] = $label;
				}
			}
		}else{
			if(isset($lists['displayname'])){
				$label = $lists['displayname'];
			}elseif(isset($lists['cn'])){
				$label = $lists['cn'];
			}elseif(isset($lists['uid'])){
				$label = $lists['uid'];
			}else{
				$label = $lists['dn'];
			}

			if($type=='groupofuniquenames'){
				$data[$lists['dn']] = $label;
			}elseif($type == 'posixgroup'){
				$data[$lists['uid']] = $label;
			}
			$data[$lists['dn']] = $label;
		}
		return $data;
	} 

	if($type == 'groupofuniquenames'){
		$attr = 'uniquemember';
	}elseif($type == 'posixgroup'){
		$attr = 'memberuid';
	}
	$model = substr($this->name,0,-1);
	$nonmemberid = $model.'Non'.$attr;
	$memberid = $model.ucwords($attr);


	$members = getOptions(isset($groups['members']) ? $groups['members'] : null, $type);
	$nonmembers = getOptions(isset($groups['nonmembers']) ? $groups['nonmembers'] : null, $type);
?>
	<script type="text/javascript">
	
		$().ready(function() {
			$('#<?php echo $attr;?>add').click(function() {
				return !$('#<?php echo $nonmemberid;?> option:selected').remove().appendTo('#<?php echo $memberid;?>');
			});
			$('#<?php echo $attr;?>remove').click(function() {
				return !$('#<?php echo $memberid;?> option:selected').remove().appendTo('#<?php echo $nonmemberid;?>');
			});
		});
		function select<?php echo $memberid;?>(){
			$("#<?php echo $memberid;?>").each(function(){
				$("#<?php echo $memberid;?> option").attr("selected","selected");
			}) ;
			return true;
		}
	</script>

	<style type="text/css">
		div.memberSelect{
			display: inline;
			clear: none;
			float: left;
		}

		select#<?php echo $nonmemberid;?>, select#<?php echo $memberid;?> {
			width: 250px;
			height: 250px;
		}
	</style>
	<div id="DivNotMembers" class="memberSelect">  
		<?php echo $form->input($model.'.non'.$attr, array( 'type' => 'select', 'multiple' => 'true', 'label' => 'Non-Members', 'options'=>$nonmembers)); ?>
		<a href="#" id="<?php echo $attr;?>add">add &gt;&gt;</a>  
	</div>  
	<div id="DivMembers" class="memberSelect">  
		<?php echo $form->input($model.'.'.$attr, array( 'type' => 'select', 'multiple' => 'true', 'label' => 'Members', 'options'=>$members)); ?>
		<a href="#" id="<?php echo $attr;?>remove">&lt;&lt; remove</a>  
	</div> 
