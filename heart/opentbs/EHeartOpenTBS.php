<?php

/**
 * Wrapper for the OpenTBS library.
 * @see README.md
 */
class EHeartOpenTBS extends CComponent
{
	private static $_isInitialized = false;
	private static $libPathOpenTBS = 'ext.heart.vendors.OpenTBS'; //the path to the PHP excel lib
	
	/**
	 * Register autoloader.
	 */
	public static function init()
	{
		if (!self::$_isInitialized) {			  
			$lib = Yii::getPathOfAlias(self::$libPathOpenTBS).DIRECTORY_SEPARATOR.'tbs_class.php';
			if(!file_exists($lib)) {
				Yii::log("OpenTBS lib not found($lib). Export disabled !", CLogger::LEVEL_WARNING, 'EHeartOpenTBS');
			}           
			else{
				spl_autoload_unregister(array('YiiBase','autoload'));
				//Yii::import(self::$libPathOpenTBS.DIRECTORY_SEPARATOR.'tbs_class.php', true);
				//Yii::import(self::$libPathOpenTBS.'/tbs_plugin_opentbs.php', true);
				$lib = Yii::getPathOfAlias(self::$libPathOpenTBS).DIRECTORY_SEPARATOR.'tbs_class.php';
				require($lib);
				$lib = Yii::getPathOfAlias(self::$libPathOpenTBS).DIRECTORY_SEPARATOR.'tbs_plugin_opentbs.php';
				require($lib);
				spl_autoload_register(array('YiiBase','autoload')); 
				self::$_isInitialized = true; 
			}
		}
	}
}