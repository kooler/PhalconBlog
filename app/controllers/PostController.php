<?php 

class PostController extends Phalcon_Controller {
	public function indexAction() {
		$id = (int) $_GET["id"];

		if ($id > 0) {
			$post = Post::findFirst($id);
			
			if ($post) {
				$this->view->setVar('post', $post);		
				return;
			}
		}
		throw new Exception('Can\'t find post with id #'.$id);
	}

	public function addcommentAction() {
		$body = strip_tags($_POST['body']);
		$postId = (int) $_POST['post'];
		if (!empty($body) && $postId > 0) {
			$comment = new Comment();
			$comment->post_id = $postId;
			$comment->body = $body;
			$comment->save();
		}
		header('Location: /post/?id='.$postId.'&res=saved');
	}
}