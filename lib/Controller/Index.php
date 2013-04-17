<?php

class Controller_Index {
    
    protected $index;
    protected $config;
    
    public function __construct($config) {
        $this->config = $config;
        $this->story = new Model_Story($this->config['database']);
        $this->comment = new Model_Comment($this->config['database']);
    }
    
    public function index() {
        
        $stories = $this->story->getStories();
        
        $content = '<ol>';
        
        foreach($stories as $story) {
            $count = $this->comment->getCommentCountByStory($story['id']);
            $content .= '
                <li>
                <a class="headline" href="' . $story['url'] . '">' . $story['headline'] . '</a><br />
                <span class="details">' . $story['created_by'] . ' | <a href="/story/?id=' . $story['id'] . '">' . $count['count'] . ' Comments</a> | 
                ' . date('n/j/Y g:i a', strtotime($story['created_on'])) . '</span>
                </li>
            ';
        }
        
        $content .= '</ol>';
        
        require_once $this->config['views']['layout_path'] . '/layout.phtml';
    }
}