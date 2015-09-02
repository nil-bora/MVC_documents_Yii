<?php $this->beginContent('application.modules_core.activity.views.activityLayout', array('activity' => $activity)); ?>
<?php echo Yii::t('PollsModule.views_activities_PollCreated', '{userName} created a new {question}.', array(
    '{userName}' => '<strong>'. $user->displayName .'</strong>',
    '{question}' =>  Helpers::truncateText($target['body'], 25)
)); ?>
<?php $this->endContent(); ?>


