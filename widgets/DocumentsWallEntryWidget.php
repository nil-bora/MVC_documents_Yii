<?php

/**
 * PollWallEntryWidget is used to display a poll inside the stream.
 *
 * This Widget will used by the Poll Model in Method getWallOut().
 *
 * @package humhub.modules.polls.widgets
 * @since 0.5
 * @author Luke
 */
class DocumentsWallEntryWidget extends HWidget {

    public $document;

    public function run() {

        $this->render('entry', array('document' => $this->document,
            'user' => $this->document->content->user,
            'space' => $this->document->content->container));
    }

}

?>