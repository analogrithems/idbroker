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
 
        function setSettings($data){
                $data = array_merge($this->_settings[$this->_settingsName], $data);
                $configs = $this->expandArray($data, "['".$this->_settingsName."']");
                $this->log("Settings Data:".print_r($configs,true)."\nfrom:".print_r($data,true),'debug');
                foreach ($configs as $config) {
                        $content .= $config;
                }
 
                if (!class_exists('File')) {
                        require LIBS . 'file.php';
                }
 
                $fileClass = new File($this->settingsFile,true,'0744');
                $content = "<?php\n".$content."\n?>";
                if ($fileClass->writable()) {
                        $fileClass->write($content);
                }
        }

        function expandArray($options, $prefix = null){
                $results = array();
                foreach($options as $key => $value){
                	$key = $prefix."['$key']";
                        if(is_array($value)){
                                $tres =  $this->expandArray($value, $key);
                                foreach($tres as $res){
                                	$results[] = $res;
                                }
                                $this->log("Expanding Array again :".print_r($results,true),'debug');
                        }else{
                                $results[] = "\t\$config".$key." = '$value';\n";
                        }
                }    
                         
                return $results;
        }

        function setAutoSet($attribute, $function, $options = null){
		if($options){
			$this->_settings[$this->_settingsName]['auto'][$attribute][][$function] = $options;
		}else{
			$this->_settings[$this->_settingsName]['auto'][$attribute][] = $function;
		}
        }

	function autoSet($attribute){
		$nauto = '';
		if($this->isAutoSet($attribute)){
			//Force this to zero, can only have one auto set..
                        $path = $this->_settings['auto'][$attribute][0];
                        $nauto = $this->requestAction($path, array('return'=>true));
                        $this->log("Getting auto for $attribute ".print_r($path,true)."Result is:".print_r($nauto,true),'debug');
                        return($nauto);
                }
		return false;
	}


	function isAutoSet($attribute, $function = null){
		$found = false;
		if($function == null&& isset($this->_settings['auto'][$attribute])){
			foreach($this->_settings['auto'][$attribute] as $key => $value){
				if( $function == $key){
					$found = true;
				}
			}
		}else{
			if(isset($this->_settings['auto'][$attribute])){
				$found = true;
			}
		}
                return($found);
	}

        function SyncWith($attribute, $function, $options = null){
		if($options){
			$this->_settings[$this->_settingsName]['sync'][$attribute][][$function] = $options;
		}else{
			$this->_settings[$this->_settingsName]['sync'][$attribute][] = $function;
		}
        }
	
	function isSyncWith($attribute, $function){ 
		$found = in_array($function, $this->_settings['sync'][$attribute]);
		if($found == false){
			foreach($this->_settings['sync'][$attribute] as $key => $value){
				if( $function == $key){
					$found = true;
				}
			}
		}
		return($found);
	}
}
?>
