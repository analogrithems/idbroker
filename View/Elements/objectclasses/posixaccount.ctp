<?php
	echo "<div id='$objectclass'>";
	echo $this->Ajax->form('edit','post',array('model'=>substr($this->name,0,-1),'update'=>'dndisplay'));
	echo $this->Form->input('dn', array('type'=>'hidden'));

	echo $this->Form->input('description', array('title'=>'Provides a human-readable description of the object. For people and organizations this often includes their role or work assignment.'));

	echo $this->Form->input('gecos', array('label'=>'Display Name(gecos)', 'title'=>'The gecos field (also written as GECOS field, standing for General Electric Comprehensive Operating System) is an entry in the /etc/passwd file on Unix operating systems that is typically used to record general information about the account or its user(s). Exact information depends on the Unix variant, but for example it may contain real name and phone number.'));

	echo $this->Form->input('uid', array('label'=>'User Name', 'div'=>'required', 'title'=>'Identifies the entry\'s userid (usually the logon ID). Abbreviation: uid. For example: userid: banderson  or uid: banderson '));

	echo $this->Form->input('loginshell', array('label'=>'Unix Shell', 'div'=>'required', 'title'=>'The path to the login shell. For example: loginShell: /bin/bash'));

	echo $this->Form->input('homedirectory', array('label'=>'Home Directory', 'div'=>'required', 'title'=>'The home directory of the account. For example: homeDirectory: /home/bsmith'));

	echo $this->Form->input('uidnumber', array('label'=> 'User ID Number', 'div'=>'required', 'title'=>'UNIX only. Related to the /etc/shadow file, this attribute specifies the user\'s login ID.'));

	echo $this->Form->input('gidnumber', array('label'=> 'Group ID Number', 'div'=>'required', 'title'=>'Group ID number. For example: gidNumber: 162035'));

	echo $this->Form->end('Update');
                echo "</div>";
?>
