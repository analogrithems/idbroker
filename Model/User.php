<?php 
class User extends IdbrokerAppModel {
	var $name = 'User';
	var $useDbConfig = 'ldap';
	var $primaryKey = 'sAMAccountName';
	var $useTable = '';
}
?>
