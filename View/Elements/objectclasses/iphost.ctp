<?php 
	echo "<div id='$objectclass'>";
	echo $this->Ajax->form('edit','post',array('model'=>substr($this->name,0,-1),'update'=>'dndisplay'));
	echo $this->Form->input('dn', array('type'=>'hidden'));

	echo $this->Form->input('iphostnumber', array('label'=>'IP Address', 'div'=>'required', 'title'=>'The IP address of this host'));

	echo $this->Form->end('Update');
                echo "</div>";
?>
