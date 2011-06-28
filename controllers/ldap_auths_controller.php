<?php
class LdapAuthsController extends IdbrokerAppController {

	var $name = 'LdapAuths';
        var $components = array('RequestHandler');
        var $helpers = array('Form','Html','Javascript', 'Ajax');
 
	function beforeFilter(){
		//$this->LdapAuth->allow('*');
	}
	function login(){
	}

	function logout(){
	}


	//Very Ugly, fix this.,
        function isAuthorized() {
                return true;
        }

}
?>
