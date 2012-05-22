<div class="users form">
<?php echo $this->Form->create('User');?>
	<fieldset>
 		<legend><?php echo __('Edit User');?></legend>
	<?php
		echo $this->Form->input('id');
		echo $this->Form->input('username');
		echo $this->Form->input('email');
		echo $this->Form->input('group_id');
	?>
	</fieldset>
<?php echo $this->Form->end('Submit');?>
</div>
<div class="actions">
	<ul>
		<li><?php echo $this->Html->link(__('Delete'), array('action'=>'delete', $this->Form->value('User.id')), null, sprintf(__('Are you sure you want to delete # %s?'), $this->Form->value('User.id'))); ?></li>
		<li><?php echo $this->Html->link(__('List Users'), array('action'=>'index'));?></li>
		<li><?php echo $this->Html->link(__('List Groups'), array('controller'=> 'groups', 'action'=>'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Group'), array('controller'=> 'groups', 'action'=>'add')); ?> </li>
	</ul>
</div>
<pre><?php print_r($this);?></pre>
