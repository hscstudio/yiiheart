<?php
$this->breadcrumbs=array(
	'Employees'=>array('index'),
	$model->name,
);

$this->menu=array(
	array('label'=>'Employee','url'=>array('index'),'icon'=>'fa fa-list-alt', 'items' =>
		array(	
			array('label'=>'List Employee','url'=>array('index'),'icon'=>'fa fa-list-ol'),	
			array('label'=>'Create Employee','url'=>array('create'),'icon'=>'fa fa-plus-circle'),
			array('label'=>'Import Employee','url'=>array('import'),'icon'=>'fa fa-download'),
			array('label'=>'Update Employee','url'=>array('update','id'=>$model->id),'icon'=>'fa fa-pencil'),
			array('label'=>'View Employee','url'=>array('view','id'=>$model->id),'icon'=>'fa fa-eye','active'=>true),
			array('label'=>'Manage Employee','url'=>array('admin'),'icon'=>'fa fa-tasks'),
		)
	)	
);
?>

<?php $box = $this->beginWidget(
    'bootstrap.widgets.TbBox',
    array(
        'title' => 'View Employees #'.$model->id,
        'headerIcon' => 'icon- fa fa-eye',
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
		?>		
<?php $this->widget('bootstrap.widgets.TbDetailView',array(
	'data'=>$model,
	'attributes'=>array(
			'id',
					array(
		        //'header' => 'Religion ',
		        'name'=> 'ref_religion_id',
		        'type'=>'raw',
		        		        	'value' => ($model->Religion->name),
		        			    ),
			
		'name',
		'born',
		'birthDay',
					array(
		        //'header' => 'Ende ',
		        'name'=> 'gender',
		        'type'=>'raw',
		        		        	'value' => ($model->gender)?"on":"off",
		        			    ),
			
		'phone',
		'email',
		'address',
		'photo',
		'status',
		'created',
					array(
		        //'header' => 'createdBy',
		        'name'=> 'createdBy',
		        'type'=>'raw',
		        'value' => @Admin::model()->findByPk($model->createdBy)->username,
		    ),
			
		'modified',
					array(
		        //'header' => 'modifiedBy',
		        'name'=> 'modifiedBy',
		        'type'=>'raw',
		        'value' => @Admin::model()->findByPk($model->modifiedBy)->username,
		    ),
			
		'deleted',
					array(
		        //'header' => 'deletedBy',
		        'name'=> 'deletedBy',
		        'type'=>'raw',
		        'value' => @Admin::model()->findByPk($model->deletedBy)->username,
		    ),
			
		/*
		//CONTOH
		array(
	        'header' => 'Level',
	        'name'=> 'ref_level_id',
	        'type'=>'raw',
	        'value' => ($model->Level->name),
	        // 'value' => ($model->status)?"on":"off",
	        // 'value' => @Admin::model()->findByPk($model->createdBy)->username,
	    ),

	    */
	),
)); ?>

<?php $this->endWidget(); ?>
