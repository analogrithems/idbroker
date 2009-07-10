<?php
	echo "<div id='$objectclass'>";
	echo $ajax->form('edit','post',array('model'=>substr($this->name,0,-1),'update'=>'dndisplay'));
	echo $form->input('dn', array('type'=>'hidden'));
	echo $form->input('businesscategory', array('label'=>'Department', 'title'=>'Identifies the type of business in which the entry is engaged. This should be a broad generalization such as is made at the corporate division level. For example: businessCategory: Engineering.'));

	echo $form->input('givenname', array('label'=>'First Name', 'div'=>'required', 'title'=>'Identifies the entry\'s given name, usually a person\'s first name. For example: givenName: Hecuba.'));

	echo $form->input('employeenumber', array('label'=>'Employe Enumber', 'title'=>'Identifies the entry\'s employee number. For example: employeeNumber: 3440.'));

	echo $form->input('employeetype', array('label'=>'Full Time | Part Time', 'title'=>'Identifies the entry\'s type of employment. For example: employeeType: Full time '));

	echo $form->input('manager', array('label'=>'Manager', 'title'=>'Identifies the distinguished name of the entry\'s manager. For example: \'manager:cn=Jane Doe, ou=Quality Control, dc=example, dc=com\'.'));

	echo $form->input('mail', array('label'=>'E-mail Address', 'div'=>'required', 'title'=>'Identifies a user\'s primary email address (the email address retrieved and displayed by "white-pages" lookup applications). For example: mail: banderson@example.com.'));

	echo $form->input('roomnumber', array('label'=>'Office Number', 'title'=>'Specifies the room number of an object. Note that the commonName attribute should be used for naming room objects. For example: roomNumber: 230.'));

	echo $form->input('homephone', array('label'=>'Home Phone Number', 'title'=>'Identifies the entry\'s home phone number. For example: homePhone: 415-555-1212'));

	echo $form->input('mobile', array('label'=>'Cell Phone Number', 'title'=>'Identifies the entry\'s mobile or cellular phone number. Abbreviation: mobile. For example: mobileTelephoneNumber: 415-555-4321 mobile: 415-555-4321 '));

	echo $form->input('jpegphoto', array('label'=>'User Photo', 'title'=>'Contains a JPEG photo of the entry in binary, MIME format', 'type'=>'file'));

	echo $form->end('Update');
                echo "</div>";
?>
