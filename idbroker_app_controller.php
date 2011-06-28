<?php
/* SVN FILE: $Id: app_controller.php 7945 2008-12-19 02:16:01Z gwoo $ */
/**
 * Short description for file.
 *
 * This file is application-wide controller file. You can put all
 * application-wide controller-related methods here.
 *
 * PHP versions 4 and 5
 *
 * CakePHP(tm) :  Rapid Development Framework (http://www.cakephp.org)
 * Copyright 2005-2008, Cake Software Foundation, Inc. (http://www.cakefoundation.org)
 *
 * Licensed under The MIT License
 * Redistributions of files must retain the above copyright notice.
 *
 * @filesource
 * @copyright     Copyright 2005-2008, Cake Software Foundation, Inc. (http://www.cakefoundation.org)
 * @link          http://www.cakefoundation.org/projects/info/cakephp CakePHP(tm) Project
 * @package       cake
 * @subpackage    cake.app
 * @since         CakePHP(tm) v 0.2.9
 * @version       $Revision: 7945 $
 * @modifiedby    $LastChangedBy: gwoo $
 * @lastmodified  $Date: 2008-12-18 18:16:01 -0800 (Thu, 18 Dec 2008) $
 * @license       http://www.opensource.org/licenses/mit-license.php The MIT License
 */
/**
 * Short description for class.
 *
 * Add your application-wide methods in the class below, your controllers
 * will inherit them.
 *
 * @package       cake
 * @subpackage    cake.app
 */
class IdbrokerAppController extends Controller {
	var $helpers = array('Html','Javascript','Ajax');
	var $components = array('RequestHandler', 'LDAPAuth', 'LDAPAcl', 'SettingsHandler'); // This should give ajax paginator support??
        var $settings;

        function initialize() {
                $this->settings = $this->SettingsHandler->getSettings();
        }

        function beforeFilter() {
	
                $this->LDAPAuth->allow('*');
                $this->LDAPAuth->allowedActions = array('display');
                //Configure LDAPAuthComponent
                $this->LDAPAuth->actionPath = 'controllers/';
                $this->LDAPAuth->authorize = 'actions';
                $this->LDAPAuth->loginAction = array('controller' => 'LdapAuths', 'action' => 'login');
                $this->LDAPAuth->logoutRedirect = array('controller' => 'LdapAuths', 'action' => 'login');
		$this->LDAPAuth->loginError = "Invalid Username or Password";
		$this->LDAPAuth->authError = "None shall pass!  OK, actually you just don't have permission to go there";
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
