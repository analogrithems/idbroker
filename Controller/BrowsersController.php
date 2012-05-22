<?php
class BrowsersController extends IdbrokerAppController {

	var $name = 'Browsers';
	var $components = array('Ldap', 'ActiveDirectory');
	var $dbConfig;
	var $schemaPlugin;
	
	function index() {
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
		if(!empty($this->request->data)){
			$this->Browser->id = $id;

			//do a check for each objectclass that gets submitted and check for validation rules.
			//maybe that should be added to the driver it self....or datasource.
			if(isset($this->request->data['Browser']['shadowexpire']) && 
			   preg_match('/[0-9][0-9]\/[0-9][0-9]\/[0-9][0-9][0-9][0-9]/', $this->request->data['Browser']['shadowexpire'])){
				$this->request->data['Browser']['shadowexpire'] = $this->getEpochDay($this->request->data['Browser']['shadowexpire']);
			}
			if(isset($this->request->data['Browser']['shadowlastchange']) && 
			   preg_match('/[0-9][0-9]\/[0-9][0-9]\/[0-9][0-9][0-9][0-9]/', $this->request->data['Browser']['shadowlastchange'])){
				$this->request->data['Browser']['shadowlastchange'] = $this->getEpochDay($this->request->data['Browser']['shadowlastchange']);
			}

			$this->log("What I'm Going to save".print_r($this->request->data,true),'debug');
			$result = $this->Browser->save($this->request->data);

			if($result != false){
				$this->Session->setFlash('Your entry has been updated.');
			}else{
				$this->Session->setFlash('Failed to update');
			}
		}
		$this->request->data = $this->Browser->find('first',array('targetDn'=>$id, 'scope'=>'base'));
		$this->schemaPlugin = Configure::read('plugin');
		$this->set('schemaPlugin', $this->schemaPlugin);
		$this->layout = 'ajax';
	}

	function resetPassword( $user = null ){
		 if(!empty($this->request->data)){
			$this->Browser->id = $user;
                        //do save or pass to a smarter function
			if($this->request->data['Browser']['password'] == $this->request->data['Browser']['password_confirm']){
				$this->request->data['Browser']['userpassword'] = $this->request->data['Browser']['password'];
				$this->request->data['Browser']['passwordallowchangetime'] = array();
				unset($this->request->data['Browser']['password']);
				unset($this->request->data['Browser']['password_confirm']);

				if($this->Browser->save($this->request->data)){
					$this->updateShadowExpire($user);
					$this->Session->setFlash('Your password has been updated.');
				}else{
					$this->Session->setFlash('Failed to update');
				}
			}else{
                                $this->Session->setFlash("Failed to reset password, they don't match.");
			}

		}
		$this->request->data = $this->Browser->find('all',array('targetDn'=>$user, 'scope'=>'base', 'fields'=> array('cn', 'userpassword')));
		$this->request->data = $this->request->data[0];
		$this->layout = 'simple';
	}

	
	function getnodes() {
	header('Content-type: application/json');
		// retrieve the node id that Ext JS posts via ajax
		if(!empty($this->request->params['form']['node'])){
			$base = $this->request->params['form']['node'];
			if($base == '0'){
				$base = '';
			}
		}elseif(!empty($this->request->params['url']['node'])){
			$base = $this->request->params['url']['node'];
			if($base == '0'){
				$base = '';
			}
		}else{
			$base = '';
		}
		
		// find all the nodes underneath the parent node defined above
		// the second parameter (true) means we only want direct children
		$nodes = $this->Browser->find('all',array('targetDn'=>$base, 'scope'=>'one', 'conditions'=>'objectclass=*'));
		

		foreach($nodes as $key => $val){
			if(isset($nodes[$key]['Browser']['useraccountcontrol'])){
				$flgs = $this->ActiveDirectory->parseUACF($nodes[$key]['Browser']['useraccountcontrol']);
				if(isset($flgs['ACCOUNTDISABLE']) && $flgs['ACCOUNTDISABLE'] === true){
					$nodes[$key]['Browser']['adaccountlock'] = true;
					$nodes[$key]['Browser']['class'][] = 'locked';
				}
			}

			// Cut off the part we don't need
			$newNode = $nodes[$key]['Browser']['dn'];

			//Check if this object has children
			$leafs = $this->Browser->find('all',array('targetDn'=>$newNode, 'scope'=>'one', 'conditions'=>'objectclass=*'));
			$leafcnt = $leafs[0][0]['count'];
			if($leafcnt > 0){
				$nodes[$key]['Browser']['state'] = 'closed';
				$nodes[$key]['Browser']['children'] = $leafcnt;
			}
			
			//Lets figure out what type of object this is so we can assign the propper img in css
			$nodes[$key]['Browser']['class'][] = substr($newNode, 0, strpos($newNode, '='));
			
			if(isset($nodes[$key]['Browser']['nsaccountlock']) && $nodes[$key]['Browser']['nsaccountlock'] == 'true'){
				$nodes[$key]['Browser']['class'][] = 'locked';
			}
			//Gives the name for this node
			$nodes[$key]['Browser']['name'] = $this->getNodeRDN($nodes[$key]['Browser']['dn'],1);
			if(isset($nodes[$key]['Browser']['cn']) && !empty($nodes[$key]['Browser']['cn']) 
			   && $nodes[$key]['Browser']['cn'] != $nodes[$key]['Browser']['name']){
				$nodes[$key]['Browser']['name'] = $nodes[$key]['Browser']['cn'] . ' ( '. $nodes[$key]['Browser']['name'] .' )';
			}
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
	function lock( $dn){
		$this->request->data['Browser']['nsaccountlock']	= 'true';
		if($this->Browser->save($this->request->data)){
			$this->Session->setFlash("Locked/Disabled ".$dn);
		}else{
			$this->Session->setFlash("Error while trying to Lock/Disable ".$dn);
		}
	}
        function unLock( $dn){
                $this->request->data['Browser']['nsaccountlock'] = '';
                if($this->Browser->save($this->request->data)){
                        $this->Session->setFlash("unLocked/enabled ".$dn);
                }else{
                        $this->Session->setFlash("Error while trying to unLock/Enable ".$dn);
                }
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
		if(!isset($msg) || empty($msg) || $msg == false){
			$msg = '0';
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
		$this->request->data = $this->Browser->find('all',array('targetDn'=>$dn, 'scope'=>'base', 'fields'=> array('cn', 'shadowlastchange')));
                $this->request->data = $this->request->data[0];
		$this->request->data['Browser']['shadowlastchange'] = $this->getEpochDay();
		$this->log("updateShadowExpire: ".print_r($this->request->data,true),'debug');
		$this->Browser->save($this->request->data);
	}

}
?>
