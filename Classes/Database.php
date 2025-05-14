<?php
    class Database
    {
        private $conn;
        private static $instance = null;

        public static function getInstance()
        {
            if(self::$instance == null)
                self::$instance = new Database();

            return self::$instance;
        }

        private function __construct()
        {
            $this->conn = new mysqli("127.0.0.1","root","","tech_care");
        }

        public function getUserByID($ID)
        {
            $query = "SELECT * FROM users WHERE ID = ?";

            $stmt = $this->conn->prepare($query);
            $stmt->bind_param("i",$ID);
            $stmt->execute();

            $ris = $stmt->get_result();

            if($ris->num_rows == 1)
            {
                $tupla = $ris->fetch_assoc();
                return new User($tupla['ID'],$tupla['username'],$tupla['role'],$tupla['email'],$tupla['avatar_url']);
            }

            return null;
        }

        public function doSignup($username,$email,$password)
        {
            $response = [
                'status' => 'error',
                'message' => 'Registrazione fallita!'
            ];

            $query = "INSERT INTO users (username,email,password) VALUES (?,?,?)";

            $stmt = $this->conn->prepare($query);
            $stmt->bind_param("sss",$username,$email,$password);
            $stmt->execute();

            if($stmt->affected_rows == 1)
            {
                $response['status'] = "success";
                $response['message'] = "Registrazione avvenuta con successo!";
            }

            return $response;
        }

        public function checkSignup($username,$email)
        {
            $response = [
                'status' => 'error',
                'message' => null
            ];

            $query = "SELECT * FROM users WHERE email = ?";

            $stmt = $this->conn->prepare($query);
            $stmt->bind_param("s",$email);
            $stmt->execute();

            $ris = $stmt->get_result();

            if($ris->num_rows != 0)
            {
                $response['message'] = "Email già in uso!";
                return $response;
            }

            $query = "SELECT * FROM users WHERE username = ?";

            $stmt = $this->conn->prepare($query);
            $stmt->bind_param("s",$username);
            $stmt->execute();

            $ris = $stmt->get_result();

            if($ris->num_rows != 0)
            {
                $response['message'] = "Username già in uso!";
                return $response;
            }

            $response['status'] = "success";
            return $response;
        }

        public function doLogin($username,$password)
        {   
            $response = [
                'status' => 'error',
                'user' => null,
                'message' => null
            ];

            $user = null;

            $query = "SELECT * FROM users WHERE username = ? AND password = ?";

            $stmt = $this->conn->prepare($query);
            $stmt->bind_param("ss",$username,$password);
            $stmt->execute();

            $ris = $stmt->get_result();

            if($ris->num_rows == 1)
            {
                $tupla = $ris->fetch_assoc();
                $user = new User($tupla['ID'],$tupla['username'],$tupla['role'],$tupla['email'],$tupla['avatar_url']);
                $response['status'] = "success";
                $response['user'] = $user;
                $response['message'] = "Benvenuto ".$user->getUsername()."!";
            }

            return $response;
        }

        public function updateUsername($ID,$username)
        {
            $response = [
                'new_user'=> null,
                'status' => 'error',
                'message' => null
            ];

            $query = "UPDATE users SET username = ? WHERE ID = ?";

            $stmt = $this->conn->prepare($query);
            $stmt->bind_param("si",$username,$ID);
            $stmt->execute();

            if($stmt->affected_rows == 1)
            {
                $response['new_user'] = $this->getUserByID($ID);
                $response['status'] = "success";
                $response['message'] = "Username aggiornato con successo!";
            }

            return $response;
        }

        public function updatePassword($ID,$password,$confirmed_password)
        {
            $response = [
                'new_user'=> null,
                'status' => 'error',
                'message' => null
            ];

            if($password != $confirmed_password)
                return $response;

            $query = "UPDATE users SET password = ? WHERE ID = ?";

            $stmt = $this->conn->prepare($query);
            $stmt->bind_param("si",$password,$ID);
            $stmt->execute();

            if($stmt->affected_rows == 1)
            {
                $response['new_user'] = $this->getUserByID($ID);
                $response['status'] = "success";
                $response['message'] = "Username aggiornato con successo!";
            }

            return $response;
        }

        public function updateEmail($ID,$email)
        {
            $response = [
                'new_user'=> null,
                'status' => 'error',
                'message' => null
            ];

            $query = "UPDATE users SET email = ? WHERE ID = ?";

            $stmt = $this->conn->prepare($query);
            $stmt->bind_param("si",$email,$ID);
            $stmt->execute();

            if($stmt->affected_rows == 1)
            {
                $response['new_user'] = $this->getUserByID($ID);
                $response['status'] = "success";
                $response['message'] = "Username aggiornato con successo!";
            }

            return $response;
        }

        public function updateAvatar($ID,$avatar_url)
        {
            $response = [
                'new_user'=> null,
                'status' => 'error',
                'message' => null
            ];

            $query = "UPDATE users SET avatar_url = ? WHERE ID = ?";

            $stmt = $this->conn->prepare($query);
            $stmt->bind_param("si",$avatar_url,$ID);
            $stmt->execute();

            if($stmt->affected_rows == 1)
            {
                $response['new_user'] = $this->getUserByID($ID);
                $response['status'] = "success";
                $response['message'] = "Avatar aggiornato con successo!";
            }

            return $response;
        }

        public function getAvatar($ID)
        {
            $query = "SELECT avatar_url FROM users WHERE ID = ?";

            $stmt = $this->conn->prepare($query);
            $stmt->bind_param("i",$ID);
            $stmt->execute();

            $ris = $stmt->get_result();

            if($ris->num_rows == 1)
            {
                $tupla = $ris->fetch_assoc();
                return $tupla['avatar_url'];
            }

            return null;
        }

        public function verifyPassword($ID,$password)
        {
            $query = "SELECT * FROM users WHERE ID = ? AND password = ?";

            $stmt = $this->conn->prepare($query);
            $stmt->bind_param("is",$ID,$password);
            $stmt->execute();

            $ris = $stmt->get_result();

            if($ris->num_rows == 1)
                return true;

            return false;
        }
    }
?>