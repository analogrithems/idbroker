<?php 
class LdapAcl extends IdbrokerAppModel {
	var $name = 'LdapAcl';
	var $useDbConfig;
	var $primaryKey;
	var $useTable = false;

	//Reads these values from the config files
        function __construct(){
		$primaryKey = Configure::read('LDAP.User.Identifier');
		$useDbConfig = Configure::read('LDAP.Db.Config');
                $this->primaryKey = empty($primaryKey) ? 'uid' : $primaryKey;
                $this->useDbConfig = empty($useDbConfig) ? 'ldap' : $useDbConfig;
                parent::__construct();
        }
}
?>
