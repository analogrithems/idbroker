<?php
class DataManagersController extends AppController {

	var $name = 'DataManagers';    
	var $components = array('RequestHandler', 'Ldap', 'SettingsHandler');
	var $helpers = array('Form','Html','Javascript', 'Ajax');



}
?>
