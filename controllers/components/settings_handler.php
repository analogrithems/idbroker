<?php 
/**
 * SettingsHandler component is a wrapper a way to read and more importantly
 * write to the config/settings.php file.  Designed to work with plugins also
 * 
 * @author Analogrithems
 * @version 1.0
 * @license http://www.opensource.org/licenses/mit-license.php The MIT License
 * @category Components
 */
define('PLUGINS', APP_PATH.DS.'plugins');
class SettingsHandlerComponent extends Object {
	/**
	 * Reference to the controller
	 * 
	 * @var object
	 * @access private
	 */
	var $__controller = null;
	var $settingsFile;
	var $_settingsName = 'settings';
	var $_settings = array();
	
	function initialize(&$controller) {
		$this->__controller = &$controller;
		$this->settingsFile = ROOT.DS.APP_DIR.DS.'config'.DS.'settings.php';
		Configure::load($this->_settingsName);
		$this->_settings = Configure::read($this->_settingsName);
	}
	
	function getSettings(){
		return $this->_settings;
	}
	
	function setSettings($type, $data){
		$date = array_merge($this->_settings[$this->_settingsName], $data);
		$content = '';
		foreach ($data as $key => $value) {
			$content .= "\$config['$type']['$key']";
			if (is_array($value)) {
				$content .= " = array(";
				foreach ($value as $key1 => $value2) {
					$value2 = addslashes($value2);
					$content .= "'$key1' => '$value2', ";
				}
				$content .= ");\n";
			} else {
				$value = addslashes($value);
				$content .= " = '$value';\n";
			}
		}
		if (!class_exists('File')) {
			require LIBS . 'file.php';
		}

		$fileClass = new File($this->settingsFile,true,'0744');
		$content = "<?php\n\$config = array();\n".$content."\n?>";
		if ($fileClass->writable()) {
			$fileClass->write($content);
		}
	}
}
?>