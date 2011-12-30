<div class="groups view">
<h2><?php echo __('Group');?></h2>
	<dl><?php $i = 0; $class = ' class="altrow"';?>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php echo __('Name Name'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $group['Group']['cn']; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php echo __('Group ID Number'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $group['Group']['gidnumber']; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php echo __('Description'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $group['Group']['description']; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php echo __('Members'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>><ul>
			<?php
				if(is_array($group['Group']['uniquemember'])){
					foreach($group['Group']['uniquemember'] as $member){
						echo "<li><b>Member DN:</b> $member </li>";
					}
				}else{
					echo "<li><b>Member DN:</b> ".$group['Group']['uniquemember']."</li>";
				}
				
				if(is_array($group['Group']['memberuid'])){
					foreach($group['Group']['memberuid'] as $member){
						echo "<li><b>Member UID:</b>  $member </li>";
					}
				}else{
					echo "<li><b>Member UID:</b> ".$group['Group']['memberuid']."</li>";
				}
				
			
			?></ul>
			&nbsp;
		</dd>
	</dl>
</div>
<div class="actions">
	<ul>
		<li><?php echo $this->Html->link(__('Edit Group'), array('action'=>'edit', $group['Group']['uid'])); ?> </li>
		<li><?php echo $this->Html->link(__('Delete Group'), array('action'=>'delete', $group['Group']['uid']), null, sprintf(__('Are you sure you want to delete # %s?'), $group['Group']['uid'])); ?> </li>
		<li><?php echo $this->Html->link(__('List Groups'), array('action'=>'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Group'), array('action'=>'add')); ?> </li>
	</ul>
</div>
