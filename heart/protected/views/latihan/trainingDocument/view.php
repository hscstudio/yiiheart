<?php
$this->breadcrumbs=array(
	$pName=>Yii::app()->createUrl($pUrl), 
	'Training Documents'=>array('index'),
	$model->name,
);
$this->menuCaption='Sub Menu';


$menu2=array(
	array('label'=>'TrainingDocument','url'=>array('index'),'icon'=>'fa fa-list-alt', 'items' =>
		array(	
			array('label'=>'List TrainingDocument','url'=>array('index',"pId"=>$pId),'icon'=>'fa fa-list-ol'),	
			array('label'=>'Create TrainingDocument','url'=>array('create',"pId"=>$pId),'icon'=>'fa fa-plus-circle'),
			array('label'=>'Import TrainingDocument','url'=>array('import',"pId"=>$pId),'icon'=>'fa fa-download'),
			array('label'=>'Update TrainingDocument','url'=>array('update',"pId"=>$pId,'id'=>$model->id),'icon'=>'fa fa-pencil','active'=>true),
			array('label'=>'View TrainingDocument','url'=>array('view',"pId"=>$pId,'id'=>$model->id),'icon'=>'fa fa-eye'),
			array('label'=>'Manage TrainingDocument','url'=>array('admin',"pId"=>$pId),'icon'=>'fa fa-tasks'),
		)
	)	
);
?>

<?php $box = $this->beginWidget(
    'bootstrap.widgets.TbBox',
    array(
        'title' => 'View Training Documents #'.$model->id,
        'headerIcon' => 'icon- fa fa-eye',
        'headerButtons' => array(
            array(
                'class' => 'bootstrap.widgets.TbButtonGroup',
                'type' => 'success',
                // '', 'primary', 'info', 'success', 'warning', 'danger' or 'inverse'
                'buttons' => $menu2
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
		        //'header' => 'Training ',
		        'name'=> 'tb_training_id',
		        'type'=>'raw',
		        		        	'value' => (@$model->Training->name),
		        			    ),
			
		'name',
		'filename',
		'description',
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
