<?php
class PosixgroupSchemasController extends PosixAppController {
	var $name = 'PosixgroupSchemas';
	var $uses = array('Posix.PosixgroupSchema');
	var $components = array('RequestHandler', 'Ldap');
	var $helpers = array('Form','Html','Javascript', 'Ajax');
	
	
	function edit( $id ){
		if(!empty($this->data)){
			if(isset($this->data['PosixgroupSchema']['dn']) && !empty($this->data['PosixgroupSchema']['dn']) ){
				$id = $this->data['PosixgroupSchema']['dn'];
			}
			$this->PosixgroupSchema->id = $id;
			unset($this->data['PosixgroupSchema']['nonmemberuid']);
			$this->log("What I'm Going to save".print_r($this->data['PosixgroupSchema'],true)."\nFor the following ID:".$this->PosixgroupSchema->id,'debug');
			$result = $this->PosixgroupSchema->save($this->data);
			if($result != false){
				$this->Session->setFlash('Your Posix Group has been updated.');
			}else{
				$this->Session->setFlash('Failed to update');
			}
		}

		$options['targetDn'] = $id;
		$options['scope'] = 'base';
		$this->data = $this->PosixgroupSchema->find('first', $options);

		$members = $this->Ldap->getUsers(array('uid', 'cn'), $id, 'memberuid');
		foreach ($members as $member){
			$group['members'][$member['uid']] = $member['cn'];
		}
		$nonmembers = $this->Ldap->getUsers(array('uid', 'cn'));
		foreach ($nonmembers as $nonmember){
			if(!isset($group['members'][$nonmember['uid']])){
				$group['nonmembers'][$nonmember['uid']] = $nonmember['cn'];
			}
		}
		//Remove Users already in this group role


		$this->log("Group for $id:".print_r($group,true)."\nThis group looks like:".print_r($this->data,true),'debug');
		$this->set('groups', $group);
		$this->layout = 'ajax';
	}
}
?>
