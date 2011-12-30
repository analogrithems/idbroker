<div id="organizationalperson">
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

	echo $this->Form->input('dn', array('type'=>'hidden'));

	echo $this->Form->input('telephonenumber', array('label'=>'Phone Number', 'title'=>"Identifies the entry's phone number."));

	echo $this->Form->input('fax', array('label'=>'Fax Number', 'title'=>"Identifies the fax number at which the entry can be reached. Abbreviation: fax.\nFor example:\nfacsimileTelephoneNumber: 415-555-1212\nor:\nfax: 415-555-1212\nThis attribute is defined in RFC 2256.\nThis attribute is defined in RFC 2256."));

	echo $this->Form->input('postaladdress', array('label'=>'Office Address', 'title'=>"Identifies the entry's mailing address. This field is intended to include multiple lines.\nFor example:\npostalAddress: P.O. Box 3541$Santa Clara, CA$99555\nEach line should be separated by a dollar sign ($).\nTo represent an actual dollar sign ($) or backslash (\) within the text, use the escaped hex values \24 and \5c respectively."));

	echo $this->Form->input('postalcode', array('label'=>'Office Zip', 'title'=>"Identifies the entry's zip code in the United States."));

	echo $this->Form->input('localityname', array('label'=>'City', 'title'=>"Identifies the county, city, or other geographical area in which the entry is located or with which it is in some other way associated.\nFor Example:\nlocalityName: Santa Clara"));

	echo $this->Form->input('st', array('label'=>'State', 'title'=>"Identifies the state or province in which the entry resides."));

	echo $this->Form->input('ou', array('label'=>'Department', 'title'=>"Identifies the name of the department the person is part of.\nFor example:\nou:marketing\nor\nou: Software"));

	echo $this->Form->input('title', array('label'=>'Title', 'title'=>"Identifies the title of a person in the organization.\nFor example:\ntitle: Electronics Lead"));

	echo $this->Form->end('Update');
?>
</div>