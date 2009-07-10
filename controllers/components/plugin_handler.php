<?php 
//File: /app/controllers/components/plugin_handler.php

/**
 * PluginHandler component adds a basic functionality
 * required for the plugin development. Main features
 * are plugin configuration autoloading and callbacks
 * from the controller. 
 * 
 * @author Sky_l3ppard
 * @version 1.3
 * @license http://www.opensource.org/licenses/mit-license.php The MIT License
 * @category Components
 */
class PluginHandlerComponent extends Object {
	/**
	 * Reference to the controller
	 * 
	 * @var object
	 * @access private
	 */
	var $__controller = null;
	
	/**
	 * Plugin Settings, available options:
	 * 		autoload - array of configuration files to be loaded
	 * 		priority - array of classified plugin names as priority 
	 * 			for launching callbacks (e.g.: array('MyPlugin', 'Administration'))
	 * 		primary - (true) will set this component to be executed first of all,
	 * 			but firstly this component must be called. This is good advantage
	 * 			if you want to call this handler beforeFilter callback before
	 * 			any other component`s startup method.
	 * 		permanently - (true) to load configuration files before any action,
	 * 			(false) - loaded only for a plugin's controller actions
	 * 
	 * @var array
	 * @access private
	 */
	var $__settings = array(
		'autoload' => array(
			'bootstrap',
			'core',
			'routes',
			'inflections'
		),
		'priority' => array(),
		'primary' => true,
		'permanently' => true
	);
	
	/**
	 * Initializes component by loading all configuration files from 
	 * all plugins found in application. Configuration files should be
	 * placed in \app\plugins\your_plugin\config\ directory. Be careful,
	 * it will overwrite all settings loaded from \app\config if the 
	 * setting name matches.
	 * At the end it will execute an 'initialize' callback method loaded
	 * from \plugins\your_plugin\{your_plugin}_auto_loader.php file
	 * 
	 * @param object $controller - reference to the controller
	 * @param array $settings - component settings, list of autoload files
	 * @return void
	 * @access public
	 */
	function initialize(&$controller, $settings = array()) {
		$this->__controller = &$controller;
		$this->__settings = Set::merge($this->__settings, $this->__settingsUnique((array)$settings));

		if (empty($this->__settings['priority'])) {
			$this->__settings['priority'] = Configure::listobjects('plugin');
		} else {
			foreach(Configure::listobjects('plugin') as $plugin) {
				if (!in_array($plugin, $this->__settings['priority'])) {
					array_push($this->__settings['priority'], $plugin);
				} 
			}
		}

		foreach ($this->__settings['priority'] as $plugin) {
			$is_parent_class = strpos(get_parent_class($controller), Inflector::classify($plugin)) !== false;
			if ($this->__settings['permanently'] || (!$this->__settings['permanently'] && $is_parent_class)) {
				foreach ($this->__settings['autoload'] as $type) {
					App::import(
						'Plugin', 
						Inflector::classify("{$plugin}_{$type}"), 
						array('file' => Inflector::underscore($plugin).DS.'config'.DS.$type.'.php')
					);
				}
			}
		}

		if ($this->__settings['primary']) {
			$ordering = $this->__controller->Component->_primary;
			$new_ordering[] = 'PluginHandler';
			foreach ($ordering as $component_name) {
				if (!in_array($component_name, $new_ordering)) {
					$new_ordering[] = $component_name;
				}
			}
			$this->__controller->Component->_primary = $new_ordering;
		}
		$this->loaderExecute('initialize');
	}
	
	/**
	 * Executes a 'beforeFilter' callback method loaded
	 * from \plugins\your_plugin\{your_plugin}_auto_loader.php file
	 * 
	 * @param object $controller - reference to the controller
	 * @return void
	 * @access public
	 */
	function startup(&$controller) {
		$this->loaderExecute('beforeFilter');
	}
	
	/**
	 * Executes a 'beforeRender' callback method loaded
	 * from \plugins\your_plugin\{your_plugin}_auto_loader.php file
	 * 
	 * @param object $controller - reference to the controller
	 * @return void
	 * @access public
	 */
	function beforeRender(&$controller) {
		$this->loaderExecute('beforeRender');
	}
	
	/**
	 * Initializes \plugins\your_plugin\{your_plugin}_auto_loader.php file
	 * and executes specified callback $method from AutoLoader class for
	 * all plugins found in application. 
	 * 
	 * @param string $method - name of the method to execute
	 * @return void
	 * @access public
	 */
	function loaderExecute($method) {
		foreach ($this->__settings['priority'] as $plugin) {
			$loader_file = Inflector::underscore($plugin).'_auto_loader';
			$loader_class = Inflector::classify($loader_file);

			if (!ClassRegistry::isKeySet($loader_file)) {
				App::import('Plugin', $loader_class, Inflector::underscore($plugin).DS.$loader_file.'.php');
				if (class_exists($loader_class)) {
					$class = new $loader_class();
					ClassRegistry::addObject($loader_file, $class);
					unset($class);
				}
			}

			$loader_instance = &ClassRegistry::getObject($loader_file);
			if (!empty($loader_instance) && in_array($method, get_class_methods($loader_class))) {
				call_user_func_array(array($loader_instance, $method), array($this->__controller)); 
			}
		}
	}
	
	/**
	 * By some bug or misstake component setting values
	 * are doubled in array. This function will make
	 * unique values recursively. It will be removed
	 * then the bug is fixed
	 * 
	 * @param array $settings - list of settings
	 * @return array of unique settings
	 * @access private
	 */
	function __settingsUnique($settings = array()) {
		$result = array_unique((array)$settings);
		foreach ($settings as $key => $val) {
			if (is_array($val)) {
				$result[$key] = $this->__settingsUnique($val);
			}
		}
		return $result;
	}
}
?>