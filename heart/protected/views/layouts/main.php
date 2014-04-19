<?php /* @var $this Controller */ ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<meta name="language" content="en" />

	<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/main.css" />

	<title><?php echo CHtml::encode($this->pageTitle); ?></title>
</head>
<body>

	<?php
	$currController 	= Yii::app()->controller->id;
	$currControllers	= explode('/', $currController);
	$currAction			= Yii::app()->controller->action->id;
	$currRoute 			= Yii::app()->controller->getRoute();
	$currRoutes			= explode('/', $currRoute);

	$this->widget('bootstrap.widgets.TbNavbar', array(
		'type'=>null, // null or 'inverse'
		'brand'=>CHtml::encode(Yii::app()->name),
		'brandUrl'=>'#',
		'collapse'=>true, // requires bootstrap-responsive.css
		'items'=>array(
			array(
				'class'=>'bootstrap.widgets.TbMenu',
				'items'=>array(
						array('label'=>'HOME', 'url'=>array('/site/index'), 'icon'=>'fa fa-home','active'=>($currRoute=='site/index')),
						array('label'=>'ADMIN', 'url'=>'#', 'icon'=>'fa fa-sitemap', 'visible'=>Yii::app()->user->checkAccess('rights'), 'active'=>($currControllers[0]=='administrator' or $currRoutes[0]=='rights') ,'items'=>array(
							array('label'=>'Generator Code', 'url'=>array('/gii'), 'icon'=>'fa fa-gear', 'visible'=>Yii::app()->user->checkAccess('rights')),
							array('label'=>'Manage Access', 'url'=>array('/rights'), 'icon'=>'fa fa-lock', 'visible'=>Yii::app()->user->checkAccess('rights')),
							array('label'=>'Manage Admin', 'url'=>array('/administrator/admin'), 'icon'=>'fa fa-users', 'visible'=>Yii::app()->user->checkAccess('rights')),
							array('label'=>'Manage Employee', 'url'=>array('/administrator/employee'), 'icon'=>'fa fa-users', 'visible'=>Yii::app()->user->checkAccess('rights')),
							//'---',
							//array('label'=>'NAV HEADER'),
						)),
						array('label'=>'LATIHAN', 'url'=>'#', 'icon'=>'fa fa-sitemap', 'visible'=>!Yii::app()->user->isGuest, 'active'=>($currRoutes[0]=='latihan') ,'items'=>array(
							array('label'=>'Manage Training', 'url'=>array('/latihan/training'), 'icon'=>'fa fa-', 'visible'=>!Yii::app()->user->isGuest),
						)),	
												
				),
			),
			'<form class="navbar-search pull-left" action="">
				<input type="text" class="search-query span2" placeholder="Search" id="main-search">
			</form>',
			array(
				'class'=>'bootstrap.widgets.TbMenu',
				'htmlOptions'=>array('class'=>'pull-right'),
				'items'=>array(
					array('label'=>'Login', 'url'=>array('/site/login'), 'icon'=>'fa fa-unlock', 'visible'=>Yii::app()->user->isGuest),
					//'---',
					array('label'=>'', 'url'=>'#', 'icon'=>'fa fa-user', 'visible'=>!Yii::app()->user->isGuest, 'items'=>array(
						array('label'=>'Account', 'url'=>array('/site/account'), 'icon'=>'fa fa-key','visible'=>!Yii::app()->user->isGuest),
						array('label'=>'Profile', 'url'=>array('/site/profile'), 'icon'=>'fa fa-user','visible'=>!Yii::app()->user->isGuest),
						'---',
						array('label'=>'Logout ('.Yii::app()->user->name.')', 'url'=>array('/site/logout'), 'icon'=>'fa fa-power-off',),
		
					)),
				),
			),
		),
	));
	?>


<div class="container" id="page">

	<?php 
	if(isset($this->breadcrumbs)){
		$this->widget('bootstrap.widgets.TbBreadcrumbs', array(
		    'links'=>$this->breadcrumbs,
		));
	}	
	?>

	<?php echo $content; ?>

	<div class="clearfix"></div>

</div><!-- page -->

<?php
$this->widget('bootstrap.widgets.TbNavbar', array(
	'brand' => '<small>Copyright &copy; 2014 by Hafid Mukhlasin. All Rights Reserved</small>',
	'fixed' => 'bottom',
	'type' => 'inverse',
));
?>

</body>
</html>
