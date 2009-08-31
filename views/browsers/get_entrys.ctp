<?php

$data = array();
$entrys = $this->data;

foreach ($entrys as $entry){
	$entry = $entry['Browser'];
	$this->log("get_entry:".print_r($entry,true),'debug');
	if(isset($entry['displayname'])){
		$label = $entry['displayname'];
	}elseif(isset($entry['cn']) && isset($entry['uid'])){
                $label = $entry['cn']." \ ".$entry['uid'];
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
