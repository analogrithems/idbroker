<?php
class UsersController extends AppController {

	var $name = 'Users';    
        var $components = array('RequestHandler');
        var $helpers = array('Form','Html','Javascript', 'Ajax');
 
	/**
	*  The AuthComponent provides the needed functionality
	*  for login, so you can leave this function blank.
	*/
        function getMsg(){
                $msg = false;
                if ($this->Session->check('Message.flash.message')){
                        $msg =  $this->Session->read('Message.flash.message');
                        $this->Session->del('Message.flash.message');
                }
                $this->set(compact('msg'));
        }

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
