<?php 
/*
$this->widget('zii.widgets.CMenu', array(
	'firstItemCssClass'=>'first',
	'lastItemCssClass'=>'last',
	'htmlOptions'=>array('class'=>'actions'),
	'items'=>array(
		array(
			'label'=>Rights::t('core', 'Assignments'),
			'url'=>array('assignment/view'),
			'itemOptions'=>array('class'=>'item-assignments'),
		),
		array(
			'label'=>Rights::t('core', 'Permissions'),
			'url'=>array('authItem/permissions'),
			'itemOptions'=>array('class'=>'item-permissions'),
		),
		array(
			'label'=>Rights::t('core', 'Roles'),
			'url'=>array('authItem/roles'),
			'itemOptions'=>array('class'=>'item-roles'),
		),
		array(
			'label'=>Rights::t('core', 'Tasks'),
			'url'=>array('authItem/tasks'),
			'itemOptions'=>array('class'=>'item-tasks'),
		),
		array(
			'label'=>Rights::t('core', 'Operations'),
			'url'=>array('authItem/operations'),
			'itemOptions'=>array('class'=>'item-operations'),
		),
	)
));	
*/
?>

<?php
$this->widget(
    'bootstrap.widgets.TbTabs',
    array(
        'type' => 'tabs', // 'tabs' or 'pills'
        'tabs' => array(
          	 array(
				'label'=>Rights::t('core', 'Assignments'),
				'url'=>array('assignment/view'),
				'active'=>(Yii::app()->controller->id=='assignment')?true:false,
			),
			array(
				'label'=>Rights::t('core', 'Permissions'),
				'url'=>array('authItem/permissions'),
				'active'=>(Yii::app()->controller->id=='authItem' and Yii::app()->controller->action->id=='permissions')?true:false,
			),
			array(
				'label'=>Rights::t('core', 'Roles'),
				'url'=>array('authItem/roles'),
				'active'=>(Yii::app()->controller->id=='authItem' and Yii::app()->controller->action->id=='roles')?true:false,
			),
			array(
				'label'=>Rights::t('core', 'Tasks'),
				'url'=>array('authItem/tasks'),
				'active'=>(Yii::app()->controller->id=='authItem' and Yii::app()->controller->action->id=='tasks')?true:false,
			),
			array(
				'label'=>Rights::t('core', 'Operations'),
				'url'=>array('authItem/operations'),
				'active'=>(Yii::app()->controller->id=='authItem' and Yii::app()->controller->action->id=='operations')?true:false,
			),
        ),
    )
);
?>