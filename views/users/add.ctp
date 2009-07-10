<div id="Forms">
<?php

	echo $ajax->form('add', 'post', array('model'=>'User'));

        echo $form->hidden('User.objectclass.[]', array('value'=>'top'));
        echo $form->hidden('User.objectclass.[]', array('value'=>'inetorgperson'));
        echo $form->hidden('User.objectclass.[]', array('value'=>'organizationalperson'));
        echo $form->hidden('User.objectclass.[]', array('value'=>'person'));
        echo $form->hidden('User.objectclass.[]', array('value'=>'posixaccount'));
        echo $form->hidden('User.objectclass.[]', array('value'=>'shadowaccount'));

        echo $form->input('cn', array('label'=> 'Display Name', 'div'=> 'required', 'title'=>'A single word name for the description.'));

	echo $form->input('givenname', array('label'=>'First Name', 'title'=> 'The account Holders first name.'));

	echo $form->input('sn', array('label'=>'Last Name', 'div'=> 'required', 'title'=> 'The account Holders last/family name.'));

        echo $form->input('uid', array('label'=>'User Name', 'div'=> 'required',  'title'=>'Account login name, ex: jdoe'));

        echo $form->input('mail', array('label'=>'Email Address', 'div'=> 'required',  'title'=>'Users contact email address.'));

        echo $form->input('uidnumber', array('label'=>'User ID Number', 'div'=> 'required',  'title'=>'Unix Style User ID Number.'));

        echo $form->input('gidnumber', array('label'=>'Group ID Number', 'div'=> 'required',  'title'=>'Unix Style Group ID Number.'));

        echo $form->input('homedirectory', array('label'=>'Home Directory', 'div'=> 'required',  'title'=>'Where the users home directory is, ex: /home/jdoe.'));

        echo $form->input('password', array('label'=>'Password',  'type'=>'password', 'div'=> 'required',  'title'=>'Super Secret User Password'));

        echo $form->input('password_confirm', array('label'=>'Re-Type Password', 'type'=>'password', 'div'=> 'required',  'title'=>'Super Secret User Password'));
        echo $form->end('Update');
                echo "</div>";


?>
</div>
