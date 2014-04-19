<?php
$this->breadcrumbs=array(
	'Trainings'=>array('index'),
	$model->name=>array('view','id'=>$model->id),
	'Update',
);

$this->menu=array(
	array('label'=>'Training','url'=>array('index'),'icon'=>'fa fa-list-alt', 'items' =>
		array(	
			array('label'=>'List Training','url'=>array('index'),'icon'=>'fa fa-list-ol'),	
			array('label'=>'Create Training','url'=>array('create'),'icon'=>'fa fa-plus-circle'),
			array('label'=>'Import Training','url'=>array('import'),'icon'=>'fa fa-download'),
			array('label'=>'Update Training','url'=>array('update','id'=>$model->id),'icon'=>'fa fa-pencil','active'=>true),
			array('label'=>'View Training','url'=>array('view','id'=>$model->id),'icon'=>'fa fa-eye'),
			array('label'=>'Manage Training','url'=>array('admin'),'icon'=>'fa fa-tasks'),
		)
	)	
);
?>

<?php $box = $this->beginWidget(
    'bootstrap.widgets.TbBox',
    array(
        'title' => 'Update Trainings #'.$model->id,
        'headerIcon' => 'icon- fa fa-pencil',
        'headerButtons' => array(
            array(
                'class' => 'bootstrap.widgets.TbButtonGroup',
                'type' => 'success',
                // '', 'primary', 'info', 'success', 'warning', 'danger' or 'inverse'
                'buttons' => $this->menu
            ),
        ) 
    )
);?>
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
		?><?php echo $this->renderPartial('_form',array('model'=>$model)); ?>
<?php $this->endWidget(); ?>