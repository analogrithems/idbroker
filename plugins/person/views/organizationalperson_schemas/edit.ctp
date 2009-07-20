<?php
	echo $ajax->form(array('type' => 'post',
            'options' => array(
                'model'=>'OrganizationalpersonSchema',
                'update'=>'organizationalperson',
                'url' => array(
                    'controller' => 'OrganizationalpersonSchemas',
                    'action' => 'edit'
                 )
                )
	));

	echo $form->input('dn', array('type'=>'hidden'));

	echo $form->input('telephonenumber', array('label'=>'Phone Number', 'title'=>"Identifies the entry's phone number."));

	echo $form->input('fax', array('label'=>'Fax Number', 'title'=>"Identifies the fax number at which the entry can be reached. Abbreviation: fax.\nFor example:\nfacsimileTelephoneNumber: 415-555-1212\nor:\nfax: 415-555-1212\nThis attribute is defined in RFC 2256.\nThis attribute is defined in RFC 2256."));

	echo $form->input('postaladdress', array('label'=>'Office Address', 'title'=>"Identifies the entry's mailing address. This field is intended to include multiple lines.\nFor example:\npostalAddress: P.O. Box 3541$Santa Clara, CA$99555\nEach line should be separated by a dollar sign ($).\nTo represent an actual dollar sign ($) or backslash (\) within the text, use the escaped hex values \24 and \5c respectively."));

	echo $form->input('postalcode', array('label'=>'Office Zip', 'title'=>"Identifies the entry's zip code in the United States."));

	echo $form->input('localityname', array('label'=>'City', 'title'=>"Identifies the county, city, or other geographical area in which the entry is located or with which it is in some other way associated.\nFor Example:\nlocalityName: Santa Clara"));

	echo $form->input('st', array('label'=>'State', 'title'=>"Identifies the state or province in which the entry resides."));

	echo $form->input('ou', array('label'=>'Department', 'title'=>"Identifies the name of the department the person is part of.\nFor example:\nou:marketing\nor\nou: Software"));

	echo $form->input('title', array('label'=>'Title', 'title'=>"Identifies the title of a person in the organization.\nFor example:\ntitle: Electronics Lead"));

	echo $form->end('Update');
?>
