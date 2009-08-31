<?php
class PeopleController extends AppController {

	var $name = 'People';    
	var $components = array('RequestHandler', 'Ldap');
	var $helpers = array('Form','Html','Javascript', 'Ajax');
 
	function add(){
		if(!empty($this->data)){
			$this->data['Person']['objectclass'] = array('top', 'organizationalperson', 'inetorgperson','person','posixaccount','shadowaccount');

			if($this->data['Person']['password'] == $this->data['Person']['password_confirm']){
				$this->data['Person']['userpassword'] = $this->data['Person']['password'];
				unset($this->data['Person']['password']);
				unset($this->data['Person']['password_confirm']);
			
				if(!isset($this->data['Person']['homedirectory'])&& isset($this->data['Person']['uid'])){
					$this->data['Person']['homedirectory'] = '/home/'.$this->data['Person']['uid'];
				}

				$cn = $this->data['Person']['cn'];
				if ($this->Person->save($this->data)) {
					$this->Session->setFlash($cn.' was added Successfully.');
					$id = $this->Person->id;
					$this->redirect(array('action' => 'view', 'id'=> $id));
				}else{
					$this->Session->setFlash("$cn couldn't be created.");
				}
			}else{
				$this->Session->setFlash("Passwords don't match.");
			}
		}
		$attributes = array('uidnumber', 'uid', 'homedirectory');
		$preset = $this->autoSet($attributes);
		foreach($this->data['Person'] as $key => $value){
			$preset[$key] = $value; 
		}
		$this->data['Person'] = $preset;
		
		$groups = $this->Ldap->getGroups(array('cn','gidnumber'),null,'posixgroup');
		foreach($groups as $group){
			$groupList[$group['gidnumber']] = $group['cn'];
		}
		natcasesort($groupList);
		$this->set('groups',$groupList);
		$this->layout = 'people';
	}
	
	function view( $id ){
		if(!empty($id)){
			$filter = $this->Person->primaryKey."=".$id;
			$people = $this->Person->find('first', array( 'conditions'=>$filter));
			$this->set(compact('people'));
		}
		$this->layout = 'people';
	}

	function myAccount(){
		
		if(!empty($this->data)){
			$udata = $this->LdapAuth->user();
			$dn = $udata[$this->LdapAuth->userModel]['dn'];
			$this->Person->id = $udata[$this->LdapAuth->userModel][$this->Person->primaryKey];
			if(!empty($this->data['Person']['password']) && $this->data['Person']['password'] == $this->data['Person']['password_confirm']){
				$this->data['Person']['userpassword'] = $this->data['Person']['password'];
				
				$udata[$this->LdapAuth->userModel]['bindPasswd'] = $this->data['Person']['password'];
			}
			unset($this->data['Person']['password']);
			unset($this->data['Person']['password_confirm']);
			if ($this->Person->save($this->data)) {
				$this->data = $this->Person->find('first',array('targetDn'=>$dn, 'scope'=>'base'));
				$user = array_merge($udata[$this->LdapAuth->userModel], $this->data['Person']);
				$this->Session->write($this->LdapAuth->sessionKey, $user);
				$this->Session->setFlash('Your Account Has Been Updated.');
			}else{
				$this->Session->setFlash("Couldn't update your account, Sorry.  Please notify your support Team.");
			}
		}else{
			$udata = $this->LdapAuth->user();
			$dn = $udata[$this->LdapAuth->userModel]['dn'];
			$this->data['Person'] = $udata[$this->LdapAuth->userModel];
		}
		$passwordReset = $this->Ldap->canChangePassword($dn);
		$groups = $this->Ldap->getGroups(array('cn'), $dn);
		$computers = $this->Ldap->getComputers(array('cn'), $dn);
		$sudoers = $this->Ldap->getSudoers(array('cn'), $dn);
		$this->set('passwordReset', $passwordReset);
		$this->set('groups', $groups);
		$this->set('computers', $computers);
		$this->set('sudoers', $sudoers);
		$this->layout = 'people';
	}

	function delete($id = null) {
		$this->Person->id = $id;
		return $this->Person->del($id);
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
