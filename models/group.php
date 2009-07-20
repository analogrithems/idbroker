<?php 
class Group extends AppModel {

	var $name = 'Group';
	var $useDbConfig = 'ldap';
	var $primaryKey = 'cn';     // Adapt this parameter to your data
	var $useTable = 'ou=Groups'; // Adapt this parameter to your data
	var $validate = array(
		'cn' => array(
			'rule' => array('custom', '/^[a-zA-Z0-9]*$/'),
			'required' => true,
			'on' => 'create',
			'message' => 'Group names must be alpha numeric.'
        ),
        'gidnumber' => array(
			'rule' => array('custom', '/^[0-9]*$/'),
			'required' => true,
			'on' => 'create',
			'message' => 'Group ID number must be numeric.'
        ),

    );
}
?>
