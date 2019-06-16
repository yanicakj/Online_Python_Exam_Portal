<?php

	$hostname = 'sql.njit.edu';
	$username = 'am2272';
	$password = 'zy0sqcm7'; //NJIT given password
	$database = 'am2272';

	$examnum = (int)trim($_POST['examnum']);
	//$examnum = 22;

	$conn = mysqli_connect($hostname, $username, $password, $database);

	if(!$conn)
	{
		die("Connection failed: " . mysqli_connect_error());
	}

	$sql = "SELECT * FROM ExamLookup2 WHERE ExamNumber = $examnum";
	$result = $conn->query($sql);

	$sql2 = "SELECT * FROM Exams WHERE ExamNum = $examnum";
	$result2 = $conn->query($sql2);
	$row2 = mysqli_fetch_assoc($result2);
	$examgrade = (string)$row2["Grade"];

	// $cntstr = (string)$counter;
	// //$cntstr = "1";
	// $points = (string)$row["Points"];
	// //$points = "0";
	// $strdes = (string)$row["Description"];
	// $strans = (string)$row["Answer"];
	// $strgra = (string)$row["Grade"];
	// $strcom = (string)$row["Comments"];
	// //$strdes = "hello";
	// $div = $div . "<h3>Question $cntstr, $points Points</h3><h4>$strdes</h4>";
	// $div = $div . "<h5>Student answer: </h5>";
	// $div = $div . "<p><pre>$strans</pre></p>";
	// $div = $div . "<h3>Auto-Grade: $strgra/$points</h3>";//<h5>Final Grade:</h5><input type=\"text\" name=\"changegrade$cntstr\"><br><br>";
	// //$div = $div . "<h5>Comments: <pre>$strcom</pre></h5><br><h5>Add to comments: </h5><br><input type=\"text\" name=\"professorcomment$cntstr\"><br><br>";
	// $div = $div . "<h5>Comments: <pre>$strcom</pre></h5><br><h5>Add to comments: </h5><br><textarea rows=\"5\" cols=\"60\" wrap=\"soft\" id=\"professorcomment$cntstr\"></textarea><br><br>";
	// $counter += 1;

	$counter = 1;
	//$table = "<table border='1' width='100%' id='feedbackTable'><tr><td>Question Number</td><td>Question</td><td>Answer</td><td>Grade</td><td>Feedback</td></tr>";
	$html = "<div id='resDiv'><h1>Exam " . (string)$examnum . " Results : $examgrade %</h1>";
	while ($row = mysqli_fetch_assoc($result))
	{
		$cntstr = (string)$counter;
		$description = (string)$row["Description"];
		$answer = (string)$row["Answer"];
		$grade = (string)$row["Grade"];
		$points = (string)$row["Points"];
		$comments = (string)$row["Comments"];
		$comments = str_replace("<textarea rows=\"2\" cols=\"2\">", " ", $comments);
		$comments = str_replace("</textarea>", " ", $comments);
		//$table = $table . "<tr><td>$cntstr</td><td>$description</td><td>$answer</td><td>$grade</td><td>$comments</td></tr>";
		$html = $html . "<h3>Question $cntstr, $grade/$points Points</h3><h4>$strdes</h4>";
		$html = $html . "<h5>Your answer: </h5>" . "<p><pre>$answer</pre></p>";
		$html = $html . "<h5><pre>$comments</pre></h5><br>";
		$counter += 1;
	}
	$html = $html . "</div>";

	//$table = $table  . "</table>";

	$arr = array("results" => $html);
	echo json_encode($arr);
?>
