<?php 
	echo "<div id='$objectclass'>";
	echo $ajax->form('edit','post',array('model'=>substr($this->name,0,-1),'update'=>'dndisplay'));
	echo $form->input('dn', array('type'=>'hidden'));

	echo $form->input('iphostnumber', array('label'=>'IP Address', 'div'=>'required', 'title'=>'The IP address of this host'));

	echo $form->end('Update');
                echo "</div>";
?>
