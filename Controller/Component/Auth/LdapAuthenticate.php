<?php
App::uses('CakeLog', 'Log');
App::uses('BaseAuthenticate', 'Controller/Component/Auth');

class LdapAuthenticate extends BaseAuthenticate {

	/**
	* The name of the model that represents users which will be authenticated.  Defaults to 'User'.
	*
	* @var string
	* @access public
	* @link http://book.cakephp.org/view/1266/userModel
	*/
        var $userModel;
        var $sqlUserModel;
        var $sqlGroupModel;
	

	function __construct(ComponentCollection $collection, $settings = array()) {
		$controller = $collection->getController();
		$this->form = $controller->name;

		$model = Configure::read('LDAP.LdapAuth.Model');
		$model = (isset($settings['userModel'])) ? $settings['userModel'] : $model;

		$this->sqlUserModel = Configure::read('LDAP.LdapAuth.MirrorSQL.Users');
		$this->sqlUserModel = (isset($settings['MirrorSQLUser'])) ? $settings['MirrorSQLUser'] : $this->sqlUserModel;

		$this->sqlGroupModel = Configure::read('LDAP.LdapAuth.MirrorSQL.Groups');
		$this->sqlGroupModel = (isset($settings['MirrorSQLGroup'])) ? $settings['MirrorSQLGroup'] : $this->sqlGroupModel;


		if(isset($this->sqlUserModel) && !empty($this->sqlUserModel) ){
				$this->sqlUserModel =& ClassRegistry::init($this->sqlUserModel);
		}
		if(isset($this->sqlGroupModel) && !empty($this->sqlGroupModel) ){
				$this->sqlGroupModel =& ClassRegistry::init($this->sqlGroupModel);
		}


		$this->groupType = Configure::read('LDAP.groupType');
		$this->groupType = (isset($settings['GroupType'])) ? $settings['GroupType'] : $this->groupType;


		//lets find all of our users groups
		if(!isset($this->groupType) || empty($this->groupType) ){
				$this->groupType = 'group';
		}
		$this->userModel = empty($model) ? 'Idbroker.LdapAuth' : $model;
		$this->model =& ClassRegistry::init($model);
		parent::__construct($collection, $settings);
	}

	public function authenticate(CakeRequest $request, CakeResponse $response) {
		CakeLog::write('debug',"Trying to login with:".print_r($request,true));

                $userModel = $this->settings['userModel'];
                list($plugin, $model) = pluginSplit($userModel);

                $fields = $this->settings['fields'];
                if (empty($request->data[$this->form])) {
                        return false;
                }
                if (
                        empty($request->data[$this->form][$fields['username']]) ||
                        empty($request->data[$this->form][$fields['password']])
                ) {
                        return false;
                }
		$dn = $this->_getDn($this->model->primaryKey, $request->data[$this->form][$fields['username']]);
                return $this->_findLdapUser(
			$dn,
                        $request->data[$this->form][$fields['password']]
                );


	}

	/**
	* Get a user based on information in the request.  Used by cookie-less auth for stateless clients.
	*
	* @param CakeRequest $request Request object.
	* @return mixed Either false or an array of user information
	*/
	public function getUser($request) {
                $username = env('PHP_AUTH_USER');
                $pass = env('PHP_AUTH_PW');

                if (empty($username) || empty($pass)) {
                        return false;
                }
		$dn = $this->_getDn($this->model->primaryKey, $username);
                return $this->_findLdapUser(
                        $dn,
                        $pass
                );
        }


        function _findLdapUser($dn, $password){
                $authResult =  $this->model->auth( array('dn'=>$dn, 'password'=>$password));
		if($authResult == 1){
			$user =  $this->model->find('first', array('scope'=>'base', 'targetDn'=>$dn));
                        $user[$this->model->alias]['bindDN'] = $dn;
                        $user[$this->model->alias]['bindPasswd'] = $password;

			$groups = $this->getGroups($user[$this->model->alias]);

			//This may be removed in the future.  It's an idea I have about creating a SQL user whenever a user exists in LDAP
			if(isset($this->sqlUserModel) && !empty($this->sqlUserModel)){
				$userRecord = $this->existsOrCreateSQLUser($user);
				if($userRecord){
					CakeSession::write('Auth.LdapGroups',$groups);
					//Check if we are mirroring sql for groups
					if(isset($this->sqlGroupModel) && !empty($this->sqlGroupModel)){
						if($sqlGroup = $this->existsOrCreateSQLGroup($userRecord,$groups)){
							CakeSession::write('Auth.'.$this->sqlGroupModel->alias,$groups);
						}else{
							CakeLog::write('ldap.error',"Failed to update sql mirrored groups:".print_r($sqlGroup,1));
						}
					}
					//Stuff the SQL user in there also
					$user[$this->model->alias] =  array_merge($user[$this->model->alias], $userRecord);
				}else{
					CakeLog::write('ldap.error',"Error creating or finding the SQL version of the user: ".print_r($user,1));
				}
			}
			return $user[$this->model->alias];
		}else{
			return false;
		}
        }

        function _getDn( $attr, $query){
                $userObj = $this->model->find('first', array('conditions'=>"$attr=$query", 'scope'=>'sub'));
                return($userObj[$this->model->alias]['dn']);
        }

	function existsOrCreateSQLGroup($user = null, $groups = null){
		if(!$user || !$groups) return false;
		
		$parent_id = Configure::read('LDAP.Group.behavior.tree.parent_id');

		$sqlGroups = array();
		foreach($groups as $groupName=>$dn){
			//If group already exists, add it to our groups list and next
			if($sqlGroup = $this->sqlGroupModel->find('first',array('conditions'=>array('Group.name'=>$groupName)))){
				//group exists, see if user already listed in group, if not add them to sql group
				if(isset($user['username']) && is_string($user['username']) ){
					$userInGroup = false; //Lets see if we find out user
					foreach($sqlGroup[$this->sqlUserModel->alias] as $u){
						if(strtolower($u['username']) == strtolower($user['username'])){
							$sqlGroups[] = $sqlGroup[$this->sqlGroupModel->alias];
						}		
					}
					if(!$userInGroup){//User wasn't found, add him real quick
						$udata[$this->sqlUserModel->alias] = $user;
						if(!isset($udata[$this->sqlGroupModel->alias]) || 
						!in_array($sqlGroup[$this->sqlGroupModel->alias]['id'],$udata[$this->sqlGroupModel->alias]))
							$udata[$this->sqlGroupModel->alias][] = $sqlGroup[$this->sqlGroupModel->alias]['id'];
					}
				}
			}else{ //sqlGroup doesn't exists yet, so create them and add this user to it
				//todo add group
				$data[$this->sqlGroupModel->alias]['name'] = $groupName;
				$data[$this->sqlGroupModel->alias]['dn']  = $dn;
				if(isset($parent_id) && !empty($parent_id) ){
					$data[$this->sqlGroupModel->alias]['parent_id']  = $parent_id;
				}
				$udata[$this->sqlUserModel->alias] = $user;
				if(!isset($udata[$this->sqlGroupModel->alias]) ||  !in_array($this->sqlGroupModel->id,$udata[$this->sqlGroupModel->alias]))
					$udata[$this->sqlGroupModel->alias][] = $this->sqlGroupModel->id;
					
				if($ngroup = $this->sqlGroupModel->saveAll($data)){
					CakeLog::write('debug',"Added new group {$groupName} with user {$user['username']}");
				}else{
					CakeLog::write('ldap.error', "Failed to add new group {$groupName}/{$dn} with user:". print_r($user,1).	
						':Input:'.print_r($data,1).':Result:'.print_r($ngroup,1));
				}
	
			}
		}
		if($gupdate = $this->sqlUserModel->save($udata)){
			CakeLog::write('ldap.debug',"Updating group {$sqlGroup[$this->sqlGroupModel->alias]['name']} to add:".print_r($user,1).
				':With Data:'.print_r($udata,1).':Result:'.print_r($gupdate,1));
		}else{
			CakeLog::write('ldap.error',"Failed to Mirror group {$sqlGroup[$this->sqlGroupModel->alias]['name']} for user:".
				print_r($user,1));
		}
		CakeLog::write('debug',"SQL group result:".print_r($sqlGroups,1).':'.print_r($user,1).':'.print_r($groups,1));
		return (!empty($sqlGroups)) ? $sqlGroups : false;
	}


	function existsOrCreateSQLUser($user){
		//Find out what the LDAP primary key is for the user model, this will be used to know which attribute to lookup the username in
		$userPK = $this->model->primaryKey;
		if(isset($user[$this->model->alias][$userPK]) ) $username = $user[$this->model->alias][$userPK];
		if(is_array($username) && isset($username[0]) && !is_array($username[0]) ) $username = $username[0];

		//Lets See if that username is already in our system
		$result = $this->sqlUserModel->find('first',array('recursive'=>-1,'conditions'=>array('username'=>$username)));
		//If so, lets just return that record and continue working
		if(isset($result)){
			//Check if we are mirroring groups as well, then refresh them
			return $result[$this->sqlUserModel->alias];
		}
		else{
			$this->sqlUserModel->create(); //User doesn't exists, grab it from the auth session and add it to the user table
			if(isset($user['displayname']) && !empty($user['displayname'])) $u['displayname'] = $user['displayname'];
			if(isset($user['dn']) && !empty($user['dn']) ) $u['dn'] = $user['dn'];
			if(isset($username) && !empty($username) ) $u['username'] = $username;
			if(isset($user['mail']) && !empty($user['mail']) ) $u['email'] = $user['mail'];
			//so that it will get a id number for the foreign keys
			if($this->sqlUserModel->save($u)){
				$result = $this->sqlUserModel->find('first', array('recursive'=>-1,'conditions'=>array('username'=>$username)));
				if($result){
					return $result[$this->sqlModel->alias];
				}else return false;
			}else{
				return false;
			}
		}
	}

	function getGroups($user = null){

		if(strtolower($this->groupType) == 'group'){
			CakeLog::write('ldap.debug',"Looking for {$user['dn']} & 'objectclass'=>'group'");
                        $groups = $this->model->find('all',array('conditions'=>array('AND'=>array('objectclass'=>'group', 'member'=>$user['dn'])),'scope'=>'sub'));
		}elseif(strtolower($this->groupType) == 'groupofuniquenames'){
                        $groups = $this->model->find('all',array('conditions'=>array('AND'=>
				array('objectclass'=>'groupofuniquenames', 'uniquemember'=>$user['dn'])),'scope'=>'sub'));
		}elseif(strtolower($this->groupType) == 'posixgroup'){
			$pk = $this->model->primaryKey;
                        $groups = $this->model->find('all',array('conditions'=>array('AND'=>array('objectclass'=>'posixgroup', 'memberuid'=>$user[$pk])),'scope'=>'sub'));
		}

		if(!isset($groups)  || empty($groups)) return false;

		$groupIdentifer = Configure::read('LDAP.Group.Identifier');
		$groupIdentifer = (empty($groupIdentifer)) ? 'cn' : $groupIdentifer;
		foreach($groups as $group){
			$gid = $group[$this->model->alias][$groupIdentifer];
			if(isset($gid)){
				$mygroup[$gid] = $group[$this->model->alias]['dn'];
			}
		}
		//todo loop through groupos to see if any are nested groups that need to be expanded!
		return $mygroup;
	}

}
?>
