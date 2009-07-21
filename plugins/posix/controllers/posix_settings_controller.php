<?php
class PosixSettingsController extends PosixAppController {
        var $name = 'PosixSettings';
        var $uses = array('Posix.PosixSetting');
        var $components = array('RequestHandler', 'SettingsHandler');
        var $helpers = array('Form','Html','Javascript', 'Ajax');
 
        function index(){
                if(!empty($this->data)){
                        $this->log("Trying To Save Settings:".print_r($this->data,true),'debug');
                        if($this->data['PosixSetting']['autouidnumber'] == true){
                                $this->SettingsHandler->AutoSet('uidnumber', array('/posix/PosixaccountSchema/findUniqueUidNumber'));
                                unset($this->data['PosixSetting']['autouidnumber']);
                        }
                        if($this->data['PosixSetting']['autogidnumber'] == true){
                                $this->SettingsHandler->AutoSet('gidnumber', array('/posix/PosixgroupSchema/findUniqueGidNumber'));
                                unset($this->data['PosixSetting']['autogidnumber']);
                        }
                        if($this->data['PosixSetting']['syncwithuniquemember'] == true){
                                $this->SettingsHandler->SyncWith('uniquemember', array('/posix/PosixgroupSchema/syncGroup'=>array('dn')));
                                unset($this->data['PosixSetting']['syncwithuniquemember']);
                        }
 
                        $this->SettingsHandler->setSettings($this->data);
                }
                $settings = $this->SettingsHandler->getSettings();
                $this->log("Loading Settings:".print_r($settings,true)."\nCheck Paths:".print_r(Configure::corePaths('cake'),true),'debug');
 
                $this->data = $settings;
        }
}
?>