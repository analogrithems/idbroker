<?php

	echo $this->Form->create('Settings',array('action'=>'index'));

	echo $this->Form->input('enable_ldap',array('label'=>__('Enable Ldap Auth'), 'type'=>'checkbox','value'=>__('Enable')));
	echo $this->Form->input('ldap_user_attribute',array('label'=>__('User Attribute'),'type'=>'text'));
	echo $this->Form->input('ldap_user_filter',array('label'=>__('User Filter'), 'type'=>'text'));
	echo $this->Form->input('ldap_groups',array('label'=>__('Use Ldap Groups'), 'type'=>'checkbox', 'value'=>__('Enable')));
	echo $this->Form->input('ldap_server',array('label'=>__('Server'),'type'=>'text'));
	echo $this->Form->input('ldap_base_dn',array('label'=>__('Base Dn'),'type'=>'text'));
	echo $this->Form->input('ldap_proxy_user',array('label'=>__('Proxy User'), 'type'=>'text'));
	echo $this->Form->input('ldap_proxy_pass',array('label'=>__('Proxy Password'), 'type'=>'text'));

	echo $this->Form->submit(__('Save'));
	
	echo $this->Form->end();
?>
