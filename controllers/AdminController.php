<?php

/**
 * Description of AdminController
 *
 * @author luke
 */
class AdminController extends Controller
{

    public $subLayout = "application.modules_core.admin.views._layout";

    /**
     * @return array action filters
     */
    public function filters()
    {
        return array(
            'accessControl', // perform access control for CRUD operations
        );
    }

    /**
     * Specifies the access control rules.
     * This method is used by the 'accessControl' filter.
     * @return array access control rules
     */
    public function accessRules()
    {
        return array(
            array('allow',
                'expression' => 'Yii::app()->user->isAdmin()',
            ),
            array('deny', // deny all users
                'users' => array('*'),
            ),
        );
    }

    public function actionIndex()
    {

        $pages = Folder::model()->findAll(array('index'=>'id'));
        
        $this->render('index', array(
        	'pages' => $pages,
        	'parent' => 1
        ));
    }

    public function actionEdit()
    {
        $page = Folder::model()->findByPk(Yii::app()->request->getParam('id'));
       
        if ($page === null) {
            $page = new Folder;
        }

        if (isset($_POST['ajax']) && $_POST['ajax'] === 'page-edit-form') {
            echo CActiveForm::validate($page);
            Yii::app()->end();
        }
       
        if (isset($_POST['Folder'])) {
            $page->attributes = $_POST['Folder'];
            
            if ($page->validate()) {
                $page->save();
            }
            
        }

	$root=array();
	$pages = Folder::model()->findAll();
        
        $this->render('edit', array(
        	'page' => $page,
        	'root' => $root
        ));
    }

    public function actionDelete()
    {
        $page = Folder::model()->findByPk(Yii::app()->request->getParam('id'));

        if ($page !== null) {
            $page->delete();
        }

        $this->redirect(Yii::app()->createUrl('//documents/admin'));
    }

}
