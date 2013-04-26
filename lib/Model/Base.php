<?php
class Model_Base {
	protected $config;
	protected $db;

	public function __construct($config) {
		$this->config = $config;
		$this->db = new Database_Mysql($config);
	}
}
