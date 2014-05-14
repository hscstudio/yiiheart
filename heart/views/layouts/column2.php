<?php /* @var $this Controller */ ?>
<?php $this->beginContent('//layouts/main'); ?>
<div class="row-fluid">
	<div class="span3">
		<div id="sidebar">
		<?php $box = $this->beginWidget(
		    'bootstrap.widgets.TbBox',
		    array(
		        'title' => $this->menuCaption,
		        'headerIcon' => 'icon- fa fa-list-alt'
		    )
		);?>

		<?php
			$this->widget(
				'bootstrap.widgets.TbTabs',
				array(
					'type' => 'pills',
	        		'stacked' => true,
					'tabs'=>$this->menu,
				)
			);
		?>

		<?php $this->endWidget(); ?>
		</div><!-- sidebar -->
	</div>

	<div class="span9">
		<div id="content">
			<?php echo $content; ?>
		</div><!-- content -->
	</div>
	
</div>
<?php $this->endContent(); ?>