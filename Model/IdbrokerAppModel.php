<?php
class IdbrokerAppModel extends AppModel {
	var $bindDN;
	var $bindPasswd;
	var $specific = true;

        function __construct($id = false, $table = null, $ds = null) {
		$ds = Configure::read('LDAP.Db.Config');
		$config = ConnectionManager::getDataSource($ds)->config;
		@session_start();
		//if already auth, use that login creds
		if(isset($_SESSION['Auth']['User']['bindDN']) && isset($_SESSION['Auth']['User']['bindPasswd'])){
			$this->bindDN = $_SESSION['Auth']['User']['bindDN'];
			$this->bindPasswd = $_SESSION['Auth']['User']['bindPasswd'];
			// Set correct database name
			$config['login'] = $this->bindDN;
			$config['password'] = $this->bindPasswd;
			$dbName = 'LoggedInUser';
			// Add new config to registry
			ConnectionManager::create($dbName, $config);
			// Point model to new config
			$this->useDbConfig = $dbName;
		}


                parent::__construct($id, $table, $ds);
        } 
	

}
?>
