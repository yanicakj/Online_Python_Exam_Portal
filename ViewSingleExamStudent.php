<?php

	$hostname = 'sql.njit.edu';
	$username = 'am2272';
	$password = 'zy0sqcm7'; //NJIT given password
	$database = 'am2272';

	$examnum = (int)trim($_POST['examnum']);
	//$examnum = 1;

	$conn = mysqli_connect($hostname, $username, $password, $database);

	if(!$conn)
	{
		die("Connection failed: " . mysqli_connect_error());
	}

	$sql = "SELECT Points, Description FROM ExamLookup2 WHERE ExamNumber = $examnum";
	$result = $conn->query($sql);

	$counter = 1;
	$div = "<h1 id='examnumber'>Exam $examnum</h1><br><br>";
	while ($row = mysqli_fetch_assoc($result)) {

		$cntstr = (string)$counter;
		//$cntstr = "1";
		$points = (string)$row["Points"];
		//$points = "0";
		$strdes = (string)$row["Description"];
		//$strdes = "hello";
		$div = $div . "<h5>Question $cntstr, $points Points</h5><p>$strdes</p>";
		$div = $div . "<textarea rows=\"30\" cols=\"70\">Enter your code here!</textarea><br><br>";
		$counter += 1;

	}

	$arr = array("results" => $div);
	echo json_encode($arr);
	//echo "reached the end";
?>
