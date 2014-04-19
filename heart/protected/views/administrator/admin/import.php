<?php
$this->breadcrumbs=array(
	'Admins'=>array('index'),
	'Import',
);

$this->menu=array(
	array('label'=>'Admin','url'=>array('index'),'icon'=>'fa fa-list-alt', 'items' =>
		array(	
			array('label'=>'List Admin','url'=>array('index'),'icon'=>'fa fa-list-ol'),	
			array('label'=>'Create Admin','url'=>array('create'),'icon'=>'fa fa-plus-circle'),
			array('label'=>'Import Admin','url'=>array('import'),'icon'=>'fa fa-download','active'=>true),
			array('label'=>'Manage Admin','url'=>array('admin'),'icon'=>'fa fa-tasks'),
		)
	)	
);
?>

<?php $box = $this->beginWidget(
    'bootstrap.widgets.TbBox',
    array(
        'title' => 'Import Admins' ,
        'headerIcon' => 'icon- fa fa-download',
        'headerButtons' => array(
        	array(
            	'class' => 'bootstrap.widgets.TbButtonGroup',
            	'type' => 'success',
            	// '', 'primary', 'info', 'success', 'warning', 'danger' or 'inverse'
            	'buttons' => $this->menu
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