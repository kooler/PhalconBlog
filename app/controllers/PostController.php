<?php 

class PostController extends Phalcon_Controller {
	public function indexAction() {
		//Create a cache that caches from the "Output" to a "File" backend
		$cache = Phalcon_Cache::factory("Output", "File", array("lifetime" => 172800), array("cacheDir" => "../app/cache/"));

		$id = (int) $_GET["id"];

		if ($id > 0) {
			$post = $cache->get('post'.$id);
			if ($post == null) {
				$post = Post::findFirst($id);
				$cache->save('post'.$id, $post);
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