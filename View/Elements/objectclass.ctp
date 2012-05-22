<?php
	
        if (!defined('ELEMENT_PATH')) {
                define('ELEMENT_PATH', APP_DIR.DS.'views'.DS.'elements'.DS);
        }

	//First we try blindly to render an object class.
	$ocResult = $this->element('objectclasses/'.strtolower($objectclass), array('objectclass'=>$objectclass, 'schemas'=>$schemas), true);

	if(!$ocResult){ //If their is no custom element for the objectclass then use this generic one.
                echo "<div id='$objectclass' class='genericOC'>";
                echo $this->Form->create();
                echo $this->Form->input('dn', array('type'=>'hidden'));
                foreach($schemas['objectclasses'][strtolower($objectclass)]['may'] as $attribute){
                        echo $this->Form->input(strtolower($attribute));
                }
                foreach($schemas['objectclasses'][strtolower($objectclass)]['must'] as $attribute){
                        echo $this->Form->input(strtolower($attribute));
                }
                echo $this->Form->end('Update');
                echo "</div>";
	}else{ //If we did find and render a object class with out previous call, lets show it
		print $ocResult;
	}
?>
