<?php 
class Sudoer extends IdbrokerAppModel {

	var $name = 'Sudoer';
	var $useDbConfig = 'ldap';
	var $primaryKey = 'cn';     // Adapt this parameter to your data
	var $useTable = 'ou=Sudoers'; // Adapt this parameter to your data

}
?>
