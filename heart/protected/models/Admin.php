<?php

/**
 * This is the model class for table "tb_admin".
 *
 * The followings are the available columns in table 'tb_admin':
 * @property integer $id
 * @property integer $tb_employee_id
 * @property string $username
 * @property string $password
 * @property integer $status
 * @property string $created
 * @property integer $createdBy
 * @property string $modified
 * @property integer $modifiedBy
 * @property string $deleted
 * @property integer $deletedBy
 *
 * The followings are the available model relations:
 * @property Employee $tbEmployee
 */
class Admin extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'tb_admin';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('username, password', 'required'),
			array('tb_employee_id, status, createdBy, modifiedBy, deletedBy', 'numerical', 'integerOnly'=>true),
			array('username', 'length', 'max'=>25),
			array('password', 'length', 'max'=>100),
			array('created, modified, deleted', 'safe'),
			/*
			//Contoh username
			array('username', 'match', 'pattern' => '/^[A-Za-z0-9_]+$/u',
                 'message'=>'Username can contain only alphanumeric 
                             characters and hyphens(-).'),
          	array('username','unique'),
          	*/
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, tb_employee_id, username, password, status, created, createdBy, modified, modifiedBy, deleted, deletedBy', 'safe', 'on'=>'search'),
		);
	}

	/**
	 * @return array relational rules.
	 */
	public function relations()
	{
		// NOTE: you may need to adjust the relation name and the related
		// class name for the relations automatically generated below.
		return array(
			'Employee' => array(self::BELONGS_TO, 'Employee', 'tb_employee_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'tb_employee_id' => 'Employee',
			'username' => 'Username',
			'password' => 'Password',
			'status' => 'Status',
			'created' => 'Created',
			'createdBy' => 'Created By',
			'modified' => 'Modified',
			'modifiedBy' => 'Modified By',
			'deleted' => 'Deleted',
			'deletedBy' => 'Deleted By',
		);
	}

	/**
	 * Retrieves a list of models based on the current search/filter conditions.
	 *
	 * Typical usecase:
	 * - Initialize the model fields with values from filter form.
	 * - Execute this method to get CActiveDataProvider instance which will filter
	 * models according to data in model fields.
	 * - Pass data provider to CGridView, CListView or any similar widget.
	 *
	 * @return CActiveDataProvider the data provider that can return the models
	 * based on the search/filter conditions.
	 */
	public function search()
	{
		// @todo Please modify the following code to remove attributes that should not be searched.

		$criteria=new CDbCriteria;

		$criteria->compare('id',$this->id);
		$criteria->compare('tb_employee_id',$this->tb_employee_id);
		$criteria->compare('username',$this->username,true);
		$criteria->compare('password',$this->password,true);
		$criteria->compare('status',$this->status);
		$criteria->compare('created',$this->created,true);
		$criteria->compare('createdBy',$this->createdBy);
		$criteria->compare('modified',$this->modified,true);
		$criteria->compare('modifiedBy',$this->modifiedBy);
		$criteria->compare('deleted',$this->deleted,true);
		$criteria->compare('deletedBy',$this->deletedBy);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return Admin the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

	public function beforeSave() 
    {
        if($this->isNewRecord)
        {           
             $this->created=new CDbExpression('NOW()'); 
             $this->createdBy=Yii::app()->user->id; 
             $this->password = $this->hashPassword($this->password);
        }else{
             $this->modified = new CDbExpression('NOW()'); 
             $this->modifiedBy=Yii::app()->user->id; 
             if(!empty($this->password)){
	        	$this->password = $this->hashPassword($this->password);
	    	}
        }
        
        return parent::beforeSave();
    }

    public function beforeDelete () {
         $this->status=0; 
         $this->deletedBy=Yii::app()->user->id; 
         $this->deleted=new CDbExpression('NOW()'); 
         $this->save(); 
        return false;
    }

    public function defaultScope()
    {
    	/*
    	//Contoh Penggunaan Scope
    	return array(
	        'condition'=>"deleted IS NULL ",
            'order'=>'create_time DESC',
            'limit'=>5,
        );
        */
        $scope=array();

         
    	$scope = array(
            'condition'=>" deleted IS NULL ",
        );

        return $scope;
    }

    /**
	 * Checks if the given password is correct.
	 * @param string the password to be validated
	 * @return boolean whether the password is valid
	 */
	public function validatePassword($password)
	{
		return CPasswordHelper::verifyPassword($password,$this->password);
	}

	/**
	 * Generates the password hash.
	 * @param string password
	 * @return string hash
	 */
	public static function hashPassword($password)
	{
		return CPasswordHelper::hashPassword($password);
	}
}
