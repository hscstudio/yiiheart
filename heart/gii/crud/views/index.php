<?php
$this->layout="ext.heart.gii.heart.views.layouts.generator";
$class=get_class($model);
Yii::app()->clientScript->registerScript('gii.crud',"
$('#{$class}_controller').change(function(){
	$(this).data('changed',$(this).val()!='');
});
$('#{$class}_model').bind('keyup change', function(){
	var controller=$('#{$class}_controller');
	if(!controller.data('changed')) {
		var id=new String($(this).val().match(/\\w*$/));
		if(id.length>0)
			id=id.substring(0,1).toLowerCase()+id.substring(1);
		controller.val(id);
	}
});

$('#{$class}_controllerParent').change(function(){
	$(this).data('changed',$(this).val()!='');
});
$('#{$class}_modelParent').bind('keyup change', function(){
	var controller=$('#{$class}_controllerParent');
	if(!controller.data('changed')) {
		var id=new String($(this).val().match(/\\w*$/));
		if(id.length>0)
			id=id.substring(0,1).toLowerCase()+id.substring(1);
		controller.val(id);
	}
});

$('#{$class}_file').bind('keyup change', function(){
	var model=$('#{$class}_model');
	var controller=$('#{$class}_controller');
	model.val('batch');
	controller.val('batch')
	$('form#yw1').attr('enctype','multipart/form-data');
	$('.row').hide();
	$('.show').show();
	$('input[name=\"preview\"]').val('Generate');
});

$('#{$class}_modelType').bind('keyup change', function(){
	var modelType=$('#{$class}_modelType');
	if(modelType.val()=='3'){
		$('.childOnly').show();
		$('#{$class}_modelParent').val('')
		$('#{$class}_controllerParent').val('')
	}
	else{
		$('.childOnly').hide();	
		$('#{$class}_modelParent').val('ok')
		$('#{$class}_controllerParent').val('ok')
	}
});

$('.childOnly').hide();
");

if(@$_POST['CrudCode']['modelType']==3)
Yii::app()->clientScript->registerScript('gii.crud2',"$('.childOnly').show();");
else{
	Yii::app()->clientScript->registerScript('gii.crud2',"
		$('#{$class}_modelParent').val('ok')
		$('#{$class}_controllerParent').val('ok')
	");	
}

?>
<?php $box = $this->beginWidget(
	'bootstrap.widgets.TbBox',
	array(
		'title' => 'Heart Crud Generator',
		'headerIcon' => 'icon- fa fa-rocket'
	)
);?>

<p>This generator generates a controller and views that implement CRUD operations for the specified data model.</p>

<?php $form=$this->beginWidget('CCodeForm', array('model'=>$model)); ?>

<?php $collapse = $this->beginWidget('bootstrap.widgets.TbCollapse'); ?>
    <div class="accordion-group">
        <div class="accordion-heading">
            <a class="accordion-toggle" data-toggle="collapse"
               data-parent="#accordion2" href="#collapseOne">
                Normal Generator
            </a>
        </div>
        <div id="collapseOne" class="accordion-body collapse in">
            <div class="accordion-inner">
                <div class="row">
					<?php echo $form->labelEx($model,'modelType'); ?>
					<?php echo $form->dropDownList($model,'modelType',
								array('1'=>'Normal','2'=>'Parent','3'=>'Child')
						  ); ?>
					<div class="tooltip">
						Type to different CRUD style
					</div>
					<?php echo $form->error($model,'modelType'); ?>
				</div>
				
				<div class="row childOnly">
					<?php echo $form->labelEx($model, 'modelParent'); ?>
					<?php $form->widget(
						'zii.widgets.jui.CJuiAutoComplete',
						array(
							'model' => $model,
							'attribute' => 'modelParent',
							'source' => $this->getModels(),
							'options' => array(
								'delay' => 100,
								'focus' => 'js:function(event,ui){
										$(this).val($(ui.item).val());
										$(this).trigger(\'change\');
									}',
							),
							'htmlOptions' => array(
								'size' => '65',
							),
						)
						);
					?>
					<div class="tooltip">
						Parent Model class is case-sensitive. It can be either a class name (e.g. <code>Post</code>)
						or the path alias of the class file (e.g. <code>application.models.Post</code>).
						Note that if the former, the class must be auto-loadable.
					</div>
					<?php echo $form->error($model, 'modelParent'); ?>
				</div>

				<div class="row childOnly">
					<?php echo $form->labelEx($model, 'controllerParent'); ?>
					<?php echo $form->textField($model, 'controllerParent', array('size' => 65)); ?>
					<div class="tooltip">
						Parent Controller ID is case-sensitive. CRUD controllers are often named after
						the model class name that they are dealing with. Below are some examples:
						<ul>
							<li><code>post</code> generates <code>PostController.php</code></li>
							<li><code>postTag</code> generates <code>PostTagController.php</code></li>
							<li><code>admin/user</code> generates <code>admin/UserController.php</code>.
								If the application has an <code>admin</code> module enabled,
								it will generate <code>UserController</code> (and other CRUD code)
								within the module instead.
							</li>
						</ul>
					</div>
					<?php echo $form->error($model, 'controllerParent'); ?>
				</div>
				
				<div class="row">
					<?php echo $form->labelEx($model,'model'); ?>
					<?php echo $form->textField($model,'model',
							array(
								'size'=>65,
							)
						  ); ?>
					<div class="tooltip">
						Model class is case-sensitive. It can be either a class name (e.g. <code>Post</code>)
						or the path alias of the class file (e.g. <code>application.models.Post</code>).
						Note that if the former, the class must be auto-loadable.
					</div>
					<?php echo $form->error($model,'model'); ?>
				</div>
				<div class="row">
					<?php echo $form->labelEx($model,'controller'); ?>
					<?php echo $form->textField($model,'controller',array('size'=>65)); ?>
					<div class="tooltip">
						Controller ID is case-sensitive. CRUD controllers are often named after
						the model class name that they are dealing with. Below are some examples:
						<ul>
							<li><code>post</code> generates <code>PostController.php</code></li>
							<li><code>postTag</code> generates <code>PostTagController.php</code></li>
							<li><code>admin/user</code> generates <code>admin/UserController.php</code>.
								If the application has an <code>admin</code> module enabled,
								it will generate <code>UserController</code> (and other CRUD code)
								within the module instead.
							</li>
						</ul>
					</div>
					<?php echo $form->error($model,'controller'); ?>
				</div>
            </div>
        </div>
    </div>
    <div class="accordion-group">
        <div class="accordion-heading">
            <a class="accordion-toggle" data-toggle="collapse"
               data-parent="#accordion2" href="#collapseTwo">
                Batch Generator (Experimental)
            </a>
        </div>
        <div id="collapseTwo" class="accordion-body collapse">
            <div class="accordion-inner">
				<div class="row show">
					download template generator: 
					<a href='<?php echo $this->createUrl('template'); ?>'>[xlsx]</a>
					<a href='<?php echo $this->createUrl('template2'); ?>' title='Dont use this!'>[docx]</a>
					<?php echo $form->labelEx($model,'file'); ?>
					<?php echo $form->fileField($model,'file'); ?>
					<div class="tooltip">
					Warning : This code will generate directly not prepare.. be carefully
					</div>
					<?php echo $form->error($model,'file'); ?>
				</div>
            </div>
        </div>
    </div>
<?php $this->endWidget(); ?>


	

	<div class="row sticky">
		<?php echo $form->labelEx($model,'baseControllerClass'); ?>
		<?php echo $form->textField($model,'baseControllerClass',array('size'=>65)); ?>
		<div class="tooltip">
			This is the class that the new CRUD controller class will extend from.
			Please make sure the class exists and can be autoloaded.
		</div>
		<?php echo $form->error($model,'baseControllerClass'); ?>
	</div>

<?php $this->endWidget(); ?>
<?php $this->endWidget(); ?>