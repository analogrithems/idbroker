<div id="Forms">
<?php
	echo $this->Form->create('Sudoer');

        echo $this->Form->input('cn', array('label'=> 'Role Name', 'div'=> 'required', 'title'=>'The name of this Sudo Role.'));


	echo $this->Form->input('sudouser', array('label'=>'Members', 'type' => 'select', 'multiple' => 'true', 'options'=>$sudousers, 'div'=> 'required', 'title'=> 'Choose Either The Individual User Or Group That This Role Applys To.'));

	echo $this->Form->input('sudohost', array('label'=>'Hosts', 'type' => 'select', 'multiple' => 'true', 'options'=>$sudohosts, 'div'=> 'required', 'title'=> 'Select what machines this applys to. The Special Value ALL Will Match Any Host.'));

	echo $this->Form->input('sudocommand', array('label'=>'Commands', 'div'=> 'required', 'title'=> "A Unix command with optional command line arguments, potentially including globbing characters (aka wild cards). The special value ALL will match any command. If a command is prefixed with an exclamation point '!', the user will be prohibited from running that command."));

	echo $this->Form->input('sudorunasuser', array('label'=>'Run As', 'div'=> 'required', 'title'=> 'What User Should this Role Run As? (Ex: root, nobody, apache, jdoe)'));

	echo $this->Form->input('sudorunasgroup', array('label'=>'Group Run As', 'type' => 'select', 'multiple' => 'true', 'options'=>$sudogroups, 'title'=> 'What Group Should this Role Run As? The special value ALL will match any group. \'!\' negates groups (Ex: wheel, nobody, users)'));

	echo $this->Form->input('sudooption', array('label'=>'Sudo Option', 'title'=> 'Extra Options (Like Environmnetal Variables to Keep) To Pass To Sudo.'));

        echo $this->Form->end('Make Sudo Role');
                echo "</div>";


?>
</div>
