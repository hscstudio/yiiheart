<?php
$this->breadcrumbs=array(
	$pName=>Yii::app()->createUrl($pUrl), 
	'Training Documents'=>array('index'),
	'Import',
);
$this->menuCaption='Sub Menu';

$this->menu=array(
	array('label'=>'View '.$pName,'url'=>array($pUrl.'/view','id'=>$pId),'icon'=>'fa fa-eye'),
	array('label'=>'TrainingDocument','url'=>array("index","pId"=>$pId),'icon'=>'fa fa-list-alt','active'=>true),
);

$menu2=array(
	array('label'=>'TrainingDocument','url'=>array('index'),'icon'=>'fa fa-list-alt', 'items' =>
		array(	
			array('label'=>'List TrainingDocument','url'=>array('index',"pId"=>$pId),'icon'=>'fa fa-list-ol'),	
			array('label'=>'Create TrainingDocument','url'=>array('create',"pId"=>$pId),'icon'=>'fa fa-plus-circle'),
			array('label'=>'Import TrainingDocument','url'=>array('import',"pId"=>$pId),'icon'=>'fa fa-download','active'=>true),
			array('label'=>'Manage TrainingDocument','url'=>array('admin',"pId"=>$pId),'icon'=>'fa fa-tasks'),
		)
	)	
);
?>

<?php $box = $this->beginWidget(
    'bootstrap.widgets.TbBox',
    array(
        'title' => 'Import Training Documents' ,
        'headerIcon' => 'icon- fa fa-download',
        'headerButtons' => array(
        	array(
            	'class' => 'bootstrap.widgets.TbButtonGroup',
            	'type' => 'success',
            	// '', 'primary', 'info', 'success', 'warning', 'danger' or 'inverse'
            	'buttons' => $menu2
            )
        )        
    )
);?>
	<div class="clearfix"></div>
	<?php $form=$this->beginWidget('bootstrap.widgets.TbActiveForm',array(
		'id'=>'import-program-form',
		'enableAjaxValidation'=>false,
		'htmlOptions'=>array(
			'enctype'=>'multipart/form-data',
		),
		//'action' => Yii::app()->createUrl('import'),  //<- your form action here
	)); ?>
		<?php $this->widget('bootstrap.widgets.TbAlert', array(
		    'block'=>false, // display a larger alert block?
		    'fade'=>true, // use transitions?
		    'closeText'=>'&times;', // close link text - if set to false, no close link is displayed
		    'alerts'=>array( // configurations per alert type
		        'success'=>array('block'=>true, 'fade'=>true, 'closeText'=>'&times;'), //success, info, warning, error or danger
		        'info'=>array('block'=>true, 'fade'=>true, 'closeText'=>'&times;'), //success, info, warning, error or danger
		        'warning'=>array('block'=>true, 'fade'=>true, 'closeText'=>'&times;'), //success, info, warning, error or danger
		        'error'=>array('block'=>true, 'fade'=>true, 'closeText'=>'&times;'), //success, info, warning, error or danger
		        'danger'=>array('block'=>true, 'fade'=>true, 'closeText'=>'&times;'), //success, info, warning, error or danger
		    ),
		));
		?>
		<?php echo $form->fileFieldRow($model,'fileImport'); ?> (file type permitted: xls, xlsx, ods only)
	<div class="form-actions">
		<?php $this->widget('bootstrap.widgets.TbButton', array(
				'buttonType'=>'submit',
				'type'=>'primary',
				'label'=>'Import',
			)); ?>	</div>

	<?php $this->endWidget(); ?>
<?php $this->endWidget(); ?>