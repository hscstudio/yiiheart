<?php
$this->breadcrumbs=array(
	'Account'=>array('site/account'),
);

?>

<?php $box = $this->beginWidget(
    'bootstrap.widgets.TbBox',
    array(
    	'id' => 'box-account',
        'title' => 'Account',
        'headerIcon' => 'icon- fa fa-key',
        'headerButtons'=>	array(
	        	array(
	          		'class' => 'bootstrap.widgets.TbButton',
	          		'icon' => 'fa fa-key',
	           		'label' => '',
	           		'htmlOptions' => array(
	           			'onclick' => 'alert("OK")',
	   				),
	           		//'size' => '...',
	         	),
	 		)
    )
);?>

	<?php $form=$this->beginWidget('bootstrap.widgets.TbActiveForm',array(
		'id'=>'admin-form',
		'enableAjaxValidation'=>false,
		'type' => 'horizontal',
	)); ?>

	<p class="help-block">Fields with <span class="required">*</span> are required.</p>

	<?php echo $form->errorSummary($model); ?>

		

		<?php echo $form->textFieldRow($model,'tb_employee_id',array('value'=> $model->Employee->name ,'disabled' => true)); ?>

		<?php echo $form->textFieldRow($model,'username',array('class'=>'','maxlength'=>25)); ?>

		<?php echo $form->passwordFieldRow($model,'password',array('value'=>'','class'=>'','maxlength'=>100)); ?>

		<?php echo $form->textFieldRow($model,'status',array('value'=> ($model->status)?'on':'off' ,'disabled' => true)); ?>

	<div class="form-actions">
		<?php $this->widget('bootstrap.widgets.TbButton', array(
				'buttonType'=>'submit',
				'type'=>'primary',
				'label'=>$model->isNewRecord ? 'Create' : 'Save',
			)); ?>
	</div>

	<?php $this->endWidget(); ?>

<?php $this->endWidget(); ?>