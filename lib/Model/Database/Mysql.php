<?php
class Model_Database_Mysql {
	protected $config;
	protected $db;
	protected $last_query;
	protected $insert_id = 0;

	public function __construct($config) {
		$this->config = $config;
		$dbconfig = $config['database'];
		$dsn = 'mysql:host=' . $dbconfig['host'] . ';dbname=' . $dbconfig['name'];
		$this->db = new PDO($dsn, $dbconfig['user'], $dbconfig['pass']);
		$this->db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
	}

	public function fetchOne($sql, $args = array()) {
		$stmt = $this->_do_prepare_and_query($sql, $args);
		return $stmt->fetch(PDO::FETCH_ASSOC);
	}

	public function fetchAll($sql, $args = array()) {
		$stmt = $this->_do_prepare_and_query($sql, $args);
		return $stmt->fetchAll(PDO::FETCH_ASSOC);
	}

	public function insert($sql, $args = array()) {
		$result = $this->_do_insert_or_delete($sql, $args);
		$this->last_insert_id = $this->db->lastInsertId();
		return $result;
	}

	public function getError() {
		if ($this->last_query->errorCode()) {
			$error = $this->last_query->errorInfo();
			return $error[2];
		}
		return false;
	}

	public function delete($sql, $args = array()) {
		return $this->_do_insert_or_delete($sql, $args);
	}

	public function rowCount() {
		if ($this->last_query instanceof PDOStatement) {
			return $this->last_query->rowCount();
		}
		return 0;
	}

	public function lastInsertId() {
		return $this->last_insert_id;
	}

	protected function _do_prepare_and_query($sql, $args = array()) {
		if (!is_array($args)) {
			$args = array($args);
		}

		$stmt = $this->db->prepare($sql);
		$stmt->execute($args);
		$this->last_query = $stmt;
		return $stmt;
	}

	protected function _do_insert_or_delete($sql, array $args = array()) {
		if (!is_array($args)) {
			$args = array($args);
		}

		$stmt = $this->db->prepare($sql);
		$this->last_query = $stmt;
		return $stmt->execute($args);
	}
}
