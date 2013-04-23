<?php

class Controller_User extends Controller_Base {
    
	protected $user;
    
	protected function _loadModels() {
		$this->user = new Model_User($this->config);
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
                $check_sql = 'SELECT * FROM user WHERE username = ?';
                $check_stmt = $this->db->prepare($check_sql);
                $check_stmt->execute(array($_POST['username']));
                if($check_stmt->rowCount() > 0) {
                    $error = 'Your chosen username already exists. Please choose another.';
                }
            }
            
            if(is_null($error)) {
                $params = array(
                    $_POST['username'],
                    $_POST['email'],
                    md5($_POST['username'] . $_POST['password']),
                );
            
                $sql = 'INSERT INTO user (username, email, password) VALUES (?, ?, ?)';
                $stmt = $this->db->prepare($sql);
                $stmt->execute($params);
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
        
        require_once $this->config['views']['layout_path'] . 'layout.phtml';
        
    }
    
    public function account() {
        $error = null;
        if (!$this->session->isAuthenticated()) {
            header("Location: /user/login");
            exit;
        }
        
        if(isset($_POST['updatepw'])) {
            if(!isset($_POST['password']) || !isset($_POST['password_check']) ||
               $_POST['password'] != $_POST['password_check']) {
                $error = 'The password fields were blank or they did not match. Please try again.';       
            }
            else {
				$this->user->changeUserPassword($this->session->username, $_POST['password']);
                $error = 'Your password was changed.';
            }
        }
        
		$details = $this->user->getUser($this->session->username);

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
        
        require_once $this->config['views']['layout_path'] . 'layout.phtml';
    }
    
    public function login() {
        $error = null;
        // Do the login
        if(isset($_POST['login'])) {
            $username = $_POST['user'];
            $password = $_POST['pass'];

			$data = $this->user->authenticate($username, $password);
			if ($data) {
				session_regenerate_id();
				$this->session->username = $data['username'];
				$this->session->authenticate();
				header('Location: /');
				exit;
			} else {
				$error = 'Your username and password combination was incorrect.';
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
        
        require_once $this->config['views']['layout_path'] . 'layout.phtml';
        
    }
    
    public function logout() {
        // Log out, redirect
		$this->session->destroy();
        header("Location: /");
    }
}
