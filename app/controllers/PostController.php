<?php 

class PostController extends Phalcon_Controller {
	public function indexAction() {
		$memcache = new Memcache;
		$memcache->connect('localhost', 11211);

		$id = (int) $_GET["id"];

		if ($id > 0) {
			$post = $memcache->get('post'.$id);
			if ($post == null) {
				$post = Post::findFirst($id);
				$memcache->set('post'.$id, $post);
			}
			
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