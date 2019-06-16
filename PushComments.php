<?php

    $hostname = 'sql.njit.edu';
    $username = 'am2272';
    $password = 'zy0sqcm7'; //NJIT given password
    $database = 'am2272';

    // grab POST variables passed
    $examnum = $_POST["examnum"];
    //$examnum = 5;
    $bigstring = $_POST["bigstring"];
    //$bigstring = "Write a function named doubleIt that doubles an integer input.,!%-25,!%+good job!,!%=Write a function named tripleIt that takes an integer input and triples it.,!%-good job!,!%+55";
    $bigarray= explode(",!%=", $bigstring);

    //echo "<br>bigstring : " . $bigstring . "<br><br>";

    // connect to db
    $conn = mysqli_connect($hostname, $username, $password, $database);
    if(!$conn) {
        die("Connection failed: " . mysqli_connect_error());
    }

    $sql4 = "SELECT * FROM ExamLookup2 WHERE ExamNumber = $examnum";
    $result4 = $conn->query($sql4);
    $row = mysqli_fetch_assoc($result4);
    //echo "sql4 : " . $sql4 . "<br>";

    $newtotal = 0;
    // add answers values to ExamLookup Table
    for ($i = 0; $i <= sizeof($bigarray)-1; $i++) {

        // question verbiage ,!%- comments ,!%+ new points ,!%=

        $arrval = $bigarray[$i];
        //echo "arrval : " . $arrval . "<br>";
        $exp = explode(",!%-", $arrval);
        $question = $exp[0];
        $gradeNcomment = $exp[1];
        //echo "gradeNcomment : " . $gradeNcomment . "<br>";
		$exp2 = explode(",!%+", $gradeNcomment);
		$grade = (int)$exp2[1];
        $comment = $exp2[0];

        // setting new info
        $question2 = substr($question, 2, strlen($question) - 4);
        $newtotal += (int)$grade;

        // getting old comments
        //$sql7 = "SELECT Comments FROM ExamLookup2 WHERE ExamNumber = $examnum AND Description LIKE '%$question2%'";
        //$result7 = $conn->query($sql7);
        //$row7 = mysqli_fetch_assoc($result7);
        //$oldcom = $row7["Comments"];
        //$comment2 = $oldcom . "\n" . $comment;

        // echo "examnum : " . (string)$examnum . "<br>";
        // echo "question2 : " . $question2 . "<br>";
        // echo "comment2 : " . $comment2 . "<br>";
        // echo "grade : " . (string)$grade . "<br>";
		//$sql = "UPDATE ExamLookup2 SET Comments = '$comment2' WHERE Description LIKE '%$question2%' AND ExamNumber = $examnum";
        $sql = "UPDATE ExamLookup2 SET Comments = '$comment' WHERE Description LIKE '%$question2%' AND ExamNumber = $examnum";
        $result = $conn->query($sql);
		$sql2 = "UPDATE ExamLookup2 SET Grade = $grade WHERE Description LIKE '%$question2%' AND ExamNumber = $examnum";
		$result2 = $conn->query($sql2);
        // echo "sql : " . $sql . "<br>";
        // echo "sql2 : " . $sql2 . "<br>";
    }

    // update Exams submitted field to 1 from 0
    $sql3 = "UPDATE Exams SET Feedback = 1 WHERE ExamNum = $examnum";
    $result3 = $conn->query($sql3);
    $sql5 = "UPDATE Exams SET Grade = $newtotal WHERE ExamNum = $examnum";
    $result5 = $conn->query($sql5);
    //echo "sql3 : " . $sql3 . "<br>";

    $arr = array("results" => "Success");
    echo json_encode($arr);

?>
