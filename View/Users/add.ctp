<div id="Forms">
<?php

	echo $this->Ajax->form('add', 'post', array('model'=>'User'));

        echo $this->Form->hidden('User.objectclass.[]', array('value'=>'top'));
        echo $this->Form->hidden('User.objectclass.[]', array('value'=>'inetorgperson'));
        echo $this->Form->hidden('User.objectclass.[]', array('value'=>'organizationalperson'));
        echo $this->Form->hidden('User.objectclass.[]', array('value'=>'person'));
        echo $this->Form->hidden('User.objectclass.[]', array('value'=>'posixaccount'));
        echo $this->Form->hidden('User.objectclass.[]', array('value'=>'shadowaccount'));

        echo $this->Form->input('cn', array('label'=> 'Display Name', 'div'=> 'required', 'title'=>'A single word name for the description.'));

	echo $this->Form->input('givenname', array('label'=>'First Name', 'title'=> 'The account Holders first name.'));

	echo $this->Form->input('sn', array('label'=>'Last Name', 'div'=> 'required', 'title'=> 'The account Holders last/family name.'));

        echo $this->Form->input('uid', array('label'=>'User Name', 'div'=> 'required',  'title'=>'Account login name, ex: jdoe'));

        echo $this->Form->input('mail', array('label'=>'Email Address', 'div'=> 'required',  'title'=>'Users contact email address.'));

        echo $this->Form->input('uidnumber', array('label'=>'User ID Number', 'div'=> 'required',  'title'=>'Unix Style User ID Number.'));

        echo $this->Form->input('gidnumber', array('label'=>'Group ID Number', 'div'=> 'required',  'title'=>'Unix Style Group ID Number.'));

        echo $this->Form->input('homedirectory', array('label'=>'Home Directory', 'div'=> 'required',  'title'=>'Where the users home directory is, ex: /home/jdoe.'));

        echo $this->Form->input('password', array('label'=>'Password',  'type'=>'password', 'div'=> 'required',  'title'=>'Super Secret User Password'));

        echo $this->Form->input('password_confirm', array('label'=>'Re-Type Password', 'type'=>'password', 'div'=> 'required',  'title'=>'Super Secret User Password'));
        echo $this->Form->end('Update');
                echo "</div>";


?>
</div>
