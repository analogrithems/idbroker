<?php
class SudoSchemasController extends SudoAppController {
	var $name = 'SudoSchemas';
	var $uses = array('Sudo.SudoSchema');
	var $components = array('RequestHandler', 'Ldap');
	var $helpers = array('Form','Html','Javascript', 'Ajax');
	
	function index() {
	  	//...
	}
	
	function edit( $id ){
		if(!empty($this->data)){
			if(isset($this->data['SudoSchema']['dn']) && !empty($this->data['SudoSchema']['dn']) ){
				$this->SudoSchema->id = $this->data['SudoSchema']['dn'];
			}
			unset($this->data['SudoSchema']['nonuniquemember']);
			unset($this->data['SudoSchema']['nonmemberuid']);
			unset($this->data['SudoSchema']['nonsudouser']);
			unset($this->data['SudoSchema']['nonsudohost']);
			unset($this->data['SudoSchema']['nonsudogrunasgroup']);
			$this->log("What I'm Going to save".print_r($this->data['SudoSchema'],true)."\nFor the following ID:".$this->SudoSchema->id,'debug');
			$result = $this->SudoSchema->save($this->data);
			if($result != false){
				$this->Session->setFlash('Your Sudo Role has been updated.');
			}else{
				$this->Session->setFlash('Failed to update');
			}
		}else{
			$options['scope'] = 'base';
			$options['targetDn'] = $id;
			$options['conditions'] = 'objectclass=sudorole';	
			$this->data = $this->SudoSchema->find('first', $options);
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

		//Remove sudoUsers already in this sudo role
		if(isset($this->data['SudoSchema']['sudouser']) && is_array($this->data['SudoSchema']['sudouser']) ){
			foreach($this->data['SudoSchema']['sudouser'] as $sudouser){
				unset($sudousers[$sudouser]);
			}
		}elseif(isset($this->data['SudoSchema']['sudouser'])){
			unset($sudousers[$this->data['SudoSchema']['sudouser']]);
		}
		//Remove host already in this role
		if(isset($this->data['SudoSchema']['sudohost']) && is_array($this->data['SudoSchema']['sudohost']) ){
			foreach($this->data['SudoSchema']['sudohost'] as $sudohost){
				unset($sudohosts[$sudohost]);
			}
		}elseif(isset($this->data['SudoSchema']['sudohost'])){
			unset($sudohosts[$this->data['SudoSchema']['sudohost']]);
		}
		//Remove groups already in this role
		if(isset($this->data['SudoSchema']['sudorunasgroup']) && is_array($this->data['SudoSchema']['sudorunasgroup']) ){
			foreach($this->data['SudoSchema']['sudorunasgroup'] as $sudorunasgroup){
				unset($sudogroups[$sudorunasgroup]);
			}
		}elseif(isset($this->data['SudoSchema']['sudorunasgroup'])){
			unset($sudogroups[$this->data['SudoSchema']['sudorunasgroup']]);
		}

		$this->set(compact('sudousers'));
		$this->set(compact('sudohosts'));
		$this->set(compact('sudogroups'));

		$this->layout = 'ajax';
	}
}
?>
