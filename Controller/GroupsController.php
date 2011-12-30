<?php
class GroupsController extends IdbrokerAppController {

	var $name = 'Groups';    
	var $components = array('Ldap');

	function add(){
		if(!empty($this->request->data)){
			
			$this->request->data['Group']['objectclass'] = array('top', 'groupofuniquenames', 'posixgroup');
			
			if(isset($this->request->data['Group']['description']) && empty($this->request->data['Group']['description'])){
				unset($this->request->data['Group']['description']);
			}
			
			if(isset($this->request->data['Group']['members']) && empty($this->request->data['Group']['members'])){
				unset($this->request->data['Group']['members']);
			}elseif(is_array($this->request->data['Group']['members'])){
					foreach($this->request->data['Group']['members'] as $member){
						$this->request->data['Group']['uniquemember'] = $member;
						$memberuid = $this->Ldap->getUser($member);
						$this->request->data['Group']['memberuid'] = $memberuid['uid'];
					}
			}
			unset($this->request->data['Group']['members']);
			$this->log("Trying to add group:".print_r($this->request->data,true),'debug');
			
			$cn = $this->request->data['Group']['cn'];
			if ($this->Group->save($this->request->data)) {
				$this->Session->setFlash("Group $cn Was Successfully Created.");
				$id = $this->Group->id;
				$this->redirect(array('action' => 'view', 'id'=> $id));
			}else{
				$this->Session->setFlash("Group $cn couldn't be created.");
			}
		}
		$attributes = array('gidnumber', 'description');
		$preset = $this->autoSet($attributes);
		$this->request->data['Group'] = $preset;
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
		$this->redirect($this->LDAPAuth->logout());
	}

	//Very Ugly, fix this.,
	function isAuthorized() {
		return true;
	}

}
?>
