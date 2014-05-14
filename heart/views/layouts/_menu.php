<?php
$currController 	= Yii::app()->controller->id;
$currControllers	= explode('/', $currController);
$currAction			= Yii::app()->controller->action->id;
$currRoute 			= Yii::app()->controller->getRoute();
$currRoutes			= explode('/', $currRoute);

$menu=
	array(
		array('label'=>'Home', 'url'=>array('/site/index'), 'icon'=>'fa fa-home','active'=>($currController=='site' and $currAction=='index' )),
		array('label'=>'Admin', 'url'=>'#', 'icon'=>'fa fa-gear', 'visible'=>!Yii::app()->user->isGuest, 'active'=> false ,'items'=>array(
			array('label'=>'Generator Code', 'url'=>array('/gii/heart'), 'icon'=>'fa fa-refresh fa-fw', 'visible'=>!Yii::app()->user->isGuest),
			//'---',
			//array('label'=>'NAV HEADER'),
		)),
		array('label'=>'Pages', 'url'=>'#', 'icon'=>'fa fa-sitemap' , 'active'=>($currController=='site' and $currAction!='index') , 'items'=>array(
			array('label'=>'About', 'url'=>array('/site/page', 'view'=>'about'),'active'=>($currController=='site' and $currAction=='page' )),
			array('label'=>'Contact', 'url'=>array('/site/contact'),'active'=>($currController=='site' and $currAction=='contact' )),
			//'---',
			//array('label'=>'NAV HEADER'),
		)),
	);	
?>	