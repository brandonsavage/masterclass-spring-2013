<?php

class Controller_Index {
    
    protected $db;
    protected $config;
    protected $session;
    protected $story_model;
    protected $comment_model;

    
    public function __construct(array $config,Database_Abstract $db, Session_Interface $session) {
        $this->config=$config;
        $this->db=$db;
        $this->session=$session;

        $this->story_model=new Model_Story($config,$db);
        $this->comment_model=new Model_Comment($config,$db);

    }
    
    public function index() {
        
        $stories=$this->story_model->getListOfStories();
        $content = '<ol>';
        
        foreach($stories as $story) {
            $content .= '
                <li>
                <a class="headline" href="' . $story['url'] . '">' . $story['headline'] . '</a><br />
                <span class="details">' . $story['created_by'] . ' | <a href="/story/?id=' . $story['id'] . '">' . $this->comment_model->getCommentCountForStory($story['id']) . ' Comments</a> |
                ' . date('n/j/Y g:i a', strtotime($story['created_on'])) . '</span>
                </li>
            ';
        }
        
        $content .= '</ol>';
        
        require $this->config['views']['layout_path'].'/layout.phtml';
    }
}