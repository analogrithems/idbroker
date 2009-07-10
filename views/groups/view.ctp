<div class="groups view">
<h2><?php  __('Group');?></h2>
	<dl><?php $i = 0; $class = ' class="altrow"';?>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Name Name'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $group['Group']['cn']; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Group ID Number'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $group['Group']['gidnumber']; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Description'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $group['Group']['description']; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Members'); ?></dt>
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
		<li><?php echo $html->link(__('Edit Group', true), array('action'=>'edit', $group['Group']['uid'])); ?> </li>
		<li><?php echo $html->link(__('Delete Group', true), array('action'=>'delete', $group['Group']['uid']), null, sprintf(__('Are you sure you want to delete # %s?', true), $group['Group']['uid'])); ?> </li>
		<li><?php echo $html->link(__('List Groups', true), array('action'=>'index')); ?> </li>
		<li><?php echo $html->link(__('New Group', true), array('action'=>'add')); ?> </li>
	</ul>
</div>
