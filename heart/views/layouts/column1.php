<?php /* @var $this Controller */ ?>
<?php $this->beginContent('//layouts/main'); ?>
<div id="content">
	<?php 
	$currController 	= Yii::app()->controller->id;
	$currAction			= Yii::app()->controller->action->id;
	if($currController=='site'){
		$box = $this->beginWidget(
		    'bootstrap.widgets.TbBox',
		    array(
		        'title' => ($currAction=='page')?'About Us':(($currAction=='contact')?'Contact Us':'Home'),
		        'headerIcon' => 'icon- fa fa-home'
		    )
		);
	}
	?>
	
	<?php echo $content; ?>

	<?php
	if($currController=='site'){
		$this->endWidget();
	}
	?>
</div><!-- content -->
<?php $this->endContent(); ?>