<?php
	echo $ajax->form(array('type' => 'post',
	    'options' => array(
	        'model'=>'QmailSetting',
	        'update'=>'qmail_settings',
	        'url' => array(
	            'controller' => 'QmailSettings',
	            'action' => 'index'
	         )
		)
	));
	
	echo $this->Form->input('syncwithuidnumber', array('label'=>'Keep Qmail uidnumber in sync with Unix uidnumber', 'type'=>'checkbox'));
	echo $this->Form->input('qmailvhostuid', array('label'=>'Use the same User ID Number for all users (Virtual Hosting)'));
	echo $this->Form->input('syncwithgidnumber', array('label'=>'Keep Qmail Group ID Number in sync with Unix Group ID Number', 'type'=>'checkbox'));
	echo $this->Form->input('qmailvhostgid', array('label'=>'Use the same Group ID Number for all users (Virtual Hosting)'
	echo $this->Form->end('Update');
?>