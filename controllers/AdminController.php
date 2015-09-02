<?php

/**
 * HumHub
 * Copyright © 2014 The HumHub Project
 *
 * The texts of the GNU Affero General Public License with an additional
 * permission and of our proprietary license can be found at and
 * in the LICENSE file you have received along with this program.
 *
 * According to our dual licensing model, this program can be used either
 * under the terms of the GNU Affero General Public License, version 3,
 * or under a proprietary license.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
 * GNU Affero General Public License for more details.
 */

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
        
		$parent = array();
		
		/*
        foreach($pages as $one) {
	        $parent[$one->id] = $one->parent_id>0?$pages[$one->parent_id]:false;
	    }
	    */
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

        //Yii::app()->clientScript->registerCssFile($this->getModule()->getAssetsUrl() . '/bootstrap-select.min.css');
        //Yii::app()->clientScript->registerScriptFile($this->getModule()->getAssetsUrl() . '/bootstrap-select.min.js');
       
        	
        if (isset($_POST['Folder'])) {
        	
        	//$page->content->populateByForm();
            $page->attributes = $_POST['Folder'];
  
            //if ($page->validate()) {
                $page->save();
             //   $this->redirect(Yii::app()->createUrl('//pages/admin'));
           // }
            
        }

		$root=array();
		$pages = Folder::model()->findAll();
		/*
        foreach($pages as $one) {
	        if($one->parent_id == 0) {
				$root[$one->id]=$one->title;
			}
		}
		*/
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
