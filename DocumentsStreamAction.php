<?php

/**
 * PollsStreamAction is modified version of the StreamAction to show only objects
 * of type Poll.
 *
 * This Action is inserted in PollController and shows with interaction of the
 * PollStreamWidget the Poll Stream.
 *
 * @package humhub.modules.polls
 * @since 0.5
 * @author Luke
 */
class DocumentsStreamAction extends StreamAction {

    /**
     * Inject Question Specific SQL
     */
     
    protected function prepareSQL() {
	    
        $this->sqlWhere .= " AND object_model='Document'";
       
        if(isset($_SESSION['folder_id']))
        {
	        $folder_id = $_SESSION['folder_id'];
	        $this->sqlJoin .="LEFT JOIN document ON content.object_id = document.id";
	        $this->sqlWhere .=" AND document.folder_id = ".$folder_id."";
        }
        if(isset($_SESSION['search']))
        {
	        $search = $_SESSION['search'];
	        $this->sqlJoin .="LEFT JOIN document ON content.object_id = document.id";
	        $this->sqlWhere .=" AND (document.name LIKE '%{$search}%' OR document.body LIKE '%{$search}%')";
	        //unset($_SESSION['search']);
        }
       
        parent::prepareSQL();
    }

    /**
     * Handle Question Specific Filters
     */
    protected function setupFilterSQL() {

        if (in_array('polls_notAnswered', $this->filters) || in_array('polls_mine', $this->filters)) {

            $this->sqlJoin .= " LEFT JOIN poll ON content.object_id=poll.id AND content.object_model = 'Poll'";

            if (in_array('polls_notAnswered', $this->filters)) {
                $this->sqlJoin .= " LEFT JOIN poll_answer_user ON poll.id=poll_answer_user.poll_id AND poll_answer_user.created_by = '" . Yii::app()->user->id . "'";
                $this->sqlWhere .= " AND poll_answer_user.id is null";
            }

            #if (in_array('questions_mine', $this->filters)) {
            #	$this->sqlWhere .= " AND question.created_by = '".Yii::app()->user->id."'";
            #}
        }


        parent::setupFilterSQL();
    }

}

?>
