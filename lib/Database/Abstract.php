<?php
/**
 * Created by JetBrains PhpStorm.
 * User: ricardo
 * Date: 4/20/13
 * Time: 2:45 PM
 * To change this template use File | Settings | File Templates.
 */

abstract class Database_Abstract {

    protected $config;
    protected $db;
    protected $last_query;
    protected $last_insert_id = 0;


    public function fetchOne($sql, array $args = array()) {
        $stmt = $this->_do_prepare_and_query($sql, $args);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function fetchAll($sql, array $args = array()) {
        $stmt = $this->_do_prepare_and_query($sql, $args);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);

    }

    public function insert($sql, array $args = array()) {
        $result = $this->_do_insert_or_delete($sql, $args);
        $this->last_insert_id = $this->db->lastInsertId();
        return $result;
    }

    public function delete($sql, array $args = array()) {
        return $this->_do_insert_or_delete($sql, $args);
    }

    public function rowCount() {
        if($this->last_query instanceof PDOStatement) {
            return $this->last_query->rowCount();
        }
        return 0;
    }

    public function lastInsertId() {
        return $this->last_insert_id;
    }

    protected function _do_prepare_and_query($sql, array $args = array()) {
        $stmt = $this->db->prepare($sql);
        $stmt->execute($args);
        $this->last_query = $stmt;
        return $stmt;
    }

    protected function _do_insert_or_delete($sql, array $args = array()) {
        $stmt = $this->db->prepare($sql);
        $this->last_query = $stmt;
        return $stmt->execute($args);
    }

}