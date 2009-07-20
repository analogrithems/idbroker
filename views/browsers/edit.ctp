<div id="Forms">
<?php

//Should probably create a form per object class and each one in a tab

$user = $this->data['Browser'];
$dn = $this->data['Browser']['dn'];

//This just generates the tab headers
	echo "<ul>";
	if(is_array($user['objectclass'])){
		foreach($user['objectclass'] as $objectclass){
			$objectclass = strtolower($objectclass);
			if($objectclass != 'top'){
				
				if(isset($schemaPlugin[$objectclass]['label']) && !empty($schemaPlugin[$objectclass]['label']) ){
					$label = $schemaPlugin[$objectclass]['label'];
				}else{
					$label = $objectclass;
				}
		
				echo "<li><a href='#$objectclass'><span>$label</span></a></li>";
			}
		}
	}else{
		$objectclass = strtolower($user['objectclass']);
		if($objectclass != 'top'){
			
			if(isset($schemaPlugin[$objectclass]['label']) && !empty($schemaPlugin[$objectclass]['label']) ){
				$label = $schemaPlugin[$objectclass]['label'];
			}else{
				$label = $objectclass;
			}
	
			echo "<li><a href='#$objectclass'><span>$label</span></a></li>";
		}
	}
	echo "</ul>";

	if(is_array($user['objectclass'])){
		foreach($user['objectclass'] as $objectclass){
			$objectclass = strtolower($objectclass);
			if($objectclass != 'top'){
				if(isset($schemaPlugin[$objectclass]['name']) && !empty($schemaPlugin[$objectclass]['name']) ){
					$name = $schemaPlugin[$objectclass]['name'];
					$plugin = $schemaPlugin[$objectclass]['plugin'];
					$path = '/'.$plugin.'/'.ucfirst($name).'Schemas/edit/'.$dn;
					$this->log("requestaction for $path",'debug');
					$schemaEdit =  $this->requestAction(
						$path,
						array('return'=>false)
					);
					print "<div id='$objectclass'>\n";
					print $schemaEdit;
					print "</div>\n";
				}else{
					//Right Here is where to create check for and insert plugins per objectClass
					print $this->element('objectclass', array('objectclass'=>$objectclass, 'schemas'=>$schemas), true);
				}
			}
		}
	}else{
		$objectclass = strtolower($user['objectclass']);
		if($objectclass != 'top'){
			if(isset($schemaPlugin[$objectclass]['name']) && !empty($schemaPlugin[$objectclass]['name']) ){
				$name = $schemaPlugin[$objectclass]['name'];
				$plugin = $schemaPlugin[$objectclass]['plugin'];
				$path = '/'.$plugin.'/'.ucfirst($name).'Schemas/edit/'.$dn;
				$this->log("requestaction for $path",'debug');
				$schemaEdit =  $this->requestAction(
					$path,
					array('return'=>false)
				);
				print "<div id='$objectclass'>\n";
				print $schemaEdit;
				print "</div>\n";
			}else{
				//Right Here is where to create check for and insert plugins per objectClass
				print $this->element('objectclass', array('objectclass'=>$objectclass, 'schemas'=>$schemas), true);
			}
		}		
	}
?>
</div>
<span id='editdn'><b>Current DN: <?php echo $dn; ?></b></span>
<script type="text/javascript">
        $(function() {
                <!-- This is for form editing -->
                $("#Forms").tabs();
		getMsg();
	});
</script>
