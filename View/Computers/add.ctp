<div id="Forms">
<?php
	echo $this->Form->create('Computer')."\n";

        echo $this->Form->input('cn', array('label'=> 'Fully Qualified Domain Name', 'div'=> 'required', 'title'=>"A fully qualified domain name (FQDN), sometimes referred to as an absolute domain name, is a domain name that specifies its exact location in the tree hierarchy of the Domain Name System (DNS). It specifies all domain levels, including the top-level domain, relative to the root domain. A fully qualified domain name is distinguished by its unambiguity; it can only be interpreted one way."))."\n";

        echo $this->Form->input('description', array('label'=>'Description', 'title'=>'A Breif description as to what this computer is used for.'))."\n";

        echo $this->Form->input('iphostnumber', array('label'=>'IP Address', 'div'=> 'required', 'title'=>'The IP address of the machine you are adding.'))."\n";
        
        echo $this->Form->input('members', array('label'=>'Allowed Users', 'type'=>'select', 'multiple'=>'true', 'options'=>$users, 'title'=> 'Users Allowed To Login To This Server.'))."\n";

        echo $this->Form->end('Add Computer');
                echo "</div>";


?>
</div>
