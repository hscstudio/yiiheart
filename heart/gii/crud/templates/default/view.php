<?php
/**
 * The following variables are available in this template:
 * - $this: the CrudCode object
 */
?>
<?php echo "<?php\n"; ?>
/* @var $this <?php echo $this->getControllerClass(); ?> */
/* @var $model <?php echo $this->getModelClass(); ?> */

<?php
$nameColumn=$this->guessNameColumn($this->tableSchema->columns);
$label=$this->pluralize($this->class2name($this->modelClass));
echo "\$this->breadcrumbs=array(
	'$label'=>array('index'),
	\$model->{$nameColumn},
);\n";
?>

$menu=array();
require(dirname(__FILE__).DIRECTORY_SEPARATOR.'_menu.php');
<?php if($this->modelType=="2"){ ?>

$this->menu=array(
	array('label'=>'View <?php echo $this->modelClass; ?>','url'=>array('view','id'=>$model->id),'icon'=>'fa fa-eye','active'=>true),
	// Add child model
	array('label'=>'Child Model 1','url'=>Yii::app()->createUrl("'Child Model 1", array("pId"=>$model->id)),'icon'=>'fa fa-list-alt'),
	array('label'=>'Child Model 2','url'=>Yii::app()->createUrl("'Child Model 2", array("pId"=>$model->id)),'icon'=>'fa fa-list-alt'),
	array('label'=>'Child Model 3','url'=>Yii::app()->createUrl("'Child Model 3", array("pId"=>$model->id)),'icon'=>'fa fa-list-alt'),
	
);
<?php } ?>

<?php if($this->modelType=="3"){ ?>

$this->menu=array(
	array('label'=>'View <?php echo $this->modelClass; ?>','url'=>array('view','id'=>$model->id),'icon'=>'fa fa-eye','active'=>true),
	// Add child model
	array('label'=>'Child Model 1','url'=>Yii::app()->createUrl("'Child Model 1", array("pId"=>$model->id)),'icon'=>'fa fa-list-alt'),
	array('label'=>'Child Model 2','url'=>Yii::app()->createUrl("'Child Model 2", array("pId"=>$model->id)),'icon'=>'fa fa-list-alt'),
	array('label'=>'Child Model 3','url'=>Yii::app()->createUrl("'Child Model 3", array("pId"=>$model->id)),'icon'=>'fa fa-list-alt'),
	
);
<?php } ?>

$menu2=array(
	array('label'=>'<?php echo $this->modelClass; ?>','url'=>array('index'),'icon'=>'fa fa-list-alt', 'items' => $menu)	
);

if(!isset($_GET['asModal'])){
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
                'buttons' => \$menu2
            ),
        ) 
    )
);?>";
?>

<?php echo "<?php\n"; ?>
}
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
		));
		?>"; ?>
		
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
		        if($column->dbType==='tinyint(1)' and ($column->name=='gender' or $column->name=='sex')){
		        	?>

		        	'value' => ($model-><?php echo $column->name; ?>)?"male":"female",
		        	<?php
		        }
		        else if($column->dbType==='tinyint(1)'){
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
		        //'value' => @Admin::model()->findByPk($model-><?php echo $column->name; ?>)->username,
		    ),
			<?php
			echo "\n";
		}
		else if($column->dbType==='date'){		
			echo "\t\t";
			?>

			array(
		        'name'=> '<?php echo $column->name; ?>',
		        'type'=>'raw',
		        'value' => date("l, d M Y",strtotime($model-><?php echo $column->name; ?>)),
		    ),
			<?php
			echo "\n";
		}
		else if($column->dbType==='datetime'){		
			echo "\t\t";
			?>
			
			array(
		        'name'=> '<?php echo $column->name; ?>',
		        'type'=>'raw',
		        'value' => date("d M Y H:i:s",strtotime($model-><?php echo $column->name; ?>)),
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

<?php echo "<?php\n"; ?>
if(!isset($_GET['asModal'])){
	<?php echo "\$this->endWidget();"; ?>
}
?>