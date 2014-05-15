<?php
/**
 * This is the template for generating the model class of a specified table.
 * - $this: the ModelCode object
 * - $tableName: the table name for this class (prefix is already removed if necessary)
 * - $modelClass: the model class name
 * - $columns: list of table columns (name=>CDbColumnSchema)
 * - $labels: list of attribute labels (name=>label)
 * - $rules: list of validation rules
 * - $relations: list of relations (name=>relation declaration)
 */
?>
<?php echo "<?php\n"; ?>

/**
 * This is the model class for table "<?php echo $tableName; ?>".
 *
 * The followings are the available columns in table '<?php echo $tableName; ?>':
<?php foreach($columns as $column): ?>
 * @property <?php echo $column->type.' $'.$column->name."\n"; ?>
<?php endforeach; ?>
<?php if(!empty($relations)): ?>
 *
 * The followings are the available model relations:
<?php foreach($relations as $name=>$relation): ?>
 * @property <?php
	if (preg_match("~^array\(self::([^,]+), '([^']+)', '([^']+)'\)$~", $relation, $matches))
    {
        $relationType = $matches[1];
        $relationModel = $matches[2];

        switch($relationType){
            case 'HAS_ONE':
                echo $relationModel.' $'.$name."\n";
            break;
            case 'BELONGS_TO':
                echo $relationModel.' $'.$name."\n";
            break;
            case 'HAS_MANY':
                echo $relationModel.'[] $'.$name."\n";
            break;
            case 'MANY_MANY':
                echo $relationModel.'[] $'.$name."\n";
            break;
            default:
                echo 'mixed $'.$name."\n";
        }
	}
    ?>
<?php endforeach; ?>
<?php endif; ?>
 */
class <?php echo $modelClass; ?> extends <?php echo $this->baseClass."\n"; ?>
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return '<?php echo $tableName; ?>';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
<?php foreach($rules as $rule): ?>
			<?php echo $rule.",\n"; ?>
<?php endforeach; ?>
			/*
			//Example username
			array('username', 'match', 'pattern' => '/^[A-Za-z0-9_]+$/u',
                 'message'=>'Username can contain only alphanumeric 
                             characters and hyphens(-).'),
          	array('username','unique'),
          	*/
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('<?php echo implode(', ', array_keys($columns)); ?>', 'safe', 'on'=>'search'),
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
<?php 
	//echo $this->tablePrefix;
	foreach($relations as $name=>$relation): ?>
			<?php  
			$a=explode("'", $relation);
			$b=explode("_", $a[3]);
			if ($b[0]=='ref'){
				if(strtolower(substr($name,0,3))=='ref'){
					$name=substr($name, 3, 100);
					echo "'".$name."' => "; 
				}
				else{
					echo "'$name' => "; 
				}

				if(strtolower(substr($a[1],0,3))=='ref'){
					$a[1]=substr($a[1], 3, 100);
					echo $a[0]."'".$a[1]."'".$a[2]."'".$a[3]."'".$a[4].",\n"; 
				}
				else{
					echo $relation.",\n"; 
				}
			}
			else if ($b[0]=='tbl'){
				if(strtolower(substr($name,0,3))=='tbl'){
					$name=substr($name, 3, 100);
					echo "'".$name."' => "; 
				}
				else{
					echo "'$name' => "; 
				}

				if(strtolower(substr($a[1],0,3))=='tbl'){
					$a[1]=substr($a[1], 3, 100);
					echo $a[0]."'".$a[1]."'".$a[2]."'".$a[3]."'".$a[4].",\n"; 
				}
				else{
					echo $relation.",\n"; 
				}
			}
			else if ($b[0]=='tb'){
				if(strtolower(substr($name,0,2))=='tb'){
					$name=substr($name, 2, 100);
					echo "'".$name."' => "; 
				}
				else{
					echo "'$name' => "; 
				}

				if(strtolower(substr($a[1],0,2))=='tb'){
					$a[1]=substr($a[1], 2, 100);
					echo $a[0]."'".$a[1]."'".$a[2]."'".$a[3]."'".$a[4].",\n"; 
				}
				else{
					echo $relation.",\n"; 
				}
			}
			else{
				echo "'$name' => $relation,\n"; 
			}
			?>
<?php endforeach; ?>
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
<?php foreach($labels as $name=>$label): ?>
			<?php 
			if(strtolower(substr($label, 0, 4))=='ref '){
				$label=substr($label, 4, 100);
			}
			else if(strtolower(substr($label, 0, 3))=='tb '){
				$label=substr($label, 3, 100);
			}
			else if(strtolower(substr($label, 0, 4))=='tbl '){
				$label=substr($label, 4, 100);
			}
			echo "'$name' => '$label',\n"; 
			?>
<?php endforeach; ?>
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

<?php
/* special field */
$password=false;
$password_field='';
/* check recommendate field exist */
$created=false;
$createdBy=false;
$modified=false;
$modifiedBy=false;
$deleted=false;
$deletedBy=false;
$status=false;

$date_field_arr=array();
foreach($columns as $name=>$column)
{
	if(in_array($name,array('password','pwd','pass','pasword','passwd'))){
		$password=true;
		$password_field=$name;
	}
	else if($column->type==='string')
	{
		echo "\t\t\$criteria->compare('$name',\$this->$name,true);\n";
	}
	else
	{
		echo "\t\t\$criteria->compare('$name',\$this->$name);\n";
	}
	
	if($name=='created') $created=true;
	if($name=='createdBy') $createdBy=true;
	if($name=='modified') $modified=true;
	if($name=='modifiedBy') $modifiedBy=true;
	if($name=='deleted') $deleted=true;
	if($name=='deletedBy') $deletedBy=true;
	if($name=='status') $status=true;

	if($column->dbType==='date'){
		$date_field_arr[]=$name;
	}
	
}
?>

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

<?php if($connectionId!='db'):?>
	/**
	 * @return CDbConnection the database connection used for this class
	 */
	public function getDbConnection()
	{
		return Yii::app()-><?php echo $connectionId ?>;
	}

<?php endif?>
	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return <?php echo $modelClass; ?> the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
	
	public function beforeSave() 
    {
        $userId=0;
		if(null!=Yii::app()->user->id) $userId=(int)Yii::app()->user->id;
		
		if($this->isNewRecord)
        {           
            <?php if($created) { ?> $this->created=new CDbExpression('NOW()'); <?php echo "\n"; } ?>
            <?php if($createdBy) { ?> $this->createdBy=$userId; <?php echo "\n"; } ?>
			<?php if($password) { ?>
			$this-><?php echo $password_field; ?> = $this->hashPassword($this-><?php echo $password_field; ?>);
			<?php echo "\n"; } ?>
			
        }else{
            <?php if($modified) { ?> $this->modified = new CDbExpression('NOW()'); <?php echo "\n"; } ?>
            <?php if($modifiedBy) { ?> $this->modifiedBy=$userId; <?php echo "\n"; } ?>
			<?php if($password) { ?>
			if(!empty($this-><?php echo $password_field; ?>)){
	        	$this-><?php echo $password_field; ?> = $this->hashPassword($this-><?php echo $password_field; ?>);
	    	}
			<?php echo "\n"; } ?>
			
        }

        <?php
        foreach ($date_field_arr as $fieldname) {
        	?>

        	// NOT SURE RUN PLEASE HELP ME -> 
        	//$from=DateTime::createFromFormat('d/m/Y',$this-><?php echo $fieldname; ?>);
        	//$this-><?php echo $fieldname; ?>=$from->format('Y-m-d');
        	<?php
        }
        ?>

        return parent::beforeSave();
    }

    public function beforeDelete () {
		$userId=0;
		if(null!=Yii::app()->user->id) $userId=(int)Yii::app()->user->id;
        <?php if($status) { ?> $this->status=0; <?php echo "\n"; } ?>
        <?php if($deletedBy) { ?> $this->deletedBy=$userId; <?php echo "\n"; } ?>
        <?php if($deleted) { ?> $this->deleted=new CDbExpression('NOW()'); <?php echo "\n"; } ?>
        <?php if($status or $deletedBy or $deleted) { ?> $this->save(); <?php echo "\n"; } ?>

        return false;
    }

    public function afterFind()    {
         <?php
        foreach ($date_field_arr as $fieldname) {
        	?>

        	// NOT SURE RUN PLEASE HELP ME -> 
        	//$from=DateTime::createFromFormat('Y-m-d',$this-><?php echo $fieldname; ?>);
        	//$this-><?php echo $fieldname; ?>=$from->format('d/m/Y');
        	<?php
        }
        ?>

        parent::afterFind();
    }
	
	<?php if($password) { ?>
	
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
	<?php echo "\n"; } ?>
	
	public function defaultScope()
    {
    	/*
    	//Example Scope
    	return array(
	        'condition'=>"deleted IS NULL ",
            'order'=>'create_time DESC',
            'limit'=>5,
        );
        */
        $scope=array();

        <?php if($deleted) { ?> 
        	$scope = array(
	            'condition'=>" deleted IS NULL ",
	        );
        <?php } ?>

        return $scope;
    }
}
