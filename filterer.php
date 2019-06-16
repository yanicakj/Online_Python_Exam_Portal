<?php
	$hostname = 'sql.njit.edu';
	$username = 'am2272';
	$password = 'zy0sqcm7'; //NJIT given password
	$database = 'am2272';

	$type = $_POST['type'];
	$value = $_POST['value'];

	$conn = mysqli_connect($hostname, $username, $password, $database);

	if(!$conn)
	{
		die("Connection failed: " . mysqli_connect_error());
	}

	if ($type == "difficulty") {
		$sql = "SELECT * FROM Questions WHERE difficulty like '%$value%'";
	} else if ($type = "category") {
		$sql = "SELECT * FROM Questions WHERE category like '%$value%'";
	} else if ($type = "search") {
		$sql = "SELECT * FROM Questions WHERE Question like '%$value%'";
	}

	$result = $conn->query($sql);

	$var = 1;
	//$table = "<table border='1' width='100%' id='bank'><tr><td>#</td><td>Description</td><td>Difficulty</td><td>Category</td><td>Select</td></tr>";
	$table = "<table border='1' width='100%' style='font-size:50%' id='bank'><tr><td>#</td><td>Description</td><td>Difficulty</td><td>Category</td></tr>";
	while ($row = mysqli_fetch_assoc($result))
	{
		$table = $table. "<tr>";
		foreach ($row as $field => $value)
		{
			$table = $table. "<td>" . (string)$value . "</td>";
			$var++;
			if ($var == 5) {
				$var = 1;
				break;
			}
		}
		//$table = $table . "<td><input type='checkbox'></td>";
		$table = $table. "</tr>";
	}
	$table = $table. "</table>";

	$arr = array("results" => $table);
	echo json_encode($arr);
?>
