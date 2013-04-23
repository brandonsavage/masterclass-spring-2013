<?php

class Controller_Comment extends Controller_Base {
	protected $comment;
    
    public function create() {
        if (!$this->session->isAuthenticated()) {
            header("Location: /");
            exit;
        }
        
		$args = Array(
			$this->session->username,
			$_POST['story_id'],
            filter_input(INPUT_POST, 'comment', FILTER_SANITIZE_FULL_SPECIAL_CHARS),
		);

		if (($result = $this->comment->createComment($args)) === true) {
        	header("Location: /story/?id=" . $_POST['story_id']);
		} else {
			die($result);
		}
    }

	protected function _loadModels() {
		$this->comment = new Model_Comment($this->config);
	}
}
