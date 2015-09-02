<?php

/**
 * Documents
 *
 */
class DocumentsController extends Controller {

    public $subLayout = "application.modules_core.space.views.space._layout";
    
    public $folder_id;

    public function filters() {
        return array(
            'accessControl', // perform access control for CRUD operations
        );
    }
    public function init()
    {
    	$this->folder_id = Yii::app()->request->getParam('folder_id');	
    }
    public function accessRules() {
        return array(
            array('allow', // allow authenticated user to perform 'create' and 'update' actions
                'users' => array('@'),
            ),
            array('deny', // deny all users
                'users' => array('*'),
            ),
        );
    }

    public function behaviors() {
        return array(
            'SpaceControllerBehavior' => array(
                'class' => 'application.modules_core.space.behaviors.SpaceControllerBehavior',
            ),
        );
    }
    
    public function actions() {
        return array(
            'stream' => array(
                'class' => 'application.modules.documents.DocumentsStreamAction',
                'mode' => 'normal'

            ),
        );
    }
    
    public function actionSearch() {
      // $this->renderJson(array());
	   echo Yii::app()->createUrl('//documents/documents/show', array('sguid' => $_POST['sguid'], 'search' => $_POST['search']));
	   exit;
    }
    
    
    public function actionAddposts() {
	    
	    //$command = Yii::app()->db->createCommand();
	    $host = "http://new-vist.com";	   
	    
	    $content = file_get_contents($host.'/intranet/news/get/');
	    $content = json_decode($content, true);
	   
	    if(is_array($content)) {
	    	
	    	
		    foreach($content as $key=>$item) {
			   // $content[$key]['body'] = str_replace('src="', 'src="'.$host, $item['body']);
			   	$images = array();
			    $result = array();
			    preg_match_all('/(?<=<img src=")[^"]+/', $item['body'], $result, PREG_PATTERN_ORDER);
				for ($i = 0; $i < count($result[0]); $i++) {
					 $images[] = $host.$result[0][$i];
				}  
				$content[$key]['body'] = preg_replace('/<img(?:\\s[^<>]*)?>/i', '', $item['body']);
		    }


		    foreach($content as $one) {
		    
			    $data['message'] = "<h2>".$one['name']."</h2>".$one['body'];
			    
			    Yii::app()->db->createCommand()->insert('post', array(
				    'message'=>$data['message'],
				    'created_at'=>date('Y-m-d H:i:s', time()),
				    'created_by'=>1,
				    'updated_at'=>date('Y-m-d H:i:s', time()),
				    'updated_by'=>1
				    
				));
				$idPost = Yii::app()->db->getLastInsertID();
				if($idPost) {
					
					if(is_array($images) && !empty($images)) {
						foreach($images as $two) {
							
							$guid = md5($two.time());
							$nameImg = basename($two);
							$file = file_get_contents($two);
							$dir = "/var/www/clients/client0/web171/web/uploads/file/".$guid;
							$dirFile = $dir."/".$nameImg;
							if(mkdir($dir, 0777)) {
								
								file_put_contents($dirFile, $file);
							
								Yii::app()->db->createCommand()->insert('file', array(
								    'guid' => $guid,
								    'object_model' => 'Post',
								    'object_id' => $idPost,
								    'file_name' => $nameImg,
								    'title' => $nameImg,
								    'mime_type' => 'image/jpeg',
								    'size' => filesize($dirFile),
								    'created_at' => date('Y-m-d H:i:s', time()),
								    'created_by' => 1,
								    'updated_at' => date('Y-m-d H:i:s', time()),
								    'updated_by' => 1							    
								));

							}								
						}
					}
					
					Yii::app()->db->createCommand()->insert('content', array(
					    'guid' => md5(time().$one['name']),
					    'object_model' => 'Post',
					    'object_id' => $idPost,
					    'visibility' => 0,
					    'sticked' => 0,
					    'archived' => 0,
					    'space_id' => 3,
					    'user_id' => 7,
					    'created_at' => date('Y-m-d H:i:s', time()),
					    'created_by' => 1,
					    'updated_at' => date('Y-m-d H:i:s', time()),
					    'updated_by' => 1
					    
					    
					));
					
					$idContent = Yii::app()->db->getLastInsertID();
					
					if($idContent) {
						$insert = Yii::app()->db->createCommand()->insert('wall_entry', array(
						    'wall_id' => 5,
						    'content_id' => $idContent,
						    'created_at' => date('Y-m-d H:i:s', time()),
						    'created_by' => 1,
						    'updated_at' => date('Y-m-d H:i:s', time()),
						    'updated_by' => 1
						));
						
						if($insert) {
							 $content = file_get_contents($host.'/intranet/news/update/'.$one['id']);
						}
					}
					
				}
		    }
	    }
	    
	    
	    
		
		
				
	    /*$post = new Post();
	   
	    $post->content->populateByForm();
        $post->message = "Test Message";

        if ($post->validate()) {
            $post->save();
        } 
        */
	  
    }
    
    public function actionShow() {
   
    	$user = User::model()->findByPk(Yii::app()->user->id);
    	
        $this->render('show', array('user' => $user));
    }
    

    //edit 13.05 NIL
    public function actionCreate() {

	    $this->forcePostRequest();
        $_POST = Yii::app()->input->stripClean($_POST);
        
        $poll = new Document();

        $poll->content->populateByForm();
        $poll->name = Yii::app()->request->getParam('name');
        $poll->body = Yii::app()->request->getParam('body');

        $poll->folder_id = (int)Yii::app()->request->getParam('selectFolder');

        //$poll->allow_multiple = Yii::app()->request->getParam('allowMultiple');

        if ($poll->validate()) {
            $poll->save();
            $this->renderJson(array('wallEntryId' => $poll->content->getFirstWallEntryId()));
        } else {

            $this->renderJson(array('errors' => $poll->getErrors()), false);
        }
        
    }
}
