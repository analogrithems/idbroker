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

	$user = listPrep( array('notin'=>$sudousers, 'allowed'=>$sudoRole['sudouser']));
	selectColumns('sudouser', $form, 'Users & Groups in this Role', $model, $user);

	$group = listPrep(array('notin'=>$sudogroups, 'allowed'=>$sudoRole['sudorunasgroup']));
	selectColumns('sudogrunasgroup', $form, 'A Group This Role Can Be Run As', $model, $group);

	$computer = listPrep( array('notin'=>$sudohosts, 'allowed'=>$sudoRole['sudohost']));
	selectColumns('sudohost', $form, 'Computers This Role Applys to',$model, $computer);

?>
	<script type="text/javascript">
	
		function submitSelected(){
			$(".memberSelect").each(function(){
				$(".memberSelect option").attr("selected","selected");
			}) ;
			return true;
		}
	</script>
