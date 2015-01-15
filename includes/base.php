<?php 

$db = new PDO($host, $username, $userpass);
$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

// Retriving data from the database
if ($_SERVER['REQUEST_METHOD'] == 'GET') {
	// Return stuff

	try {
		$statement = $db->prepare('SELECT id, task FROM tasks');
		$statement->execute();

		$list = $statement->fetchAll(PDO::FETCH_ASSOC);
		$json = array("task" => $list);

		$jsonString = json_encode($json);

		header('Content-Type: application/json');
		
		echo $jsonString;
		
	} catch (PDOExeption $e) {
		echo "Could not retreve tasks from database";
		echo "<br> Error: " . $e;
	}

// Submitting data to the database
} else if ($_SERVER['REQUEST_METHOD'] == 'POST') {
	// Add stuff

	if ($_POST['add-item'] != null) {
		$task = $_POST['add-item'];

		$sql="INSERT INTO tasks (task) VALUES (?)";

		try {
			$statement = $db->prepare($sql);
			$statement->execute(array($task));
		} catch (PDOExeption $e) {
			echo "The task could not be inserted";
			echo "<br> Error: " . $e;
		}
	}


} else if ($_SERVER['REQUEST_METHOD'] == 'DELETE') {
	// Deleting tasks
	$delete = array();
	parse_str(file_get_contents('php://input'), $delete);
	$del_id = $delete['id'];

	$sql_delete="DELETE FROM tasks WHERE id = ?";

	try {
		$statement = $db->prepare($sql_delete);
		$statement->execute(array($del_id));
	} catch (PDOExeption $e) {
		echo "The task could not be deleted";
		echo "<br> Error: " . $e;
	}
}
