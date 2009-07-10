<div id="Forms">
<?php
	echo $form->create('Group', array( 'url'=>'/groups/add' ));

	echo $form->input('cn', array('label'=> 'Group Name', 'div'=> 'required', 'title'=>'The Name of the Group You Are Creating.'));

	echo $form->input('description', array('label'=>'Description', 'title'=> 'Description of the purpose for this Group.'));

	echo $form->input('gidnumber', array('label'=>'Group ID Number', 'div'=> 'required', 'title'=> 'Unix Style Group ID Number, must be Unique..'));

	echo $form->input('members', array('label'=>'Group Members', 'type'=>'select', 'multiple'=>'true', 'options'=>$users, 'div'=> 'required', 'title'=> 'Users That Should Belong To This Group.'));

	echo $form->end('Create Group');
                echo "</div>";

?>
</div>
