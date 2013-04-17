<?php

class Controller_Comment {

    protected $comment;
    protected $config;
    
    public function __construct($config) {
        $this->config = $config;
        $this->comment = new Model_Comment($this->config['database']);
    }
    
    public function create() {
        if(!isset($_SESSION['AUTHENTICATED'])) {
            die('not auth');
            header("Location: /");
            exit;
        }
        
        $params = array(
            $_SESSION['username'],
            $_POST['story_id'],
            filter_input(INPUT_POST, 'comment', FILTER_SANITIZE_FULL_SPECIAL_CHARS)
        );
        
        $this->comment->insertComment($params);
        
        header("Location: /story/?id=" . $_POST['story_id']);
    }
    
}