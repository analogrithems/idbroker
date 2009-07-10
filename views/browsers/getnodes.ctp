<?php

$data = array();

$i = 0;
foreach ($nodes as $node){
        $data[$i]['attributes'] = array( 'id' => $node['Browser']['dn'], 'class' => $node['Browser']['class'] );
        $data[$i]['data'] = array( 'title' =>$node['Browser']['name'], 'class' => $node['Browser']['class']);
        if(isset($node['Browser']['state']) && !empty($node['Browser']['state'])){
        	$data[$i]['state'] = $node['Browser']['state'];
        }
        $i++;
}

echo $javascript->object($data);

?>
