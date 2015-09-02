<?php

class DocumentsEvents
{
    public static function onAdminMenuInit($event)
    {
        $event->sender->addItem(array(
            'label' => Yii::t('DocumentsModule.base', 'Documents'),
            'url' => Yii::app()->createUrl('//pages/admin'),
            'group' => 'manage',
            'icon' => '<i class="fa fa-file-code-o"></i>',
            'isActive' => (Yii::app()->controller->module && Yii::app()->controller->module->id == 'pages' && Yii::app()->controller->id == 'admin'),
            'sortOrder' => 300,
        ));

        // Check for Admin Menu Pages to insert
    }
    
    public static function onDashboardSidebarInit($event)
    {

	    if(Yii::app()->controller->module->id == 'documents')
	    {
	     
		    $event->sender->addWidget('application.modules.documents.widgets.DocumentsDashboardWidget', array(), array('sortOrder' => 0, 'sguid'=>$_GET['sguid']));
        // Check for Admin Menu Pages to insert
	    }
        
    }
    

}
