<?php $form=$this->beginWidget('bootstrap.widgets.TbActiveForm',array(
	'id'=>'admin-form',
	'enableAjaxValidation'=>false,
	// 'htmlOptions'=>array('enctype'=>'multipart/form-data'),
)); ?>

<p class="help-block">Fields with <span class="required">*</span> are required.</p>

<?php echo $form->errorSummary($model); ?>

	<?php echo  '';
			$dataEmployee = Employee::model()->findAll(array('order' => 'name'));
		    $listEmployee = CHtml::listData($dataEmployee,'id', 'name');
		    echo $form->select2Row($model, 'tb_employee_id', array(
			   'data' => $listEmployee,

			))
			; ?>

	<?php echo $form->textFieldRow($model,'username',array('class'=>'span5','maxlength'=>25)); ?>

	<?php echo $form->passwordFieldRow($model,'password',array('class'=>'span5','maxlength'=>100)); ?>

	<?php echo $form->toggleButtonRow($model,'status', array('enabledLabel'=>'Active', 'disabledLabel'=>'Inactive')); ?>

<div class="form-actions">
	<?php $this->widget('bootstrap.widgets.TbButton', array(
			'buttonType'=>'submit',
			'type'=>'primary',
			'label'=>$model->isNewRecord ? 'Create' : 'Save',
		)); ?>
</div>

<?php $this->endWidget(); ?>
