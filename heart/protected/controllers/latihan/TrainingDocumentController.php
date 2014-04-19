<?php

class TrainingDocumentController extends Controller
{
	/**
	* @var string the default layout for the views. Defaults to '//layouts/column2', meaning
	* using two-column layout. See 'protected/views/layouts/column2.php'.
	*/
	public $layout='//layouts/column2';
	public $pName = 'Training'; //parent Model Class Name => Program
	public $pUrl = 'latihan/training'; //parent URL => pusdiklat/planning/program
	public $pId = 'tb_training_id'; //parent field ID => programId

	/**
	* @return array action filters
	*/
	public function filters()
	{
		return array(
			//'accessControl', // perform access control for CRUD operations
			'rights',
		);
	}

	/**
	* Specifies the access control rules.
	* This method is used by the 'accessControl' filter.
	* @return array access control rules
	public function accessRules()
	{
		return array(
			array('allow',  // allow all users to perform 'index' and 'view' actions
				'actions'=>array('index','view'),
				'users'=>array('*'),
			),
			array('allow', // allow authenticated user to perform 'create' and 'update' actions
				'actions'=>array('create','update'),
				'users'=>array('@'),
			),
			array('allow', // allow admin user to perform 'admin' and 'delete' actions
				'actions'=>array('admin','delete'),
				'users'=>array('admin'),
			),
			array('deny',  // deny all users
				'users'=>array('*'),
			),
		);
	}
	*/
	
	/**
	* Displays a particular model.
	* @param integer $id the ID of the model to be displayed
	*/
	public function actionView($id)
	{
		if (isset($_GET['pId']) and $_GET['pId']>0) {
			$pId=(int)$_GET['pId'];
			$this->render('view',array(
				'model'=>$this->loadModel($id),
				'pName'=> $this->pName,
				'pUrl'=> $this->pUrl,
				'pId'=> $pId,
			));
		}
		else{
			$this->redirect( Yii::app()->createUrl($this->pUrl) );
		}
	}

	/**
	* Creates a new model.
	* If creation is successful, the browser will be redirected to the 'view' page.
	*/
	public function actionCreate()
	{
		if (isset($_GET['pId']) and $_GET['pId']>0) {
			$pId=(int)$_GET['pId'];
			$model=new TrainingDocument;

			// Uncomment the following line if AJAX validation is needed
			// $this->performAjaxValidation($model);

			if(isset($_POST['TrainingDocument']))
			{
				$transaction = Yii::app()->db->beginTransaction();
				try{
					$model->attributes=$_POST['TrainingDocument'];

					// Overide with parent
					$model->{$this->pId} = $pId;
					//$uploadFile=CUploadedFile::getInstance($model,'filename');
					if($model->save()){
						$messageType = 'success';
						$message = "<strong>Well done!</strong> You successfully create data ";
						/*
						$model2 = TrainingDocument::model()->findByPk($model->id);						
						if(!empty($uploadFile)) {
							$extUploadFile = substr($uploadFile, strrpos($uploadFile, '.')+1);
							if(!empty($uploadFile)) {
								if($uploadFile->saveAs(Yii::app()->basePath.DIRECTORY_SEPARATOR.'..'.DIRECTORY_SEPARATOR.'files'.DIRECTORY_SEPARATOR.'trainingdocument'.DIRECTORY_SEPARATOR.$model2->id.DIRECTORY_SEPARATOR.$model2->id.'.'.$extUploadFile)){
									$model2->filename=$model2->id.'.'.$extUploadFile;
									$model2->save();
									$message .= 'and file uploded';
								}
								else{
									$messageType = 'warning';
									$message .= 'but file not uploded';
								}
							}						
						}
						*/
						$transaction->commit();
						Yii::app()->user->setFlash($messageType, $message);
						$this->redirect(array('view','id'=>$model->id,
							'pId'=> $pId,
						));
					}
				}
				catch (Exception $e){
					$transaction->rollBack();
					Yii::app()->user->setFlash('error', "{$e->getMessage()}");
					//$this->refresh();
				} 		
			}

			$this->render('create',array(
				'model'=>$model,
				'pName'=> $this->pName,
				'pUrl'=> $this->pUrl,
				'pId'=> $pId,
			));	
		}
		else{
			$this->redirect( Yii::app()->createUrl($this->pUrl) );
		}
	}

	/**
	* Updates a particular model.
	* If update is successful, the browser will be redirected to the 'view' page.
	* @param integer $id the ID of the model to be updated
	*/
	public function actionUpdate($id)
	{
		if (isset($_GET['pId']) and $_GET['pId']>0) {
			$pId=(int)$_GET['pId'];
			$model=$this->loadModel($id);

			// Uncomment the following line if AJAX validation is needed
			// $this->performAjaxValidation($model);

			if(isset($_POST['TrainingDocument']))
			{
				$transaction = Yii::app()->db->beginTransaction();
				try{
					$model->attributes=$_POST['TrainingDocument'];
					$messageType = 'success';
					$message = "<strong>Well done!</strong> You successfully update data ";

					/*
					$uploadFile=CUploadedFile::getInstance($model,'filename');
					if(!empty($uploadFile)) {
						$extUploadFile = substr($uploadFile, strrpos($uploadFile, '.')+1);
						if(!empty($uploadFile)) {
							if($uploadFile->saveAs(Yii::app()->basePath.DIRECTORY_SEPARATOR.'..'.DIRECTORY_SEPARATOR.'files'.DIRECTORY_SEPARATOR.'trainingdocument'.DIRECTORY_SEPARATOR.$model->id.DIRECTORY_SEPARATOR.$model->id.'.'.$extUploadFile)){
								$model->filename=$model->id.'.'.$extUploadFile;
								$message .= 'and file uploded';
							}
							else{
								$messageType = 'warning';
								$message .= 'but file not uploded';
							}
						}						
					}
					*/
					// Overide with parent
					$model->{$this->pId} = $pId;

					if($model->save()){
						$transaction->commit();
						Yii::app()->user->setFlash($messageType, $message);
						$this->redirect(array('view','id'=>$model->id,
							'pId'=> $pId,
						));
					}
				}
				catch (Exception $e){
					$transaction->rollBack();
					Yii::app()->user->setFlash('error', "{$e->getMessage()}");
					// $this->refresh(); 
				}
			}

			$this->render('update',array(
				'model'=>$model,
				'pName'=> $this->pName,
				'pUrl'=> $this->pUrl,
				'pId'=> $pId,
			));
		}
		else{
			$this->redirect( Yii::app()->createUrl($this->pUrl) );
		}
	}

	/**
	* Deletes a particular model.
	* If deletion is successful, the browser will be redirected to the 'admin' page.
	* @param integer $id the ID of the model to be deleted
	*/
	public function actionDelete($id)
	{
		if(Yii::app()->request->isPostRequest)
		{
			// we only allow deletion via POST request
			$this->loadModel($id)->delete();

			// if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
			if(!isset($_GET['ajax']))
				$this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('admin'));
		}
		else
			throw new CHttpException(400,'Invalid request. Please do not repeat this request again.');
	}

	/**
	* Lists all models.
	*/
	public function actionIndex()
	{
		/**
		$dataProvider=new CActiveDataProvider('TrainingDocument');
		$this->render('index',array(
			'dataProvider'=>$dataProvider,
		));
		*/

		if (isset($_GET['pId']) and $_GET['pId']>0) {
			$pId = (int)@$_GET['pId'];
			$model=new TrainingDocument('search');
			$model->unsetAttributes();  // clear any default values
			if(isset($_GET['TrainingDocument']))
				$model->attributes=$_GET['TrainingDocument'];

			$this->render('index',array(
				'model'=>$model,
				'pName'=> $this->pName,
				'pUrl'=> $this->pUrl,
				'pId'=> $pId,
			));	
		}
		else{
			$this->redirect( Yii::app()->createUrl($this->pUrl) );
		}
	}

	/**
	* Manages all models.
	*/
	public function actionAdmin()
	{
		if (isset($_GET['pId']) and $_GET['pId']>0) {
			$pId = (int)@$_GET['pId'];
			$model=new TrainingDocument('search');
			$model->unsetAttributes();  // clear any default values
			if(isset($_GET['TrainingDocument']))
				$model->attributes=$_GET['TrainingDocument'];

			$this->render('admin',array(
				'model'=>$model,
				'pName'=> $this->pName,
				'pUrl'=> $this->pUrl,
				'pId'=> $pId,
			));
		}
		else{
			$this->redirect( Yii::app()->createUrl($this->pUrl) );
		}
	}

	/**
	* Returns the data model based on the primary key given in the GET variable.
	* If the data model is not found, an HTTP exception will be raised.
	* @param integer the ID of the model to be loaded
	*/
	public function loadModel($id)
	{
		$model=TrainingDocument::model()->findByPk($id);
		if($model===null)
			throw new CHttpException(404,'The requested page does not exist.');
		return $model;
	}

	/**
	* Performs the AJAX validation.
	* @param CModel the model to be validated
	*/
	protected function performAjaxValidation($model)
	{
		if(isset($_POST['ajax']) && $_POST['ajax']==='training-document-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}

	public function actionExport()
    {
        $model=new TrainingDocument;
		$model->unsetAttributes();  // clear any default values
		if(isset($_POST['TrainingDocument']))
			$model->attributes=$_POST['TrainingDocument'];

		$exportType = $_POST['fileType'];
        $this->widget('ext.phpexcel.EExcelView', array(
            'title'=>'List of TrainingDocument',
            'dataProvider' => $model->search(),
            'filter'=>$model,
            'grid_mode'=>'export',
            'exportType'=>$exportType,
            'columns' => array(
	                
					'id',
					'tb_training_id',
					'name',
					'filename',
					'description',
					'status',
					//'created',
					//'createdBy',
					//'modified',
					//'modifiedBy',
					//'deleted',
					//'deletedBy',
	            ),
        ));
    }

    /**
	* Creates a new model.
	* If creation is successful, the browser will be redirected to the 'view' page.
	*/
	public function actionImport()
	{
		if (isset($_GET['pId']) and $_GET['pId']>0) {
			$pId=(int)$_GET['pId'];	
			$model=new TrainingDocument;
			// Uncomment the following line if AJAX validation is needed
			// $this->performAjaxValidation($model);

			if(isset($_POST['TrainingDocument']))
			{
				if (!empty($_FILES)) {
					$tempFile = $_FILES['TrainingDocument']['tmp_name']['fileImport'];
					$fileTypes = array('xls','xlsx'); // File extensions
					$fileParts = pathinfo($_FILES['TrainingDocument']['name']['fileImport']);
					if (in_array(@$fileParts['extension'],$fileTypes)) {

						Yii::import('ext.phpexcel.XPHPExcel',true);
		        		XPHPExcel::init();
		        		$inputFileType = PHPExcel_IOFactory::identify($tempFile);
						$objReader = PHPExcel_IOFactory::createReader($inputFileType);
						$objPHPExcel = $objReader->load($tempFile);
						$sheetData = $objPHPExcel->getActiveSheet()->toArray(null,true,true,true);
						$baseRow = 2;
						$inserted=0;
						$read_status = false;
						while(!empty($sheetData[$baseRow]['A'])){
							$read_status = true;
							
						$tb_training_id=  $sheetData[$baseRow]['A'];
						$name=  $sheetData[$baseRow]['B'];
						$filename=  $sheetData[$baseRow]['C'];
						$description=  $sheetData[$baseRow]['D'];
						$status=  $sheetData[$baseRow]['E'];
						//$created=  $sheetData[$baseRow]['F'];
						//$createdBy=  $sheetData[$baseRow]['G'];
						//$modified=  $sheetData[$baseRow]['H'];
						//$modifiedBy=  $sheetData[$baseRow]['I'];
						//$deleted=  $sheetData[$baseRow]['J'];
						//$deletedBy=  $sheetData[$baseRow]['K'];


							$model2=new TrainingDocument;
													$model2->tb_training_id=  $tb_training_id;
						$model2->name=  $name;
						$model2->filename=  $filename;
						$model2->description=  $description;
						$model2->status=  $status;
						//$model2->created=  $created;
						//$model2->createdBy=  $createdBy;
						//$model2->modified=  $modified;
						//$model2->modifiedBy=  $modifiedBy;
						//$model2->deleted=  $deleted;
						//$model2->deletedBy=  $deletedBy;

							try{
								if($model2->save()){
									$inserted++;
								}
							}
							catch (Exception $e){
								Yii::app()->user->setFlash('error', "{$e->getMessage()}");
								//$this->refresh();
							} 
							$baseRow++;
						}	
						Yii::app()->user->setFlash('success', ($inserted).' row inserted');	
					}	
					else
					{
						Yii::app()->user->setFlash('warning', 'Wrong file type (xlsx, xls, and ods only)');
					}
				}


				$this->render('import',array(
					'model'=>$model,
					'pName'=> $this->pName,
					'pUrl'=> $this->pUrl,
					'pId'=> $pId,
				));
			}
			else{
				$this->render('import',array(
					'model'=>$model,
					'pName'=> $this->pName,
					'pUrl'=> $this->pUrl,
					'pId'=> $pId,
				));
			}
		}
		else{
			$this->redirect( Yii::app()->createUrl($this->pUrl) );
		}

	}

	public function actionEditable(){
		Yii::import('bootstrap.widgets.TbEditableSaver'); 
	    $es = new TbEditableSaver('TrainingDocument');  
	    $es->onBeforeUpdate = function($event) {
	    		        	$event->sender->setAttribute('modified', new CDbExpression('NOW()'));
	        	$event->sender->setAttribute('modifiedBy', Yii::app()->user->id);
	        		    };
	    
	    $es->update();
	}
}
