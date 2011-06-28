<?php
class IdbrokerGroupsController extends IdbrokerAppController {

	var $name = 'IdebrokerGroups';    
        var $components = array('RequestHandler');
        var $helpers = array('Form','Html','Javascript', 'Ajax');
 
	//Very Ugly, fix this.,
        function isAuthorized() {
                return true;
        }

}
?>
