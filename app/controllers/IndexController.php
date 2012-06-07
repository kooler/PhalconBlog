<?php

class IndexController extends Phalcon_Controller {

	public function indexAction(){
		$page = (int) $_GET["page"];

		//Create a model paginator, show 10 rows by page starting from $numberPage
		$paginator = Phalcon_Paginator::factory("Model", array(
		  "data" => Post::find(array("order" => "created DESC")),
		  "limit"=> 10,
		  "page" => $page == 0 ? 1 : $page
		));

		$this->view->setVar('posts', $paginator->getPaginate());
		$this->view->setVar('randomPosts', Post::find(array("order" => "RAND()", 'limit' => 10)));
		$this->view->setVar('topPosts', Post::find(array("order" => "created DESC", 'limit' => 10)));
		$this->view->setVar('randomComments', Comment::find(array("order" => "RAND()", 'limit' => 5)));
		$this->view->setVar('lastComments', Comment::find(array("order" => "id DESC", 'limit' => 5)));
	}

	public function generateAction() {
		$text = 'Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industrys standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.';
		for ($i = 0; $i < 500; $i++) {
			$post = new Post();
			$post->name = 'Post #'.mt_rand(100000, 999999);
			$post->body = $text;
			$post->created = date('Y-m-d H:i');
			if ($post->save()) {
				$createdPost = Post::findFirst(array("order" => "id DESC"));
				$postId = $createdPost->id;
				$numberOfComments = mt_rand(50, 100);
				for ($j = 0; $j < $numberOfComments; $j++) {
					$comment = new Comment();
					$comment->post_id = (int) $postId;
					$comment->body = substr($text, mt_rand(10, 200), mt_rand(10,200));
					if (!$comment->save()) {
						print_r($comment->getMessages());exit;
					}
				}
			} else {
				foreach ($post->getMessages() as $message) {
			    	echo $message, "<br>";
			   	}
			   	exit;
			}
		}
	}

	public function sitemapAction() {
		$posts = Post::find(array("order" => "created DESC"));
		$baseUrl = 'http://'.$_SERVER['HTTP_HOST'].'/';
		//List pages
		$pagesNumber = ceil(count($posts)/10);
		for ($i = 1; $i < $pagesNumber; $i++) {
			echo $baseUrl.'?page='.$i."\n";
		}
		//Post pages
		foreach ($posts as $post) {
			echo $baseUrl.'post/?id='.$post->id."\n";
		}
	}

}