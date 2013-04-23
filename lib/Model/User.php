<?php

class Model_User extends Model_Base {
    
    public function createUser($username, $email, $password, $pass_confirm) {
        $error = null;
        
		if (count(array_filter(func_get_args(), 'empty'))) {
			$error = 'You did not fill in all required fields.';
		}

		if (!$error) {
			if (!filter_input(INPUT_POST, 'email', FILTER_VALIDATE_EMAIL)) {
				$error = 'Your email address is invalid';
			}
		}
		
		if (!$error) {
			if ($password != $pass_confirm) {
				$error = 'Your passwords do not match.';
			}
		}

		if (!$error) {
			if ($this->checkUsername($username)) {
				$error = 'Your chosen username already exists. Please choose another.';
			}
		}

		if (!$error) {
			$params = array($username, $email, md5($username . $password));

			$sql = 'INSERT INTO user (username, email, password) VALUES (?, ?, ?)';
			$stmt = $this->db->prepare($sql);
			$stmt->execute($params);

			if ($err = $this->db->getError()) {
				return $err;
			}
			return true;
        }

		return $error;
    }

	public function checkUsername($username) {
		if ($this->getUser($username)) {
			return true;
		} else {
			return false;
		}
	}
    
	public function getUser($username) {
		$sql = 'SELECT * FROM user WHERE username = ?';
		$user = $this->db->fetchOne($sql, $username);
		return $user;
	}

	public function authenticate($username, $password) {
		$password = md5($username . $password);
		$sql = 'SELECT * FROM user WHERE username = ? AND password = ? LIMIT 1';
		$user = $this->db->fetchOne($sql, array($username, $password));
		if ($this->db->rowCount()) {
			return $user;
		} else {
			return false;
		}
	}

	public function changePassword($username, $password) {
		$sql = 'UPDATE user SET password = ? WHERE username = ?';
		$stmt = $this->db->prepare($sql);
		$stmt->execute($password, $username);

		if ($err = $this->db->getError()) {
			return $err;
		}
		return true;
	}
}
