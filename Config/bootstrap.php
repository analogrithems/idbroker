<?php
App::uses('CakeLog', 'Log');
App::uses('PhpReader', 'Configure');

	/*
	* Hook into the settings menu to plug auth
	* If you are using it that way
	*/
	function LdapAuthSettings(){
		Configure::load('Idbroker.menu');
	}

	Configure::load('ldap');
	LdapAuthSettings();
	
?>
