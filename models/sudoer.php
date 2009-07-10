<?php 
class Sudoer extends AppModel {

	var $name = 'Sudoer';
	var $useDbConfig = 'ldap';
	var $primaryKey = 'cn';     // Adapt this parameter to your data
	var $useTable = 'ou=Sudoers'; // Adapt this parameter to your data

}
?>
