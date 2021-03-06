<?php
class MasterController {
    
    private $config;
	protected $_session;
    
    public function __construct($config) {
        $this->_setupConfig($config);
		spl_autoload_register(array($this, 'autoloader'));
		$this->_configureSession();
    }
    
	public function autoloader($class) {
		$className = str_replace('_', '/', $class) . '.php';
		require_once $className;
	}

    public function execute() {
        $call = $this->_determineControllers();
        $call_class = $call['call'];
        $class = 'Controller_' . ucfirst(array_shift($call_class));
        $method = array_shift($call_class);
        $o = new $class($this->_session, $this->config);
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
    
	protected function _configureSession() {
		$config = $this->config;
		$session_config = $config['session_config'];

		$driver = $session_config['driver'];
		$session_class = 'Session_' . $driver;
		$this->_session = new $session_class($session_config);
	}

    private function _setupConfig($config) {
        $this->config = $config;
    }
    
}
