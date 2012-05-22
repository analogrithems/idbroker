<?php

$data = array();

$i = 0;
foreach ($nodes as $node){
        $data[$i]['data']['title'] = $node['Browser']['name'];
        $data[$i]['metadata']['title'] = $node['Browser']['name'];
        if(isset($node['Browser']['state']) && !empty($node['Browser']['state'])){
        	$data[$i]['state'] = $node['Browser']['state'];
        }

	$data[$i]['metadata']['id'] = $node['Browser']['dn'];
	$class = array('OU'=>'ui-icon-folder-collapsed', 'CN'=>'ui-icon-person', 'locked'=>'ui-icon-locked');
	$data[$i]['metadata']['class'][] = 'ui-icon';
	foreach($node['Browser']['class'] as $k=>$v){
		if(isset($class[$v])) $data[$i]['metadata']['class'][] = $class[$v];
		else $data[$i]['metadata']['class'][] = $v;
	}

	if(isset($node['Browser']['nsaccountlock']) && !empty($node['Browser']['nsaccountlock'])){
		$data[$i]['metadata']['lock'] = 'true';
	}elseif(isset($node['Browser']['adaccountlock']) && $node['Browser']['adaccountlock'] == true ){
		$data[$i]['metadata']['lock'] = 'true';
	}

	if(isset($node['Browser']['userpassword']) && !empty($node['Browser']['userpassword'])){
		$data[$i]['metadata']['hasPassword'] = 'true';
        }else{
		$data[$i]['metadata']['hasPassword'] = 'false';
        }
	$data[$i]['children'] = false;
		
        $i++;
}

echo $javascript->object($data);

?>
