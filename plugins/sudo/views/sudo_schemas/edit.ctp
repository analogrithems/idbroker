<style type="text/css">

#uniqueMemberSelectBox {
        clear: none;
        text-align: center;
        margin: 10px;
        white-space: nowrap;
}
</style>

<?php

	$model = substr($this->name,0,-1);
	function listPrep( $lists){

	   foreach($lists as $key => $value){
		if(count($lists[$key]) == 0){
			continue;
		}else{
			if(is_array($lists[$key])){
				foreach($lists[$key] as $item){
					if(!is_array($item)){
						$nlist[$item] = $item;
					}else{
						foreach($item as $k =>$v){
							$nlist[$item[$k]] = $v;
						}
					}
				}
			}elseif(!is_array($lists[$key])){
				$nlist[$lists[$key]] = $lists[$key];
			}

			if(isset($nlist) && !empty($nlist)){ 
				$lists[$key] = $nlist; 
				unset($nlist);
			}
		}
	   }
	   return $lists;
					
	}
	function selectColumns( $name, $form, $label, $model, $list){

		$nonmemberid = $model.'Non'.$name;
		$memberid = $model.ucfirst($name);
		$hrefadd = $name.'Add';
		$hrefsub = $name.'Sub';

		$labelID = $name.'BlockContainer';
		echo "<label for='".$labelID."' class='selectbox'>$label</label>\n";
		echo "<div id='".$labelID."' class='groupSelect'>\n";
		
?>
		<script type="text/javascript">
			$().ready(function() {
				$('#<?php echo $hrefadd;?>').click(function() {
					return !$('#<?php echo $nonmemberid;?>  option:selected').remove().appendTo('#<?php echo $memberid;?>');
				});
		
				$('#<?php echo $hrefsub;?>').click(function() {
					return !$('#<?php echo $memberid;?>  option:selected').remove().appendTo('#<?php echo $nonmemberid;?>');
				});
			});

		</script>
<?php

		echo "<div id='Not".$name."Div' class='nonmemberSelect'>\n";
		echo $form->input($model.'.non'.$name, array( 'type' => 'select', 'multiple' => 'true', 'label' => 'Not Allowed', 'options'=>$list['notin']));
		echo "<a href='#' id='".$hrefadd."'> add &gt;&gt;</a>\n";
		echo "</div>\n\n";

		$ucname = ucfirst($name);
		echo "<div id='".$name."Div' class='memberSelect'>\n";
		echo $form->input($model.'.'.$name, array( 'type' => 'select', 'multiple' => 'true', 'label' => 'Allowed', 'options'=>$list['allowed']));
		echo "<a href='#' id='".$hrefsub."'> &lt;&lt; Remove</a>\n";
		echo "</div>\n";
		echo "</div>\n\n";
	}

	echo $ajax->form(array('type' => 'post',
	    'options' => array(
	        'model'=>'SudoSchema',
	        'update'=>'sudorole',
	        'url' => array(
	            'controller' => 'SudoSchemas',
	            'action' => 'edit'
	         )
		)
	));

	echo $form->input('dn', array('type'=>'hidden'));
	echo $form->input('cn', array('label'=> 'Name', 'div'=>'required', 'title'=>'A single word name for the description.'));
	echo $form->input('description', array('title'=>'Provides a human-readable description of the Sudo Role. For example: These users can reset passwords for other people.'));
	echo $form->input('sudocommand', array('label'=>'Command', 'title'=>'The command that people in this sudo role can run.  For example: /usr/bin/passwd or ALL for all commands'));
	echo $form->input('sudorunasuser', array('label'=> 'Run As User', 'title'=>'A user name or uid (prefixed with \'#\') that commands may be run as or a Unix group (prefixed with a \'%\') or user netgroup (prefixed with a \'+\') that contains a list of users that commands may be run as. The special value ALL will match any user.'));


?>
	<script type="text/javascript">
	
		function submitSelected(){
			$(".memberSelect").each(function(){
				$(".memberSelect option").attr("selected","selected");
			}) ;
			return true;
		}
	</script>
<div id="sudoSelectBox">
<?php
	$user = listPrep( array('notin'=>$sudousers, 'allowed'=>$this->data['SudoSchema']['sudouser']));
	selectColumns('sudouser', $form, 'Users & Groups in this Role', $model, $user);

	$group = listPrep(array('notin'=>$sudogroups, 'allowed'=>$this->data['SudoSchema']['sudorunasgroup']));
	selectColumns('sudogrunasgroup', $form, 'A Group This Role Can Be Run As', $model, $group);

	$computer = listPrep( array('notin'=>$sudohosts, 'allowed'=>$this->data['SudoSchema']['sudohost']));
	selectColumns('sudohost', $form, 'Computers This Role Applys to',$model, $computer);
?>
</div>
<?php
	echo $form->end('Update');
?>
