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
    var $database = false;
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
    function connect($bindDN = null, $passwd = null) {
        $config = $this->config;
        $this->connected = false;
        $hasFailover = false;
        if(isset($config['host']) && is_array($config['host']) ){
                $config['host'] = $config['host'][$this->_multiMasterUse];
                if(count($this->config['host']) > (1 + $this->_multiMasterUse) ) {
                        $hasFailOver = true;
                }
        }
        $bindDN     =  (empty($bindDN)) ? $config['login'] : $bindDN;
        $bindPasswd =  (empty($passwd)) ? $config['password'] : $passwd;
        $this->database = @ldap_connect($config['host']);
        if(!$this->database){
            //Try Next Server Listed
            if($hasFailover){
                $this->log('Trying Next LDAP Server in list:'.$this->config['host'][$this->_multiMasterUse],'ldap.error');
                $this->_multiMasterUse++;
                $this->connect($bindDN, $passwd);
                if($this->connected){
                        return $this->connected;
                }
            }
        }

        //Set our protocol version usually version 3
        ldap_set_option($this->database, LDAP_OPT_PROTOCOL_VERSION, $config['version']);
        // From Filipee, to allow the user to specify in the db config to use TLS
        // 'tls'=> true in config/database.php
        if ($config['tls']) {
                if (!ldap_start_tls($this->database)) {
                        $this->log("Ldap_start_tls failed", 'ldap.error');
                        fatal_error("Ldap_start_tls failed");
                }
        }
        //So little known fact, if your php-ldap lib is built against openldap like pretty much every linux
        //distro out their like redhat, suse etc. The connect doesn't acutally happen when you call ldap_connect
        //it happens when you call ldap_bind.  So if you are using failover then you have to test here also.
        $bind_result = @ldap_bind($this->database, $bindDN, $bindPasswd);
        if (!$bind_result){
                if(ldap_errno($this->database) == 49){
                        $this->log("Auth failed for '$bindDN'!",'ldap.error');
                }else{
                        $this->log('Trying Next LDAP Server in list:'.$this->config['host'][$this->_multiMasterUse],'ldap.error');
                        $this->_multiMasterUse++;
                        $this->connect($bindDN, $passwd);
                        if($this->connected){
                                return $this->connected;
                        }
                }

        }else{
                 $this->connected = true;
        }
        return $this->connected;
    }

    /**
     * Test if the dn/passwd combo is valid
     */
    function auth( $dn, $passwd ){
        $this->connect($dn, $passwd);
        if ($this->connected){
            return true;
        }else{
            $this->log("Auth Error: for '$dn': ".$this->lastError(),'ldap.error');
            return $this->lastError();
        }
    }


    /**
     * Disconnects database, kills the connection and says the connection is closed,
     * and if DEBUG is turned on, the log for this object is shown.
     *
     */
    function close() {
        if ($this->fullDebug && Configure :: read() > 1) {
            $this->showLog();
        }
        $this->disconnect();
    }

    function disconnect() {
        @ldap_free_result($this->results);
        $this->connected = !@ldap_unbind($this->database);
        return !$this->connected;
    }

    /**
     * Checks if it's connected to the database
     *
     * @return boolean True if the database is connected, else false
     */
    function isConnected() {
        return $this->connected;
    }

    /**
     * Reconnects to database server with optional new settings
     *
     * @param array $config An array defining the new configuration settings
     * @return boolean True on success, false on failure
     */
    function reconnect($config = null) {
        $this->disconnect();
        if ($config != null) {
            $this->config = am($this->_baseConfig, $this->config, $config);
        }
        return $this->connect();
    }

    // CRUD --------------------------------------------------------------
    /**
     * The "C" in CRUD
     *
     * @param Model $model
     * @param array $fields containing the field names
     * @param array $values containing the fields' values
     * @return true on success, false on error
     */
    function create( &$model, $fields = null, $values = null ) {
                $basedn = $this->config['basedn'];
                $key = $model->primaryKey;
                $table = $model->useTable;
        $fieldsData = array();
        $id = null;
        $objectclasses = null;

        if ($fields == null) {
            unset($fields, $values);
            $fields = array_keys($model->data);
            $values = array_values($model->data);
        }

        $count = count($fields);

        for ($i = 0; $i < $count; $i++) {
            if ($fields[$i] == $key) {
                $id = $values[$i];
            }elseif($fields[$i] == 'cn'){
                                $cn = $values[$i];
            }
            $fieldsData[$fields[$i]] = $values[$i];
        }

                //Lets make our DN, this is made from the useTable & basedn + primary key. Logically this corelate to LDAP

                if(isset($table) && preg_match('/=/', $table)){
                        $table = $table.', ';
                }else{ $table = ''; }
                if(isset($key) && !empty($key)){
                        $key = "$key=$id, ";
                }else{
                        //Almost everything has a cn, this is a good fall back.
                        $key = "cn=$cn, ";
                }
                $dn = $key.$table.$basedn;

                $res = @ ldap_add( $this->database, $dn, $fieldsData );
        // Add the entry
        if( $res ){
            $model->setInsertID($id);
            $model->id = $id;
            return true;
        } else {
            $this->log("Failed to add ldap entry: dn:$dn\nData:".print_r($fieldsData,true)."\n".ldap_error($this->database),'ldap.error');
            $model->onError();
            return false;
        }
    }

        /**
         * Returns the query
         *
         */
        function query($find, $query = null, $model){
                if(isset($query[0]) && is_array($query[0])){
                        $query = $query[0];
                }

                if(isset($find)){
                    switch($find){
                        case 'auth':
                                return $this->auth($query['dn'], $query['password']);
                        case 'findSchema':
                                $query = $this->__getLDAPschema();
                                //$this->findSchema($query);
                                break;
                        case 'findConfig':
                                return $this->config;
                                break;
                        default:
                                $query = $this->read($model, $query);
                                break;
                        }
                }
                return $query;
        }
    /**
     * The "R" in CRUD
     *
     * @param Model $model
     * @param array $queryData
     * @param integer $recursive Number of levels of association
     * @return unknown
     */
    function read( &$model, $queryData = array(), $recursive = null ) {
        $this->model = $model;
        $this->__scrubQueryData($queryData);
        if (!is_null($recursive)) {
            $_recursive = $model->recursive;
            $model->recursive = $recursive;
        }

        // Check if we are doing a 'count' .. this is kinda ugly but i couldn't find a better way to do this, yet
        if ( is_string( $queryData['fields'] ) && $queryData['fields'] == 'COUNT(*) AS ' . $this->name( 'count' ) ) {
            $queryData['fields'] = array();
        }

        // Prepare query data ------------------------
        $queryData['conditions'] = $this->_conditions( $queryData['conditions'], $model);
        if(empty($queryData['targetDn'])){
                $queryData['targetDn'] = $model->useTable;
        }
        $queryData['type'] = 'search';

        if (empty($queryData['order']))
                $queryData['order'] = array($model->primaryKey);

        // Associations links --------------------------
        foreach ($model->__associations as $type) {
            foreach ($model->{$type} as $assoc => $assocData) {
                if ($model->recursive > -1) {
                    $linkModel = & $model->{$assoc};
                    $linkedModels[] = $type . '/' . $assoc;
                }
            }
        }

        // Execute search query ------------------------
        $res = $this->_executeQuery($queryData );

        if ($this->lastNumRows()==0)
            return false;

        // Format results  -----------------------------
        ldap_sort($this->database, $res, $queryData['order'][0]);
        $resultSet = ldap_get_entries($this->database, $res);
        $resultSet = $this->_ldapFormat($model, $resultSet);

        // Query on linked models  ----------------------
        if ($model->recursive > 0) {
            foreach ($model->__associations as $type) {

                foreach ($model->{$type} as $assoc => $assocData)