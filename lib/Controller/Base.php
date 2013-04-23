<?php

abstract class Controller_Base {
    
	protected $config = array();
	protected $session;
    
    public function __construct(Model_Session_Interface $session, array $config = array()) {
		$this->config = $config;
		$this->session = $session;
		$this->_loadModels();
    }

	abstract protected function _loadModels();
}
