<?php
class ShadowaccountSchemasController extends ShadowAppController {
        var $name = 'ShadowaccountSchemas';
        var $uses = array('Shadow.ShadowaccountSchema');
        var $components = array('RequestHandler', 'Ldap');
        var $helpers = array('Form','Html','Javascript', 'Ajax');

        function edit( $id ){
                if(!empty($this->request->data)){
                        if(isset($this->request->data['ShadowaccountSchema']['dn']) && !empty($this->request->data['ShadowaccountSchema']['dn']) ){
                                $this->ShadowaccountSchema->id = $this->request->data['ShadowaccountSchema']['dn'];
                        }

                        if(isset($this->request->data['ShadowaccountSchema']['shadowlastchange']) && !empty($this->request->data['ShadowaccountSchema']['shadowlastchange']) ){
                                $this->request->data['ShadowaccountSchema']['shadowlastchange'] = ceil(strtotime($this->request->data['ShadowaccountSchema']['shadowlastchange']) / 86400);
                        }
                        if(isset($this->request->data['ShadowaccountSchema']['shadowexpire']) && !empty($this->request->data['ShadowaccountSchema']['shadowexpire']) ){
                                $this->request->data['ShadowaccountSchema']['shadowexpire'] = ceil(strtotime($this->request->data['ShadowaccountSchema']['shadowexpire']) / 86400);
                        }
                        $result = $this->ShadowaccountSchema->save($this->request->data);
                        if($result != false){
                                $this->Session->setFlash('Your shadow settings have been updated.');
                        }else{
                                $this->Session->setFlash('Failed to update');
                        }
                }else{
                        $options['scope'] = 'base';
                        $options['targetDn'] = $id;
                        $options['conditions'] = 'objectclass=Shadowaccount';
                        $this->request->data = $this->ShadowaccountSchema->find('first', $options);
                }

                $this->layout = 'ajax';
        }


}
?>