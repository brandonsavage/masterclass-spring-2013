<?php

class Controller_Comment {

    protected $db;
    protected $config;
    protected $comment_model;
    protected $session;

    public function __construct(array $config,Database_Abstract $db,Session_Interface $session) {
        $this->config=$config;
        $this->db=$db;
        $this->session=$session;
        $this->comment_model=new Model_Comment($config,$this->db);
    }
    
    public function create() {
        if(!$this->session->get('authed')) {
            die('not auth');
            header("Location: /");
            exit;
        }

        $params=array(
            $_SESSION['username'],
            $_POST['story_id'],
            filter_input(INPUT_POST, 'comment', FILTER_SANITIZE_FULL_SPECIAL_CHARS),
        );
        $this->comment_model->createComment($params);



        header("Location: /story/?id=" . $_POST['story_id']);
    }
    
}