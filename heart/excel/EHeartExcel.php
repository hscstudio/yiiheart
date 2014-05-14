<?php

/**
 * Wrapper for the PHPExcel library.
 * @see README.md
 */
class EHeartExcel extends CComponent
{
	private static $_isInitialized = false;
	private static $libPathPHPExcel = 'ext.heart.vendors.phpexcel.Classes.PHPExcel'; //the path to the PHP excel lib
	
	/**
	 * Register autoloader.
	 */
	public static function init()
	{
		if (!self::$_isInitialized) {			  
			$lib = Yii::getPathOfAlias(self::$libPathPHPExcel).'.php';
			if(!file_exists($lib)) {
				Yii::log("PHP Excel lib not found($lib). Export disabled !", CLogger::LEVEL_WARNING, 'EHeartExcel');
			}           
			else{
				spl_autoload_unregister(array('YiiBase','autoload'));
				Yii::import(self::$libPathPHPExcel, true);
				spl_autoload_register(array('YiiBase','autoload')); 
				self::$_isInitialized = true; 
			}
		}
	}
}