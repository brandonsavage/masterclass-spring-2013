<?php

class DatabaseMysql implements DatabaseInterface {

    protected $config;
    protected $db;

    public function __construct(array $config) {
        $this->config=$config;

        $dsn='mysql:host='.$this->config['database']['host'].';dbname='.$this->config['database']['name'];
        $this->db= new PDO($dsn,$this->config['database']['user'],$this->config['database']['pass']);
        $this->db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    }

    public function select($sql, array $params) {
        $stm = $this->db->prepare($sql);
        $stm->execute($params);
        return $stm->fetchAll(PDO::FETCH_ASSOC);
    }

    public function insert($sql, array $params) {
        $stm= $this->db->prepare($sql);
        $stm->execute($params);
        return $this->db->lastInsertId();

    }

    public function update($sql,array $params) {
        $stm = $this->db->prepare($sql);
        $stm->execute($params);
        return $stm->rowCount();
    }

    public function delete($sql,array $params) {
        $stm = $this->db->prepare($sql);
        $stm->execute($params);
        return $stm->rowCount();
    }

}