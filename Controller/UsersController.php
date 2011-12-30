<?php
class UsersController extends IdbrokerAppController {

	var $name = 'Users';    
 
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
		$this->redirect($this->LDAPAuth->logout());
	}

	//Very Ugly, fix this.,
        function isAuthorized() {
                return true;
        }

}
?>
