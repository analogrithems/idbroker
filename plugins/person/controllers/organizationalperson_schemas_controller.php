<?php
class OrganizationalpersonSchemasController extends PersonAppController {
	var $name = 'OrganizationalpersonSchemas';
	var $uses = array('Person.OrganizationalpersonSchema');
	var $components = array('RequestHandler', 'Ldap');
	var $helpers = array('Form','Html','Javascript', 'Ajax');
	
        function edit( $id ){
                if(!empty($this->data)){
                        $this->OrganizationalpersonSchema->id = $dn;
                        $this->log("What I'm Going to save".print_r($this->data['OrganizationalpersonSchema'],true)."\nFor the following ID:".$this->OrganizationalpersonSchema->id,'debug');
                        $result = $this->OrganizationalpersonSchema->save($this->data);
                        if($result != false){
                                $this->Session->setFlash('Your Organization info has been updated.');
                        }else{
                                $this->Session->setFlash('Failed to update');
                        }
                }else{
                        $options['scope'] = 'base';
                        $options['targetDn'] = $id;
                        $options['conditions'] = 'objectclass=inetorgperson';
                        $this->data = $this->OrganizationalpersonSchema->find('first', $options);
                }
                $this->layout = 'ajax';
        }
}
?>
