<?php
class QmailuserSchemasController extends QmailAppController {
	var $name = 'QmailuserSchemas';
	var $uses = array('Qmail.QmailuserSchema');
	var $components = array('RequestHandler', 'Ldap');
	var $helpers = array('Form','Html','Javascript', 'Ajax');
	
	function edit( $id ){
		if(!empty($this->data)){
			if(isset($this->data['QmailuserSchema']['dn']) && !empty($this->data['QmailuserSchema']['dn']) ){
				$this->QmailuserSchema->id = $this->data['QmailuserSchema']['dn'];
			}

			if(isset($this->data['QmailuserSchema']['mailquotasize']) && $this->data['QmailuserSchema']['mailquotasize'] == 'none' ){
				unset($this->data['QmailuserSchema']['mailquotasize']);
			}
			if(isset($this->data['QmailuserSchema']['mailquotacount']) && $this->data['QmailuserSchema']['mailquotacount'] == 'none' ){
				unset($this->data['QmailuserSchema']['mailquotacount']);
			}
			$this->log("What I'm Going to save".print_r($this->data['QmailuserSchema'],true)."\nFor the following ID:".$this->QmailuserSchema->id,'debug');
			$result = $this->QmailuserSchema->save($this->data);
			if($result != false){
				$this->Session->setFlash('Your Qmail settings have been updated.');
			}else{
				$this->Session->setFlash('Failed to update');
			}
		}else{
			$options['scope'] = 'base';
			$options['targetDn'] = $id;
			$options['conditions'] = 'objectclass=Qmailuser';	
			$this->data = $this->QmailuserSchema->find('first', $options);
		}

		$this->layout = 'ajax';
	}
}
?>