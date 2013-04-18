<?php

class Model_Story extends Model_Base {

    public function __construct($dbconfig)
    {
        parent::__construct($dbconfig);
    }
    
    public function createStory($headline, $url, $username)
    {
        $sql = 'INSERT INTO story (headline, url, created_by, created_on) VALUES (?, ?, ?, NOW())';
        $this->_insert($sql, array($headline, $url, $username));
        return $this->lastInsertId();
    }
    
    public function getStory($id)
    {
        $sql = 'SELECT * FROM story WHERE id = ?';
        return $this->fetchOne($sql, array($id));
    }

    public function getStories()
    {
        $sql = 'SELECT * FROM story ORDER BY created_on DESC';
        $stories = $this->fetchAll($sql);
        return $stories;
    }
    
    public function getComments($username, $password)
    {
        $sql = 'SELECT * FROM user WHERE username = ? AND password = ? LIMIT 1';
        $password = md5($username . $password);
        $user = $this->fetchOne($sql, array($username, $password));
        // starting doing this with more code in controller
        return array('authenticated' => $this->rowCount(), 'user' => $user);
    }
    
    public function createUser($params = array())
    {
        $query = 'INSERT INTO user (username, email, password) VALUES (?, ?, ?)';
        $this->_query($query, $params);
    }

}