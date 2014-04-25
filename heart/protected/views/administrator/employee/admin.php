<?php
$this->breadcrumbs=array(
	'Employees'=>array('index'),
	'Manage',
);

$this->menu=array(
	array('label'=>'Employee','url'=>array('index'),'icon'=>'fa fa-list-alt', 'items' =>
		array(	
			array('label'=>'List Employee','url'=>array('index'),'icon'=>'fa fa-list-ol'),	
			array('label'=>'Create Employee','url'=>array('create'),'icon'=>'fa fa-plus-circle'),
			array('label'=>'Import Employee','url'=>array('import'),'icon'=>'fa fa-download'),
			array('label'=>'Manage Employee','url'=>array('admin'),'icon'=>'fa fa-tasks','active'=>true),
		)
	)	
);

Yii::app()->clientScript->registerScript('search', "
	$('.search-button').click(function(){
		$('.search-form').toggle();
		return false;
	});
	$('.search-form form').submit(function(){
		$.fn.yiiGridView.update('employee-grid', {
			data: $(this).serialize()
		});
		return false;
	});
");
?>

<?php $box = $this->beginWidget(
    'bootstrap.widgets.TbBox',
    array(
        'title' => 'Manage Employees',
        'headerIcon' => 'icon- fa fa-tasks',
        'headerButtons' => array(
            array(
                'class' => 'bootstrap.widgets.TbButtonGroup',
                'type' => 'success',
                // '', 'primary', 'info', 'success', 'warning', 'danger' or 'inverse'
                'buttons' => $this->menu
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
	'id'=>'employee-grid',
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
		//'ref_religion_id',
			array(
		        'header' => 'Name',
		        'name'=> 'name',
		        'type'=>'raw',
		        'value' => '($data->name)',
		        'class' => 'bootstrap.widgets.TbEditableColumn',
	            'headerHtmlOptions' => array('style' => 'width:80px'),
				'editable' => array(
					'type'    => 'text',
					'url'     => $this->createUrl('editable'),
					'params' => array('YII_CSRF_TOKEN' => Yii::app()->request->csrfToken),
				)
		    ),
			
			array(
		        'header' => 'Born',
		        'name'=> 'born',
		        'type'=>'raw',
		        'value' => '($data->born)',
		        'class' => 'bootstrap.widgets.TbEditableColumn',
	            'headerHtmlOptions' => array('style' => 'width:80px'),
				'editable' => array(
					'type'    => 'text',
					'url'     => $this->createUrl('editable'),
					'params' => array('YII_CSRF_TOKEN' => Yii::app()->request->csrfToken),
				)
		    ),
			
			array(
		        'header' => 'BirthDay',
		        'name'=> 'birthDay',
		        'type'=>'raw',
		        'value' => '($data->birthDay)',
		        'class' => 'bootstrap.widgets.TbEditableColumn',
	            'headerHtmlOptions' => array('style' => 'width:80px'),
				'editable' => array(
					'type'          => 'date',
                  	'viewformat'    => 'yyyy-mm-dd',
					'url'     => $this->createUrl('editable'),
					'placement'     => 'right',
					'params' => array('YII_CSRF_TOKEN' => Yii::app()->request->csrfToken),
				)
		    ),
			
			array(
		        'header' => 'Gender',
		        'name'=> 'gender',
		        'type'=>'raw',
		        'value' => '($data->gender)?"on":"off"',
		        'class' => 'bootstrap.widgets.TbEditableColumn',
	            'headerHtmlOptions' => array('style' => 'width:80px'),
				'editable' => array(
					'type'    => 'select',
					'url'     => $this->createUrl('editable'),
					'source'  => array(0 => 'Off', 1 => 'On'),
					'params' => array('YII_CSRF_TOKEN' => Yii::app()->request->csrfToken),
				)
		    ),
			
			array(
		        'header' => 'Phone',
		        'name'=> 'phone',
		        'type'=>'raw',
		        'value' => '($data->phone)',
		        'class' => 'bootstrap.widgets.TbEditableColumn',
	            'headerHtmlOptions' => array('style' => 'width:80px'),
				'editable' => array(
					'type'    => 'text',
					'url'     => $this->createUrl('editable'),
					'params' => array('YII_CSRF_TOKEN' => Yii::app()->request->csrfToken),
				)
		    ),
			
			array(
		        'header' => 'Email',
		        'name'=> 'email',
		        'type'=>'raw',
		        'value' => '($data->email)',
		        'class' => 'bootstrap.widgets.TbEditableColumn',
	            'headerHtmlOptions' => array('style' => 'width:80px'),
				'editable' => array(
					'type'    => 'text',
					'url'     => $this->createUrl('editable'),
					'params' => array('YII_CSRF_TOKEN' => Yii::app()->request->csrfToken),
				)
		    ),
		    array(
		        'header' => 'Status',
		        'name'=> 'status',
		        'type'=>'raw',
		        'value' => '($data->status)',
		        'class' => 'bootstrap.widgets.TbToggleColumn',
			'headerHtmlOptions' => array('style' => 'width:80px'),
			'toggleAction' => 'administrator/employee/toggle',
		    ),
			
/*
			array(
		        'header' => 'Address',
		        'name'=> 'address',
		        'type'=>'raw',
		        'value' => '($data->address)',
		        'class' => 'bootstrap.widgets.TbEditableColumn',
	            'headerHtmlOptions' => array('style' => 'width:80px'),
				'editable' => array(
					'type'    => 'text',
					'url'     => $this->createUrl('editable'),
					'params' => array('YII_CSRF_TOKEN' => Yii::app()->request->csrfToken),
				)
		    ),
			
*/
/*
			array(
		        'header' => 'Photo',
		        'name'=> 'photo',
		        'type'=>'raw',
		        'value' => '($data->photo)',
		        'class' => 'bootstrap.widgets.TbEditableColumn',
	            'headerHtmlOptions' => array('style' => 'width:80px'),
				'editable' => array(
					'type'    => 'text',
					'url'     => $this->createUrl('editable'),
					'params' => array('YII_CSRF_TOKEN' => Yii::app()->request->csrfToken),
				)
		    ),
			
*/

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
