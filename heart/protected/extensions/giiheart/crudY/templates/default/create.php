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
	'$label'=>array('index'),
	'Create',
);\n";
?>

$this->menu=array(
    array('label'=>'<?php echo $this->modelClass; ?>','url'=>array('index'),'icon'=>'fa fa-list-alt', 'items' =>
        array(  
            array('label'=>'List <?php echo $this->modelClass; ?>','url'=>array('index'),'icon'=>'fa fa-list-ol'),  
            array('label'=>'Create <?php echo $this->modelClass; ?>','url'=>array('create'),'icon'=>'fa fa-plus-circle','active'=>true),
            array('label'=>'Import <?php echo $this->modelClass; ?>','url'=>array('import'),'icon'=>'fa fa-download'),
            array('label'=>'Manage <?php echo $this->modelClass; ?>','url'=>array('admin'),'icon'=>'fa fa-tasks'),
        )
    )   
);
?>

<?php
echo "<?php \$box = \$this->beginWidget(
    'bootstrap.widgets.TbBox',
    array(
        'title' => 'Create ".$label."' ,
        'headerIcon' => 'icon- fa fa-plus-circle',
        'headerButtons' => array(
        	array(
            	'class' => 'bootstrap.widgets.TbButtonGroup',
            	'type' => 'success',
            	// '', 'primary', 'info', 'success', 'warning', 'danger' or 'inverse'
            	'buttons' => \$this->menu
            )
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
		));
		?>"; ?>
		
<?php echo "<?php echo \$this->renderPartial('_form', array('model'=>\$model)); ?>"; ?>

<?php echo"<?php \$this->endWidget(); ?>"; ?>