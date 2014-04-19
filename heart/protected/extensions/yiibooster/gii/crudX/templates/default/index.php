<?php
/**
 * The following variables are available in this template:
 * - $this: the BootCrudCode object
 */
?>
<?php
echo "<?php\n";
$label = $this->pluralize($this->class2name($this->modelClass));
echo "\$this->breadcrumbs=array(
	'$label',
);\n";
?>

$this->menu=array(
	array('label'=>'<?php echo $this->modelClass; ?>','url'=>array('index'),'icon'=>'fa fa-list-alt', 'items' =>
		array(	
			array('label'=>'List <?php echo $this->modelClass; ?>','url'=>array('index'),'icon'=>'fa fa-list-ol','active'=>true),	
			array('label'=>'Create <?php echo $this->modelClass; ?>','url'=>array('create'),'icon'=>'fa fa-plus-circle'),
			array('label'=>'Import <?php echo $this->modelClass; ?>','url'=>array('import'),'icon'=>'fa fa-download'),
			array('label'=>'Manage <?php echo $this->modelClass; ?>','url'=>array('admin'),'icon'=>'fa fa-tasks'),
		)
	)	
);

Yii::app()->clientScript->registerScript('search', "
	$('.search-button').click(function(){
		$('.search-form').toggle();
		return false;
	});
	$('.search-form form').submit(function(){
		$.fn.yiiGridView.update('<?php echo $this->class2id($this->modelClass); ?>-grid', {
			data: $(this).serialize()
		});
		return false;
	});
");
?>

<?php
echo "<?php \$box = \$this->beginWidget(
    'bootstrap.widgets.TbBox',
    array(
        'title' => 'List ".$label."' ,
        'headerIcon' => 'icon- fa fa-list-ol',
        'headerButtons' => array(
            array(
                'class' => 'bootstrap.widgets.TbButtonGroup',
                'type' => 'success',
                // '', 'primary', 'info', 'success', 'warning', 'danger' or 'inverse'
                'buttons' => \$this->menu
            ),
        ) 
    )
);?>";
?>

<?php echo "<?php"; ?> /** $this->widget('bootstrap.widgets.TbListView',array(
'dataProvider'=>$dataProvider,
'itemView'=>'_view',
)); **/ ?>
		<?php echo"<?php \$this->widget('bootstrap.widgets.TbAlert', array(
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
		?>"; ?>
<p>
	You may optionally enter a comparison operator (<b>&lt;</b>, <b>&lt;=</b>, <b>&gt;</b>, <b>&gt;=</b>, <b>
		&lt;&gt;</b>
	or <b>=</b>) at the beginning of each of your search values to specify how the comparison should be done.
</p>

<?php echo "<?php echo CHtml::link('Advanced Search','#',array('class'=>'search-button btn')); ?>"; ?>

<div class="search-form" style="display:none">
	<?php echo "<?php \$this->renderPartial('_search',array(
	'model'=>\$model,
)); ?>\n"; ?>
</div><!-- search-form -->

<?php echo "<?php echo CHtml::beginForm(array('export')); ?>"; ?>

<?php echo "<?php"; ?> $this->widget('bootstrap.widgets.TbGridView',array(
	'id'=>'<?php echo $this->class2id($this->modelClass); ?>-grid',
	'dataProvider'=>$model->search(),
	'filter'=>$model,
	'type' => 'striped hover', //bordered condensed
	'columns'=>array(
<?php
$count = 0;
foreach ($this->tableSchema->columns as $column) {
	if($column->name=='id'){
		echo "\t\t" . 
			"array(".
				"'header'=>'No',".
				"'value'=>'(\$this->grid->dataProvider->pagination->currentPage*
					 \$this->grid->dataProvider->pagination->pageSize
					)+
					array_search(\$data,\$this->grid->dataProvider->getData())+1',
				'htmlOptions' => array('style' =>'width: 60px'),\n" .
			"\t\t),\n";
	}
	else if(substr($column->name,0,4)=='ref_' or substr($column->name,0,3)=='tb_' or ($count>5) or in_array($column->name, array('created','createdBy','modified','modifiedBy','deleted','deletedBy'))){
		echo "\t\t//'" . $column->name . "',\n";
	}
	else if($column->dbType=='tinyint(1)'){
		?>
		array(
	        'header' => '<?php echo ucfirst($column->name); ?>',
	        'name'=> '<?php echo $column->name; ?>',
	        'type'=>'raw',
	        'value' => '($data-><?php echo $column->name; ?>)?"on":"off"',
	    ),
		<?php
		echo "\n";
		++$count;
	}
	else{
		echo "\t\t'" . $column->name . "',\n";
		++$count;
	}
		
}
?>

		/*
		//Contoh
		array(
	        'header' => 'Level',
	        'name'=> 'ref_level_id',
	        'type'=>'raw',
	        'value' => '($data->Level->name)',
	        // 'value' => '($data->status)?"on":"off"',
	        // 'value' => '@Admin::model()->findByPk($data->createdBy)->username',
	    ),
	    */
		array(
			'class'=>'bootstrap.widgets.TbButtonColumn',
			'template'=>'{view}',
		),
	),
)); ?>

<select name="fileType" style="width:150px;">
	<option value="Excel5">EXCEL 5 (xls)</option>
	<option value="Excel2007">EXCEL 2007 (xlsx)</option>
	<option value="HTML">HTML</option>
</select>
<br>

<?php echo"<?php 
\$this->widget('bootstrap.widgets.TbButton', array(
	'buttonType'=>'submit', 'icon'=>'fa fa-print','label'=>'Export', 'type'=> 'primary'));
?>"; ?>

<?php echo "<?php echo CHtml::endForm(); ?>"; ?>

<?php echo"<?php \$this->endWidget(); ?>"; ?>