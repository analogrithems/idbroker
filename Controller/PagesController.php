<?php
class PagesController extends IdbrokerAppController {
	var $name = 'Pages';
	var $uses = array();
/**
 * Displays a view
 *
 * @param mixed What page to display
 * @access public
 */
	function display() {
		$this->redirect('/people/MyAccount');
	}
}

?>
