<?php
class Database_Interface {
	public function fetchOne($sql, $args = array()) {}

	public function fetchAll($sql, $args = array()) {}

	public function insert($sql, $args = array()) {}

	public function getError() {}

	public function delete($sql, $args = array()) {}

	public function rowCount() {}

	public function lastInsertId() {}

	protected function _do_prepare_and_query($sql, $args = array()) {}

	protected function _do_insert_or_delete($sql, array $args = array()) {}
}
