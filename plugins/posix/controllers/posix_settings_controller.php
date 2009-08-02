<?php
class PosixSettingsController extends PosixAppController {
        var $name = 'PosixSettings';
        var $uses = array('Posix.PosixSetting');
        var $components = array('RequestHandler', 'SettingsHandler');
        var $helpers = array('Form','Html','Javascript', 'Ajax');
	var $uuidCallback = '/posix/PosixaccountSchema/findUniqueUidNumber';
	var $ugidCallback = '/posix/PosixgroupSchema/findUniqueGidNumber';
	var $groupSyncCallback = '/posix/PosixgroupSchema/syncGroup';
 
        function index(){
                if(!empty($this->data)){
                        $this->log("Trying To Save Settings:".print_r($this->data,true),'debug');
                        if($this->data['PosixSetting']['autouidnumber'] == true){
                                $this->SettingsHandler->AutoSet('uidnumber', $this->uuidCallback);
                        }
                        if($this->data['PosixSetting']['autogidnumber'] == true){
                                $this->SettingsHandler->AutoSet('gidnumber', $this->ugidCallback);
                        }
                        if($this->data['PosixSetting']['syncwithuniquemember'] == true){
                                $this->SettingsHandler->SyncWith('uniquemember', $this->groupSyncCallback, array('dn'));
                        }
			unset($this->data['PosixSetting']['autouidnumber']);
			unset($this->data['PosixSetting']['autogidnumber']);
			unset($this->data['PosixSetting']['syncwithuniquemember']);
 
                        $this->SettingsHandler->setSettings($this->data);
                }
                $settings = $this->SettingsHandler->getSettings();
                $this->data = $settings;
		if($this->SettingsHandler->isAutoSet('uidnumber', $this->uuidCallback)){
			$this->data['PosixSetting']['autouidnumber'] = true;
		}
		if($this->SettingsHandler->isAutoSet('gidnumber',$this->ugidCallback)){
			$this->data['PosixSetting']['autogidnumber'] = true;
		}
		if($this->SettingsHandler->isSyncWith('uniquemember',$this->groupSyncCallback)){
			$this->data['PosixSetting']['syncwithuniquemember'] = true;
		}
		$this->log("Posix Settings:".print_r($this->data,true),'debug');
        }
}
?>
