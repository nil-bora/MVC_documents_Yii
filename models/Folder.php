<?php

/**
 * This is the model class for table "Document".
 *
 * The followings are the available columns in table 'Document':
 *
 */
class Folder extends HActiveRecord
{
	const MIN_REQUIRED_ANSWERS = 2;
	
	public $name;
    
    const NAV_CLASS_TOPNAV = 'TopMenuWidget';
    const NAV_CLASS_ACCOUNTNAV = 'AccountMenuWidget';
    const TYPE_LINK = '1';
    const TYPE_HTML = '2';
    const TYPE_IFRAME = '3';
    const TYPE_MARKDOWN = '4';
    /**
     * Returns the static model of the specified AR class.
     * @param string $className active record class name.
     * @return Question the static model class
     */
    public static function model($className = __CLASS__)
    {
        return parent::model($className);
    }

    /**
     * @return string the associated database table name
     */
    public function tableName()
    {
         return 'document_folder';
    }
    
    public function rules()
    {
	     return array(
	    	array('name, created_at, created_by, updated_at, updated_by', 'required'),
	    	//array('name', 'NameUnique'),
	    	array('created_by, updated_by', 'numerical', 'integerOnly' => true),
        );

    }
    
    public function NameUnique()
    {
        $m = Folder::model()->findByAttributes(array('name'=>$this->name));
        echo "<pre>";
       // print_r($m);
         if(isset($m))
             $this->addError("Name", "User with this name already exist and is active."); 
    }
    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels()
    {
        return array(
            'name' => Yii::t('PollsModule.models_Poll', 'Answers'),
        );
    }
    
     /**
     * @return array relational rules.
     */
    

}
