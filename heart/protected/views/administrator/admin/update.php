<?php
$this->breadcrumbs=array(
	'Admins'=>array('index'),
	$model->id=>array('view','id'=>$model->id),
	'Update',
);

$this->menu=array(
	array('label'=>'Admin','url'=>array('index'),'icon'=>'fa fa-list-alt', 'items' =>
		array(	
			array('label'=>'List Admin','url'=>array('index'),'icon'=>'fa fa-list-ol'),	
			array('label'=>'Create Admin','url'=>array('create'),'icon'=>'fa fa-plus-circle'),
			array('label'=>'Import Admin','url'=>array('import'),'icon'=>'fa fa-download'),
			array('label'=>'Update Admin','url'=>array('update','id'=>$model->id),'icon'=>'fa fa-pencil','active'=>true),
			array('label'=>'View Admin','url'=>array('view','id'=>$model->id),'icon'=>'fa fa-eye'),
			array('label'=>'Manage Admin','url'=>array('admin'),'icon'=>'fa fa-tasks'),
		)
	)	
);
?>

<?php $box = $this->beginWidget(
    'bootstrap.widgets.TbBox',
    array(
        'title' => 'Update Admins #'.$model->id,
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