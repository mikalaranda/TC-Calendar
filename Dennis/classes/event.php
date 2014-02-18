<?php
	require_once('database.php');
	class Event {

		private $result;
		private $con;
		function __construct() {
			$db = new Database();
			$this->con = $db->connect();
			if($_POST['type'] == 'drop'){
				$this->Drop();
			}
			else if($_POST['type'] == 'resize'){
				$this->Resize();
			}
			else if($_POST['type'] == 'submit'){
				$this->Submit();
			}
		}

		public function Submit() {

			if($_POST['update'] == '0')
			{
				if ($stmt = $this->con->prepare("INSERT INTO events (title, start, end, URL, allDay) VALUES (?, ?, ?, ?, ?)")) {

				    /* bind parameters for markers */
				    $stmt->bind_param("sssss", $_POST['title'],$_POST['start'],$_POST['end'],$_POST['url'],$_POST['allDay']);

					/* Execute it */
					$stmt->execute();

					/* Close statement */
					$stmt -> close();
				}	
			}else{
				if ($stmt = $this->con->prepare("UPDATE events SET title = ?, start = ?, end = ?, URL = ?, allDay = ? where id = ?")) {

				    /* bind parameters for markers */
				    $stmt->bind_param("ssssss", $_POST['title'],$_POST['start'],$_POST['end'],$_POST['url'],$_POST['allDay'], $_POST['update']);

					/* Execute it */
					$stmt->execute();

					/* Close statement */
					$stmt -> close();
				}	

			}

		}

		public function Drop() {
			$query = "UPDATE events SET start = DATE_ADD(start, INTERVAL " . $_POST['dayDelta'] . " DAY),
				end = DATE_ADD(end, INTERVAL " . $_POST['dayDelta'] . " DAY)
				WHERE events.id = " . $_POST['id'];
			$this->submitQuery($query);
		}

		public function Resize() {
			$query = "UPDATE events SET	end = DATE_ADD(end, INTERVAL " . $_POST['dayDelta'] . " DAY)
				WHERE events.id = " . $_POST['id'];	
			$this->submitQuery($query);
		}

		public function submitQuery($query) {
			$ok = mysqli_query($this->con,$query) or die(mysqli_error($con));
			if ($ok){ 
				$this->result = "The operation was a success!"; 
			}
			mysqli_close($this->con);
		}

		public function getResult() {
			return $this->result;
		}
	}
?>