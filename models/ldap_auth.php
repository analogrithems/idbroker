<?php 
class LdapAuth extends IdbrokerAppModel {
	var $name = 'LdapAuth';
	var $useDbConfig;
	var $primaryKey;
	var $useTable = ''; // Needed for LDAP datasource

	function __construct(){
                $primaryKey = Configure::read('LDAP.User.Identifier');
                $useDbConfig = Configure::read('LDAP.Db.Config');
                $this->primaryKey = empty($primaryKey) ? 'uid' : $primaryKey;
                $this->useDbConfig = empty($useDbConfig) ? 'ldap' : $useDbConfig;
		parent::__construct();
	}
		
}
?>
