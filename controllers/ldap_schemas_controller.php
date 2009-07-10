<?php

class LdapSchemasController extends AppController{
	var $name       = 'LdapSchemas';
	var $useTable   = false;
	var $useDbConfig = 'ldap';
        var $ds;

        function __construct(){
                parent::__construct();
		//$this->log(print_r($this,true),'error');
/*
                Configure::load('database');
                $this->host = Configure::read('ldap.host');
                $this->port = Configure::read('ldap.port');
                $this->baseDn = Configure::read('ldap.baseDN');
                $this->bindUser = Configure::read('ldap.bindUser');
                $this->bindPasswd = Configure::read('ldap.bindPasswd');

                $this->ds = ldap_connect($this->host, $this->port);
                if($this->ds == false) $this->log("Error Connecting to ".$this->host." on ".print_r($this->config,true),'error');
                ldap_set_option($this->ds, LDAP_OPT_PROTOCOL_VERSION, 3);
                if ($this->bindUser) {
                        ldap_bind($this->ds, $this->bindUser, $this->bindPasswd);
                } else {
                        //Do an anonymous bind.
                        ldap_bind($this->ds);
                }
*/
        }

        function __destruct(){
        }




	public function index(){

		//$data = ConnectionManager::getDataSource($this->useDbConfig);
		$data = $this->LdapSchema->findSchema('person');
		$this->set('data', $data);
		
	}

}

?>
