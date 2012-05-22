<?php
App::import('Component', 'Acl');
class LDAPAclComponent extends IniAcl{

	var $model;  //Model to use that talks to LDAP
	var $modelName;  //Model Name to use that talks to LDAP
	var $groupType;  //posixGroup, groupOfNames or group(Active Directory's group)
	var $init; //if you want to override settings like the model to use without using the Configure:: system

        /**
         * Makes Sure the LDAP Datasource is loaded and available
         *
         */
	function __construct(ComponentCollection $collection, $settings = array()) {
                $model = Configure::read('LDAP.LdapACL.Model');
		$model (isset($settings['Model'])) ? $settings['Model'] : $model;

                $groupType = Configure::read('LDAP.LdapACL.groupType');
                $groupType = (isset($settings['GroupType'])) ? $settings['GroupType'] : $groupType

                $this->groupType = empty($groupType) ? 'groupOfNames' : $groupType;
                $this->modelName = empty($model) ? 'LdapAcl' : $model;
                $this->model = $this->getModel($this->modelName);
		parent::__construct($collection, $settings);
        }


	function initialize($controller, $init=array()) {
		$this->controller = $controller;

                if(isset($this->init['model'])){
			$this->modelName = $this->init['model'];
                        $this->model = $this->getModel($this->init['model']); //Initalize the model
                }
		
                if(isset($this->init['groupType'])){
                        $this->groupType = $init['groupType'];
                }
	}

	/**
	 *  isInGroup( $user, $group)
	 *
	 */
	function isInGroup($user, $group){

		switch($this->groupType){
			case 'posixGroup':
					$scope = 'sub';
					//$filter = '(&(objectClass='.$this->groupType.')(memberUid='.$user.'))';
					$filter = array('and'=>array('objectClass'=>$this->groupType,'memberUid'=>$user));
					$results = $this->model->find('first',array('conditions'=>$filter, 'scope'=>$scope));

					//Now Check to see if the listed user was in the group
					if(isset($results[0]['count']) && $results[0]['count'] > 0){
						return true;
					}
					return false;
						
					break;
			case 'group':
			case 'groupOfNames':
				if($this->isValidDn($group)){
					$scope = 'base';
					$filter = array('and'=>array('objectClass'=>$this->groupType,'member'=>$user));
					$options = array('conditions'=>$filter, 'targetDn'=>$group, 'scope'=>$scope);
					$results = $this->model->find('first',$options);

					//Now Check to see if the listed user was in the group
					if(isset($results[0]['count']) && $results[0]['count'] > 0){
						//If we get any results from this one, then it was true
						return true;
					}
					return false;
				}elseif(preg_match('/=/',$group) == 0){ //If we didn't provide the DN/CN are just giving the raw group search for that
					$scope = 'sub';
					$filter = array('and'=>array('objectClass'=>$this->groupType, 'and'=>array('cn'=>$group, 'member'=>$user)));
					$results = $this->model->find('first',array('conditions'=>$filter, 'scope'=>$scope));

					//Now Check to see if the listed user was in the group
					if(isset($results[0]['count']) && $results[0]['count'] > 0){
						return true;
					}
					return false;
				}

				break;
		}
	}

	/**
	 * getGroups($user) Return me an array of all the groups the users is a member of
	 *
	 * @param string $user if you are using group or groupOfNames then user should be full dn.  If it's posixGroup then just the name is needed
	 * @return array $groups an array of strings that the users is a member of
	 */
	function getGroups($user = false){

		$scope = 'sub';
		$fields = array('cn', 'uid', 'samacountName', 'displayName','memberUid', 'member','mail','grouptype','name');
		switch($this->groupType){
			case 'posixGroup':
                                        $filter = array('and'=>array('objectClass'=>$this->groupType,'memberUid'=>$user));
                                        break;
                        case 'group':
                        case 'groupOfNames':
                                        $filter = array('and'=>array('objectClass'=>$this->groupType,'member'=>$user));
					break;
                }
		$options = array('conditions'=>$filter, 'scope'=>$scope, 'fields'=>$fields);
		$results = $this->model->find('all',$options);

		//Now Check to see if the listed user was in the group
		if(isset($results[0]) && count($results) > 0){
			return $results;
		}
		return false;
	}

	
	/**
	 * taken from CakePHP Auth component. quick clean way to get the model
	 * Returns a reference to the model object specified, and attempts
	 * to load it if it is not found.
	 *
	 * @param string $name Model name (defaults to AuthComponent::$userModel)
	 * @return object A reference to a model object
	 * @access public
	 */
        function &getModel($name = null) {
                $model = null;
                if (!$name) {
                        $name = $this->userModel;
                }
		
		$model = ClassRegistry::init($name);

                if (empty($model)) {
                        trigger_error(__('Auth::getModel() - Model is not set or could not be found'), E_USER_WARNING);
                        return null;
                }

                return $model;
        }

	/**
	 * isValidDn($dn) this just checks if a DN is valid
	 *
	 * @param string dn to test for example 'dc=john doe, dc=example, dc=com'
	 * @return boolean true or false
	 */
	function isValidDn($dn){
		$result = $this->model->find('first',array('targetDn'=>$dn,'scope'=>'base'));
		if(isset($result[0]['count']) && $result[0]['count'] >= 1){
			return true;
		}else{
			return false;
		}
	}

	function check($user = false, $object = false, $action = false){
		//$this->log("User Arg:".print_r($user,1),'debug');
		//$this->log("Object Arg:".print_r($object,1),'debug');
		//$this->log("Action Arg:".print_r($action,1),'debug');
		return true;
	}
}
