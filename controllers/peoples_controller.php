<?php
class PeoplesController extends AppController {

	var $name = 'Peoples';    
	var $components = array('RequestHandler', 'Ldap', 'SettingsHandler');
	var $helpers = array('Form','Html','Javascript', 'Ajax');

 
	function add(){
		if(!empty($this->data)){
			$this->data['People']['objectclass'] = array('top', 'organizationalperson', 'inetorgperson','person','posixaccount','shadowaccount');

			if($this->data['People']['password'] == $this->data['People']['password_confirm']){
				$this->data['People']['userpassword'] = $this->data['People']['password'];
				unset($this->data['People']['password']);
				unset($this->data['People']['password_confirm']);
			
				if(!isset($this->data['People']['homedirectory'])&& isset($this->data['People']['uid'])){
					$this->data['People']['homedirectory'] = '/home/'.$this->data['People']['uid'];
				}

				$cn = $this->data['People']['cn'];
				if ($this->People->save($this->data)) {
					$this->Session->setFlash($cn.' was added Successfully.');
					$id = $this->People->id;
					$this->redirect(array('action' => 'view', 'id'=> $id));
				}else{
					$this->Session->setFlash("$cn couldn't be created.");
				}
			}else{
				$this->Session->setFlash("Passwords don't match.");
			}
		}
		$settings = $this->SettingsHandler->getSettings();
		if(isset($settings['auto']['uidnumber']) && !empty($settings['auto']['uidnumber'])){
			$path = $settings['auto']['uidnumber'];
			$nuid = $this->requestAction($path, array('return'=>true));
			$this->data['People']['uidnumber'] = $nuid;
		}
		
		$groups = $this->Ldap->getGroups(array('cn','gidnumber'),null,'posixgroup');
		foreach($groups as $group){
			$groupList[$group['gidnumber']] = $group['cn'];
		}
		natcasesort($groupList);
		$this->log("Group ID:".print_r($groupList,true),'debug');
		$this->set('groups',$groupList);
		$this->layout = 'people';
	}
	
	function view( $id ){
		if(!empty($id)){
			$filter = $this->People->primaryKey."=".$id;
			$people = $this->People->find('first', array( 'conditions'=>$filter));
			$this->log("Dump of view: ".print_r($people,true),'debug');
			$this->set(compact('people'));
		}
		$this->layout = 'people';
	}

	function myAccount(){
		
		if(!empty($this->data)){
			$udata = $this->LdapAuth->user();
			$dn = $udata[$this->LdapAuth->userModel]['dn'];
			$this->log("Current Session".print_r($udata,true),'debug');
			$this->People->id = $udata[$this->LdapAuth->userModel][$this->People->primaryKey];
			$this->log("People->id".print_r($user,true),'debug');
			if(!empty($this->data['People']['password']) && $this->data['People']['password'] == $this->data['People']['password_confirm']){
				$this->data['People']['userpassword'] = $this->data['People']['password'];
				
				$udata[$this->LdapAuth->userModel]['bindPasswd'] = $this->data['People']['password'];
			}
			unset($this->data['People']['password']);
			unset($this->data['People']['password_confirm']);

			$this->log("Trying To update my account with: ".print_r($this->data,true),'debug');
			if ($this->People->save($this->data)) {
				$this->data = $this->People->find('first',array('targetDn'=>$dn, 'scope'=>'base'));
				$user = array_merge($udata[$this->LdapAuth->userModel], $this->data['People']);

				$this->log("Reset Current Session".print_r($user,true),'debug');
				$this->Session->write($this->LdapAuth->sessionKey, $user);
				$this->Session->setFlash('Your Account Has Been Updated.');
			}else{
				$this->Session->setFlash("Couldn't update your account, Sorry.  Please notify your support Team.");
			}

		}else{
			$udata = $this->LdapAuth->user();
			$dn = $udata[$this->LdapAuth->userModel]['dn'];
			$this->data['People'] = $udata[$this->LdapAuth->userModel];
		$this->log("Current Session".print_r($udata,true),'debug');
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
		$this->People->id = $id;
		return $this->People->del($id);
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
