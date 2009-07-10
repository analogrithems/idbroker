<?php
	echo $ajax->form(array('type' => 'post',
	    'options' => array(
	        'model'=>'QmailuserSchema',
	        'update'=>'qmailuser',
	        'url' => array(
	            'controller' => 'QmailuserSchemas',
	            'action' => 'edit'
	         )
		)
	));
	$accountStatus = array( 'active'=>'Active no restrictions', 'nopop'=>'POP3 Access Denied', 'disabled'=>'Bounce Incoming Mails');
	echo $form->input('accountstatus', array('label'=> 'Account Status', 'div'=>'required', 'options'=>$accountStatus, 'title'=>'The current mail access status'));
	$quotasize = array( 'none'=>'Unlimitd', '10000000'=>'10Mb', '50000000'=>'50Mb', '100000000'=>'100Mb');
	echo $form->input('mailquotasize', array('label'=> 'Mail Quota size', 'options'=>$quotasize, 'title'=>'The limit in Mb of the maildir'));
	$quotacount = array( 'none'=>'Unlimited', '100'=>'100', '500'=>'500', '10000'=>'10000', '100000'=>'100000');
	echo $form->input('mailquotacount', array('label'=> 'Mail Quota Count', 'options'=>$quotacount, 'title'=>'The limit in Mb of the maildir'));
	$deliverymode = array( 'normal'=> 'Default', 'nolocal'=>"Don't Handle Localy", 'noforward'=>"Don't Forward To Anywhere", 'noprogram'=>"Skip Special Handeling Programs", 'reply'=>"Auto Reply");
	echo $form->input('deliverymode', array('label'=> 'Delivery Options', 'options'=>$deliverymode, 'title'=>'The rules defining how delivery should or should not be done.'));
	echo $form->input('deliveryprogrampath', array('label'=> 'Post Delivery Program', 'title'=>'Path and arguments to a program for post processing. Great place to use procmail'));
	echo $form->input('mailalternateaddress', array('label'=> 'Email Alias', 'title'=>'Another address that is an alias for this mail account, Mail sent to that address will end up here'));
	echo $form->input('mailforwardingaddress', array('label'=> 'Forward To', 'title'=>'An email address you would like to have your mail forwarded to.'));
	echo $form->input('mail', array('label'=> 'E-mail Address', 'title'=>'The E-mail address for this account'));
	echo $form->input('mailreplytext', array('label'=> 'Auto Reply/Out Of Office Reply', 'title'=>'An Auto reply vacation message.', 'type'=>'textarea'));
	echo $form->end('Update');
?>