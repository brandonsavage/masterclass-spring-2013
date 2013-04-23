<?php
class Model_Base {
	protected $config;
	protected $db;

	public function __construct($config) {
		$this->config = $config;
		$this->db = new Model_Database_Mysql($config);
	}
}
