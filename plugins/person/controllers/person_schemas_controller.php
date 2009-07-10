<?php
class PersonSchemasController extends PersonAppController {
	var $name = 'PersonSchemas';
	var $uses = array('Person.PersonSchema');
	var $components = array('RequestHandler', 'Ldap');
	var $helpers = array('Form','Html','Javascript', 'Ajax');
	
        function edit( $id ){
                if(!empty($this->data)){
                        $this->PersonSchema->id = $dn;
                        $this->log("What I'm Going to save".print_r($this->data['PersonSchema'],true)."\nFor the following ID:".$this->PersonSchema->id,'debug');
                        $result = $this->PersonSchema->save($this->data);
                        if($result != false){
                                $this->Session->setFlash('Your Account info has been updated.');
                        }else{
                                $this->Session->setFlash('Failed to update');
                        }
                }else{
                        $options['scope'] = 'base';
                        $options['targetDn'] = $id;
                        $options['conditions'] = 'objectclass=inetorgperson';
                        $this->data = $this->PersonSchema->find('first', $options);
                }
                $this->layout = 'ajax';
        }

}
?>
