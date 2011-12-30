<?php
class ComputersController extends IdbrokerAppController {

	var $name = 'Computers';    
	var $components = array('Ldap');

	function add(){
		if(!empty($this->request->data)){
			$this->request->data['Computer']['objectclass'] = array('top', 'groupofuniquenames', 'iphost');
			if(is_array($this->request->data['Computer']['members'])){
					foreach($this->request->data['Computer']['members'] as $member){
						$this->request->data['Computer']['uniquemember'][] = $member;
					}
			}else{
				$this->request->data['Computer']['uniquemember'] = $member;
			}
			unset($this->request->data['Computer']['members']);
			
			if ($this->Computer->save($this->request->data)) {
				$this->Session->setFlash("Computer Entry Was Successfully Added.");
				$id = $this->Computer->id;
				$this->redirect(array('action' => 'view', 'id'=> $id));
			}else{
				$this->Session->setFlash("Computer entry couldn't be created.");
			}
		}
		$gusers = $this->Ldap->getUsers();
		foreach($gusers as $user){
			if(isset($user['uid']) && !empty($user['uid'])){
				$users[$user['dn']] = $user['uid'];
			}
		}
		$this->set(compact('users'));
		$this->layout = 'computer';
	}
	
	function view( $id ){
		if(!empty($id)){
			$filter = $this->Computer->primaryKey."=".$id;
			$Computer = $this->Computer->find('first', array( 'conditions'=>$filter));
			$this->log("Dump of Computer view: ".print_r($Computer,true),'debug');
			$this->set(compact('Computer'));
		}
		$this->layout = 'computer';
	}

	function myComputer(){

	}
	function edit($id = null) {

	}

	/**
	*  The AuthComponent provides the needed functionality
	*  for login, so you can leave this function blank.
	*/
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
