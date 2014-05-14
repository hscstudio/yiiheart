<?php
/**
 * The following variables are available in this template:
 * - $this: the CrudCode object
 */
?>
<?php echo "<?php\n"; ?>
/* @var $this <?php echo $this->getControllerClass(); ?> */
/* @var $dataProvider CActiveDataProvider */

<?php
$label=$this->pluralize($this->class2name($this->modelClass));
echo "\$this->breadcrumbs=array(
	'$label',
);\n";
?>

$menu=array();
require(dirname(__FILE__).DIRECTORY_SEPARATOR.'_menu.php');
$this->menu=array(
	array('label'=>'<?php echo $this->modelClass; ?>','url'=>array('index'),'icon'=>'fa fa-list-alt', 'items' => $menu)	
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

Yii::app()->clientScript->registerScript('refreshGridView', "
	// automatically refresh grid on 5 seconds
	//setInterval(\"$.fn.yiiGridView.update('<?php echo $this->class2id($this->modelClass); ?>-grid')\",5000);
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
$name="";
$name2="";
foreach ($this->tableSchema->columns as $column) {
	if(in_array($column->name, array('name','title'))){
		if(empty($name)) $name=$column->name;
	}

	if($column->name=='id'){
		echo "\t\t" . 
			"array(".
				"'header'=>'No',".
				"'value'=>'(\$this->grid->dataProvider->pagination->currentPage*
					 \$this->grid->dataProvider->pagination->pageSize
					)+
					array_search(\$data,\$this->grid->dataProvider->getData())+1',
				'htmlOptions' => array('style' =>'width: 25px; text-align:center;'),\n" .
			"\t\t),\n";
	}
	else if(substr($column->name,0,4)=='ref_' or substr($column->name,0,3)=='tb_' or ($count>5) or in_array($column->name, array('created','createdBy','modified','modifiedBy','deleted','deletedBy'))){
		echo "\t\t//'" . $column->name . "',\n";
	}
	else if (preg_match('/^(password|pass|passwd|passcode)$/i', $column->name)) {
		echo "\t\t//'" . $column->name . "',\n";	
	}
	else if($column->dbType=='tinyint(1)'){
		?>
		array(
	        'header' => '<?php echo ucfirst($column->name); ?>',
	        'name'=> '<?php echo $column->name; ?>',
	        'type'=>'raw',
	        'value' => '($data-><?php echo $column->name; ?>)?"on":"off"',
	        'headerHtmlOptions' => array('style' => 'width:25px;text-align:center'),
	    ),
		<?php
		echo "\n";
		++$count;
	}
	else if($column->dbType=='date'){
		?>
		array(
	        'header' => '<?php echo ucfirst($column->name); ?>',
	        'name'=> '<?php echo $column->name; ?>',
	        'type'=>'raw',
	        'value' => '(date("d-M-Y",strtotime($data-><?php echo $column->name; ?>)))',
	        'headerHtmlOptions' => array('style' => 'width:100px;text-align:center;'),
	    ),
		<?php
		echo "\n";
		++$count;
	}
	else{
		?>
		array(
	        'name'=> '<?php echo $column->name; ?>',
	        'value' => '($data-><?php echo $column->name; ?>)',
	        'headerHtmlOptions' => array('style' => 'text-align:center;'),
	    ),
		<?php
		echo "\n";
		if(empty($name2)) $name2=$column->name;
		++$count;
	}
		
}

if(empty($name)) $name=$name2;
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
			'template'=>'{view}<?php if($this->modelType=="2"){ ?> {detail}<?php } ?>',
			'buttons'=>array
            (
                'view' => array
                (    
                	'url' => '$data-><?php echo $this->tableSchema->primaryKey; ?>."|".$data-><?php if(!empty($name)) echo $name; else echo  $this->tableSchema->primaryKey; ?>',              
                	'click' => 'function(){
                		data=$(this).attr("href").split("|")
                		$("#myModalHeader").html(data[1]);
	        			$("#myModalBody").load("'.$this->createUrl('view').'&id="+data[0]+"&asModal=true");
                		$("#myModal").modal();
                		return false;
                	}',
                ),
                <?php if($this->modelType=="2"){ ?>
                'detail' => array
                (
                    'label'=>'View data under this data',
                    'icon'=>'fa fa-level-down',
                    'url'=>'array("view","id"=>$data-><?php echo $this->tableSchema->primaryKey; ?>)',
                    'options'=>array(
                        'class'=>'badge badge-info',
                    ),
                ),
                <?php } ?>
            )
		),
	),
)); ?>

<select name="fileType" style="width:150px;">
	<option value="Excel5">EXCEL 5 (xls)</option>
	<option value="Excel2007">EXCEL 2007 (xlsx)</option>
	<option value="HTML">HTML</option>
	<option value="PDF">PDF</option>
	<option value="WORD">WORD (docx)</option>
</select>
<br>

<?php echo"<?php 
\$this->widget('bootstrap.widgets.TbButton', array(
	'buttonType'=>'submit', 'icon'=>'fa fa-print','label'=>'Export', 'type'=> 'primary'));
?>"; ?>

<?php echo "<?php echo CHtml::endForm(); ?>"; ?>

<?php echo"<?php \$this->endWidget(); ?>"; ?>

<?php echo "<?php"; ?>  $this->beginWidget(
    'bootstrap.widgets.TbModal',
    array('id' => 'myModal')
); ?>
 
    <div class="modal-header">
        <a class="close" data-dismiss="modal">&times;</a>
        <h4 id="myModalHeader">Modal header</h4>
    </div>
 
    <div class="modal-body" id="myModalBody">
        <p>One fine body...</p>
    </div>
 
    <div class="modal-footer">
        <?php echo "<?php"; ?>  $this->widget(
            'bootstrap.widgets.TbButton',
            array(
                'label' => 'Close',
                'url' => '#',
                'htmlOptions' => array('data-dismiss' => 'modal'),
            )
        ); ?>
    </div>
 
<?php echo "<?php"; ?>  $this->endWidget(); ?>
