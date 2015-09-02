<?php

Yii::app()->moduleManager->register(array(
    'id' => 'documents',
    'class' => 'application.modules.documents.DocumentsModule',
    'import' => array(
        'application.modules.documents.models.*',
        'application.modules.documents.behaviors.*',
        'application.modules.documents.*',
    ),
    // Events to Catch 
    'events' => array(
        array(
        	'class' => 'SpaceMenuWidget',
        	'event' => 'onInit',
        	'callback' => array('DocumentsModule', 'onSpaceMenuInit')
        ),
        array('class' => 'SpaceSidebarWidget', 'event' => 'onInit', 'callback' => array('DocumentsEvents', 'onDashboardSidebarInit')),
    ),
));
?>