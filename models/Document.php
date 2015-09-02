<?php

/**
 * This is the model class for table "Document".
 *
 * The followings are the available columns in table 'Document':
 *
 */
class Document extends HActiveRecordContent
{
	const MIN_REQUIRED_ANSWERS = 2;
	
	public $name;
	public $body;
	public $folder_id;
	public $answersText;
	public $autoAddToWall = true;
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
        return 'document';
    }
    
    public function rules()
    {
	    return array(
	    	
	    	array('name, body, folder_id, created_at, created_by, updated_at, updated_by', 'required'),
            array('created_by, updated_by', 'numerical', 'integerOnly' => true),
            array('folder_id', 'numerical', 'integerOnly' => true, 'min'=>1),
            array('body', 'length', 'max' => 600),
            /*
            array('name, body, created_at, created_by, updated_at, updated_by', 'required'),
            array('folder', 'default'),
            array('name', 'validateAnswersText'),
            
            array('body', 'length', 'max' => 600),
            */
           
        );
    }
    
    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels()
    {
        return array(
            'name' => Yii::t('DocumentsModule.models_Document', 'Name'),
            'body' => Yii::t('DocumentsModule.models_Document', 'Body'),
            'folder_id' => Yii::t('DocumentsModule.models_Document', 'Select folder'),
        );
    }
    
     /**
     * @return array relational rules.
     */
    public function relations()
    {
        return array(
            'folder' => array(self::BELONGS_TO, 'Folder', 'folder_id'),
        );
    }
    
    public function afterSave()
    {
	    parent::afterSave();
	     if ($this->isNewRecord) {
			$activity = Activity::CreateForContent($this);
			$activity->type = "DocumentCreated";
			$activity->module = "documents";
			$activity->save();
			$activity->fire();
	     }
	    return true;
    }
    
    /**
     * Returns the Wall Output
     */
    public function getWallOut()
    {
        return Yii::app()->getController()->widget('application.modules.documents.widgets.DocumentsWallEntryWidget', array('document' => $this), true);
    }
    
         /**
     * Returns a title/text which identifies this IContent.
     *
     * e.g. Post: foo bar 123...
     *
     * @return String
     */
    public function getContentTitle()
    {
        return Yii::t('PollsModule.models_Poll', "Question") . " \"" . Helpers::truncateText($this->body, 25) . "\"";
    }
    
    public function validateAnswersText()
    {

        $answers = explode("\n", $this->answersText);
        $answerCount = 0;
        $answerTextNew = "";

        foreach ($answers as $answer) {
            if (trim($answer) != "") {
                $answerCount++;
                $answerTextNew .= $answer . "\n";
            }
        }

        if ($answerCount < self::MIN_REQUIRED_ANSWERS) {
            $this->addError('answersText', Yii::t('PollsModule.models_Poll', "Please specify at least {min} answers!", array("{min}" => self::MIN_REQUIRED_ANSWERS)));
        }

        $this->answersText = $answerTextNew;
    }
}
