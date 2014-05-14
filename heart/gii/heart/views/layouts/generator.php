<?php
$assetsDir=Yii::getPathOfAlias('ext.heart.gii.heart.views.css');
$assets=Yii::app()->assetManager->publish($assetsDir);
$cs=Yii::app()->clientScript;
$cs->registerCssFile($assets.'/heart.css');
?>
<?php $this->beginContent('gii.views.layouts.main'); ?>
<?php
$currController 	= Yii::app()->controller->id;
$currControllers	= explode('/', $currController);
$currAction			= Yii::app()->controller->action->id;
$currRoute 			= Yii::app()->controller->getRoute();
$currRoutes			= explode('/', $currRoute);

$this->widget('bootstrap.widgets.TbNavbar', array(
	'type'=>null, // null or 'inverse'
	'brand'=>CHtml::encode('Heart Gii!'),
	'brandUrl'=>'#',
	'collapse'=>true, // requires bootstrap-responsive.css
	'items'=>array(
		array(
			'class'=>'bootstrap.widgets.TbMenu',
			'items'=>array(
					array('label'=>'Back To Website', 'url'=>Yii::app()->baseUrl, 'icon'=>'fa fa-home'),
					array('label'=>'Heart Gii', 'url'=>array('index'), 'icon'=>'fa fa-rocket','active'=>(@$currController=='heart')),
					
											
			),
		),
	),
));
?>

<div class="row-fluid">
	<div class="span2">
		<div id="sidebar">
		<?php $box = $this->beginWidget(
		    'bootstrap.widgets.TbBox',
		    array(
		        'title' => 'Generators',
		        'headerIcon' => 'icon- fa fa-list-alt'
		    )
		);?>
			
			<?php 
			$menu=array();
			$menu[]=array('label'=>'Heart','url'=>array('heart/index'),'icon'=>'fa fa-rocket','active'=>(@$currController=='heart'));
			$menu[]=array('label'=>'Model','url'=>array('model/index'),'icon'=>'fa fa-chevron-circle-right','active'=>(@$currController=='model'));
			$menu[]=array('label'=>'Crud','url'=>array('crud/index'),'icon'=>'fa fa-chevron-circle-right','active'=>(@$currController=='crud'));
			
			$this->widget(
				'bootstrap.widgets.TbTabs',
				array(
					'type' => 'pills',
					'stacked' => true,
					'tabs'=>$menu,
				)
			);
			?>
		<?php $this->endWidget(); ?>
		</div><!-- sidebar -->
	</div>
	<div class="span10">
		<div id="content">
		
			<?php echo $content; ?>
			
		</div><!-- content -->
	</div>
</div>
<?php $this->endContent(); ?>