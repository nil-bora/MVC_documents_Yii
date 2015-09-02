<div class="panel panel-default panel-tour" id="getting-started-panel">
    <?php
    // Temporary workaround till panel widget rewrite in 0.10 verion
    $removeOptionHtml = "<li>" . $this->widget('application.widgets.ModalConfirmWidget', array(
                'uniqueID' => 'hide-panel-button',
                'title' => '<strong>Remove</strong> tour panel',
                'message' => 'This action will remove the tour panel from your dashboard. You can reactivate it at<br>Account settings <i class="fa fa-caret-right"></i> Settings.',
                'buttonTrue' => 'Ok',
                'buttonFalse' => 'Cancel',
                'linkContent' => '<i class="fa fa-eye-slash"></i> ' . Yii::t('TourModule.widgets_views_tourPanel', ' Remove panel'),
                'linkHref' => $this->createUrl("//tour/tour/hidePanel", array("ajax" => 1)),
                'confirmJS' => '$(".panel-tour").slideToggle("slow")'
                    ), true) . "</li>";
    ?>

    <!-- Display panel menu widget -->
    <?php $this->widget('application.widgets.PanelMenuWidget', array('id' => 'getting-started-panel', 'extraMenus' => $removeOptionHtml)); ?>

    <div class="panel-heading">
    	<span>
        	<?php echo Yii::t('DocumentsModule.widgets_views_folderPanel', 'Folder'); ?>
        </span>
    </div>
    <div class="panel-body">
		<ul class="tour-list">
			<?php foreach($folder as $one):?>
            <li id="interface_entry" <?php if(isset($_GET['folder_id']) && ($one->id == $_GET['folder_id'])):?> class="active"<?php endif;?>>
            
            	<a href="<?php echo Yii::app()->createUrl('//documents/documents/show', array('sguid' => $_GET['sguid'], 'folder_id' => $one->id)); ?>">
            		<i class="fa fa-folder"></i><?=$one->name;?>
            	</a>
            </li>
            <?php endforeach;?>
        </ul>
		
    </div>
</div>
