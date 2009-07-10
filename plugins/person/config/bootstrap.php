<?php
	//person objectclass
	Configure::write('schemaPlugin.person.label', 'Name');
	Configure::write('schemaPlugin.person.name', 'person');
	Configure::write('schemaPlugin.person.plugin', 'person');

	//inetorgperson objectclass
	Configure::write('schemaPlugin.inetorgperson.label', 'Contact Info');
	Configure::write('schemaPlugin.inetorgperson.name', 'inetorgperson');
	Configure::write('schemaPlugin.inetorgperson.plugin', 'person');

	//organizationalperson objectclass
	Configure::write('schemaPlugin.organizationalperson.label', 'Organization Info');
	Configure::write('schemaPlugin.organizationalperson.name', 'organizationalperson');
	Configure::write('schemaPlugin.organizationalperson.plugin', 'person');
?>
