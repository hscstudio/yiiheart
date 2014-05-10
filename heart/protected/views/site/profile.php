<?php
$this->breadcrumbs=array(
	'Profile'=>array('site/profile'),
);

?>

<?php $box = $this->beginWidget(
    'bootstrap.widgets.TbBox',
    array(
    	'id' => 'box-profile',
        'title' => 'Profile',
        'headerIcon' => 'icon- fa fa-user',
    )
);?>

	<?php $form=$this->beginWidget('bootstrap.widgets.TbActiveForm',array(
		'id'=>'employee-form',
		'enableAjaxValidation'=>false,
		//'type' => 'horizontal',
		'htmlOptions'=>array('enctype'=>'multipart/form-data'),
	)); ?>

	<?php $this->widget('bootstrap.widgets.TbAlert', array(
        'block'=>false, // display a larger alert block?
        'fade'=>true, // use transitions?
        'closeText'=>'&times;', // close link text - if set to false, no close link is displayed
        'alerts'=>array( // configurations per alert type
            'success'=>array('block'=>true, 'fade'=>true, 'closeText'=>'&times;'), // success, info, warning, error or danger
        ),
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
		);
	?>

	<?php echo $form->toggleButtonRow($model,'gender', array('enabledLabel'=>'Pria', 'disabledLabel'=>'Wanita')); ?>

	<?php echo $form->textFieldRow($model,'phone',array('class'=>'span5','maxlength'=>50)); ?>

	<?php echo $form->textFieldRow($model,'email',array('class'=>'span5','maxlength'=>100)); ?>

	<?php echo $form->textFieldRow($model,'address',array('class'=>'span5','maxlength'=>255)); ?>

	<?php echo $form->fileFieldRow($model,'photo'); ?>

	

	<div class="form-actions">
		<?php $this->widget('bootstrap.widgets.TbButton', array(
				'buttonType'=>'submit',
				'type'=>'primary',
				'label'=>$model->isNewRecord ? 'Create' : 'Save',
			)); ?>
	</div>

	<?php $this->endWidget(); ?>

<?php $this->endWidget(); ?>