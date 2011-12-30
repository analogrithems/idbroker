<?php
	echo "<div id='$objectclass'>";
	echo $this->Ajax->form('edit','post',array('model'=>substr($this->name,0,-1),'update'=>'dndisplay'));

	echo $this->Form->input('dn', array('type'=>'hidden'));
	echo $this->Form->input('cn', array('label'=>'Display Name','div'=>'required'));
	echo $this->Form->input('sn', array('label'=>'Last Name', 'div'=>'required'));
	echo $this->Form->input('description');
	echo $this->Form->input('telephonenumber', array('label'=> 'Phone Number'));
	echo $this->Form->end('Update');
?>
</div>
