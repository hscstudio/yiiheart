<?php
/**
 * This is the template for generating a controller class file for CRUD feature.
 * The following variables are available in this template:
 * - $this: the CrudCode object
 */
?>
<?php echo "<?php\n"; ?>

class <?php echo $this->controllerClass; ?> extends <?php echo $this->baseControllerClass."\n"; ?>
{
	
	<?php
	
	$showCalendar=false;
	$date=0;
	$calendar_name='';
	$calendar_start='';
	$calendar_end='';
	foreach ($this->tableSchema->columns as $column) {
    	if ($column->dbType === 'date'){
    		$date++;
    	}

    	if(in_array($column->name, array('name','title','agenda'))){
    		if(empty($calendar_name)){
    			$calendar_name=$column->name;
    		}
    	}

    	if(in_array($column->name, array('birthDay','birthday'))){
    		if(empty($calendar_start)){
    			$calendar_start=$column->name;
    			$calendar_end=$column->name;
    		}
    	}

    	if(in_array($column->name, array('start','begin'))){
    		if(empty($calendar_start)){
    			$calendar_start=$column->name;
    		}
    	}

    	if(in_array($column->name, array('end','finish'))){
    		if(empty($calendar_end)){
    			$calendar_end=$column->name;
    		}
    	}
    }

    if($date>0){
    	$showCalendar=true;
    }
    ?>

	/**
	 * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
	 * using two-column layout. See 'protected/views/layouts/column2.php'.
	 */
	<?php 
	if($this->modelType=="1"){ ?>
	
	public $layout='//layouts/column1';		
	<?php 
	}
	else if($this->modelType=="2"){ ?>

	public $layout='//layouts/column1';	
	public $menuCaption='Sub Menu';	
	<?php }else{ ?>
	<?php
	$modelParent = new $this->modelParent;
	?>
	public $menuCaption="Sub Menu";
	public $layout='//layouts/column2';
	public $pName = '<?php echo $this->modelParent; ?>'; //parent Model Class Name => Program
	public $pUrl = '<?php echo $this->controllerParent; ?>'; //parent URL => pusdiklat/planning/program
	public $pId = '<?php echo $modelParent->tableName().'_'.$this->tableSchema->primaryKey; ?>'; //parent field ID => programId
	<?php } ?>
	/**
	 * @return array action filters
	 */
	public function filters()
	{
		return array(
			<?php 
			if (!Yii::app()->hasModule('rights')) { ?>
			
			'accessControl', // perform access control for CRUD operations
			'postOnly + delete', // we only allow deletion via POST request
			<?php
			}
			else{ ?>
			
			'rights - index, view',
			<?php
			}
			?>
			
		);
	}
	
	<?php 
	if (!Yii::app()->hasModule('rights')) { ?>
	/**
	 * Specifies the access control rules.
	 * This method is used by the 'accessControl' filter.
	 * @return array access control rules
	 */
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
				'actions'=>array('admin','delete','export','import','editable','toggle',<?php if($showCalendar){ echo "'calendar', 'calendarEvents', "; } ?>),
				'users'=>array('admin'),
			),
			array('deny',  // deny all users
				'users'=>array('*'),
			),
		);
	}
	<?php
	}
	?>
	
	/**
	 * Displays a particular model.
	 * @param integer $id the ID of the model to be displayed
	 */
	public function actionView($id)
	{
		<?php if($this->modelType=="2"){ ?>
		
		$this->layout = 'column2';
		<?php } ?>

		if(isset($_GET['asModal'])){
			$this->renderPartial('view',array(
				'model'=>$this->loadModel($id),
			));
		}
		else{
			<?php if($this->modelType=="3"){ ?>
			
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
			<?php } else{ ?>
			
			$this->render('view',array(
				'model'=>$this->loadModel($id),
			));
			<?php } ?>

		}
	}

	/**
	 * Creates a new model.
	 * If creation is successful, the browser will be redirected to the 'view' page.
	 */
	public function actionCreate()
	{
		<?php if($this->modelType=="3"){ ?>
		
		if (isset($_GET['pId']) and $_GET['pId']>0) {
			$pId=(int)$_GET['pId'];
			
		<?php } ?>
		
		$model=new <?php echo $this->modelClass; ?>;

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if(isset($_POST['<?php echo $this->modelClass; ?>']))
		{
			$transaction = Yii::app()->db->beginTransaction();
			try{
				$messageType='warning';
				$message = "There are some errors ";
				$model->attributes=$_POST['<?php echo $this->modelClass; ?>'];
				//$uploadFile=CUploadedFile::getInstance($model,'filename');
				if($model->save()){
					$messageType = 'success';
					$message = "<strong>Well done!</strong> You successfully create data ";
					/*
					$model2 = <?php echo $this->modelClass; ?>::model()->findByPk($model-><?php echo $this->tableSchema->primaryKey; ?>);						
					if(!empty($uploadFile)) {
						$extUploadFile = substr($uploadFile, strrpos($uploadFile, '.')+1);
						if(!empty($uploadFile)) {
							if($uploadFile->saveAs(Yii::app()->basePath.DIRECTORY_SEPARATOR.'files'.DIRECTORY_SEPARATOR.'<?php echo strtolower($this->modelClass); ?>'.DIRECTORY_SEPARATOR.$model2-><?php echo $this->tableSchema->primaryKey; ?>.DIRECTORY_SEPARATOR.$model2-><?php echo $this->tableSchema->primaryKey; ?>.'.'.$extUploadFile)){
								$model2->filename=$model2-><?php echo $this->tableSchema->primaryKey; ?>.'.'.$extUploadFile;
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
					$this->redirect(array('view','id'=>$model-><?php echo $this->tableSchema->primaryKey; ?>));
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
			<?php if($this->modelType=="3"){ ?>
		
			'pName'=> $this->pName,
			'pUrl'=> $this->pUrl,
			'pId'=> $pId,
			<?php } ?>
		));
		
		<?php if($this->modelType=="3"){ ?>
		
		}
		else{
			$this->redirect( Yii::app()->createUrl($this->pUrl) );
		}
		<?php } ?>		
	}

	/**
	 * Updates a particular model.
	 * If update is successful, the browser will be redirected to the 'view' page.
	 * @param integer $id the ID of the model to be updated
	 */
	public function actionUpdate($id)
	{
		<?php if($this->modelType=="3"){ ?>
		
		if (isset($_GET['pId']) and $_GET['pId']>0) {
			$pId=(int)$_GET['pId'];
			
		<?php } ?>

		$model=$this->loadModel($id);

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if(isset($_POST['<?php echo $this->modelClass; ?>']))
		{
			$messageType='warning';
			$message = "There are some errors ";
			$transaction = Yii::app()->db->beginTransaction();
			try{
				$model->attributes=$_POST['<?php echo $this->modelClass; ?>'];
				$messageType = 'success';
				$message = "<strong>Well done!</strong> You successfully update data ";

				/*
				$uploadFile=CUploadedFile::getInstance($model,'filename');
				if(!empty($uploadFile)) {
					$extUploadFile = substr($uploadFile, strrpos($uploadFile, '.')+1);
					if(!empty($uploadFile)) {
						if($uploadFile->saveAs(Yii::app()->basePath.DIRECTORY_SEPARATOR.'files'.DIRECTORY_SEPARATOR.'<?php echo strtolower($this->modelClass); ?>'.DIRECTORY_SEPARATOR.$model-><?php echo $this->tableSchema->primaryKey; ?>.DIRECTORY_SEPARATOR.$model-><?php echo $this->tableSchema->primaryKey; ?>.'.'.$extUploadFile)){
							$model->filename=$model-><?php echo $this->tableSchema->primaryKey; ?>.'.'.$extUploadFile;
							$message .= 'and file uploded';
						}
						else{
							$messageType = 'warning';
							$message .= 'but file not uploded';
						}
					}						
				}
				*/

				if($model->save()){
					$transaction->commit();
					Yii::app()->user->setFlash($messageType, $message);
					$this->redirect(array('view','id'=>$model-><?php echo $this->tableSchema->primaryKey; ?>));
				}
			}
			catch (Exception $e){
				$transaction->rollBack();
				Yii::app()->user->setFlash('error', "{$e->getMessage()}");
				// $this->refresh(); 
			}

			$model->attributes=$_POST['<?php echo $this->modelClass; ?>'];
			if($model->save())
				$this->redirect(array('view','id'=>$model-><?php echo $this->tableSchema->primaryKey; ?>));
		}

		$this->render('update',array(
			'model'=>$model,
			<?php if($this->modelType=="3"){ ?>
		
			'pName'=> $this->pName,
			'pUrl'=> $this->pUrl,
			'pId'=> $pId,
			<?php } ?>
		));
		
		<?php if($this->modelType=="3"){ ?>
		
		}
		else{
			$this->redirect( Yii::app()->createUrl($this->pUrl) );
		}
		<?php } ?>
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
		/*
		$dataProvider=new CActiveDataProvider('<?php echo $this->modelClass; ?>');
		$this->render('index',array(
			'dataProvider'=>$dataProvider,
		));
		*/
		<?php if($this->modelType=="3"){ ?>
		
		if (isset($_GET['pId']) and $_GET['pId']>0) {
			$pId=(int)$_GET['pId'];
			
		<?php } ?>

		$model=new <?php echo $this->modelClass; ?>('search');
		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['<?php echo $this->modelClass; ?>']))
			$model->attributes=$_GET['<?php echo $this->modelClass; ?>'];

		$this->render('index',array(
			'model'=>$model,
			<?php if($this->modelType=="3"){ ?>
		
			'pName'=> $this->pName,
			'pUrl'=> $this->pUrl,
			'pId'=> $pId,
			<?php } ?>
		));
		
		<?php if($this->modelType=="3"){ ?>
		
		}
		else{
			$this->redirect( Yii::app()->createUrl($this->pUrl) );
		}
		<?php } ?>
	}

	/**
	 * Manages all models.
	 */
	public function actionAdmin()
	{
		<?php if($this->modelType=="3"){ ?>
		
		if (isset($_GET['pId']) and $_GET['pId']>0) {
			$pId=(int)$_GET['pId'];
			
		<?php } ?>

		$model=new <?php echo $this->modelClass; ?>('search');
		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['<?php echo $this->modelClass; ?>']))
			$model->attributes=$_GET['<?php echo $this->modelClass; ?>'];

		$this->render('admin',array(
			'model'=>$model,
			<?php if($this->modelType=="3"){ ?>
		
			'pName'=> $this->pName,
			'pUrl'=> $this->pUrl,
			'pId'=> $pId,
			<?php } ?>
		));
		
		<?php if($this->modelType=="3"){ ?>
		
		}
		else{
			$this->redirect( Yii::app()->createUrl($this->pUrl) );
		}
		<?php } ?>
	}

	/**
	 * Returns the data model based on the primary key given in the GET variable.
	 * If the data model is not found, an HTTP exception will be raised.
	 * @param integer $id the ID of the model to be loaded
	 * @return <?php echo $this->modelClass; ?> the loaded model
	 * @throws CHttpException
	 */
	public function loadModel($id)
	{
		$model=<?php echo $this->modelClass; ?>::model()->findByPk($id);
		if($model===null)
			throw new CHttpException(404,'The requested page does not exist.');
		return $model;
	}

	/**
	 * Performs the AJAX validation.
	 * @param <?php echo $this->modelClass; ?> $model the model to be validated
	 */
	protected function performAjaxValidation($model)
	{
		if(isset($_POST['ajax']) && $_POST['ajax']==='<?php echo $this->class2id($this->modelClass); ?>-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}
	
	public function actionExport()
    {
        $model=new <?php echo $this->modelClass; ?>;
		$model->unsetAttributes();  // clear any default values
		if(isset($_POST['<?php echo $this->modelClass; ?>']))
			$model->attributes=$_POST['<?php echo $this->modelClass; ?>'];

		$exportType = $_POST['fileType'];
        $this->widget('ext.heart.export.EHeartExport', array(
            'title'=>'List of <?php echo $this->modelClass; ?>',
            'dataProvider' => $model->search(),
            'filter'=>$model,
            'grid_mode'=>'export',
            'exportType'=>$exportType,
            'columns' => array(
	                <?php
	                $count=0;
					foreach ($this->tableSchema->columns as $column) {
						if (in_array($column->name, array('created','createdBy','modified','modifiedBy','deleted','deletedBy'))) 
							echo "\n\t\t\t\t\t//'" . $column->name . "',";
						else	
							echo "\n\t\t\t\t\t'" . $column->name . "',";
						$count++;
					}
					echo "\n";
					?>
	            ),
        ));
    }

    /**
	* Creates a new model.
	* If creation is successful, the browser will be redirected to the 'view' page.
	*/
	public function actionImport()
	{
		
		$model=new <?php echo $this->modelClass; ?>;
		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if(isset($_POST['<?php echo $this->modelClass; ?>']))
		{
			if (!empty($_FILES)) {
				$tempFile = $_FILES['<?php echo $this->modelClass; ?>']['tmp_name']['fileImport'];
				$fileTypes = array('xls','xlsx'); // File extensions
				$fileParts = pathinfo($_FILES['<?php echo $this->modelClass; ?>']['name']['fileImport']);
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
					while(!empty($sheetData[$baseRow]['A'])){
						$read_status = true;						
						<?php
						$abjadX=array();
						for($i=65;$i<=90;$i++){
							$abjadX[]=chr($i);
							if($i==90){
								for($j=65;$j<=90;$j++){
									for($k=65;$k<=90;$k++){
										$abjadX[]=chr($j).chr($k);
									}
								}
							}
						}
						$count=0;
						foreach ($this->tableSchema->columns as $column) {
							if($count!=0) echo "\t\t\t\t\t\t";
							if ($column->autoIncrement or in_array($column->name, array('created','createdBy','modified','modifiedBy','deleted','deletedBy'))) 
								echo "//\$" . $column->name . "=  \$sheetData[\$baseRow]['".$abjadX[$count]."'];\n";	
							else 
								echo "\$" . $column->name . "=  \$sheetData[\$baseRow]['".$abjadX[$count]."'];\n";
							$count++;
						}
						echo "\n";
						?>
						$model2=new <?php echo $this->modelClass; ?>;
						<?php
						$count=0;
						foreach ($this->tableSchema->columns as $column) {
							if($count!=0) echo "\t\t\t\t\t\t";
							if ($column->autoIncrement or in_array($column->name, array('created','createdBy','modified','modifiedBy','deleted','deletedBy'))) 
								echo "//\$model2->" . $column->name . "=  \$".$column->name.";\n";
							else 
								echo "\$model2->" . $column->name . "=  \$".$column->name.";\n";
							$count++;	
						}
						echo "\n";
						?>
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


			$this->render('admin',array(
				'model'=>$model,
			));
		}
		else{
			$this->render('admin',array(
				'model'=>$model,
			));
		}
	}

	public function actionEditable(){
		Yii::import('bootstrap.widgets.TbEditableSaver'); 
	    $es = new TbEditableSaver('<?php echo $this->modelClass; ?>'); 
		<?php
		$fieldModified=false;
		foreach ($this->tableSchema->columns as $column) {
			if($column->name=='modified' or $column->name=='modifiedBy'){
				$fieldModified=true;
			}
		}
		
		if($fieldModified){
			?>		
			$es->onBeforeUpdate = function($event) {
				
					$event->sender->setAttribute('modified', new CDbExpression('NOW()'));
					$event->sender->setAttribute('modifiedBy', Yii::app()->user->id);
			};
			<?php
		}
		?>
	    $es->update();
	}

	public function actions()
	{
    	return array(
        		'toggle' => array(
                	'class'=>'bootstrap.actions.TbToggleAction',
                	'modelName' => '<?php echo $this->modelClass; ?>',
        		)
    	);
	}

	<?php
	if($showCalendar){ ?>

	public function actionCalendar()
	{
		$model=new <?php echo $this->modelClass; ?>('search');
		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['<?php echo $this->modelClass; ?>']))
			$model->attributes=$_GET['<?php echo $this->modelClass; ?>'];
		$this->render('calendar',array(
			'model'=>$model,
		));	
	}

	public function actionCalendarEvents()
	{	 	
	 	$items = array();
	 	$model=<?php echo $this->modelClass; ?>::model()->findAll();	
		foreach ($model as $value) {
			$items[]=array(
				'id'=>$value-><?php echo $this->tableSchema->primaryKey; ?>,
				<?php
				if(!empty($calendar_name)){ 
				?>

				'title'=>$value-><?php echo $calendar_name; ?>,
				<?php
				}
				if(!empty($calendar_name)){ 
				?>

				'start'=>$value-><?php echo $calendar_start; ?>,
				<?php
				}
				if(!empty($calendar_name)){ 
				?>

				'end'=>date('Y-m-d', strtotime('+1 day', strtotime($value-><?php echo $calendar_end; ?>))),
				<?php
				}
				?>
				
				//'color'=>'#CC0000',
	        	//'allDay'=>true,
	        	'url'=>'#',
			);
		}
	    echo CJSON::encode($items);
	    Yii::app()->end();
	}

	<?php
	}
	?>

}
