<?php $form=$this->beginWidget('bootstrap.widgets.TbActiveForm',array(
	'action'=>Yii::app()->createUrl($this->route),
	'method'=>'get',
)); ?>

			<?php echo  '';
			$dataTraining = Training::model()->findAll(array('order' => 'name'));
		    $listTraining = CHtml::listData($dataTraining,'id', 'name');
		    echo $form->select2Row($model, 'tb_training_id', array(
			   'data' => $listTraining,

			))
			; ?>

		<?php echo $form->textFieldRow($model,'name',array('class'=>'span5','maxlength'=>255)); ?>

		<?php echo $form->fileFieldRow($model,'filename'); ?>

		<?php echo $form->textFieldRow($model,'description',array('class'=>'span5','maxlength'=>255)); ?>

		<?php echo $form->textFieldRow($model,'status',array('class'=>'span5')); ?>

							<div class="form-actions">
		<?php $this->widget('bootstrap.widgets.TbButton', array(
			'buttonType' => 'submit',
			'type'=>'primary',
			'label'=>'Search',
		)); ?>
	</div>

<?php $this->endWidget(); ?>
