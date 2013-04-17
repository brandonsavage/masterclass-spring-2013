<?php

include_once('Model.php');

class Model_Comment extends Model {

    public function __construct($dbconfig)
    {
        parent::__construct($dbconfig);
    }

    public function getCommentCountByStory($id)
    {
        $sql = 'SELECT COUNT(*) as `count` FROM comment WHERE story_id = ?';
        return $this->fetchOne($sql, array($id));
    }
    
    public function getCommentsByStory($id)
    {
        $sql = 'SELECT * FROM comment WHERE story_id = ?';
        return $this->fetchAll($sql, array($id));
    }
    
    public function insertComment($params = array())
    {
        $sql = 'INSERT INTO comment (created_by, created_on, story_id, comment) VALUES (?, NOW(), ?, ?)';
        $this->_query($sql, $params);
    }

}