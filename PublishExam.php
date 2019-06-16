<?php

    $hostname = 'sql.njit.edu';
    $username = 'am2272';
    $password = 'zy0sqcm7'; //NJIT given password
    $database = 'am2272';

    // connect to db
    $conn = mysqli_connect($hostname, $username, $password, $database);
    if(!$conn) {
        die("Connection failed: " . mysqli_connect_error());
    }

    // get point values from post
    $pointstring = $_POST["pointstring"];
    $pointarray = explode(",", $pointstring);

    // add point values to Question Table
    for ($i = 0; $i <= sizeof($pointarray)-1; $i++) {
        $arrval = $pointarray[$i];
        $exp = explode(":", $arrval);
        $pointval = $exp[1];
        $qnum1 = $exp[0];
        $sql6 = "UPDATE Questions SET Points = $pointval WHERE QuestionNumber = $qnum1";
        $result6 = $conn->query($sql6);
    }

    // get number for exam to submit
    $sql = "SELECT MAX(ExamNum) As max_num FROM Exams";
    $result = $conn->query($sql);
    $row = mysqli_fetch_assoc($result);
    $examnum = $row["max_num"] + 1;

    // insert exam into Exams table
    $curdate = "'".date("m/d/Y")."'";

    $sql2 = "INSERT INTO Exams ( ExamNum, Submitted, DateSubmitted, Grade, Feedback ) VALUES ( $examnum, 0, $curdate,  0, 0)";
    $result2 = $conn->query($sql2);

    // add bank questions to ExamLookup table
    $sql3 = "SELECT QuestionNumber, Question, Points, FuncName FROM Questions WHERE AddToExam = 1";
    $result3 = $conn->query($sql3);
    while ($row = mysqli_fetch_assoc($result3))
    {
        $qnum = (int)$row["QuestionNumber"];
        $pnts = (int)$row["Points"];
        $qdes = "'" . (string)$row["Question"] . "'";
        $funcName = "'" . (string)$row["FuncName"] . "'";
        $emptyspace = " ";
        //                                  int           int         string  int     string   int     string                // int     int   string        int         string  int string
        //$sql4 = "INSERT INTO ExamLookup ( ExamNumber, QuestionNumber, Answer, Points, Comments, Grade, Description ) VALUES ( $examnum, $qnum, $emptyspace , $pnts, $emptyspace , 0, $qdes)";
        $sql4 = "INSERT INTO ExamLookup2 VALUES ( $examnum, $qnum, ' ', $pnts, ' ' , 0, $qdes, $funcName)";
        $result4 = $conn->query($sql4);
        //echo $examnum ." ". $row["QuestionNumber"] . " " . $row["Points"] . " " . "0" . " " . $row["Question"] . "<br>";
    }

    // update all bank flags to 0
    $sql5 = "UPDATE Questions SET `AddToExam`=0";
    $result5 = $conn->query($sql5);

    $arr = array("results" => "Success");
    echo json_encode($arr);
?>
