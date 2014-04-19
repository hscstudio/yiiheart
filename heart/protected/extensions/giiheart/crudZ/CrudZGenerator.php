<?php
/**
 *## BootstrapGenerator class file.
 *
 * @author Christoffer Niska <ChristofferNiska@gmail.com>
 * @copyright Copyright &copy; Christoffer Niska 2011-
 * @license http://www.opensource.org/licenses/bsd-license.php New BSD License
 */

Yii::import('gii.generators.crud.CrudGenerator');

/**
 *## Class BootstrapGenerator
 *
 * @package booster.gii
 */
class CrudZGenerator extends CrudGenerator
{
	public $codeModel = 'ext.giiheart.crudZ.CrudZCode';

	/**
     * Returns the model names in an array.
     * Only non abstract and subclasses of AweActiveRecord models are returned.
     * The array is used to build the autocomplete field.
     * @return array The names of the models
     */
    protected function getModels()
    {
        $models = array();
        $files = scandir(Yii::getPathOfAlias('application.models'));
        foreach ($files as $file) {
            if ($file[0] !== '.' && CFileHelper::getExtension($file) === 'php') {
                $fileClassName = substr($file, 0, strpos($file, '.'));
                $models[] = $fileClassName;
            }
        }
        return $models;
    }
}