<?php

$data = array();

$i = 0;
foreach ($nodes as $node){
        $data[$i]['data'] = array( 'title' =>$node['Browser']['name'], 'class' => $node['Browser']['class']);
        if(isset($node['Browser']['state']) && !empty($node['Browser']['state'])){
        	$data[$i]['state'] = $node['Browser']['state'];
        }

	$data[$i]['attributes']['id'] = $node['Browser']['dn'];
	$data[$i]['attributes']['class'] = $node['Browser']['class'];
	if(isset($node['Browser']['nsaccountlock']) && !empty($node['Browser']['nsaccountlock']) ){
		$data[$i]['attributes']['lock'] = $node['Browser']['nsaccountlock'];
	}
	
	if(isset($node['Browser']['userpassword']) && !empty($node['Browser']['userpassword'])){
		$data[$i]['attributes']['hasPassword'] = 'true';
        }else{
		$data[$i]['attributes']['hasPassword'] = 'false';
        }
		
        $i++;
}

echo $javascript->object($data);

?>
