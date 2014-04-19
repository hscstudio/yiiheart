<?php $form=$this->beginWidget('bootstrap.widgets.TbActiveForm',array(
	'id'=>'employee-form',
	'enableAjaxValidation'=>false,
	// 'htmlOptions'=>array('enctype'=>'multipart/form-data'),
)); ?>

<p class="help-block">Fields with <span class="required">*</span> are required.</p>

<?php echo $form->errorSummary($model); ?>

	<?php echo  '';
			$dataReligion = Religion::model()->findAll(array('order' => 'name'));
		    $listReligion = CHtml::listData($dataReligion,'id', 'name');
		    echo $form->select2Row($model, 'ref_religion_id', array(
			   'data' => $listReligion,

			))
			; ?>

	<?php echo $form->textFieldRow($model,'name',array('class'=>'span5','maxlength'=>50)); ?>

	<?php echo $form->textFieldRow($model,'born',array('class'=>'span5','maxlength'=>50)); ?>

	<?php echo $form->datepickerRow($model,'birthDay',
								array(
					                'options' => array(
					                    'language' => 'id',
					                    'format' => 'yyyy/mm/dd' , 'weekStart'=> 1
					                ), 
					            ),
					            array(
					                'prepend' => '<i class="icon-calendar"></i>'
					            )
			);; ?>

	<?php echo $form->toggleButtonRow($model,'gender'); ?>

	<?php echo $form->textFieldRow($model,'phone',array('class'=>'span5','maxlength'=>50)); ?>

	<?php echo $form->textFieldRow($model,'email',array('class'=>'span5','maxlength'=>100)); ?>

	<?php echo $form->textFieldRow($model,'address',array('class'=>'span5','maxlength'=>255)); ?>

	<?php echo $form->fileFieldRow($model,'photo'); ?>

	<?php echo $form->textFieldRow($model,'status',array('class'=>'span5')); ?>



<div class="form-actions">
	<?php $this->widget('bootstrap.widgets.TbButton', array(
			'buttonType'=>'submit',
			'type'=>'primary',
			'label'=>$model->isNewRecord ? 'Create' : 'Save',
		)); ?>
</div>

<?php $this->endWidget(); ?>
