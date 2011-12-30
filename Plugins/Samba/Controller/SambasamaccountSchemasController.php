<?php
class SambasamaccountSchemasController extends SambaAppController {
	var $name = 'SambasamaccountSchemas';
	var $uses = array('Samba.SambasamaccountSchema');
	var $components = array('RequestHandler', 'Ldap');
	var $helpers = array('Form','Html','Javascript', 'Ajax');
	
	function index() {
	  	//...
	}
	
	function edit( $id ){
		if(!empty($this->request->data)){
			if(isset($this->request->data['SambasamaccountSchema']['dn']) && !empty($this->request->data['SambasamaccountSchema']['dn']) ){
				$this->SambasamaccountSchema->id = $this->request->data['SambasamaccountSchema']['dn'];
			}

			$this->log("What I'm Going to save".print_r($this->request->data['SambasamaccountSchema'],true)."\nFor the following ID:".$this->SambasamaccountSchema->id,'debug');
			$result = $this->SambasamaccountSchema->save($this->request->data);
			if($result != false){
				$this->Session->setFlash('Your windows settings have been updated.');
			}else{
				$this->Session->setFlash('Failed to update');
			}
		}else{
			$options['scope'] = 'base';
			$options['targetDn'] = $id;
			$options['conditions'] = 'objectclass=Sambasamaccountrole';	
			$this->request->data = $this->SambasamaccountSchema->find('first', $options);
		}

		$this->layout = 'ajax';
	}
}
?>