<?php $form=$this->beginWidget('bootstrap.widgets.TbActiveForm',array(
	'action'=>Yii::app()->createUrl($this->route),
	'method'=>'get',
)); ?>

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
			'buttonType' => 'submit',
			'type'=>'primary',
			'label'=>'Search',
		)); ?>
	</div>

<?php $this->endWidget(); ?>
