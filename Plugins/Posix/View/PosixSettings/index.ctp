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
	
	echo $this->Form->input('autouidnumber', array('label'=>'Auto-Generate User Id Number?', 'type'=>'checkbox'));
	echo $this->Form->input('uidnumbermin', array('label'=>'Minimum ID number for user ID'));
	echo $this->Form->input('uidnumbermax', array('label'=>'Maximum ID number for user ID'));
	echo $this->Form->input('syncwithuniquemember', array('label'=>'Keep Unix group members in sync with LDAP Group Members', 'type'=>'checkbox'));
	echo $this->Form->input('autogidnumber', array('label'=>'Auto-Generate Group Id Number?', 'type'=>'checkbox'));
	echo $this->Form->input('gidnumbermin', array('label'=>'Minimum group ID number'));
	echo $this->Form->input('gidnumbermax', array('label'=>'Maximum group ID number'));
	echo $this->Form->end('Update');
?>
