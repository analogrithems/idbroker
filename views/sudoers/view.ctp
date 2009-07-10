<div class="sudoers view">
<h2><?php  __('Sudo Role');?></h2>
	<dl><?php $i = 0; $class = ' class="altrow"';?>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Sudo Role Name'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $sudoer['Sudoer']['cn']; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('The Following Users/Groups'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>><ul>
			<?php 
				if(is_array($sudoer['Sudoer']['sudouser'])){
					foreach($sudoer['Sudoer']['sudouser'] as $user){
						echo "<li>$user</li> ";
					}
				}else{
					echo "<li>".$sudoer['Sudoer']['sudouser']."</li>"; 
				}

			?></ul>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Can Run The Following Command(s),'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>><ul>
                        <?php
                                if(is_array($sudoer['Sudoer']['sudocommand'])){
                                        foreach($sudoer['Sudoer']['sudocommand'] as $command){
                                                echo "<li>$command</li> ";
                                        }
                                }else{
                                        echo "<li>".$sudoer['Sudoer']['sudocommand']."</li>";
                                }

                        ?></ul>
			&nbsp;
		</dd>
                <dt<?php if ($i % 2 == 0) echo $class;?>><?php __('On The Following Computers,'); ?></dt>
                <dd<?php if ($i++ % 2 == 0) echo $class;?>><ul>
                        <?php
                                if(is_array($sudoer['Sudoer']['sudohost'])){
                                        foreach($sudoer['Sudoer']['sudohost'] as $host){
                                                echo "<li>$host </li> ";
                                        }
                                }else{
                                        echo "<li>".$sudoer['Sudoer']['sudohost']."</li>";
                                }

                        ?></ul>
                        &nbsp;
                </dd>
                <dt<?php if ($i % 2 == 0) echo $class;?>><?php __('As The Following Users,'); ?></dt>
                <dd<?php if ($i++ % 2 == 0) echo $class;?>><ul>
                        <?php
                                if(is_array($sudoer['Sudoer']['sudorunasuser'])){
                                        foreach($sudoer['Sudoer']['sudorunasuser'] as $runas){
                                                echo "<li>$runas </li> ";
                                        }
                                }else{
                                        echo "<li>".$sudoer['Sudoer']['sudorunasuser']."</li>";
                                }

                        ?></ul>
                        &nbsp;
                </dd>
                <dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Or As The Following Groups,'); ?></dt>
                <dd<?php if ($i++ % 2 == 0) echo $class;?>><ul>
                        <?php
                                if(is_array($sudoer['Sudoer']['sudorunasgroup'])){
                                        foreach($sudoer['Sudoer']['sudohost'] as $runasgroup){
                                                echo "<li>$runasgroup </li> ";
                                        }
                                }else{
                                        echo "<li>".$sudoer['Sudoer']['sudorunasgroup']."</li>";
                                }

                        ?></ul>
                        &nbsp;
                </dd>
                <dt<?php if ($i % 2 == 0) echo $class;?>><?php __('With These Extra Options.'); ?></dt>
                <dd<?php if ($i++ % 2 == 0) echo $class;?>>
                        <?php
                                if(is_array($sudoer['Sudoer']['sudooption'])){
                                        foreach($sudoer['Sudoer']['sudooption'] as $option){
                                                echo "<li>$option </li> ";
                                        }
                                }else{
                                        echo "<li>".$sudoer['Sudoer']['sudooption']."</li>";
                                }

                        ?></ul>
                        &nbsp;
                </dd>

	</dl>
</div>
<div class="actions">
	<ul>
		<li><?php echo $html->link(__('Edit Sudo Role', true), array('action'=>'edit', $sudoer['Sudoer']['cn'])); ?> </li>
		<li><?php echo $html->link(__('Delete Sudo Role', true), array('action'=>'delete', $sudoer['Sudoer']['cn']), null, sprintf(__('Are you sure you want to delete # %s?', true), $sudoer['Sudoer']['uid'])); ?> </li>
		<li><?php echo $html->link(__('List Sudo Roles', true), array('action'=>'index')); ?> </li>
		<li><?php echo $html->link(__('New Sudo Role', true), array('action'=>'add')); ?> </li>
	</ul>
</div>
