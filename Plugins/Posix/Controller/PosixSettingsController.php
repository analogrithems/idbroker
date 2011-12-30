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
                if(!empty($this->request->data)){
                        $this->log("Trying To Save Settings:".print_r($this->request->data,true),'debug');
                        if($this->request->data['PosixSetting']['autouidnumber'] == true){
                                $this->SettingsHandler->AutoSet('uidnumber', $this->uuidCallback);
                        }
                        if($this->request->data['PosixSetting']['autogidnumber'] == true){
                                $this->SettingsHandler->AutoSet('gidnumber', $this->ugidCallback);
                        }
                        if($this->request->data['PosixSetting']['syncwithuniquemember'] == true){
                                $this->SettingsHandler->SyncWith('uniquemember', $this->groupSyncCallback, array('dn'));
                        }
			unset($this->request->data['PosixSetting']['autouidnumber']);
			unset($this->request->data['PosixSetting']['autogidnumber']);
			unset($this->request->data['PosixSetting']['syncwithuniquemember']);
 
                        $this->SettingsHandler->setSettings($this->request->data);
                }
                $settings = $this->SettingsHandler->getSettings();
                $this->request->data = $settings;
		if($this->SettingsHandler->isAutoSet('uidnumber', $this->uuidCallback)){
			$this->request->data['PosixSetting']['autouidnumber'] = true;
		}
		if($this->SettingsHandler->isAutoSet('gidnumber',$this->ugidCallback)){
			$this->request->data['PosixSetting']['autogidnumber'] = true;
		}
		if($this->SettingsHandler->isSyncWith('uniquemember',$this->groupSyncCallback)){
			$this->request->data['PosixSetting']['syncwithuniquemember'] = true;
		}
		$this->log("Posix Settings:".print_r($this->request->data,true),'debug');
        }
}
?>
