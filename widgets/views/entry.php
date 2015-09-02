<?php
/**
 * This view represents a wall entry of a polls.
 * Used by PollWallEntryWidget to show Poll inside a wall.
 *
 * @property User $user the user which created this poll
 * @property Poll $poll the current poll
 * @property Space $space the current space
 *
 * @package humhub.modules.polls.widgets.views
 * @since 0.5
 */
?>
<div class="panel panel-default">
    <div class="panel-body">

        <?php $this->beginContent('application.modules_core.wall.views.wallDocumentLayout', array('object' => $document)); ?>


        <?php echo CHtml::beginForm(); ?>
        <?php $first_file = array();?>
        <?php $files = File::getFilesOfObject($document);?>

        <?php if (count($files) != 0) : ?>
        <?php $first_file = $files[0];?>
        <?php endif;?>
	        <!-- start: show document's img -->
		<!--
<a <?php //if (count($first_file) != 0) : ?>href="<?php //echo $first_file->getUrl(); ?>"<?php //endif;?> class="pull-left doc-img">
	        <img class="media-object user-image" alt="" src="/themes/Vist/img/doc.png"/>
	        <span class="doc-type">pdf</span>
	    </a>
-->
	    <!-- end: show document's img -->
        <div class="media-body media-body-doc">
	        <!-- show document's body-->
		    <div class="time"><a href="<?=Yii::app()->createUrl('//documents/documents/show', array("sguid"=>$document->content->container->guid, "folder_id"=>$document->folder_id))?>"><i class="fa fa-folder"></i>&nbsp;<?php echo $document->folder['name'];?></a></div>
	        <h4 class="media-heading">
	       	 	<a <?php if (count($first_file) != 0) : ?>href="<?php echo $first_file->getUrl(); ?>"<?php endif;?>><?php echo $document->name;?></a>
	        </h4>
	
	    </div>
	    
	    <hr/>
	    
	    <!-- show document's content -->
	    <div class="content content-doc" id="wall_content_<?php echo $document->getUniqueId(); ?>">
	        <?php print nl2br($document->body); ?><br><br>
	    </div>
	    <br><br>
	    <hr>
	    <?php if (count($files) != 0) : ?>
	    	<ul class="files" style="list-style: none; margin: 0;" id="files-<?php echo $document->getPrimaryKey(); ?>">
	    	<?php foreach ($files as $file) : ?>
	    		<li class="mime <?php echo HHtml::getMimeIconClassByExtension($file->getExtension()); ?>">
	    			<a href="<?php echo $file->getUrl(); ?>" target="_blank"><?php echo Helpers::trimText($file->file_name, 40); ?> 
	    				<span class="tome"> - <?php echo Yii::app()->format->formatSize($file->size); ?></span></a>
	    		</li>
	    	<?php endforeach;?>
	    	</ul>
	    <?php endif;?>
        <?php //echo $document->folder['name'];?>

        <div class="clearFloats"></div>

        <?php echo CHtml::endForm(); ?>

        


        <?php $this->endContent(); ?>

    </div>

</div>


