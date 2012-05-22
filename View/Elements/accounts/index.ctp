<div class="users index">
<h2><?php echo __('Users');?></h2>
	<div id="debugldap">
	<pre><?php print_r($accounts); ?> </pre>
	</div>
</div>
<div class="paging">
	<?php echo $this->Paginator->prev('<< '.__('previous'), array(), null, array('class'=>'disabled'));?>
 | 	<?php echo $this->Paginator->numbers();?>
	<?php echo $this->Paginator->next(__('next').' >>', array(), null, array('class'=>'disabled'));?>
</div>
<div class="actions">
	<ul>
		<li><?php echo $this->Html->link(__('New User'), array('action'=>'add')); ?></li>
		<li><?php echo $this->Html->link(__('List Groups'), array('controller'=> 'groups', 'action'=>'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Group'), array('controller'=> 'groups', 'action'=>'add')); ?> </li>
	</ul>
</div>
