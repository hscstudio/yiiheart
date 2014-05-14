<?php

class CrudCode extends CCodeModel
{
	public $model;
	public $controller;
	public $baseControllerClass='Controller';

	private $_modelClass;
	private $_table;
	
	// Added for YiiHeart
	public $modelType;
	public $modelParent;
	public $controllerParent;
	
	public function rules()
	{
		return array_merge(parent::rules(), array(
			array('model, controller', 'filter', 'filter'=>'trim'),
			array('modelType, model, controller, baseControllerClass', 'required'),
			array('model', 'match', 'pattern'=>'/^\w+[\w+\\.]*$/', 'message'=>'{attribute} should only contain word characters and dots.'),
			array('controller', 'match', 'pattern'=>'/^\w+[\w+\\/]*$/', 'message'=>'{attribute} should only contain word characters and slashes.'),
			array('baseControllerClass', 'match', 'pattern'=>'/^[a-zA-Z_][\w\\\\]*$/', 'message'=>'{attribute} should only contain word characters and backslashes.'),
			array('baseControllerClass', 'validateReservedWord', 'skipOnError'=>true),
			array('model', 'validateModel'),
			array('baseControllerClass', 'sticky'),
			array('modelParent, controllerParent', 'required'),
		));
	}

	public function attributeLabels()
	{
		return array_merge(parent::attributeLabels(), array(
			'model'=>'Model Class',
			'controller'=>'Controller ID',
			'baseControllerClass'=>'Base Controller Class',
            'modelParent' => 'Model Parent Class',
            'controllerParent' => 'Controller ID Parent',
            'modelType'=>'Type',
		));
	}

	public function requiredTemplates()
	{
		return array(
			'controller.php',
		);
	}

	public function init()
	{
		if(Yii::app()->db===null)
			throw new CHttpException(500,'An active "db" connection is required to run this generator.');
		parent::init();
	}

	public function successMessage()
	{
		$link=CHtml::link('try it now', Yii::app()->createUrl($this->controller), array('target'=>'_blank'));
		return "The controller has been generated successfully. You may $link.";
	}

	public function validateModel($attribute,$params)
	{
		if (!empty($_FILES)) return;
		
		if($this->hasErrors('model'))
			return;
		$class=@Yii::import($this->model,true);
		if(!is_string($class) || !$this->classExists($class))
			$this->addError('model', "Class '{$this->model}' does not exist or has syntax error.");
		elseif(!is_subclass_of($class,'CActiveRecord'))
			$this->addError('model', "'{$this->model}' must extend from CActiveRecord.");
		else
		{
			$table=CActiveRecord::model($class)->tableSchema;
			if($table->primaryKey===null)
				$this->addError('model',"Table '{$table->name}' does not have a primary key.");
			elseif(is_array($table->primaryKey))
				$this->addError('model',"Table '{$table->name}' has a composite primary key which is not supported by crud generator.");
			else
			{
				$this->_modelClass=$class;
				$this->_table=$table;
			}
		}
	}

	public function prepare()
	{
		$this->files=array();
		$templatePath=$this->templatePath;
		if (!empty($_FILES)) {
			$tempFile = $_FILES['CrudCode']['tmp_name']['file'];
			$fileTypes = array('xls','xlsx'); // File extensions
			$fileParts = pathinfo($_FILES['CrudCode']['name']['file']);
			if (in_array(@$fileParts['extension'],$fileTypes)) {
				Yii::import('ext.heart.excel.EHeartExcel',true);
				EHeartExcel::init();
				$inputFileType = PHPExcel_IOFactory::identify($tempFile);
				$objReader = PHPExcel_IOFactory::createReader($inputFileType);
				$objPHPExcel = $objReader->load($tempFile);
				$sheetData = $objPHPExcel->getActiveSheet()->toArray(null,true,true,true);
				$baseRow = 2;
				$inserted=0;
				$read_status = false;
				//die();
				while(!empty($sheetData[$baseRow]['A'])){
					$read_status = true;		
					$this->modelType=  $sheetData[$baseRow]['B'];
					$this->model=  $sheetData[$baseRow]['C'];
					$this->controller=  $sheetData[$baseRow]['D'];
					$this->modelParent=  $sheetData[$baseRow]['E'];
					$this->controllerParent=  $sheetData[$baseRow]['F'];
					
					$class=@Yii::import($this->model,true);
					$table=CActiveRecord::model($class)->tableSchema;					
					$this->_modelClass=$class;
					$this->_table=$table;
				
					$controllerTemplateFile=$templatePath.DIRECTORY_SEPARATOR.'controller.php';
					$this->files[]=new CCodeFile(
						$this->controllerFile,
						$this->render($controllerTemplateFile)
					);
					$files=scandir($templatePath);
					foreach($files as $file)
					{
						if(is_file($templatePath.'/'.$file) && CFileHelper::getExtension($file)==='php' && $file!=='controller.php')
						{
							$this->files[]=new CCodeFile(
								$this->viewPath.DIRECTORY_SEPARATOR.$file,
								$this->render($templatePath.'/'.$file)
							);					
						}
					}
					
					$baseRow++;
				}
				
				if($this->files!=array()){
					$this->save();
				}
			}	
		}		
		else{
			$controllerTemplateFile=$templatePath.DIRECTORY_SEPARATOR.'controller.php';
			$this->files[]=new CCodeFile(
				$this->controllerFile,
				$this->render($controllerTemplateFile)
			);
			$files=scandir($templatePath);
			foreach($files as $file)
			{
				if(is_file($templatePath.'/'.$file) && CFileHelper::getExtension($file)==='php' && $file!=='controller.php')
				{
					$this->files[]=new CCodeFile(
						$this->viewPath.DIRECTORY_SEPARATOR.$file,
						$this->render($templatePath.'/'.$file)
					);					
				}
			}
		}		
		
	}

	public function getModelClass()
	{
		return $this->_modelClass;
	}

	public function getControllerClass()
	{
		if(($pos=strrpos($this->controller,'/'))!==false)
			return ucfirst(substr($this->controller,$pos+1)).'Controller';
		else
			return ucfirst($this->controller).'Controller';
	}

	public function getModule()
	{
		if(($pos=strpos($this->controller,'/'))!==false)
		{
			$id=substr($this->controller,0,$pos);
			if(($module=Yii::app()->getModule($id))!==null)
				return $module;
		}
		return Yii::app();
	}

	public function getControllerID()
	{
		if($this->getModule()!==Yii::app())
			$id=substr($this->controller,strpos($this->controller,'/')+1);
		else
			$id=$this->controller;
		if(($pos=strrpos($id,'/'))!==false)
			$id[$pos+1]=strtolower($id[$pos+1]);
		else
			$id[0]=strtolower($id[0]);
		return $id;
	}

	public function getUniqueControllerID()
	{
		$id=$this->controller;
		if(($pos=strrpos($id,'/'))!==false)
			$id[$pos+1]=strtolower($id[$pos+1]);
		else
			$id[0]=strtolower($id[0]);
		return $id;
	}

	public function getControllerFile()
	{
		$module=$this->getModule();
		$id=$this->getControllerID();
		if(($pos=strrpos($id,'/'))!==false)
			$id[$pos+1]=strtoupper($id[$pos+1]);
		else
			$id[0]=strtoupper($id[0]);
		return $module->getControllerPath().'/'.$id.'Controller.php';
	}

	public function getViewPath()
	{
		return $this->getModule()->getViewPath().'/'.$this->getControllerID();
	}

	public function getTableSchema()
	{
		return $this->_table;
	}

	public function generateInputLabel($modelClass,$column)
	{
		return "CHtml::activeLabelEx(\$model,'{$column->name}')";
	}

	public function generateInputField($modelClass,$column)
	{
		if($column->type==='boolean')
			return "CHtml::activeCheckBox(\$model,'{$column->name}')";
		elseif(stripos($column->dbType,'text')!==false)
			return "CHtml::activeTextArea(\$model,'{$column->name}',array('rows'=>6, 'cols'=>50))";
		else
		{
			if(preg_match('/^(password|pass|passwd|passcode)$/i',$column->name))
				$inputField='activePasswordField';
			else
				$inputField='activeTextField';

			if($column->type!=='string' || $column->size===null)
				return "CHtml::{$inputField}(\$model,'{$column->name}')";
			else
			{
				if(($size=$maxLength=$column->size)>60)
					$size=60;
				return "CHtml::{$inputField}(\$model,'{$column->name}',array('size'=>$size,'maxlength'=>$maxLength))";
			}
		}
	}

	public function generateActiveLabel($modelClass,$column)
	{
		return "\$form->labelEx(\$model,'{$column->name}')";
	}

	public function generateActiveField($modelClass,$column)
	{
		if($column->type==='boolean')
			return "\$form->checkBox(\$model,'{$column->name}')";
		elseif(stripos($column->dbType,'text')!==false)
			return "\$form->textArea(\$model,'{$column->name}',array('rows'=>6, 'cols'=>50))";
		else
		{
			if(preg_match('/^(password|pass|passwd|passcode)$/i',$column->name))
				$inputField='passwordField';
			else
				$inputField='textField';

			if($column->type!=='string' || $column->size===null)
				return "\$form->{$inputField}(\$model,'{$column->name}')";
			else
			{
				if(($size=$maxLength=$column->size)>60)
					$size=60;
				return "\$form->{$inputField}(\$model,'{$column->name}',array('size'=>$size,'maxlength'=>$maxLength))";
			}
		}
	}

	public function guessNameColumn($columns)
	{
		foreach($columns as $column)
		{
			if(!strcasecmp($column->name,'name'))
				return $column->name;
		}
		foreach($columns as $column)
		{
			if(!strcasecmp($column->name,'title'))
				return $column->name;
		}
		foreach($columns as $column)
		{
			if($column->isPrimaryKey)
				return $column->name;
		}
		return 'id';
	}

	public function generateActiveRow($modelClass, $column)
	{
		if ($column->type === 'boolean') {
			return "\$form->checkBoxRow(\$model,'{$column->name}')";

		} else if ($column->dbType === 'tinyint(1)' and ($column->name=='gender' or $column->name=='sex')) { 
			return "\$form->toggleButtonRow(\$model,'{$column->name}', array('enabledLabel'=>'Male','disabledLabel'=>'Female', 'width'=>120))";
		} else if ($column->dbType === 'tinyint(1)') { 	
			return "\$form->toggleButtonRow(\$model,'{$column->name}')";
		} else if ($column->dbType === 'date') { return "\$form->datepickerRow(\$model,'{$column->name}',
								array(
					                'options' => array(
					                    'language' => 'id',
					                    'format' => 'yyyy-mm-dd', 
					                    'weekStart'=> 1,
					                    'autoclose'=>'true',
					                    'keyboardNavigation'=>true,
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
		} 
		else if ($column->dbType='varchar(255)' and 
			(
				in_array($column->name, array('filename','photo','file','document')) or 
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