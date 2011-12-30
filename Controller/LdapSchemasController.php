<?php

class LdapSchemasController extends IdbrokerAppController{
	var $name       = 'LdapSchemas';
	var $useTable   = false;
	var $useDbConfig = 'ldap';
        var $ds;

        function __construct(){
                parent::__construct();
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
