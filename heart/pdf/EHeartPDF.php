<?php

/**
 * Wrapper for the TCPDF library.
 * @see README.md
 */
class EHeartPDF extends CComponent
{
	private static $_isInitialized = false;
	private static $libPathPDF = 'ext.heart.vendors.tcpdf.tcpdf'; //the path to the TCPDFlib
	
	/**
	 * Register autoloader.
	 */
	public static function init()
	{
		if (!self::$_isInitialized) {			  
			$lib = Yii::getPathOfAlias(self::$libPathPDF).'.php';
			if(!file_exists($lib)) {
				Yii::log("TCPDF lib not found($lib). Export disabled !", CLogger::LEVEL_WARNING, 'EHeartPDF');
			}           
			else{
				spl_autoload_unregister(array('YiiBase','autoload'));
				Yii::import(self::$libPathPDF, true);
				spl_autoload_register(array('YiiBase','autoload')); 
				self::$_isInitialized = true; 
			}
		}
	}
}