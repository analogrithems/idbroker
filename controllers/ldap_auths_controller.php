<?php
class LdapAuthsController extends IdbrokerAppController {

	var $name = 'LdapAuths';
        var $components = array('RequestHandler');
        var $helpers = array('Form','Html','Javascript', 'Ajax');
 
	function beforeFilter(){
		//$this->LdapAuth->allow('*');
	}

	function admin_logout(){
		$this->logout();
	}

	function admin_login(){
		$this->login();
	}

	function login(){
	}

	function logout(){
		$this->redirect($this->LDAPAuth->logout());
	}


	//Very Ugly, fix this.,
        function isAuthorized() {
                return true;
        }

}
?>
