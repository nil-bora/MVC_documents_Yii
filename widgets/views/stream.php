<?php
/**
 * This view shows the stream of all available polls.
 * Used by PollStreamWidget.
 *
 * @property Space $space the current space
 *
 * @package humhub.modules.polls.widgets.views
 * @since 0.5
 */
?>
<?php
	//echo $startUrl;
?>
<ul class="nav nav-tabs wallFilterPanel" id="filter" style="display: none;">
	<li class="dropdown search-box">
		<input type="text" class="form-control search-for" autocomplete="off" placeholder="Поиск" id="serch-js">
		<?php
			echo CHtml::ajaxLink(
			    '<i class="fa fa-search"></i>',
			     Yii::app()->createUrl('//documents/documents/search'),
			   
			
			    array(
			    'type' => 'POST',
			    'beforeSend' => "function( request ) {
			    	
			    }",
			    'success' => "function( data ){
			    	console.log(data);
			    	//var search = $('#serch-js').val();
			    	window.location.href = data;
			    }",
			    'data' => array( 'search' => "js:$('#serch-js').val()", 'sguid' => $_GET['sguid']), // посылаем значения
			    'cache'=>'false' // если нужно можно закэшировать
			  ),
			  array( // самое интересное
			    'href' => Yii::app()->createUrl('//documents/documents/show'),// подменяет ссылку на другую
			    'class' => "dropdown-toggle search-for-sign",
			    'data-toggle' => "dropdown"
			  )
			);
		?>
           
        </a>
	</li>

</ul>

<div id="pollStream">

    <!-- DIV for an normal wall stream -->
    <div class="s2_stream" style="display:none">
        <div class="s2_streamContent"></div>
        <div class="loader streamLoader"></div>
        <div class="emptyStreamMessage">
            <?php if ($this->contentContainer->canWrite()) { ?>
                <div class="placeholder placeholder-empty-stream">
                    <?php echo Yii::t('DocumentsModule.widgets_views_stream', '<b>У вас нет добавленных документов</b>'); ?>
                </div>
            <?php }?>
        </div>
        <div class="emptyFilterStreamMessage">
            <div class="placeholder">
                <b><?php echo Yii::t('DocumentsModule.widgets_views_stream', 'No poll found which matches your current filter(s)!'); ?></b>
            </div>
        </div>
    </div>

    <!-- DIV for an single wall entry -->
    <div class="s2_single" style="display: none;">
        <div class="back_button_holder">
            <a href="#" class="singleBackLink button_white"><?php echo Yii::t('WallModule.widgets_views_stream', 'Back to stream'); ?></a>
        </div>
        <div class="p_border"></div>

        <div class="s2_singleContent"></div>
        <div class="loader streamLoaderSingle"></div>
    </div>
</div>
<?php 
	if(isset($_GET['folder_id'])) {
		$_SESSION['folder_id'] = $_GET['folder_id'];
	} else {
		unset($_SESSION['folder_id']);
	}
	
	if(isset($_GET['search'])) {
		$_SESSION['search'] = $_GET['search'];
	} else {
		unset($_SESSION['search']);
	}
?>
<script>
    // Kill current stream
    if (currentStream) {
        currentStream.clear();
    }

    s = new Stream("#pollStream", "<?php echo $startUrl; ?>", "<?php echo $reloadUrl; ?>", "<?php echo $singleEntryUrl; ?>");
    s.showStream();
    currentStream = s;
    
    $(".search-for").keydown(function(e) {
       var ev = e || event;
       if(ev.keyCode == 13) {
         $(".search-for-sign").click();
          return false;
       }
   }); 
</script>


