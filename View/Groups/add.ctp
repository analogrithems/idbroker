<div id="Forms">
<?php
	echo $this->Form->create('Group', array( 'url'=>'/groups/add' ));

	echo $this->Form->input('cn', array('label'=> 'Group Name', 'div'=> 'required', 'title'=>'The Name of the Group You Are Creating.'));

	echo $this->Form->input('description', array('label'=>'Description', 'title'=> 'Description of the purpose for this Group.'));

	echo $this->Form->input('gidnumber', array('label'=>'Group ID Number', 'div'=> 'required', 'title'=> 'Unix Style Group ID Number, must be Unique..'));

	echo $this->Form->input('members', array('label'=>'Group Members', 'type'=>'select', 'multiple'=>'true', 'options'=>$users, 'div'=> 'required', 'title'=> 'Users That Should Belong To This Group.'));

	echo $this->Form->end('Create Group');
                echo "</div>";

?>
</div>
