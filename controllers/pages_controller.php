<?php
class PagesController extends AppController {
	var $name = 'Pages';
	var $helpers = array('Html');
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
