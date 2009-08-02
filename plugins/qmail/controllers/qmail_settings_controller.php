<?php
class QmailSettingsController extends QmailAppController {
	var $name = 'QmailSettings';
	var $uses = array('Qmail.QmailSetting');
	var $components = array('RequestHandler', 'SettingsHandler');
	var $helpers = array('Form','Html','Javascript', 'Ajax');
	
	function index(){
		if(!empty($this->data)){
			$this->log("Trying To Save Settings:".print_r($this->data,true),'debug');
			$this->SettingsHandler->setSettings('settings', $this->data);
		}
		$settings = $this->SettingsHandler->getSettings();
		$this->log("Loading Settings:".print_r($settings,true)."\nCheck Paths:".print_r(Configure::corePaths('cake'),true),'debug');
	
		$this->data = $settings;
	}
}
?>