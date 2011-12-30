<?php
class QmailuserSchemasController extends QmailAppController {
	var $name = 'QmailuserSchemas';
	var $uses = array('Qmail.QmailuserSchema');
	var $components = array('RequestHandler', 'Ldap');
	var $helpers = array('Form','Html','Javascript', 'Ajax');
	
	function edit( $id ){
		if(!empty($this->request->data)){
			if(isset($this->request->data['QmailuserSchema']['dn']) && !empty($this->request->data['QmailuserSchema']['dn']) ){
				$this->QmailuserSchema->id = $this->request->data['QmailuserSchema']['dn'];
			}

			if(isset($this->request->data['QmailuserSchema']['mailquotasize']) && $this->request->data['QmailuserSchema']['mailquotasize'] == 'none' ){
				unset($this->request->data['QmailuserSchema']['mailquotasize']);
			}
			if(isset($this->request->data['QmailuserSchema']['mailquotacount']) && $this->request->data['QmailuserSchema']['mailquotacount'] == 'none' ){
				unset($this->request->data['QmailuserSchema']['mailquotacount']);
			}
			$this->log("What I'm Going to save".print_r($this->request->data['QmailuserSchema'],true)."\nFor the following ID:".$this->QmailuserSchema->id,'debug');
			$result = $this->QmailuserSchema->save($this->request->data);
			if($result != false){
				$this->Session->setFlash('Your Qmail settings have been updated.');
			}else{
				$this->Session->setFlash('Failed to update');
			}
		}else{
			$options['scope'] = 'base';
			$options['targetDn'] = $id;
			$options['conditions'] = 'objectclass=Qmailuser';	
			$this->request->data = $this->QmailuserSchema->find('first', $options);
		}

		$this->layout = 'ajax';
	}
}
?>