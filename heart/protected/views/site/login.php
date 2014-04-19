<?php
/* @var $this SiteController */
/* @var $model LoginForm */
/* @var $form CActiveForm  */

$this->pageTitle=Yii::app()->name . ' - Login';
$this->breadcrumbs=array(
	'Login',
);

//echo CPasswordHelper::hashPassword('123456');
?>

<?php $box = $this->beginWidget(
    'bootstrap.widgets.TbBox',
    array(
        'title' => 'Login',
        'headerIcon' => 'icon- fa fa-unlock'
    )
);?>

	<p>Please fill out the following form with your login credentials:</p>

	<div class="form">
	<p class="note">Fields with <span class="required">*</span> are required.</p>
	<?php
	$form = $this->beginWidget(
	    'bootstrap.widgets.TbActiveForm',
	    array(
	        'id'=>'login-form',
	        'htmlOptions' => array('class' => 'well2'), // for inset effect
	    )
	);
	 
	echo $form->textFieldRow($model, 'username', array('class' => 'span3'));
	echo $form->passwordFieldRow($model, 'password', array('class' => 'span3'));
	?>
	<?php if ($model->scenario == 'withCaptcha' && CCaptcha::checkRequirements()): ?>
        <div class="control-group">
            <?php echo $form->labelEx($model, 'verifyCode'); ?>
            <div>
                <?php $this->widget('CCaptcha'); ?><br>
                <?php echo $form->textField($model, 'verifyCode'); ?>
            </div>
            <?php echo $form->error($model, 'verifyCode'); ?>
        </div>
    <?php endif; ?>
    <?php
	echo $form->checkboxRow($model, 'rememberMe');
	$this->widget(
	    'bootstrap.widgets.TbButton',
	    array('buttonType' => 'submit', 'label' => 'Login')
	);
	 
	$this->endWidget();
	unset($form);
	?>

	<?php 
	/*
	$form=$this->beginWidget('CActiveForm', array(
		'id'=>'login-form',
		'enableClientValidation'=>true,
		'clientOptions'=>array(
			'validateOnSubmit'=>true,
		),
	)); 
	*/
	?>

	
<?php $this->endWidget(); ?>

</div><!-- form -->
