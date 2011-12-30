<div class="computers view">
<h2><?php echo __('Host');?></h2>
	<dl><?php $i = 0; $class = ' class="altrow"';?>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php echo __('Fully qualified domain name'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $computer['Computer']['cn']; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php echo __('Description'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $computer['Computer']['description']; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php echo __('IP Address'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $computer['Computer']['iphostnumber']; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php echo __('Users Allowed To Login'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>><ul>
			<?php
				if(is_array($computer['Computer']['uniquemember'])){
					foreach($computer['Computer']['uniquemember'] as $member){
						echo "<li><b>Member DN:</b> $member </li>";
					}
				}else{
					echo "<li><b>Member DN:</b> ".$computer['Computer']['uniquemember']."</li>";
				}
			
			?></ul>
			&nbsp;
		</dd>		
	</dl>
</div>
<div class="actions">
	<ul>
		<li><?php echo $this->Html->link(__('Edit Host'), array('action'=>'edit', $computer['Computer']['cn'])); ?> </li>
		<li><?php echo $this->Html->link(__('Delete Host'), array('action'=>'delete', $computer['Computer']['cn']), null, sprintf(__('Are you sure you want to delete # %s?'), $computer['Computer']['uid'])); ?> </li>
		<li><?php echo $this->Html->link(__('List Hosts'), array('action'=>'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Host'), array('action'=>'add')); ?> </li>
	</ul>
</div>
