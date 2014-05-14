<?php echo "<?php\n"; ?>
$currController 	= Yii::app()->controller->id;
$currControllers	= explode('/', $currController);
$currAction			= Yii::app()->controller->action->id;
$currRoute 			= Yii::app()->controller->getRoute();
$currRoutes			= explode('/', $currRoute);

<?php
$showCalendar=false;
$date=0;
foreach ($this->tableSchema->columns as $column) {
	if ($column->dbType === 'date'){
		$date++;
	}
}
if($date>0){
	$showCalendar=true;
}
?>
$menu=array();
if(in_array($currAction,array('index','view','create','update','admin','calendar','import')))
$menu[]=array('label'=>'List <?php echo $this->modelClass; ?>','url'=>array('index'<?php if($this->modelType=="3"){ ?>,'pId'=>$pId<?php } ?>),'icon'=>'fa fa-list-ol','active'=>($currAction=='index')?true:false);

if(in_array($currAction,array('index','view','create','update','admin','calendar','import')))
$menu[]=array('label'=>'Create <?php echo $this->modelClass; ?>','url'=>array('create'<?php if($this->modelType=="3"){ ?>,'pId'=>$pId<?php } ?>),'icon'=>'fa fa-plus-circle','active'=>($currAction=='create')?true:false);

if(in_array($currAction,array('index','view','create','update','admin','calendar','import')))
$menu[]=array('label'=>'Manage <?php echo $this->modelClass; ?>','url'=>array('admin'<?php if($this->modelType=="3"){ ?>,'pId'=>$pId<?php } ?>),'icon'=>'fa fa-tasks','active'=>($currAction=='admin')?true:false);

<?php if($showCalendar==true){ ?>
if(in_array($currAction,array('index','view','create','update','admin','calendar','import')))
$menu[]=array('label'=>'Calendar <?php echo $this->modelClass; ?>','url'=>array('calendar'<?php if($this->modelType=="3"){ ?>,'pId'=>$pId<?php } ?>),'icon'=>'fa fa-calendar','active'=>($currAction=='calendar')?true:false);
<?php } ?>