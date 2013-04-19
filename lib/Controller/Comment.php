<?php

class Controller_Comment {
	protected $config;
	protected $model;
	protected $session;
    
    public function __construct($config) {
		$this->config = $config;
		$this->model = new Model_Comment($config);
		$this->session = Model_Session::getSession();
    }
    
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

		if (($result = $this->model->createComment($args)) === true) {
        	header("Location: /story/?id=" . $_POST['story_id']);
		} else {
			die($result);
		}
    }
    
}
