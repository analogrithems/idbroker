<div id="posixaccount">
<?php
	echo $ajax->form(array('type' => 'post',
	    'options' => array(
	        'model'=>'PosixaccountSchema',
	        'update'=>'posixaccount',
	        'url' => array(
	            'controller' => 'PosixaccountSchemas',
	            'action' => 'edit'
	         )
		)
	));
	$shells = array('/bin/bash'=>'Bash', '/bin/csh'=>'Csh', '/bin/tcsh'=>'Tcsh', '/bin/sh'=>'Sh', '/bin/ksh'=>'Ksh', '/usr/lib/sftp-server'=>'Sftp-only');
	echo $this->Form->input('dn', array('type'=>'hidden'));
	echo $this->Form->input('description', array('length'=>100, 'title'=>'Provides a human-readable description of the object. For people and organizations this often includes their role or work assignment.'));
	echo $this->Form->input('gecos', array('label'=>'Display Name(gecos)', 'length'=>100, 'title'=>'The gecos field (also written as GECOS field, standing for General Electric Comprehensive Operating System) is an entry in the /etc/passwd file on Unix operating systems that is typically used to record general information about the account or its user(s). Exact information depends on the Unix variant, but for example it may contain real name and phone number.'));
	echo $this->Form->input('uid', array('label'=>'User Name', 'length'=>50, 'div'=>'required', 'title'=>'Identifies the entry\'s userid (usually the logon ID). Abbreviation: uid. For example: userid: banderson  or uid: banderson '));
	echo $this->Form->input('loginshell', array('label'=>'Login Shell', 'div'=> 'required', 'options'=>$shells, 'title'=>'Unix Shell You Are Most Comfortable With.'))."\n";
	echo $this->Form->input('homedirectory', array('label'=>'Home Directory', 'length'=>70, 'div'=>'required', 'title'=>'The home directory of the account. For example: homeDirectory: /home/bsmith'));
	echo $this->Form->input('uidnumber', array('label'=> 'User ID Number', 'length'=>10,'div'=>'required', 'title'=>'UNIX only. Related to the /etc/shadow file, this attribute specifies the user\'s login ID.'));
	echo $this->Form->input('gidnumber', array('label'=> 'Default Group', 'div'=>'required', 'options'=>$groups, 'title'=>'Group ID number. For example: gidNumber: 162035'));
	echo $this->Form->end('Update');
?>
</div>