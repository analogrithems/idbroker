<?php
	//person objectclass
	Configure::write('plugin.person.label', 'Name');
	Configure::write('plugin.person.name', 'person');
	Configure::write('plugin.person.plugin', 'person');

	//inetorgperson objectclass
	Configure::write('plugin.inetorgperson.label', 'Contact Info');
	Configure::write('plugin.inetorgperson.name', 'inetorgperson');
	Configure::write('plugin.inetorgperson.plugin', 'person');

	//organizationalperson objectclass
	Configure::write('plugin.organizationalperson.label', 'Organization Info');
	Configure::write('plugin.organizationalperson.name', 'organizationalperson');
	Configure::write('plugin.organizationalperson.plugin', 'person');
?>
