<?php
	echo "<div id='$objectclass'>";
	echo $this->Ajax->form('edit','post',array('model'=>substr($this->name,0,-1),'update'=>'dndisplay'));
	echo $this->Form->input('dn', array('type'=>'hidden'));
	echo $this->Form->input('businesscategory', array('label'=>'Department', 'title'=>'Identifies the type of business in which the entry is engaged. This should be a broad generalization such as is made at the corporate division level. For example: businessCategory: Engineering.'));

	echo $this->Form->input('givenname', array('label'=>'First Name', 'div'=>'required', 'title'=>'Identifies the entry\'s given name, usually a person\'s first name. For example: givenName: Hecuba.'));

	echo $this->Form->input('employeenumber', array('label'=>'Employe Enumber', 'title'=>'Identifies the entry\'s employee number. For example: employeeNumber: 3440.'));

	echo $this->Form->input('employeetype', array('label'=>'Full Time | Part Time', 'title'=>'Identifies the entry\'s type of employment. For example: employeeType: Full time '));

	echo $this->Form->input('manager', array('label'=>'Manager', 'title'=>'Identifies the distinguished name of the entry\'s manager. For example: \'manager:cn=Jane Doe, ou=Quality Control, dc=example, dc=com\'.'));

	echo $this->Form->input('mail', array('label'=>'E-mail Address', 'div'=>'required', 'title'=>'Identifies a user\'s primary email address (the email address retrieved and displayed by "white-pages" lookup applications). For example: mail: banderson@example.com.'));

	echo $this->Form->input('roomnumber', array('label'=>'Office Number', 'title'=>'Specifies the room number of an object. Note that the commonName attribute should be used for naming room objects. For example: roomNumber: 230.'));

	echo $this->Form->input('homephone', array('label'=>'Home Phone Number', 'title'=>'Identifies the entry\'s home phone number. For example: homePhone: 415-555-1212'));

	echo $this->Form->input('mobile', array('label'=>'Cell Phone Number', 'title'=>'Identifies the entry\'s mobile or cellular phone number. Abbreviation: mobile. For example: mobileTelephoneNumber: 415-555-4321 mobile: 415-555-4321 '));

	echo $this->Form->input('jpegphoto', array('label'=>'User Photo', 'title'=>'Contains a JPEG photo of the entry in binary, MIME format', 'type'=>'file'));

	echo $this->Form->end('Update');
                echo "</div>";
?>
