<?php 
class Computer extends AppModel {

	var $name = 'Computer';
	var $useDbConfig = 'ldap';
	var $primaryKey = 'cn';     // Adapt this parameter to your data
	var $useTable = 'ou=Computers'; // Adapt this parameter to your data
	var $validate = array(
		'cn' => array(
			'rule' => array('custom', '/(?=^.{1,254}$)(^(?:(?!\d+\.|-)[a-zA-Z0-9_\-]{1,63}(?<!-)\.?)+(?:[a-zA-Z]{2,})$)/'),
			'required' => true,
			'on' => 'create',
			'message' => 'Must Be A Valid Fully Qualified Domain Name.'
        ),
        'iphostnumber' => array(
			'rule' => 'ip',
			'required' => true,
			'on' => 'create',
			'message' => 'Please supply a valid IP address.'
        ),

    );
}
?>
