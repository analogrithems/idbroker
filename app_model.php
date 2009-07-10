<?php
/* SVN FILE: $Id: app_model.php 7945 2008-12-19 02:16:01Z gwoo $ */

/**
 * Application model for Cake.
 *
 * This file is application-wide model file. You can put all
 * application-wide model-related methods here.
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
 * Application model for Cake.
 *
 * Add your application-wide methods in the class below, your models
 * will inherit them.
 *
 * @package       cake
 * @subpackage    cake.app
 */
class AppModel extends Model {
	var $bindDN;
	var $bindPasswd;
	var $specific = true;

        function __construct($id = false, $table = null, $ds = null) {
		// Get saved company/database name
		@session_start();
		if(isset($_SESSION['Auth']['User']['bindDN']) && isset($_SESSION['Auth']['User']['bindPasswd'])){
			$this->bindDN = $_SESSION['Auth']['User']['bindDN'];
			$this->bindPasswd = $_SESSION['Auth']['User']['bindPasswd'];
		}else{
			$this->bindDN = null;
                        $this->bindPasswd = null;
		}

		$config = ConnectionManager::getDataSource('ldap')->config;

		// Set correct database name
		$config['login'] = $this->bindDN;
		$config['password'] = $this->bindPasswd;
		$dbName = 'LoggedInUser';
		// Add new config to registry
		ConnectionManager::create($dbName, $config);
		// Point model to new config
		$this->useDbConfig = $dbName;
                parent::__construct($id, $table, $ds);
        } 
	

}
?>
