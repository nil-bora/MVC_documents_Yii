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
 * @author andystrobel
 */
class DocumentsDashboardWidget extends HWidget
{
	
	public function init() {

    }
	
    public function run()
    {
        $folder = array();
        $command = Yii::app()->db->createCommand("SELECT DISTINCT document.folder_id as id  FROM `content` LEFT JOIN document ON content.object_id = document.id WHERE content.`object_model`='Document' AND content.space_id=".Yii::app()->controller->space->id)->queryAll();

        if(sizeof($command) > 0)
        {
			$id = array();
			foreach($command as $one)
				$id[] = $one['id'];
				
			$folder = Folder::model()->findAllByPk($id);
			
			$this->render('folderPanel', array('folder' => $folder));
        }
       
    }

}
