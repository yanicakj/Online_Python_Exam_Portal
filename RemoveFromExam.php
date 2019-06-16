<?php
    $hostname = 'sql.njit.edu';
    $username = 'am2272';
    $password = 'zy0sqcm7'; //NJIT given password
    $database = 'am2272';

    $conn = mysqli_connect($hostname, $username, $password, $database);

    $getArray = $_POST['numArray'];

    $questionsArray = explode(',', $getArray);

    foreach($questionsArray as $num)
    {
    	$mystr = "UPDATE Questions SET AddToExam = 0 WHERE QuestionNumber = $num";
    	$result = $conn->query($mystr);
    }

    $arr = array("results" => "Success");
    echo json_encode($arr);
?>
