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

	$sql = "SELECT ExamNum, DateSubmitted, Grade FROM Exams WHERE Feedback = 1";
	$result = $conn->query($sql);

	// top table - graded exams
	$table = "<table border='1' width='100%' id='availableexams'><tr><td>Exam Number</td><td>Date Submitted</td><td>Grade</td><td>Select</td></tr>";
	while ($row = mysqli_fetch_assoc($result))
	{
		$exNumber = (string)$row["ExamNum"];
		$dateSub = $row["DateSubmitted"];
		$grade = (string)$row["Grade"];
		$table = $table . "<tr><td>" . $exNumber . "</td><td>" . $dateSub . "</td><td>" . $grade . "</td><td><input type='checkbox'></td></tr>";
	}
	$table = $table . "</table>";

	$sql2 = "SELECT ExamNum, DateSubmitted FROM Exams WHERE Feedback = 0 AND Submitted = 1";
	$result2 = $conn->query($sql2);

	// bottom table - pending exams
	$table = $table . "<br><h3>Pending Exams</h3><br><table border='1' width='100%' id='pending'><tr><td>Exam Number</td><td>Date Submitted</td></tr>";
	while ($row = mysqli_fetch_assoc($result2))
	{
		$exNumber = (string)$row["ExamNum"];
		$dateSub = $row["DateSubmitted"];
		$table = $table . "<tr><td>" . $exNumber . "</td><td>" . $dateSub . "</td></tr>";

	}
	$table = $table. "</table>";

	$arr = array("results" => $table);
	echo json_encode($arr);
?>
