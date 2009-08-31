<div id="accordion">
        <h3><a href="#">My Account</a></h3>
        <div id="MyAccunt">
                <dl><?php $i = 0; $class = ' class="altrow"';?>
                        <dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Display Name'); ?></dt>
                        <dd<?php if ($i++ % 2 == 0) echo $class;?>>
                                <?php echo $this->data['Person']['cn']; ?>
                                &nbsp;
                        </dd>
                        <dt<?php if ($i % 2 == 0) echo $class;?>><?php __('User Name'); ?></dt>
                        <dd<?php if ($i++ % 2 == 0) echo $class;?>>
                                <?php echo $this->data['Person']['uid']; ?>
                                &nbsp;
                        </dd>
                        <dt<?php if ($i % 2 == 0) echo $class;?>><?php __('User ID Number'); ?></dt>
                        <dd<?php if ($i++ % 2 == 0) echo $class;?>>
                                <?php echo $this->data['Person']['uidnumber']; ?>
                                &nbsp;
                        </dd>
                        <dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Group ID Number'); ?></dt>
                        <dd<?php if ($i++ % 2 == 0) echo $class;?>>
                                <?php echo $this->data['Person']['gidnumber']; ?>
                                &nbsp;
                        </dd>
                        <dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Email'); ?></dt>
                        <dd<?php if ($i++ % 2 == 0) echo $class;?>>
                                <?php echo $this->data['Person']['mail']; ?>
                                &nbsp;
                        </dd>
                        <dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Home Directory'); ?></dt>
                        <dd<?php if ($i++ % 2 == 0) echo $class;?>>
                                <?php echo $this->data['Person']['homedirectory']; ?>
                                &nbsp;
                        </dd>
        <?php
                echo "<div id='myAccountUpdate'>";
                $shells = array('/bin/bash'=>'Bash', '/bin/csh'=>'Csh', '/bin/tcsh'=>'Tcsh', '/bin/sh'=>'Sh', '/bin/ksh'=>'Ksh', '/usr/lib/sftp-server'=>'Sftp-only');
                $dn = $this->data['Person']['dn'];
                $loginshell = $this->data['Person']['loginshell'];

                echo $form->create('Person', array( 'url' => '/peoples/myAccount' ))."\n";
                echo $form->input('dn', array('type'=>'hidden'));
                echo $form->input('loginshell', array('label'=>'Login Shell', 'div'=> 'required', 'options'=>$shells, 'default'=>$loginshell, 'title'=>'Unix Shell You Are Most Comfortable With.'))."\n";

                if(isset($passwordReset['allowed']) && $passwordReset['allowed'] == true){
                        echo $form->input('password', array('label'=>'Password',  'type'=>'password', 'div'=> 'required',  'title'=>'Super Secret Person Password'))."\n";

                        echo $form->input('password_confirm', array('label'=>'Re-Type Password', 'type'=>'password', 'div'=> 'required',  'title'=>'Super Secret Person Password'))."\n";
                }elseif(isset($passwordReset['allowed']) && ($passwordReset['allowed'] ==false)){
                        echo "<Span id='nopasswordreset'>Password Can Not be Changed unitl <b>".$passwordReset['notuntil']."</b>.</span>"."\n";
                }
                echo $form->end('Update')."\n";
                echo "</div>"."\n";
        ?>

                </dl>
        </div>

        <?php if(isset($groups) && !empty($groups)){?>
        <h3><a href="#">Groups I'm In</a></h3>
        <div id="MyGroups">
<?php
        foreach($groups as $group){
                $img = $html->image('/js/themes/ldap/group.png', array('alt'=>'Group '.$group['cn']));
                echo "<Span id=\"".$group['cn']."_group\" class='group list'>$img  ".$group['cn']."</span>\n";
        }
?>

        </div>
        <?php }?>

        <?php if(isset($computers) && !empty($computers)){?>
        <h3><a href="#">Computers I Can Access</a></h3>
        <div id="MyComputers">
<?php
        foreach($computers as $computer){
                $img = $html->image('/js/themes/ldap/computer.png', array('alt'=>'Computer '.$computer['cn']));
                echo "<Span id=\"".$computer['cn']."_computer\" class='computer list'>$img  ".$computer['cn']."</span>\n";
        }
?>

        </div>
        <?php }?>

        <?php if(isset($sudoers) && !empty($sudoers)){?>
        <h3><a href="#">Sudo Roles</a></h3>
        <div id="MySudoers">
<?php
        foreach($sudoers as $sudoer){
                $img = $html->image('/js/themes/ldap/key.png', array('alt'=>'Sudoer '.$sudoer['cn']));
                echo "<Span id=\"".$sudoer['cn']."_sudoer\" class='sudoer list'>$img  ".$sudoer['cn']."</span>\n";
        }
?>

        </div>
        <?php }?>
</div>