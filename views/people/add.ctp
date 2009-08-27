<div id="Forms">
<?php
	$shells = array('/bin/bash'=>'Bash', '/bin/csh'=>'Csh', '/bin/tcsh'=>'Tcsh', '/bin/sh'=>'Sh', '/bin/ksh'=>'Ksh', '/usr/lib/sftp-server'=>'Sftp-only');
	echo $form->create('Person')."\n";

	echo $form->input('cn', array('label'=> 'Display Name', 'div'=> 'required', 'title'=>'A single word name for the description.'))."\n";

	echo $form->input('givenname', array('label'=>'First Name', 'title'=> 'The account Holders first name.'))."\n";

	echo $form->input('sn', array('label'=>'Last Name', 'div'=> 'required', 'title'=> 'The account Holders last/family name.'))."\n";

	echo $form->input('uid', array('label'=>'User Name', 'div'=> 'required',  'title'=>'Account login name, ex: jdoe'))."\n";

	echo $form->input('mail', array('label'=>'Email Address', 'div'=> 'required',  'title'=>'Peoples contact email address.'))."\n";

	echo $form->input('uidnumber', array('label'=>'User ID Number', 'div'=> 'required',  'title'=>'Unix Style People ID Number.'))."\n";

	echo $form->input('gidnumber', array('label'=>'Default Group', 'div'=> 'required', 'options'=>$groups, 'title'=>'Unix Style Group ID Number.'))."\n";
        
	echo $form->input('loginshell', array('label'=>'Login Shell', 'div'=> 'required', 'options'=>$shells, 'title'=>'Unix Shell You Are Most Comfortable With.'))."\n";

	echo $form->input('password', array('label'=>'Password',  'type'=>'password', 'div'=> 'required',  'title'=>'Super Secret People Password'))."\n";

	echo $form->input('password_confirm', array('label'=>'Re-Type Password', 'type'=>'password', 'div'=> 'required',  'title'=>'Super Secret People Password'))."\n";
	echo $form->end('Create User')."\n";
?>
</div>
