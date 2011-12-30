<?php
class LdapAuthsController extends IdbrokerAppController {

	var $name = 'LdapAuths';
 
	function beforeFilter(){
		$this->Auth->allow('*');
		parent::beforeFilter();
	}

	function admin_logout(){
		$this->logout();
	}

	function admin_login(){
		$this->login();
	}

	function login(){
		if ($this->request->is('post')) {
			if ($this->Auth->login()) {
				return $this->redirect($this->Auth->redirect());
			} else {
				$this->Session->setFlash(__('Username or password is incorrect'), 'default', array('class'=>'error-message'), 'auth');
			}
		}
	}

	function logout(){
		$this->log("Destroying session",'debug');
		$this->Session->destroy();
		$this->redirect($this->Auth->logout());
	}


	//Very Ugly, fix this.,
        function isAuthorized() {
                return true;
        }

}
?>
