<?php

class Model_Story {
	protected $config;
	protected $db;
    
    public function __construct($config) {
		$this->config = $config;
		$this->db = new Model_Database_Mysql($config);
    }

	public function createStory(array $params = array()) {
		$sql = 'INSERT INTO story (headline, url, created_by, created_on) VALUES (?,?,?,NOW())';
		$stmt = $this->db->insert($sql, $params);

		if ($err = $this->db->getError()) {
			return $err;
		}
		return $this->db->lastInsertId();
	}

	public function listStories() {
		$sql = 'SELECT * FROM story ORDER BY created_on DESC';
		$stories = $this->db->fetchAll($sql);
		return $stories;
	}

	public function getStory($story_id) {
		$sql = 'SELECT * FROM story WHERE id = ?';
		$story = $this->db->fetchOne($sql, $story_id);
		return $story;
	}
}
