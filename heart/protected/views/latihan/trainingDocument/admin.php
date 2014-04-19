<?php
$this->breadcrumbs=array(
	$pName=>Yii::app()->createUrl($pUrl), 
	'Training Documents'=>array('index'),
	'Manage',
);

$this->menuCaption='Sub Menu';

$this->menu=array(
	array('label'=>'View '.$pName,'url'=>array($pUrl.'/view','id'=>$pId),'icon'=>'fa fa-eye'),
	array('label'=>'TrainingDocument','url'=>array("index","pId"=>$pId),'icon'=>'fa fa-list-alt','active'=>true),
);

$menu2=array(
	array('label'=>'TrainingDocument','url'=>array('index',"pId"=>$pId),'icon'=>'fa fa-list-alt', 'items' =>
		array(	
			array('label'=>'List TrainingDocument','url'=>array('index',"pId"=>$pId),'icon'=>'fa fa-list-ol','active'=>true),	
			array('label'=>'Create TrainingDocument','url'=>array('create',"pId"=>$pId),'icon'=>'fa fa-plus-circle'),
			array('label'=>'Import TrainingDocument','url'=>array('import',"pId"=>$pId),'icon'=>'fa fa-download'),
			array('label'=>'Manage TrainingDocument','url'=>array('admin',"pId"=>$pId),'icon'=>'fa fa-tasks'),
		)
	)	
);

Yii::app()->clientScript->registerScript('search', "
	$('.search-button').click(function(){
		$('.search-form').toggle();
		return false;
	});
	$('.search-form form').submit(function(){
		$.fn.yiiGridView.update('training-document-grid', {
			data: $(this).serialize()
		});
		return false;
	});
");
?>

<?php $box = $this->beginWidget(
    'bootstrap.widgets.TbBox',
    array(
        'title' => 'Manage Training Documents',
        'headerIcon' => 'icon- fa fa-tasks',
        'headerButtons' => array(
            array(
                'class' => 'bootstrap.widgets.TbButtonGroup',
                'type' => 'success',
                // '', 'primary', 'info', 'success', 'warning', 'danger' or 'inverse'
                'buttons' => $menu2
            ),
        ) 
    )
);?>		<?php $this->widget('bootstrap.widgets.TbAlert', array(
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
<p>
	You may optionally enter a comparison operator (<b>&lt;</b>, <b>&lt;=</b>, <b>&gt;</b>, <b>&gt;=</b>, <b>
		&lt;&gt;</b>
	or <b>=</b>) at the beginning of each of your search values to specify how the comparison should be done.
</p>

<?php echo CHtml::link('Advanced Search','#',array('class'=>'search-button btn')); ?>
<div class="search-form" style="display:none">
	<?php $this->renderPartial('_search',array(
	'model'=>$model,
)); ?>
</div><!-- search-form -->

<?php echo CHtml::beginForm(array('export')); ?>
<?php $this->widget('bootstrap.widgets.TbGridView',array(
	'id'=>'training-document-grid',
	'dataProvider'=>$model->search(),
	'filter'=>$model,
	'type' => 'striped hover', //bordered condensed
	'columns'=>array(
		array('header'=>'No','value'=>'($this->grid->dataProvider->pagination->currentPage*
					 $this->grid->dataProvider->pagination->pageSize
					)+
					array_search($data,$this->grid->dataProvider->getData())+1',
				'htmlOptions' => array('style' =>'width: 60px'),
		),
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
		/*
		//Contoh
		array(
	        'header' => 'Level',
	        'name'=> 'ref_level_id',
	        'type'=>'raw',
	        'value' => '($data->Level->name)',
	        // 'value' => '($data->status)?"on":"off"',
	    ),
	    */
	    array(
			'class'=>'bootstrap.widgets.TbButtonColumn',
			'template'=>'{view} {update} {delete}',
			'buttons'=>array(
				'view' => array
                (
                    'label'=>'Detail',
                    'url'=>'array("view","id"=>"$data->id","pId"=>'.$pId.')', 
                ),
                'update' => array
                (
                    'label'=>'Update',
                    'url'=>'array("update","id"=>"$data->id","pId"=>'.$pId.')',
                ),
                'delete' => array
                (
                    'label'=>'Delete',
                    'url'=>'array("#")',
                    'linkOptions'=>'array("submit"=>array("delete","id"=>"$data->id","pId"=>'.$pId.'))', 
                    'confirm'=>'Are you sure you want to delete this item?',
                )
			),
		),
	),
)); ?>

<select name="fileType" style="width:150px;">
	<option value="Excel5">EXCEL 5 (xls)</option>
	<option value="Excel2007">EXCEL 2007 (xlsx)</option>
	<option value="HTML">HTML</option>
</select>
<br>

<?php 
$this->widget('bootstrap.widgets.TbButton', array(
	'buttonType'=>'submit', 'icon'=>'fa fa-print','label'=>'Export', 'type'=> 'primary'));
?>
<?php echo CHtml::endForm(); ?>
<?php $this->endWidget(); ?>