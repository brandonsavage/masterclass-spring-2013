<?php

class Controller_Index extends Controller_Base {
    protected $story;
	protected $comment;

	protected function _loadModels() {
		$this->story = new Model_Story($this->config);
		$this->comment = new Model_Comment($this->config);
	}

    public function index() {
        $stories = $this->story->listStories();
        
        $content = '<ol>';
        
        foreach($stories as $story) {
            $count = $this->comment->getCommentCountForStory($story['id']);
            $content .= '
                <li>
                <a class="headline" href="' . $story['url'] . '">' . $story['headline'] . '</a><br />
                <span class="details">' . $story['created_by'] . ' | <a href="/story/?id=' . $story['id'] . '">' . $count['count'] . ' Comments</a> | 
                ' . date('n/j/Y g:i a', strtotime($story['created_on'])) . '</span>
                </li>
            ';
        }
        
        $content .= '</ol>';
        
        require $this->config['views']['layout_path'] . 'layout.phtml';
    }
}
