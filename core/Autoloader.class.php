<?php
	class Autoloader {

		/**
		* Register all the autoloaders
		* All registred autoloader will be call until the call is found
		* If the class can't be found, an exception will be thrown
		*/
		static function register(){
			spl_autoload_register(array(__CLASS__, 'autoloadCore'));
			spl_autoload_register(array(__CLASS__, 'autoloadClass'));
			spl_autoload_register(array(__CLASS__, 'autoloadController'));
			spl_autoload_register(array(__CLASS__, 'autoloadModel'));
		}

		/**
		* Auto loader for core files
		* @param (string) $class : Class name. Must be in core folder with '.class.php' or '.php' file extension
		* @return (bool) true if the file can be found, false otherwise
		*/
		static function autoloadCore($class){
			return self::recursiveLoad(CORE_FOLDER, $class);
		}

		/**
		* Auto loader for class files
		* @param (string) $class : Class name. Must be in class folder with '.class.php' or '.php' file extension
		* @return (bool) true if the file can be found, false otherwise
		*/
		static function autoloadClass($class){
			return self::recursiveLoad(CLASS_FOLDER, $class);
		}

		/**
		* Auto loader for controller files
		* @param (string) $class : Class name. Must be in class folder with '.class.php' or '.php' file extension
		* @return (bool) true if the file can be found, false otherwise
		*/
		static function autoloadController($class){
			return self::recursiveLoad(CONTROLLER_FOLDER, $class);
		}

		/**
		* Auto loader for model files
		* @param (string) $class : Class name. Must be in class folder with '.class.php' or '.php' file extension
		* @return (bool) true if the file can be found, false otherwise
		*/
		static function autoloadModel($class){
			return self::recursiveLoad(MODEL_FOLDER, $class);
		}

		/**
		* Recursively check for a class into a folder
		* @param (string) folder : Folder from which start searching recursively
		* @param (string) class : Class name to find
		* @return (bool) True if the class if found into the folder, false otherwise
		*/
		static function recursiveLoad($folder, $class){
			if (self::load($folder . DS . $class))
				return true;
			else { //check subfolders
				foreach (array_diff(scandir($folder), array('.', '..')) as $folderContent) {
					$subContent = $folder . DS . $folderContent;
					if(is_dir($subContent))
						if(self::recursiveLoad($subContent, $class))
							return true;
				}
				return false;
			}
		}

		/**
		* File loader
		* @param (array) $class_path : Array of path to include (only the first existing file is included)
		* @return (bool) true if a file can be included, false otherwise
		*/
		static function load($class_path){
			foreach (Extension::$supportedPhpExtensions as $extension){
				$class_file = $class_path . $extension;
				if(file_exists($class_file)){
					require($class_file);
					return true;
				}
			}
			return false;
		}
	}
?>