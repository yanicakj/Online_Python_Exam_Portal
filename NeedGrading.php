<?php
	$hostname = 'sql.njit.edu';
	$username = 'am2272';
	$password = 'zy0sqcm7'; //NJIT given password
	$database = 'am2272';

	$conn = mysqli_connect($hostname, $username, $password, $database);

	if(!$conn)
	{
		die("Connection failed: " . mysqli_connect_error());
	}

	$sql = "SELECT * FROM Exams WHERE Submitted = 1 AND Feedback = 0";
	$result = $conn->query($sql);

	// top table - graded exams
	$table = "<table border='1' width='100%' id='needgrading'><tr><td>Exam Number</td><td>Date Submitted</td><td>Select</td></tr>";
	while ($row = mysqli_fetch_assoc($result))
	{
		$exNumber = (string)$row["ExamNum"];
		$dateSub = $row["DateSubmitted"];
		$table = $table . "<tr><td>" . $exNumber . "</td><td>" . $dateSub . "</td><td><input type='checkbox'></td></tr>";
	}
	$table = $table . "</table>";


	$arr = array("results" => $table);
	echo json_encode($arr);
?>
