<?php
class BrowsersController extends AppController {

	var $name = 'Browsers';
	var $components = array('RequestHandler', 'Ldap', 'PluginHandler');
	var $helpers = array('Form','Html','Javascript', 'Ajax');
	var $dbConfig;
	var $schemaPlugin;
	
	function index() {
		//$this->dbConfig = $this->Browser->findConfig();
		//$this->set('mconfig', $this->dbConfig);
	
		$this->layout = 'browser';
	}
	
	function beforeFilter() {
		
		parent::beforeFilter();
		$schemas = $this->Browser->findSchema();
		$this->set(compact('schemas'));
		
		// ensure our ajax methods are posted
		//$this->Security->requirePost('getnodes', 'reorder', 'reparent');
		
	}
	function edit( $id = null){
		if(!empty($this->data)){
			$this->Browser->id = $id;

			//do a check for each objectclass that gets submitted and check for validation rules.
			//maybe that should be added to the driver it self....or datasource.
			if(isset($this->data['Browser']['shadowexpire']) && 
			   preg_match('/[0-9][0-9]\/[0-9][0-9]\/[0-9][0-9][0-9][0-9]/', $this->data['Browser']['shadowexpire'])){
				$this->data['Browser']['shadowexpire'] = $this->getEpochDay($this->data['Browser']['shadowexpire']);
			}
			if(isset($this->data['Browser']['shadowlastchange']) && 
			   preg_match('/[0-9][0-9]\/[0-9][0-9]\/[0-9][0-9][0-9][0-9]/', $this->data['Browser']['shadowlastchange'])){
				$this->data['Browser']['shadowlastchange'] = $this->getEpochDay($this->data['Browser']['shadowlastchange']);
			}

			$this->log("What I'm Going to save".print_r($this->data,true),'debug');
			$result = $this->Browser->save($this->data);

			if($result != false){
				$this->Session->setFlash('Your entry has been updated.');
			}else{
				$this->Session->setFlash('Failed to update');
			}
		}
		$this->data = $this->Browser->find('first',array('targetDn'=>$id, 'scope'=>'base'));
		$this->schemaPlugin = Configure::read('schemaPlugin');
		$this->set('schemaPlugin', $this->schemaPlugin);
		$this->layout = 'ajax';
	}

	function resetPassword( $user = null ){
		 if(!empty($this->data)){
			$this->Browser->id = $user;
                        //do save or pass to a smarter function
			if($this->data['Browser']['password'] == $this->data['Browser']['password_confirm']){
				$this->data['Browser']['userpassword'] = $this->data['Browser']['password'];
				$this->data['Browser']['passwordallowchangetime'] = array();
				unset($this->data['Browser']['password']);
				unset($this->data['Browser']['password_confirm']);

				if($this->Browser->save($this->data)){
					$this->updateShadowExpire($user);
					$this->Session->setFlash('Your password has been updated.');
				}else{
					$this->Session->setFlash('Failed to update');
				}
			}else{
                                $this->Session->setFlash("Failed to reset password, they don't match.");
			}

		}
		$this->data = $this->Browser->find('all',array('targetDn'=>$user, 'scope'=>'base', 'fields'=> array('cn', 'userpassword')));
		$this->data = $this->data[0];
		$this->layout = 'simple';
	}

	
	function getnodes() {
		// retrieve the node id that Ext JS posts via ajax
		if(!empty($this->params['form']['node'])){
			$base = $this->params['form']['node'];
			if($base == 'root'){
				$base = '';
			}
		}elseif(!empty($this->params['url']['node'])){
			$base = $this->params['url']['node'];
			if($base == 'root'){
				$base = '';
			}
		}else{
			$base = '';
		}
		
		// find all the nodes underneath the parent node defined above
		// the second parameter (true) means we only want direct children
		$nodes = $this->Browser->find('all',array('targetDn'=>$base, 'scope'=>'one', 'conditions'=>'objectclass=*'));
		

		foreach($nodes as $key => $val){
			// Cut off the part we don't need
			$newNode = $nodes[$key]['Browser']['dn'];

			//Check if this object has children
			$leafs = $this->Browser->find('all',array('targetDn'=>$newNode, 'scope'=>'one', 'conditions'=>'objectclass=*'));
			$leafcnt = $leafs[0][0]['count'];
				$this->log("Node: $newNode has $leafcnt children",'debug');
			if($leafcnt > 0){
				$nodes[$key]['Browser']['state'] = 'closed';
				$nodes[$key]['Browser']['children'] = $leafcnt;
			}
			
			//Lets figure out what type of object this is so we can assign the propper img in css
			$nodes[$key]['Browser']['class'] = substr($newNode, 0, strpos($newNode, '='));

			//Gives the name for this node
			$nodes[$key]['Browser']['name'] = $this->getNodeRDN($nodes[$key]['Browser']['dn'],1);
		}
		
		$this->set(compact('nodes'));
		
		$this->layout = 'ajax';
	}
	
	function getNodeRDN($dn, $ref = 0){
		$tmp = ldap_explode_dn($dn,$ref);
		return $tmp[0];
	}

	function isAuthorized() {
		return true;
	}

	function setbindParams(){
		$user = $this->Session->read('myDN');
		$passwd = $this->Session->read('myPasswd');
		if(isset($user)){
			$this->Browser->setBind($user,$passwd);
		}
	}
		
	/*
	 * 
	 *
	 * This function checks to see if the given entry supports a specific attribute
	 * @param	string	$dn of the entry you want to check
	 * @param 	string  $attribute you want to check for
	 *
	 */
	function hasAttribute( $dn, $attribute ){
		$result = false;
		$entry = $this->Browser->find('all',(array('targetDn'=>$dn, 'scope'=>'base')));
		$objectclasses = $entry[0]['Browser']['objectclass'];
		$schemas = $this->Browser->findSchema();

		foreach($objectclasses as $oc){
			if(isset($schemas['objectclasses'][strtolower($oc)]['may']) &&
			  in_array(strtolower($attribute), array_map('strtolower', $schemas['objectclasses'][strtolower($oc)]['may']))){
				$result = true;
			}
			if(isset($schemas['objectclasses'][strtolower($oc)]['must']) &&
			  in_array(strtolower($attribute), array_map('strtolower', $schemas['objectclasses'][strtolower($oc)]['must']))){
				$result = true;
			}
		}
			
		$this->set(compact('result'));
		$this->layout = 'ajax';	
	}
	function delete( $dn ){

		$found = $this->Ldap->hasChildren($dn);
		if($found > 0){
			$this->Session->setFlash("This object Still Contains Children, Can't delete.");
		}else{
			if($this->Browser->delete($dn)){
				$this->Session->setFlash("Removed ".$dn);
			}else{
				$this->Session->setFlash("Error while trying to delete ".$dn);
			}				
			
		}
	}
	
	function getMsg(){
		$msg = false;
                if ($this->Session->check('Message.flash.message')){
			$msg =  $this->Session->read('Message.flash.message');
			$this->Session->del('Message.flash.message');
                }
		$this->set(compact('msg'));
	}

	private function getEpochDay( $date = null){
		if($date == null){ $date = date('m/d/Y'); }
                $epoc =  floor(date('U', strtotime($date)) / 86400);
		$epoc++;
		return $epoc;
        }

	private function updateShadowExpire( $dn ){
		$this->data = $this->Browser->find('all',array('targetDn'=>$dn, 'scope'=>'base', 'fields'=> array('cn', 'shadowlastchange')));
                $this->data = $this->data[0];
		$this->data['Browser']['shadowlastchange'] = $this->getEpochDay();
		$this->log("updateShadowExpire: ".print_r($this->data,true),'debug');
		$this->Browser->save($this->data);
	}

	function getGroupMembers( $group, $type ){
		$fields[] = $type;
		$members = $this->Browser->find('all',array('targetDn'=>$group, 'scope'=>'base', 'fields'=> $fields ));
		if(!isset($members[0]['Browser'][$type])){
			return null;
		}
		$list = array();
		if(is_array($members[0]['Browser'][$type])){
			if($type =='uniquemember'){
				foreach($members[0]['Browser'][$type] as $member){
					$dn = $member;
					$entry = $this->Browser->find('all',array('targetDn'=>$dn, 'scope'=>'base', 
						'fields'=>array('displayname','cn','dn','uid')));
					$list[] = $entry[0];
				}
			}else{
				foreach($members[0]['Browser'][$type] as $member){
					$entry = $this->Browser->find('all',array('targetDn'=>'', 'scope'=>'sub', 'conditions'=> 'uid='.$member,
						'fields'=> array('displayname','cn','dn','uid')));
					$list[] = $entry[0];
				}	
			}
		}else{
			if($type =='uniquemember'){
				$dn = $members[0]['Browser'][$type];
				$entry = $this->Browser->find('all',array('targetDn'=>$dn, 'scope'=>'base', 'fields'=>array('displayname','cn','dn','uid')));
				$list[] = $entry[0];
			}else{
				$member = $members[0]['Browser'][$type];
					$entry = $this->Browser->find('all',array('targetDn'=>'', 'scope'=>'sub', 'conditions'=> 'uid='.$member,
						'fields'=> array('displayname','cn','dn','uid')));
					$list[] = $entry[0];
			}
		
		}
		return $list;
	}
	
	function getEntrys( $conditions = null, $fields = null, $base = null, $scope = 'sub' ){
		if(isset($fields) && !empty($fields)){
			if(preg_match('/,/', $fields)){
				$fields = explode(',', $fields);
			}
		}
		$this->data = $this->Browser->find('all',array('targetDn'=>$base, 'scope'=>$scope, 'fields'=> $fields, 'conditions'=>$conditions));
		$this->layout = 'ajax';
		return $this->data;
	}
	
	function groupSelect( $group, $type ){
		$allUsers = $this->getEntrys('uid=*','displayname,cn,dn,uid');
		if(is_array($allUsers)){
			foreach($allUsers as $user){
				$user = $user['Browser'];
				$nonmembers[$user['dn']] = $user;
			}
		}else{ 
			$nonmembers[$allusers['Browser']['dn']] = $allusers['Browser']; 
		}
		if($type == 'posixgroup'){ $attr = 'memberuid'; }
		elseif($type == 'groupofuniquenames'){$attr = 'uniquemember'; }		
		$groupMembers = $this->getGroupMembers($group,$attr);
		if(is_array($groupMembers)){
			foreach($groupMembers as $member){
			   $member = $member['Browser'];
			   if(isset($member['dn']) && !empty($member['dn'])){
				$members[$member['dn']] = $member;
				if(isset($nonmembers[$member['dn']])) unset($nonmembers[$member['dn']]);
			   }
			}
		}else{ 
		   if(isset($groupMembers['Browser']['dn']) && !empty($groupMembers['Browser']['dn'])){
			$members[$groupMembers['Browser']['dn']] = $groupMembers['Browser'];
			if(isset($nonmembers[$groupMembers['Browser']['dn']])) unset($nonmembers[$groupMembers['Browser']['dn']]); 
		   }
		}
		
		if(isset($nonmembers)) $groups['nonmembers'] = $nonmembers;
		if(isset($members)) $groups['members'] = $members;
		$this->set(compact('groups'));
		$this->set('type', $type);
		$this->layout = 'ajax';
	}

	function sudoSelect( $dn ){
		$options['scope'] = 'base';
		$options['targetDn'] = $dn;
		$options['conditions'] = 'objectclass=sudorole';

		$sudoRole = $this->Browser->find('first', $options);
		$sudoRole = $sudoRole['Browser'];

                $users = $this->Ldap->getUsers();
                $sudousers['ALL'] = 'ALL';
                foreach($users as $user){
                        if(isset($user['uid']) && !empty($user['uid'])){
                                $sudousers[$user['uid']] = $user['uid'];
                        }
                }
                $groups = $this->Ldap->getGroups();
                $sudousers[] = 'The Following are only groups';
                $sudogroups['All'] = 'ALL';
                foreach($groups as $group){
                        if(isset($group['cn']) && !empty($group['cn'])){
                                $sudogroups[$group['cn']] = $group['cn'];
                                $sudousers['%'.$group['cn']] = '%'.$group['cn'];
                        }
                }
                $computers = $this->Ldap->getComputers();
                $sudohosts['ALL'] = 'ALL';
                foreach($computers as $computer){
                        if(isset($computer['cn']) && !empty($computer['cn'])){
                                $sudohosts[$computer['cn']] = $computer['cn'];
                        }
                }

		//Remove sudoUsers already in this sudo role
		if(isset($sudoRole['sudouser']) && is_array($sudoRole['sudouser']) ){
			foreach($sudoRole['sudouser'] as $sudouser){
				unset($sudousers[$sudouser]);
			}
		}elseif(isset($sudoRole['sudouser'])){
			unset($sudousers[$sudoRole['sudouser']]);
		}
		
		
                //Remove host already in this role
                if(isset($sudoRole['sudohost']) && is_array($sudoRole['sudohost']) ){
                        foreach($sudoRole['sudohost'] as $sudohost){
                                unset($sudohosts[$sudohost]);
                        }
                }elseif(isset($sudoRole['sudohost'])){
                        unset($sudohosts[$sudoRole['sudohost']]);
                }

                //Remove groups already in this role
                if(isset($sudoRole['sudorunasgroup']) && is_array($sudoRole['sudorunasgroup']) ){
                        foreach($sudoRole['sudorunasgroup'] as $sudorunasgroup){
                                unset($sudogroups[$sudorunasgroup]);
                        }
                }elseif(isset($sudoRole['sudorunasgroup'])){
                        unset($sudogroups[$sudoRole['sudorunasgroup']]);
                }


		$this->set(compact('sudoRole'));
		$this->set(compact('sudousers'));
		$this->set(compact('sudohosts'));
		$this->set(compact('sudogroups'));

		$this->layout = 'ajax';
	}
}
?>
