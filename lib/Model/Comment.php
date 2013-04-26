<?php

class Model_Comment extends Model_Base {
    
	public function getCommentCountForStory($story_id) {
		$sql = 'SELECT COUNT(*) as `count` FROM comment WHERE story_id = ?';
		$count = $this->db->fetchOne($sql, $story_id);
		return $count;
	}

	public function getStoryComments($story_id) {
		$sql = 'SELECT * FROM comment WHERE story_id = ?';
		$comments = $this->db->fetchAll($sql, $story_id);
		return $comments;
	}

    public function createComment(array $params = array()) {
        $sql = 'INSERT INTO comment (created_by, created_on, story_id, comment) VALUES (?, NOW(), ?, ?)';
		$stmt = $this->db->insert($sql, $params);

		if ($err = $this->db->getError()) {
			return $err;
		}

		return true;
    }
}
