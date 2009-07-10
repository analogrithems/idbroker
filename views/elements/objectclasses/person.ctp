<?php
	echo "<div id='$objectclass'>";
	echo $ajax->form('edit','post',array('model'=>substr($this->name,0,-1),'update'=>'dndisplay'));

	echo $form->input('dn', array('type'=>'hidden'));
	echo $form->input('cn', array('label'=>'Display Name','div'=>'required'));
	echo $form->input('sn', array('label'=>'Last Name', 'div'=>'required'));
	echo $form->input('description');
	echo $form->input('telephonenumber', array('label'=> 'Phone Number'));
	echo $form->end('Update');
?>
</div>
