<?php
class GroupsController extends AppController {

	var $name = 'Groups';    
	var $components = array('RequestHandler', 'Ldap');
	var $helpers = array('Form','Html','Javascript', 'Ajax');

	function add(){
		if(!empty($this->data)){
			
			$this->data['Group']['objectclass'] = array('top', 'groupofuniquenames', 'posixgroup');
			
			if(is_array($this->data['Group']['members'])){
					foreach($this->data['Group']['members'] as $member){
						$this->data['Group']['uniquemember'] = $member;
						$memberuid = $this->Ldap->getUser($member);
						$this->data['Group']['memberuid'] = $memberuid['uid'];
					}
			}
			unset($this->data['Group']['members']);
			
			if ($this->Group->save($this->data)) {
				$this->Session->setFlash("Group Was Successfully Created.");
				$id = $this->Group->id;
				$this->redirect(array('action' => 'view', 'id'=> $id));
			}else{
				$this->Session->setFlash("Group couldn't be created.");
			}
		}
		$gusers = $this->Ldap->getUsers();
		foreach($gusers as $user){
			if(isset($user['uid']) && !empty($user['uid'])){
				$users[$user['dn']] = $user['uid'];
			}
		}
		$this->set(compact('users'));
		$this->layout = 'group';
	}
	
	function view( $id ){
		if(!empty($id)){
			$filter = $this->Group->primaryKey."=".$id;
			$Group = $this->Group->find('first', array( 'conditions'=>$filter));
			$this->log("Dump of Group view: ".print_r($Group,true),'debug');
			$this->set(compact('Group'));
		}
		$this->layout = 'group';
	}

	function myGroup(){

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
		$this->redirect($this->LdapAuth->logout());
	}

	//Very Ugly, fix this.,
	function isAuthorized() {
		return true;
	}

}
?>
