<?php
class IphostSchemasController extends ComputerAppController {
	var $name = 'IphostSchemas';
	var $uses = array('Computer.IphostSchema');
	var $components = array('RequestHandler', 'Ldap');
	var $helpers = array('Form','Html','Javascript', 'Ajax');
	
	
	function edit( $id ){
		if(!empty($this->request->data)){
			if(isset($this->request->data['IphostSchema']['dn']) && !empty($this->request->data['IphostSchema']['dn']) ){
				$id = $this->request->data['IphostSchema']['dn'];
			}
			$this->IphostSchema->id = $id;
			$this->log("What I'm Going to save".print_r($this->request->data['IphostSchema'],true)."\nFor the following ID:".$this->IphostSchema->id,'debug');
			$result = $this->IphostSchema->save($this->request->data);
			if($result != false){
				$this->Session->setFlash('Your Computer has been updated.');
			}else{
				$this->Session->setFlash('Failed to update');
			}
		}

		$options['targetDn'] = $id;
		$options['scope'] = 'base';
		$this->request->data = $this->IphostSchema->find('first', $options);
		$this->layout = 'ajax';
	}
}
?>
