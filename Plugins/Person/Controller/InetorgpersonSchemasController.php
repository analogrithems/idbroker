<?php
class InetorgpersonSchemasController extends PersonAppController {
	var $name = 'InetorgpersonSchemas';
	var $uses = array('Person.InetorgpersonSchema');
	var $components = array('RequestHandler', 'Ldap');
	var $helpers = array('Form','Html','Javascript', 'Ajax');
	
        function edit( $id ){
                if(!empty($this->request->data)){
                        $this->InetorgpersonSchema->id = $dn;
                        $this->log("What I'm Going to save".print_r($this->request->data['InetorgpersonSchema'],true)."\nFor the following ID:".$this->InetorgpersonSchema->id,'debug');
                        $result = $this->InetorgpersonSchema->save($this->request->data);
                        if($result != false){
                                $this->Session->setFlash('Your contact info has been updated.');
                        }else{
                                $this->Session->setFlash('Failed to update');
                        }
                }else{
                        $options['scope'] = 'base';
                        $options['targetDn'] = $id;
                        $options['conditions'] = 'objectclass=inetorgperson';
                        $this->request->data = $this->InetorgpersonSchema->find('first', $options);
                }
                $this->layout = 'ajax';
        }

}
?>
