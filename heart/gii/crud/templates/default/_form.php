<?php
/**
 * The following variables are available in this template:
 * - $this: the BootCrudCode object
 */
?>
<?php echo "<?php \$form=\$this->beginWidget('bootstrap.widgets.TbActiveForm',array(
	'id'=>'" . $this->class2id($this->modelClass) . "-form',
	// Please note: When you enable ajax validation, make sure the corresponding
	// controller action is handling ajax validation correctly.
	// There is a call to performAjaxValidation() commented in generated controller code.
	// See class documentation of CActiveForm for details on this.
	'enableAjaxValidation'=>false,
	// 'htmlOptions'=>array('enctype'=>'multipart/form-data'),
)); ?>\n"; ?>

	<p class="note">Fields with <span class="required">*</span> are required.</p>

	<?php echo "<?php echo \$form->errorSummary(\$model); ?>\n"; ?>

<?php
foreach($this->tableSchema->columns as $column)
{
	if($column->autoIncrement)
		continue;
	if (in_array($column->name, 
		array('created','createdBy','modified','modifiedBy', 'deleted', 'deletedBy'))) 
		continue;
	echo "<?php echo " . $this->generateActiveRow($this->modelClass, $column) . "; ?>\n"; 
}
?>

<?php
/*
CONTOH LAIN
<?php echo $form->toggleButtonRow($model, 'gender', array('enabledLabel'=>'Pria','disabledLabel'=>'Wanita', 'width'=>120)); ?>
<?php echo $form->textAreaRow($model,'address',array('rows'=>3)); ?>
<?php echo $form->fileFieldRow($model,'photo'); ?>
<?php echo $form->textFieldRow($model,'status',array('value'=> ($model->status)?'on':'off' ,'disabled' => true)); ?>
<?php echo $form->dropDownListRow($model,'ref_sta_unit_id',StaUnit::lists($model->ref_sta_unit_id),
				            array(
				                'prompt'=>'- Pilih -',
				                'ajax'=>array(
				                    'type'=>'POST',
				                    'url'=>CController::createUrl('/site/staUnit'),
				                    'update'=>'#Employee_ref_sta_unit_id',                                            
				                ),
				            ));
				    ?>
<?php
$listGroup = array(0=>'ADMIN',1=>'GENERAL',2=>'PLANNING',3=>'EXECUTION',4=>'EVALUATION');
echo $form->select2Row($model, 'group', array(
   'data' => $listGroup,'options' => array(),
));
?>  
*/
?>

<div class="form-actions">
	<?php echo "<?php \$this->widget('bootstrap.widgets.TbButton', array(
			'buttonType'=>'submit',
			'type'=>'primary',
			'label'=>\$model->isNewRecord ? 'Create' : 'Save',
		)); ?>\n"; ?>
</div>

<?php echo "<?php \$this->endWidget(); ?>\n"; ?>