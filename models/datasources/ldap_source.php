<?php
/**
 * LdapSource
 * @author euphrate_ylb (base class + "R" in CRUD)
 * @author gservat (aka znoG) ("C", "U", "D" in CRUD)
 * @date 07/2007 (updated 04/2008)
 * @license GPL
 */
class LdapSource extends DataSource {
    var $description = "Ldap Data Source";
    var $cacheSources = true;
    var $SchemaResults = false;
    var $database = null;
    var $count = 0;
    var $model;

    //for formal querys
    var $_result = false;
    
    var $_baseConfig = array (
        'host' => 'localhost',
        'port' => 389,
        'version' => 3
    );
    
    var $_multiMasterUse = 0;
    var $__descriptions = array();
    
    // Lifecycle --------------------------------------------------------------
    /**
     * Constructor
     */
    function __construct($config = null) {
        $this->debug = Configure :: read() > 0;
        $this->fullDebug = Configure :: read() > 1;
        parent::__construct($config);
        return $this->connect();
    }
    
    /**
     * Destructor. Closes connection to the database.
     *
     */
    function __destruct() {
        $this->close();
        parent :: __destruct();
    }
    
    // I know this looks funny, and for other data sources this is necessary but for LDAP, we just return the name of the field we're passed as an argument
    function name( $field ) {
        return $field;
    }
    
    // Connection --------------------------------------------------------------
    function connect() {
        $config = $this->config;
		$this->log("LDAP Config Dump:".print_r($config,true),'ldap.error');
        $this->connected = false;
        $hasFailover = false;
		if(isset($config['host']) && is_array($config['host']) ){
			$config['host'] = $config['host'][$this->_multiMasterUse];
			if(count($this->config['host']) > (1 + $this->_multiMasterUse) ) 
				$hasFailOver = true;
		}
	
		$bindDN     =  (empty($this->myDN)) ? $config['login'] : $this->myDN;
		$bindPasswd =  (empty($this->myPasswd)) ? $config['password'] : $this->myPasswd;
		$this->database = ldap_connect($config['host']);
		if(!$this->database){
		    $this->log("Failed to connect to LDAP SSL Server:".$config['host'],'ldap.error');
		    //Try Next Server Listed
		    if($hasFailover){
		    	$this->_multiMasterUse++;
		    	$this->log('Trying Next LDAP Server in list:'.$this->config['host'][$this->_multiMasterUse],'ldap.error');
		    	$this->connect();
		    	