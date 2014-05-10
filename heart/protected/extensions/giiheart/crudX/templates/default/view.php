<?php
/**
 * The following variables are available in this template:
 * - $this: the BootCrudCode object
 */
?>
<?php
echo "<?php\n";
$nameColumn = $this->guessNameColumn($this->tableSchema->columns);
$label = $this->pluralize($this->class2name($this->modelClass));
echo "\$this->breadcrumbs=array(
	'$label'=>array('index'),
	\$model->{$nameColumn},
);\n";
?>

$this->menu=array(
	array('label'=>'<?php echo $this->modelClass; ?>','url'=>array('index'),'icon'=>'fa fa-list-alt', 'items' =>
		array(	
			array('label'=>'List <?php echo $this->modelClass; ?>','url'=>array('index'),'icon'=>'fa fa-list-ol'),	
			array('label'=>'Create <?php echo $this->modelClass; ?>','url'=>array('create'),'icon'=>'fa fa-plus-circle'),
			array('label'=>'Import <?php echo $this->modelClass; ?>','url'=>array('import'),'icon'=>'fa fa-download'),
			array('label'=>'Update <?php echo $this->modelClass; ?>','url'=>array('update','id'=>$model-><?php echo $this->tableSchema->primaryKey; ?>),'icon'=>'fa fa-pencil'),
			array('label'=>'View <?php echo $this->modelClass; ?>','url'=>array('view','id'=>$model-><?php echo $this->tableSchema->primaryKey; ?>),'icon'=>'fa fa-eye','active'=>true),
			array('label'=>'Manage <?php echo $this->modelClass; ?>','url'=>array('admin'),'icon'=>'fa fa-tasks'),
		)
	)	
);
?>

<?php
echo "<?php \$box = \$this->beginWidget(
    'bootstrap.widgets.TbBox',
    array(
        'title' => 'View ".$label. " #'.\$model->{$this->tableSchema->primaryKey}".",
        'headerIcon' => 'icon- fa fa-eye',
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
)); ?>"; ?>
		
<?php echo "<?php"; ?> $this->widget('bootstrap.widgets.TbDetailView',array(
	'data'=>$model,
	'attributes'=>array(
	<?php
	foreach ($this->tableSchema->columns as $column) {
		if(substr($column->name,0,4)=='ref_' or substr($column->name,0,3)=='tb_' or $column->dbType==='tinyint(1)'){
			echo "\t\t";
			$var = $column->name;
			$len= strlen($var);
			$start = strpos($var,'_');
			$end = strrpos($var,'_');
			$var = substr($var,$start+1,($end-$start-1));
			$vars = explode('_', $var);
			$header = "";
			$value="";
			foreach ($vars as $val) {
				$header.=ucfirst($val).' ';
				$value.=ucfirst($val);
			}
			?>
			array(
		        //'header' => '<?php echo $header; ?>',
		        'name'=> '<?php echo $column->name; ?>',
		        'type'=>'raw',
		        <?php
		        if($column->dbType==='tinyint(1)'){
		        	?>
		        	'value' => ($model-><?php echo $column->name; ?>)?"on":"off",
		        	<?php
		        } 
		        else{ ?>
		        	'value' => (@$model-><?php echo $value; ?>->name),
		        	<?php
		    	}
		        ?>
		    ),
			<?php
			echo "\n";
		}
		else if(in_array($column->name, array('createdBy','modifiedBy','deletedBy'))){
			echo "\t\t";
			?>
			array(
		        //'header' => '<?php echo $column->name; ?>',
		        'name'=> '<?php echo $column->name; ?>',
		        'type'=>'raw',
		        'value' => @Admin::model()->findByPk($model-><?php echo $column->name; ?>)->username,
		    ),
			<?php
			echo "\n";
		}		
		else
			echo "\t\t'" . $column->name . "',\n";
	}
	?>
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

<?php echo"<?php \$this->endWidget(); ?>"; ?>

