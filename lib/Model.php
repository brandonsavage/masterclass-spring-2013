<?php

class Model {
    
    protected $dbh;
    protected $last_query;
    protected $row_count;
    
    public function __construct($dbconfig) 
    {
        $this->_dbConnect($dbconfig);
    }
    
    public function fetchOne($sql, array $params = array())
    {
        $stmt = $this->_query($sql, $params);
        return $stmt->fetch(PDO::FETCH_ASSOC);     
    }
    
    public function fetchAll($sql, array $params = array())
    {
        $stmt = $this->_query($sql, $params);
        return $stmt->fetchAll(PDO::FETCH_ASSOC); 
    }
    
    public function rowCount()
    {
        // had a hard time abstracting the PDO class, example helped
        return $this->last_query->rowCount();
    }
    
    public function lastInsertId()
    {
        return $this->last_insert_id;
    }
    
    protected function _dbConnect($dbconfig)
    {    
        $dsn = 'mysql:host=' . $dbconfig['host'] . ';dbname=' . $dbconfig['name'];
        $this->dbh = new PDO($dsn, $dbconfig['user'], $dbconfig['pass']);
        $this->dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);   
    }
    
    protected function _query($sql, array $params = array())
    {
        $stmt = $this->dbh->prepare($sql);
        $stmt->execute($params);
        $this->last_query = $stmt;
        return $stmt;
    }
    
    protected function _insert($sql, array $params = array())
    {
        $result = $this->_query($sql, $params);
        $this->last_insert_id = $this->dbh->lastInsertId();
        return $result;
    }
    
}