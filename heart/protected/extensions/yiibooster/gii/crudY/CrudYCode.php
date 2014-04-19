<?php
/**
 *## BootstrapCode class file.
 *
 * @author Christoffer Niska <ChristofferNiska@gmail.com>
 * @copyright Copyright &copy; Christoffer Niska 2011-
 * @license http://www.opensource.org/licenses/bsd-license.php New BSD License
 */

Yii::import('gii.generators.crud.CrudCode');

/**
 *## Class BootstrapCode
 *
 * @package booster.gii
 */
class CrudYCode extends CrudCode
{
	public function generateActiveRow($modelClass, $column)
	{
		if ($column->type === 'boolean') {
			return "\$form->checkBoxRow(\$model,'{$column->name}')";

		} else if ($column->dbType === 'tinyint(1)') { return "\$form->toggleButtonRow(\$model,'{$column->name}')";
		} else if ($column->dbType === 'date') { return "\$form->datepickerRow(\$model,'{$column->name}',
								array(
					                'options' => array(
					                    'language' => 'id',
					                    'format' => 'yyyy/mm/dd' , 'weekStart'=> 1
					                ), 
					            ),
					            array(
					                'prepend' => '<i class=\"icon-calendar\"></i>'
					            )
			);";

		} else if (substr($column->name,0,4) === 'ref_' or substr($column->name,0,3) === 'tb_') { 
			$names=explode('_', $column->name);
			if(@$names[2]=='id') $names[2]='';
			return " '';
			\$data".ucfirst($names[1]).ucfirst(@$names[2])." = ".ucfirst($names[1]).ucfirst(@$names[2])."::model()->findAll(array('order' => 'name'));
		    \$list".ucfirst($names[1]).ucfirst(@$names[2])." = CHtml::listData(\$data".ucfirst($names[1]).ucfirst(@$names[2]).",'id', 'name');
		    echo \$form->select2Row(\$model, '".$column->name."', array(
			   'data' => \$list".ucfirst($names[1]).ucfirst(@$names[2]).",

			))
			";

		} else if (stripos($column->dbType, 'text') !== false) {
			return "\$form->textAreaRow(\$model,'{$column->name}',array('rows'=>6, 'cols'=>50, 'class'=>'span8'))";
		} else if ($column->dbType='varchar(255)' and 
			(
				in_array($column->name, array('filename','document1','document2','photo','file','document')) or 
				preg_match('/^(file|doc)$/i', $column->name)
			)) {
			return "\$form->fileFieldRow(\$model,'{$column->name}')";	
		} else {
			if (preg_match('/^(password|pass|passwd|passcode)$/i', $column->name)) {
				$inputField = 'passwordFieldRow';
			} else {
				$inputField = 'textFieldRow';
			}

			if ($column->type !== 'string' || $column->size === null) {
				return "\$form->{$inputField}(\$model,'{$column->name}',array('class'=>'span5'))";//$column->name.$column->type.$column->dbType;
			} else {
				return "\$form->{$inputField}(\$model,'{$column->name}',array('class'=>'span5','maxlength'=>$column->size))";//$column->name.$column->type.$column->dbType;
			}
		}
	}
}
