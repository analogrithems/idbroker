<?php
class IdbrokerAppController extends AppController {
	var $helpers = array('Html','Form', 'Js'=>array('Jquery'));
	var $components = array('RequestHandler', 'Session', 'Auth', 'Acl');
        var $settings;

        function initialize() {
                $this->settings = $this->SettingsHandler->getSettings();
        }

        function beforeFilter() {
	
                $this->Auth->authenticate = array('Idbroker.Ldap'=>array('userModel'=>'LdapAuth'));
                $this->Auth->allow('*');
		$this->Auth->authorize = array('Actions' => array('actionPath' => 'controllers/'),'Controller');
		$this->Auth->loginError = "Invalid Username or Password";
		$this->Auth->authError = "None shall pass!  OK, actually you just don't have permission to go there";
        }

	function isAuthorized() {
		return true;
	}
        
        function autoSet( $list ){
                $nlist = array();
                foreach( $list as $attr){
                        $nlist[$attr] = $this->SettingsHandler->autoSet($attr);
                }
                return($nlist);
        }
}
?>
