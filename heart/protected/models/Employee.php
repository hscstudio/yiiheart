<?php

/**
 * This is the model class for table "tb_employee".
 *
 * The followings are the available columns in table 'tb_employee':
 * @property integer $id
 * @property integer $ref_religion_id
 * @property string $name
 * @property string $born
 * @property string $birthDay
 * @property integer $gender
 * @property string $phone
 * @property string $email
 * @property string $address
 * @property string $photo
 * @property integer $status
 * @property string $created
 * @property integer $createdBy
 * @property string $modified
 * @property integer $modifiedBy
 * @property string $deleted
 * @property integer $deletedBy
 *
 * The followings are the available model relations:
 * @property RefReligion $refReligion
 */
class Employee extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'tb_employee';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('name', 'required'),
			array('ref_religion_id, gender, status, createdBy, modifiedBy, deletedBy', 'numerical', 'integerOnly'=>true),
			array('name, born, phone', 'length', 'max'=>50),
			array('email', 'length', 'max'=>100),
			array('address, photo', 'length', 'max'=>255),
			array('birthDay, created, modified, deleted', 'safe'),
			/*
			//Contoh username
			array('username', 'match', 'pattern' => '/^[A-Za-z0-9_]+$/u',
                 'message'=>'Username can contain only alphanumeric 
                             characters and hyphens(-).'),
          	array('username','unique'),
          	*/
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, ref_religion_id, name, born, birthDay, gender, phone, email, address, photo, status, created, createdBy, modified, modifiedBy, deleted, deletedBy', 'safe', 'on'=>'search'),
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
			'Religion' => array(self::BELONGS_TO, 'Religion', 'ref_religion_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'ref_religion_id' => 'Religion',
			'name' => 'Name',
			'born' => 'Born',
			'birthDay' => 'Birth Day',
			'gender' => 'Gender',
			'phone' => 'Phone',
			'email' => 'Email',
			'address' => 'Address',
			'photo' => 'Photo',
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
		$criteria->compare('ref_religion_id',$this->ref_religion_id);
		$criteria->compare('name',$this->name,true);
		$criteria->compare('born',$this->born,true);
		$criteria->compare('birthDay',$this->birthDay,true);
		$criteria->compare('gender',$this->gender);
		$criteria->compare('phone',$this->phone,true);
		$criteria->compare('email',$this->email,true);
		$criteria->compare('address',$this->address,true);
		$criteria->compare('photo',$this->photo,true);
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
	 * @return Employee the static model class
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
        }else{
             $this->modified = new CDbExpression('NOW()'); 
             $this->modifiedBy=Yii::app()->user->id; 
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
}
