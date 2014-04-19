<?php $form=$this->beginWidget('bootstrap.widgets.TbActiveForm',array(
	'id'=>'training-form',
	'enableAjaxValidation'=>false,
	// 'htmlOptions'=>array('enctype'=>'multipart/form-data'),
)); ?>

<p class="help-block">Fields with <span class="required">*</span> are required.</p>

<?php echo $form->errorSummary($model); ?>

	<?php echo $form->textFieldRow($model,'name',array('class'=>'span5','maxlength'=>255)); ?>

	<?php echo $form->datepickerRow($model,'start',
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

	<?php echo $form->datepickerRow($model,'finish',
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

	<?php echo $form->textFieldRow($model,'note',array('class'=>'span5','maxlength'=>255)); ?>

	<?php echo $form->textFieldRow($model,'status',array('class'=>'span5')); ?>



<div class="form-actions">
	<?php $this->widget('bootstrap.widgets.TbButton', array(
			'buttonType'=>'submit',
			'type'=>'primary',
			'label'=>$model->isNewRecord ? 'Create' : 'Save',
		)); ?>
</div>

<?php $this->endWidget(); ?>
