<?php
	echo $ajax->form(array('type' => 'post',
	    'options' => array(
	        'model'=>'PosixSetting',
	        'update'=>'posix_settings',
	        'url' => array(
	            'controller' => 'PosixSettings',
	            'action' => 'index'
	         )
		)
	));
	
	echo $form->input('autouidnumber', array('label'=>'Auto-Generate User Id Number?', 'type'=>'checkbox'));
	echo $form->input('uidnumbermin', array('label'=>'Minimum ID number for user ID'));
	echo $form->input('uidnumbermax', array('label'=>'Maximum ID number for user ID'));
	echo $form->input('syncwithuniquemember', array('label'=>'Keep Unix group members in sync with LDAP Group Members', 'type'=>'checkbox'));
	echo $form->input('autogidnumber', array('label'=>'Auto-Generate Group Id Number?', 'type'=>'checkbox'));
	echo $form->input('gidnumbermin', array('label'=>'Minimum group ID number'));
	echo $form->input('gidnumbermax', array('label'=>'Maximum group ID number'));
	echo $form->end('Update');
?>
