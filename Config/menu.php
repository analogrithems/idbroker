<?php
                $config['Menus'][__('Admin')][__('Settings')]['children'][__('Ldap Auth')] = array(
                        'url'=>array('plugin'=>'Idbroker','controller'=>'Settings','action'=>'index','admin'=>true),
                        'permissions'=>'authed'
                );
?>
