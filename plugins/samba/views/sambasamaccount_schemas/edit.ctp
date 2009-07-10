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
	
	echo $form->end('Update');
?>