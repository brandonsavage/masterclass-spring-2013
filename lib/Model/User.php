<?php

class Model_User extends Model_Base {

    public function __construct($dbconfig)
    {
        parent::__construct($dbconfig);
    }
    
    public function checkUser(array $params = array())
    {
        $sql = 'SELECT * FROM user WHERE username = ?';
        $results = $this->fetchOne($sql, $params);
        return $this->rowCount();
    }
    
    public function authUser($username, $password)
    {
        $sql = 'SELECT * FROM user WHERE username = ? AND password = ? LIMIT 1';
        $password = md5($username . $password);
        $user = $this->fetchOne($sql, array($username, $password));
        // starting doing this with more code in controller
        return array('authenticated' => $this->rowCount(), 'user' => $user);
    }
    
    public function createUser($username, $email, $password)
    {
        $password = md5($username . $password);
        $sql = 'INSERT INTO user (username, email, password) VALUES (?, ?, ?)';
        $this->_query($sql, array($username, $email, $password));
    }
    
    public function getUser($username)
    {
        $sql = 'SELECT * FROM user WHERE username = ?';
        return $this->fetchOne($sql, array($username));
    }
    
    public function updateUser($username, $password)
    {
        $password = md5($username . $password);
        $sql = 'UPDATE user SET password = ? WHERE username = ?'; 
        $this->_query($sql, array($password, $username));
    }

}