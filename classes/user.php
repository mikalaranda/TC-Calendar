<?php
	require_once('database.php');
	class User{

		private $result;
		private $con;

		function __construct() {
			$db = new Database();
			$this->con = $db->connect();
			if($_POST['type'] == 'login'){
				$this->Login();
			}else if($_POST['type'] == 'register'){
				$this->Register();
			}else if($_POST['type'] == 'logout'){
				session_start();
				session_destroy();
			}
		}

		public function Login() {
			session_start();
			// let the user login
			$username = $_POST['username'];
			$password = md5($_POST['password']);

			$checklogin = mysqli_query($this->con, "SELECT * FROM users WHERE Username = '".$username."' AND Password = '".$password."'");

			if(mysqli_num_rows($checklogin) == 1)
			{
				$row = mysqli_fetch_array($checklogin);
				$email = $row['EmailAddress'];

				$_SESSION['Username'] = $username;
				$_SESSION['EmailAddress'] = $email;
				$_SESSION['LoggedIn'] = 1;

				$this->result = "Success";
			}
			else
			{
				$this->result = "Error";
			}
		}

		public function Register() {

			$table = "users";
    
    		$checkusername = mysqli_query($this->con, "SELECT * FROM users WHERE Username = '".$_POST['username']."'");
     
			if(mysqli_num_rows($checkusername) == 1)
			{
				$this->result = "Sorry, that username is taken. Please try again.";
			}
			else
			{

				if ($stmt = $this->con->prepare("INSERT INTO users(Username, Password, EmailAddress) VALUES (?,?,?)")) {

					/* bind parameters for markers */
					$stmt->bind_param("sss", $_POST['username'], md5($_POST['password']), $_POST['email']);

					/* Execute it */
					$stmt->execute();

					/* Get result */
					$this->getSubmitResult($stmt, $table, $stmt->insert_id);
					//$this->result = $stmt->error;
					//$this->result = md5($_POST['password']);
					/* Close statement */
					$stmt -> close();
				}		
			}
		}

		public function getSubmitResult($stmt, $table, $id) {
			$result = mysqli_query($this->con,"SELECT * FROM " . $table . " WHERE id = " . $id);

			$data = array();
			if(mysqli_num_rows($result) == 1)
			{
				$this->result = "Success";
			}
			else
			{
				$this->result = "Registration Failed...";
			}
			
		}

		public function getResult() {
			return $this->result;
		}
	}
?>