<?php
/**
 * Created by JetBrains PhpStorm.
 * User: ricardo
 * Date: 4/19/13
 * Time: 5:04 PM
 * To change this template use File | Settings | File Templates.
 */

class Model_Comment {

    protected $db;
    protected $config;

    public function __construct(array $config,Database_Abstract $db) {
        $this->config = $config;
        $this->db = $db;
    }

    public function getCommentCountForStory($story_id) {
        $comment_sql = 'SELECT COUNT(*) as `count` FROM comment WHERE story_id = ?';
        $count = $this->db->fetchOne($comment_sql, array($story_id));
        return $count['count'];
    }

    public function getStoryComments($story_id) {
        $comment_sql = 'SELECT * FROM comment WHERE story_id = ?';
        $comments = $this->db->fetchAll($comment_sql, array($story_id));
        return $comments;
    }

    public function createComment(array $params = array()) {
        $sql = 'INSERT INTO comment (created_by, created_on, story_id, comment) VALUES (?, NOW(), ?, ?)';
        return $this->db->insert($sql, $params);
    }
}