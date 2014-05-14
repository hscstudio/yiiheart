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
    'Calendar',
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
		$.fn.yiiGridView.update('training-grid', {
			data: $(this).serialize()
		});
		return false;
	});
");
?>

<?php echo "<?php"; ?>  $box = $this->beginWidget(
    'bootstrap.widgets.TbBox',
    array(
        'title' => 'Calendar' ,
        'headerIcon' => 'icon- fa fa-calendar',
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

<?php echo "<?php"; ?>  $this->widget('ext.heart.calendar.EHeartCalendar', array(
	//'themeCssFile'=>'cupertino/jquery-ui.min.css',
	'options'=>array(
		'header'=>array(
			'left'=>'prev,next,today',
			'center'=>'title',
			'right'=>'month,basicWeek,basicDay',//agendaWeek,agendaDay',
		),
		'events'=>$this->createUrl('calendarEvents'),
		'eventClick'=> 'js:function(calEvent, jsEvent, view) {
	        $("#myModalHeader").html(calEvent.title);
	        $("#myModalBody").load("'.$this->createUrl('view').'&id="+calEvent.id+"&asModal=true");
	        $("#myModal").modal();
	    }',
	)));
?>

<?php echo "<?php"; ?>  $this->endWidget(); ?>

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