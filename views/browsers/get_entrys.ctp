<?php

$data = array();
$entrys = $this->data;

foreach ($entrys as $entry){
	$entry = $entry['Browser'];
	if(isset($entry['displayname'])){
		$label = $entry['displayname'];
	}elseif(isset($entry['cn'])){
                $label = $entry['cn'];
        }elseif(isset($entry['uid'])){
                $label = $entry['uid'];
        }
	$dn = $entry['dn'];
	$data[$dn] = $label;
       
}

echo $javascript->object($data);

?>
