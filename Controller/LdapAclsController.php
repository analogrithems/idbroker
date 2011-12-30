<?php
class LdapAclsController extends IdbrokerAppController {

	var $name = 'LdapAcls';
        var $components = array('LdapAcl');
 
	function beforeFilter(){
		//$this->LdapAcl->allow('*');
	}
	function login(){
		$this->LdapAcl->startup();
		$this->LdapAcl->find('first',
			array('conditions'=>
				array($this->LdapAclModel->primaryKey=>$data[$this->name][$this->LdapAcl->fields['username']])
			)
		);
	}

	function logout(){
		$this->LdapAcl->logout();
	}

	function redirect(){
		$r = $_SESSION['login_refer'];
		unset($_SESSION['login_refer']);
		$this->redirect('/NZfoo');
	}


	//Very Ugly, fix this.,
        function isAclorized() {
                return true;
        }

}
?>
