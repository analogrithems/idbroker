<?php
class GroupofuniquenamesSchemasController extends UniquegroupAppController {
	var $name = 'GroupofuniquenamesSchemas';
	var $uses = array('Uniquegroup.GroupofuniquenamesSchema');
	var $components = array('RequestHandler', 'Ldap');
	var $helpers = array('Form','Html','Javascript', 'Ajax');
	
	
	function edit( $id ){
		if(!empty($this->data)){
			if(isset($this->data['GroupofuniquenamesSchema']['dn']) && !empty($this->data['GroupofuniquenamesSchema']['dn']) ){
				$id = $this->data['GroupofuniquenamesSchema']['dn'];
			}
			$this->GroupofuniquenamesSchema->id = $id;
			unset($this->data['GroupofuniquenamesSchema']['nonuniquemember']);
			$result = $this->GroupofuniquenamesSchema->save($this->data);
			if($result != false){
				$this->Session->setFlash('Your Unique Group has been updated.');
			}else{
				$this->Session->setFlash('Failed to update');
			}
		}

		$options['targetDn'] = $id;
		$options['scope'] = 'base';
		$this->data = $this->GroupofuniquenamesSchema->find('first', $options);
		$members = $this->Ldap->getUsers(array('uid', 'cn'), $id, 'uniquemember');
		foreach ($members as $member){
			$group['members'][$member['dn']] = $member['cn'];
		}
		$nonmembers = $this->Ldap->getUsers(array('uid', 'cn'));
		foreach ($nonmembers as $nonmember){
			if(!isset($group['members'][$nonmember['dn']])){
				$group['nonmembers'][$nonmember['dn']] = $nonmember['cn'];
			}
		}
		//Remove Users already in this group role
		$this->set('groups', $group);
		$this->layout = 'ajax';
	}
}
?>
