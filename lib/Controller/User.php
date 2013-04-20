<?php

class Controller_User {
    
    protected $db;
    protected $config;
    protected $session;
    protected $user_model;
    
    public function __construct(array $config,Database_Abstract $db, Session_Interface $session) {
        $this->config=$config;
        $this->db=$db;
        $this->session=$session;

        $this->user_model=new Model_User($this->config,$this->db);

    }
    
    public function create() {
        $error = null;
        
        // Do the create
        if(isset($_POST['create'])) {
            if(empty($_POST['username']) || empty($_POST['email']) ||
               empty($_POST['password']) || empty($_POST['password_check'])) {
                $error = 'You did not fill in all required fields.';
            }
            
            if(is_null($error)) {
                if(!filter_input(INPUT_POST, 'email', FILTER_VALIDATE_EMAIL)) {
                    $error = 'Your email address is invalid';
                }
            }
            
            if(is_null($error)) {
                if($_POST['password'] != $_POST['password_check']) {
                    $error = "Your passwords didn't match.";
                }
            }
            
            if(is_null($error)) {
                if($this->user_model->checkUsername($_POST['username']) > 0) {
                    $error = 'Your chosen username already exists. Please choose another.';
                }
            }
            
            if(is_null($error)) {
                $params = array(
                    $_POST['username'],
                    $_POST['email'],
                    $_POST['password']
                );
            
                $this->user_model->createUser($params);
                header("Location: /user/login");
                exit;
            }
        }
        // Show the create form
        
        $content = '
            <form method="post">
                ' . $error . '<br />
                <label>Username</label> <input type="text" name="username" value="" /><br />
                <label>Email</label> <input type="text" name="email" value="" /><br />
                <label>Password</label> <input type="password" name="password" value="" /><br />
                <label>Password Again</label> <input type="password" name="password_check" value="" /><br />
                <input type="submit" name="create" value="Create User" />
            </form>
        ';
        
        require_once $this->config['views']['layout_path'].'/layout.phtml';
        
    }
    
    public function account() {
        $error = null;
        if(!$this->session->get('authed')) {
            header("Location: /user/login");
            exit;
        }
        
        if(isset($_POST['updatepw'])) {
            if(!isset($_POST['password']) || !isset($_POST['password_check']) ||
               $_POST['password'] != $_POST['password_check']) {
                $error = 'The password fields were blank or they did not match. Please try again.';       
            }
            else {
                $this->user_model->changeUserPassword($this->session->get('username'),$_POST['password']);
                $error = 'Your password was changed.';
            }
        }
        
        $details = $this->user_model->getUserData($this->session->get('username'));
        
        $content = '
        ' . $error . '<br />
        
        <label>Username:</label> ' . $details['username'] . '<br />
        <label>Email:</label>' . $details['email'] . ' <br />
        
         <form method="post">
                ' . $error . '<br />
            <label>Password</label> <input type="password" name="password" value="" /><br />
            <label>Password Again</label> <input type="password" name="password_check" value="" /><br />
            <input type="submit" name="updatepw" value="Create User" />
        </form>';
        
        require_once $this->config['views']['layout_path'].'/layout.phtml';
    }
    
    public function login() {
        $error = null;
        // Do the login
        if(isset($_POST['login'])) {
            $username = $_POST['user'];
            $password = $_POST['pass'];
            $auth_result=$this->user_model->authenticateUser($username,$password);

            if($auth_result['authenticated'] > 0) {
               $this->session->regenerate();

               $this->session->set('username',$auth_result['user']['username']);
               $this->session->set('authed',true);

               header("Location: /");
               exit;
            }
            else {
                $error = 'Your username/password did not match.';
            }
        }
        
        $content = '
            <form method="post">
                ' . $error . '<br />
                <label>Username</label> <input type="text" name="user" value="" />
                <label>Password</label> <input type="password" name="pass" value="" />
                <input type="submit" name="login" value="Log In" />
            </form>
        ';
        
        require_once $this->config['views']['layout_path'].'/layout.phtml';
        
    }
    
    public function logout() {
        // Log out, redirect
        $this->session->destroy();
        header("Location: /");
    }
}