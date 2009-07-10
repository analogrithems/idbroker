<?php
class SudoersController extends AppController {

	var $name = 'Sudoers';    
	var $components = array('RequestHandler', 'Ldap');
	var $helpers = array('Form','Html','Javascript', 'Ajax');

	function add(){
		if(!empty($this->data)){
			$this->data['Sudoer']['objectclass'] = array('top', 'sudorole');
			$this->log("Data:".print_r($this->data,true),'debug');
			if ($this->Sudoer->save($this->data)) {
				$this->Session->setFlash("Sudoer Role Was Successfully Created.");
				$id = $this->Sudoer->id;
				$this->redirect(array('action' => 'view', 'id'=> $id));
			}else{
				$this->Session->setFlash("Sudoer Role couldn't be created.");
			}
		}
		$users = $this->Ldap->getUsers();
		$sudousers['ALL'] = 'ALL';
		foreach($users as $user){
			if(isset($user['uid']) && !empty($user['uid'])){
				$sudousers[$user['uid']] = $user['uid'];
			}
		}
		$groups = $this->Ldap->getGroups();
		$sudousers[] = 'The Following are only groups';
		$sudogroups['All'] = 'ALL';
		foreach($groups as $group){
			if(isset($group['cn']) && !empty($group['cn'])){
				$sudogroups[$group['cn']] = $group['cn'];
				$sudousers['%'.$group['cn']] = '%'.$group['cn'];
			}
		}
		$computers = $this->Ldap->getComputers();
		$sudohosts['ALL'] = 'ALL';
		foreach($computers as $computer){
			if(isset($computer['cn']) && !empty($computer['cn'])){
				$sudohosts[$computer['cn']] = $computer['cn'];
			}
		}
		$this->set(compact('sudousers'));
		$this->set(compact('sudogroups'));
		$this->set(compact('sudohosts'));

		$this->layout = 'sudoer';
	}
	
	function view( $id ){
		if(!empty($id)){
			$filter = $this->Sudoer->primaryKey."=".$id;
			$sudoer = $this->Sudoer->find('first', array( 'conditions'=>$filter));
			$this->log("Dump of Sudoer view: ".print_r($sudoer,true),'debug');
			$this->set(compact('sudoer'));
		}
		$this->layout = 'sudoer';
	}

	function mySudoer(){

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
