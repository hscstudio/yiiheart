<?php

class SiteController extends Controller
{
	/**
	 * Declares class-based actions.
	 */
	public function actions()
	{
		return array(
			// captcha action renders the CAPTCHA image displayed on the contact page
			'captcha'=>array(
				'class'=>'CCaptchaAction',
				'backColor'=>0xFFFFFF,
			),
			// page action renders "static" pages stored under 'protected/views/site/pages'
			// They can be accessed via: index.php?r=site/page&view=FileName
			'page'=>array(
				'class'=>'CViewAction',
			),
		);
	}

	/**
	 * This is the default 'index' action that is invoked
	 * when an action is not explicitly requested by users.
	 */
	public function actionIndex()
	{
		// renders the view file 'protected/views/site/index.php'
		// using the default layout 'protected/views/layouts/main.php'
		$this->render('index');
	}

	/**
	 * This is the action to handle external exceptions.
	 */
	public function actionError()
	{
		if($error=Yii::app()->errorHandler->error)
		{
			if(Yii::app()->request->isAjaxRequest)
				echo $error['message'];
			else
				$this->render('error', $error);
		}
	}

	/**
	 * Displays the contact page
	 */
	public function actionContact()
	{
		$model=new ContactForm;
		if(isset($_POST['ContactForm']))
		{
			$model->attributes=$_POST['ContactForm'];
			if($model->validate())
			{
				$name='=?UTF-8?B?'.base64_encode($model->name).'?=';
				$subject='=?UTF-8?B?'.base64_encode($model->subject).'?=';
				$headers="From: $name <{$model->email}>\r\n".
					"Reply-To: {$model->email}\r\n".
					"MIME-Version: 1.0\r\n".
					"Content-Type: text/plain; charset=UTF-8";

				mail(Yii::app()->params['adminEmail'],$subject,$model->body,$headers);
				Yii::app()->user->setFlash('contact','Thank you for contacting us. We will respond to you as soon as possible.');
				$this->refresh();
			}
		}
		$this->render('contact',array('model'=>$model));
	}

	/**
	 * Displays the login page
	 */
	public function actionLogin()
	{
		if (!defined('CRYPT_BLOWFISH')||!CRYPT_BLOWFISH)
			throw new CHttpException(500,"This application requires that PHP was compiled with Blowfish support for crypt().");
		$model=new LoginForm;
		if (Yii::app()->user->getState('attempts-login') > 3) { //make the captcha required if the unsuccessful attemps are more of thee
            $model->scenario = 'withCaptcha';
        }

		// if it is ajax validation request
		if(isset($_POST['ajax']) && $_POST['ajax']==='login-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}

		// collect user input data
		if(isset($_POST['LoginForm']))
		{
			$model->attributes=$_POST['LoginForm'];
			// validate user input and redirect to the previous page if valid
			if($model->validate() && $model->login()){
				Yii::app()->user->setState('attempts-login', 0); //if login is successful, reset the attemps
				$this->redirect(Yii::app()->user->returnUrl);
			}
			else{
				Yii::app()->user->setState('attempts-login', Yii::app()->user->getState('attempts-login', 0) + 1);
				if (Yii::app()->user->getState('attempts-login') > 3) { 
                    $model->scenario = 'withCaptcha'; //useful only for view
                }
			}
		}
		// display the login form
		$this->render('login',array('model'=>$model));
	}

	/**
	 * Logs out the current user and redirect to homepage.
	 */
	public function actionLogout()
	{
		Yii::app()->user->logout();
		$this->redirect(Yii::app()->homeUrl);
	}

	public function actionAccount()
	{
		$model= Admin::model()->findByPk((int)Yii::app()->user->id);

		if(isset($_POST['Admin']))
		{
			$model->attributes=$_POST['Admin'];
			if($model->save()){
				//$this->redirect(array('view','id'=>$model->id));
			}
		}
		
		$this->render('account',array(
			'model'=>$model,
		));
	}

	public function actionProfile()
	{
		//$employee = Admin::model()->findByPk((int)Yii::app()->user->id);
		$model= Employee::model()->findByPk((int)Yii::app()->user->tb_employee_id);

		if(isset($_POST['Employee']))
		{
			$model->attributes=$_POST['Employee'];
			if($model->save()){
				//$this->redirect(array('view','id'=>$model->id));
				Yii::app()->user->setFlash('success', '<strong>Well done!</strong> You successfully update profile.');
			}
		}
		
		//$model= Employee::model()->findByPk((int)Yii::app()->user->employee_id);

		/*
		if(isset($_POST['Employee']))
		{
			$uploadFile=CUploadedFile::getInstance($model,'photo');
			if(!empty($uploadFile)) {
				$extUploadFile = substr($uploadFile, strrpos($uploadFile, '.')+1);
				$model->photo=Yii::app()->user->id.'.'.$extUploadFile;
			}		
			$model->attributes=$_POST['Employee'];
			if($model->save()){
				if(!empty($uploadFile)) {
					$extUploadFile = substr($uploadFile, strrpos($uploadFile, '.')+1);
					$uploadFile->saveAs(Yii::app()->basePath.'\..\files\employees\photos\\'.Yii::app()->user->id.'.'.$extUploadFile);//.$uploadFile);

				}
				
				Yii::app()->user->setFlash('success', '<strong>Well done!</strong> You successfully read this important alert message.');
				/*
				Yii::app()->user->setFlash('info', '<strong>Heads up!</strong> This alert needs your attention, but it\'s not super important.');
				Yii::app()->user->setFlash('warning', '<strong>Warning!</strong> Best check yo self, you\'re not looking too good.');
				Yii::app()->user->setFlash('error', '<strong>Oh snap!</strong> Change a few things up and try submitting again.');
				
				//$model2->attributes=$_POST['Administrator'];
				//$model2->save();
			}
			else{
				Yii::app()->user->setFlash('error', '<strong>Oh snap!</strong> Change a few things up and try submitting again.');
			}

			$this->render('profile',array(
				'model'=>$model,
			));
				
		}
		*/
		//else{
			$this->render('profile',array(
				'model'=>$model,
			));
		//}	
	}
}