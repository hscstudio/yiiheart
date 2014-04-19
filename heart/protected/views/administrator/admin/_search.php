<?php $form=$this->beginWidget('bootstrap.widgets.TbActiveForm',array(
	'action'=>Yii::app()->createUrl($this->route),
	'method'=>'get',
)); ?>

			<?php echo  '';
			$dataEmployee = Employee::model()->findAll(array('order' => 'name'));
		    $listEmployee = CHtml::listData($dataEmployee,'id', 'name');
		    echo $form->select2Row($model, 'tb_employee_id', array(
			   'data' => $listEmployee,

			))
			; ?>

		<?php echo $form->textFieldRow($model,'username',array('class'=>'span5','maxlength'=>25)); ?>

			<?php echo $form->textFieldRow($model,'status',array('class'=>'span5')); ?>

							<div class="form-actions">
		<?php $this->widget('bootstrap.widgets.TbButton', array(
			'buttonType' => 'submit',
			'type'=>'primary',
			'label'=>'Search',
		)); ?>
	</div>

<?php $this->endWidget(); ?>
