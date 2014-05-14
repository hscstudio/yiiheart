<?php

Yii::import('gii.generators.model.ModelGenerator');

class HeartGenerator extends ModelGenerator
{
	//public $codeModel='gii.generators.model.ModelCode';
	public $codeModel = 'ext.heart.gii.Heart.HeartCode';
}