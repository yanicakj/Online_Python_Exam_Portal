<?php
	$hostname = 'sql.njit.edu';
	$username = 'am2272';
	$password = 'zy0sqcm7'; //NJIT given password
	$database = 'am2272';

	$conn = mysqli_connect($hostname, $username, $password, $database);

	if(!$conn) {
		die("Connection failed: " . mysqli_connect_error());
	}

	$sql = "SELECT * FROM Questions";
	$result = $conn->query($sql);
	$var = 1;
	$html = "<div id='container'><div id='left' style='width: 50%; float:left'>";

	//$table = "<table border='1' width='100%' id='bank'><tr><td>#</td><td>Description</td><td>Difficulty</td><td>Category</td><td>Select</td></tr>";
	$table = "<table border='1' width='100%' id='bank' style='font-size:50%''><tr><td>#</td><td>Description</td><td>Difficulty</td><td>Category</td><td>Select</td></tr>";
	while ($row = mysqli_fetch_assoc($result))
	{
		$table = $table. "<tr>";
		foreach ($row as $field => $value)
		{
			$table = $table. "<td>" . (string)$value . "</td>";
			$var++;
			if($var == 5)

			{
				$var = 1;
				break;
			}
		}
		$table = $table . "<td><input type='checkbox'></td>";
		$table = $table . "</tr>";
	}
	// BUTTON TO ADD TO STAGING AREA
	$table = $table . "</table>" . "<br><button id='addtoexam' class=\"btn\" type=\"button\">Add to Exam</button><br<br><br><br>";
	$html = $html . $table . "</div><div id='right' style='width: 49%; float:right; border: 3px solid black; text-align:center; font-size:70%'>";

	$myfile = fopen("button1content.txt", "r") or die("Unable to open file!");
	// BUTTON TO ADD TO QUESTION BANK
	$contents = fread($myfile,filesize("button1content.txt"));
	fclose($myfile);

	$html = $html . $contents . "<br><br><br><br></div></div>";

	$arr = array("results" => $html);
	//echo $html;
	echo json_encode($arr);
?>
