<?php
class ShadowaccountSchemasController extends ShadowAppController {
        var $name = 'ShadowaccountSchemas';
        var $uses = array('Shadow.ShadowaccountSchema');
        var $components = array('RequestHandler', 'Ldap');
        var $helpers = array('Form','Html','Javascript', 'Ajax');

        function edit( $id ){
                if(!empty($this->data)){
                        if(isset($this->data['ShadowaccountSchema']['dn']) && !empty($this->data['ShadowaccountSchema']['dn']) ){
                                $this->ShadowaccountSchema->id = $this->data['ShadowaccountSchema']['dn'];
                        }

                        if(isset($this->data['ShadowaccountSchema']['shadowlastchange']) && !empty($this->data['ShadowaccountSchema']['shadowlastchange']) ){
                                $this->data['ShadowaccountSchema']['shadowlastchange'] = ceil(strtotime($this->data['ShadowaccountSchema']['shadowlastchange']) / 86400);
                        }
                        if(isset($this->data['ShadowaccountSchema']['shadowexpire']) && !empty($this->data['ShadowaccountSchema']['shadowexpire']) ){
                                $this->data['ShadowaccountSchema']['shadowexpire'] = ceil(strtotime($this->data['ShadowaccountSchema']['shadowexpire']) / 86400);
                        }
                        $result = $this->ShadowaccountSchema->save($this->data);
                        if($result != false){
                                $this->Session->setFlash('Your shadow settings have been updated.');
                        }else{
                                $this->Session->setFlash('Failed to update');
                        }
                }else{
                        $options['scope'] = 'base';
                        $options['targetDn'] = $id;
                        $options['conditions'] = 'objectclass=Shadowaccount';
                        $this->data = $this->ShadowaccountSchema->find('first', $options);
                }

                $this->layout = 'ajax';
        }


}
?>