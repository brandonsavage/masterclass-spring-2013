<?php

class Model_User {

    protected $db;
    protected $config;

    public function __construct(array $config,Database_Abstract $db) {
            $this->config = $config;
            $this->db = $db;
    }

    public function createUser(array $params = array()) {
        $params['password']=md5($params['username'] . $params['password']);
        $sql = 'INSERT INTO user (username, email, password) VALUES (?, ?, ?)';
        return $stmt = $this->db->insert($sql, $params);
    }

    public function checkUsername($username) {
        $check_sql = 'SELECT * FROM user WHERE username = ?';
        $check_stmt = $this->db->fetchOne($check_sql, array($username));
        return $this->db->rowCount();
    }

    public function authenticateUser($username, $password) {
        $password = md5($username . $password); // FIXME
        $sql = 'SELECT * FROM user WHERE username = ? AND password = ? LIMIT 1';
        $user = $this->db->fetchOne($sql, array($username, $password));
        return array('authenticated' => $this->db->rowCount(), 'user' => $user);
    }

    public function getUserData($username) {
        $sql = 'SELECT * FROM user WHERE username = ?';
        return $this->db->fetchOne($sql, array($username));
    }

    public function changeUserPassword($username, $password) {
        $sql = 'UPDATE user SET password = ? WHERE username = ?';
        $params = array(
            md5($username . $password), // FIXME.
            $username,
            );
        return $this->db->insert($sql, $params);
    }
}