<?php

class MasterController {

    protected $config;
    protected $db;
    protected $session;



    public function __construct(array $config) {

        spl_autoload_register(array($this, 'autoloader'));

        $this->_setupConfig($config);
        $this->_setupDb($config);
        $this->_setupSession($config);
    }

    public function autoloader($class) {
        $className = str_replace('_', '/', $class);
        $className = $className . '.php';
        require_once $className;
    }


    public function execute() {
        $call = $this->_determineControllers();
        $call_class = $call['call'];
        $class = "Controller_".ucfirst(array_shift($call_class));
        $method = array_shift($call_class);
        $o = new $class($this->config,$this->db,$this->session);
        return $o->$method();
    }

    private function _determineControllers()
    {
        if (isset($_SERVER['REDIRECT_BASE'])) {
            $rb = $_SERVER['REDIRECT_BASE'];
        } else {
            $rb = '';
        }

        $ruri = $_SERVER['REQUEST_URI'];
        $path = str_replace($rb, '', $ruri);
        $return = array();

        foreach($this->config['routes'] as $k => $v) {
            $matches = array();
            $pattern = '$' . $k . '$';
            if(preg_match($pattern, $path, $matches))
            {
                $controller_details = $v;
                $path_string = array_shift($matches);
                $arguments = $matches;
                $controller_method = explode('/', $controller_details);
                $return = array('call' => $controller_method);
            }
        }

        return $return;
    }

    private function _setupConfig(array $config) {
        $this->config = $config;
    }

    private function _setupDb(array $config) {
        switch ($config['database']['driver']) {
            default: // defaults to mysql
                $this->db=new Database_Mysql($config);
                break;
        }

    }

    private function _setupSession(array $config) {
        switch ($config['session']['driver']) {
            default: // defaults to PHP built in sessions
                $this->session=new Session_Php();
                break;
        }
    }

}