<?php

	$hostname = 'sql.njit.edu';
	$username = 'am2272';
	$password = 'zy0sqcm7'; //NJIT given password
	$database = 'am2272';

	$examnum = (int)trim($_POST['examnum']);
	//$examnum = 5;

	$conn = mysqli_connect($hostname, $username, $password, $database);

	if(!$conn)
	{
		die("Connection failed: " . mysqli_connect_error());
	}

	$sql = "SELECT * FROM ExamLookup2 WHERE ExamNumber = $examnum";
	$result = $conn->query($sql);

	$counter = 1;
	$div = "<h1 id='examnumber'>Exam $examnum</h1><br><br>";
	while ($row = mysqli_fetch_assoc($result)) {

		$cntstr = (string)$counter;
		//$cntstr = "1";
		$points = (string)$row["Points"];
		//$points = "0";
		$strdes = (string)$row["Description"];
        $strans = (string)$row["Answer"];
        $strgra = (string)$row["Grade"];
		$strcom = (string)$row["Comments"];
		//$strdes = "hello";
		$div = $div . "<h3>Question $cntstr, $points Points</h3><h4>$strdes</h4>";
        $div = $div . "<h5>Student answer: </h5>";
        $div = $div . "<p><pre>$strans</pre></p>";
        $div = $div . "<h3>Auto-Grade: $strgra/$points</h3>";//<h5>Final Grade:</h5><input type=\"text\" name=\"changegrade$cntstr\"><br><br>";
        //$div = $div . "<h5>Comments: <pre>$strcom</pre></h5><br><h5>Add to comments: </h5><br><input type=\"text\" name=\"professorcomment$cntstr\"><br><br>";
		$div = $div . "<h5>Comments: </h5><pre>$strcom</pre><br><h5>Add to comments: </h5><br><textarea rows=\"5\" cols=\"60\" wrap=\"soft\" id=\"professorcomment$cntstr\"></textarea><br><br>";
		$counter += 1;

	}

	$arr = array("results" => $div);
	//echo $div;
    echo json_encode($arr);
	//echo "reached the end";
?>
