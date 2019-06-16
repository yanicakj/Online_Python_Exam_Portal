<?php

    $hostname = 'sql.njit.edu';
    $username = 'am2272';
    $password = 'zy0sqcm7'; //NJIT given password
    $database = 'am2272';

    // grab POST variables passed
    $examnum = $_POST["examnum"];
    $bigstring = $_POST["bigstring"];
    $bigarray= explode(",!%+", $bigstring);

    // connect to db
    $conn = mysqli_connect($hostname, $username, $password, $database);
    if(!$conn) {
        die("Connection failed: " . mysqli_connect_error());
    }

    // add answers values to ExamLookup Table
    for ($i = 0; $i <= sizeof($bigarray)-1; $i++) {
        $arrval = $bigarray[$i];
        $exp = explode(",!%-", $arrval);
        $answer = $exp[1];
        $question = $exp[0];
        $question2 = substr($question, 2, strlen($question) - 4);
        $answer = addslashes($answer);
        $sql = "UPDATE ExamLookup2 SET Answer = '$answer' WHERE Description LIKE '%$question2%' AND ExamNumber = $examnum";
        $result = $conn->query($sql);
    }

    // update Exams submitted field to 1 from 0
    $sql2 = "UPDATE Exams SET Submitted = 1 WHERE ExamNum = $examnum";
    $result2 = $conn->query($sql2);

    $arr = array("results" => "Success");
    echo json_encode($arr);

?>
