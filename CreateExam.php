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


    // LEFT PART
    $sql = "SELECT * FROM Questions";
	$result = $conn->query($sql);
	$var = 1;
	$html = "<div id='container2'><div id='left2' style='width: 50%; float:left'>";

	//$table = "<table border='1' width='100%' id='bank'><tr><td>#</td><td>Description</td><td>Difficulty</td><td>Category</td><td>Select</td></tr>";
	$table = "<table border='1' width='100%' id='bank2' style='font-size:50%'><tr><td>#</td><td>Description</td><td>Difficulty</td><td>Category</td><td>Select</td></tr>";
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
		//$table = $table . "</tr>";
	}
	// BUTTON TO ADD TO STAGING AREA
	$table = $table . "</table>" . "<br><br><button id='addtoexam' class='btn' type='button'>Add to Exam</button><br<br><br><br>";
    //. "<br><button id='addtoexam' class=\"btn\" type=\"button\">Add to Exam</button><br<br><br><br>";
    $html = $html . $table . "</div><div id='right2' style='width: 49%; float:right; border: 3px solid black; text-align:center; font-size:100%'>";

    // RIGHT PART
    $sql = "SELECT * FROM Questions WHERE AddToExam = 1";
    $result = $conn->query($sql);
    $var = 1;

    $table = "<table border='1' width='100%' style='font-size:50%' id='makeExam'> <tr><td>#</td><td>Description</td><td>Difficulty</td><td>Category</td><td>Points</td><td>Remove?</td></tr>";
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
    	$table = $table . "<td><input type='text' style='width:50%'></td>";
        $table = $table . "<td><input type='checkbox'></td>";
    	$table = $table . "</tr>";
    }
    $html = $html . $table. "</table>" . "<br><button id='publish' class='btnNew' type='button'>Publish</button><br>";
    $html = $html . "<br>Total Points = <span id='realTimeUpdate'>0</span><br>";
    $html = $html . "<br><button id='remover' class='btnNew' type='button'>Remove</button><br><br>";
    $html = $html . "</div></div>";

    $arr = array("results" => $html);
    echo json_encode($arr);
?>
