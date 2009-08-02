<?php
class DataManagersController extends AppController {

	var $name = 'DataManagers';    
	var $components = array('RequestHandler', 'Ldap', 'SettingsHandler');
	var $helpers = array('Form','Html','Javascript', 'Ajax');



	/**
	*  The AuthComponent provides the needed functionality
	*  for login, so you can leave this function blank.
	*/
	function login() {
	}

	function logout() {
		$this->redirect($this->LdapAuth->logout());
	}

	//Very Ugly, fix this.,
	function isAuthorized() {
		return true;
	}

}
?>
