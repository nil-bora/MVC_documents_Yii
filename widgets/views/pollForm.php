<?php echo CHtml::textArea("name", "", array('id'=>'contentForm_question', 'class' => 'form-control autosize contentForm', 'rows' => '1', "tabindex" => "1", "placeholder" => Yii::t('DocumentsModule.widgets_views_pollForm', "Ask something..."))); ?>

<div class="contentForm_options">
    <?php echo CHtml::textArea("body", "", array('id' => "contentForm_answersText", 'rows' => '5', 'style' => 'height: auto !important;', "class" => "form-control contentForm", "tabindex" => "2", "placeholder" => Yii::t('DocumentsModule.widgets_views_pollForm', "Possible answers (one per line)"))); ?>
</div>

<div class="contentForm_options">
    <?php $models = Folder::model()->findAll();?>

    <?php echo CHtml::dropDownList('selectFolder', 'name', CHtml::listData($models, 'id', 'name'), array('empty' => Yii::t('DocumentsModule.widgets_views_pollForm', "Select a folder"), 'class'=>'form-control contentForm'));?>
</div>
