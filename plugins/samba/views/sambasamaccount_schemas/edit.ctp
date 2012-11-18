<div id="sambasamaccount">
<?php
	echo $ajax->form(array('type' => 'post',
	    'options' => array(
	        'model'=>'SambasamaccountSchema',
	        'update'=>'sambasamaccount',
	        'url' => array(
	            'controller' => 'SambasamaccountSchemas',
	            'action' => 'edit'
	         )
		)
	));
	
	$letters = array ("A:","B:","D:","E:","F:","G:","H:","I:","J:","K:","L:","M:","N:","O:","P:","Q:","R:","S:","T:","U:","V:","W:","X:","Y:","Z:");
	echo $form->input('homedrive',array('label'=> 'Home Drive Letter', 'div'=>'required', 'options'=>$letters, 'title'=>'Specifies the drive letter to which to map the UNC path specified by homeDirectory.'));
	echo $form->input('isdisabled', array('type'=> 'checkbox', 'label'=>'Account Is Disabled'));
	echo $form->input('nopasswordexpire', array('type'=> 'checkbox', 'label'=>'Password Doesn\'t Expires'));
	echo $form->input('scriptpath', array('label'=>'Login Script', 'title'=>"The scriptPath property specifies the path of the user's logon script, .CMD, .EXE, or .BAT file. The string can be null. The path is relative to the netlogon share. Refer to the 'logon script' parameter in the smb.conf(5) man page for more information."));
	echo $form->input('profilepath', array('label'=>'Profile Path', 'title'=>"specifies a path to the user's profile. This value can be a null string, a local absolute path, or a UNC path. Refer to the 'logon path' parameter in the smb.conf(5) man page for more information."));
	echo $form->input('smbHome', array('lable'=>'Windows Home Dir', 'title'=>"The Windows home Directory property specifies the path of the home directory for the user. The string can be null. If Home Drive Letter is set and specifies a drive letter, Windows Home Directory should be a UNC path. The path must be a network UNC path of the form \\server\share\directory. This value can be a null string. Refer to the 'logon home' parameter in the smb.conf(5) man page for more information."));
	echo $form->end('Update');
?>
</div>