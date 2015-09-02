<?php

/**
 * Documents
 *
 * This class is also used to process events catched by the autostart.php listeners.
 *
 */
class DocumentsModule extends HWebModule
{

    /**
     * Inits the Module
     */
    public function init()
    {
        $this->setImport(array(
            'documents.models.*',
            'documents.behaviors.*',
        ));
    }

    public function behaviors()
    {
        return array(
            'SpaceModuleBehavior' => array(
                'class' => 'application.modules_core.space.behaviors.SpaceModuleBehavior',
            ),
        );
    }

    /**
     * On global module disable, delete all created content
     */
    public function disable()
    {
        if (parent::disable()) {
            foreach (Content::model()->findAllByAttributes(array('object_model' => 'Document')) as $content) {
                $content->delete();
            }
            return true;
        }

        return false;
    }

    /**
     * On disabling this module on a space, deleted all module -> space related content/data.
     * Method stub is provided by "SpaceModuleBehavior"
     * 
     * @param Space $space
     */
    public function disableSpaceModule(Space $space)
    {
        foreach (Content::model()->findAllByAttributes(array('space_id' => $space->id, 'object_model' => 'Document')) as $content) {
            $content->delete();
        }
    }

    /**
     * On build of a Space Navigation, check if this module is enabled.
     * When enabled add a menu item
     *
     * @param type $event
     */
    public static function onSpaceMenuInit($event)
    {
        $space = Yii::app()->getController()->getSpace();

        // Is Module enabled on this workspace?
        if ($space->isModuleEnabled('documents')) {
            $event->sender->addItem(array(
                'label' => 'Документы',
                'group' => 'modules',
                'url' => Yii::app()->createUrl('//documents/documents/show', array('sguid' => $space->guid)),
                'icon' => '<i class="fa fa-folder"></i>',
                'isActive' => (Yii::app()->controller->module && Yii::app()->controller->module->id == 'documents'),
            ));
        }
    }
}
