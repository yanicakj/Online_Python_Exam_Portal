<?php

    $hostname = 'sql.njit.edu';
    $username = 'am2272';
    $password = 'zy0sqcm7'; //NJIT given password
    $database = 'am2272';

    // grabbing post data
    $examnum = $_POST["examnum"];
    //$examnum = 5;
    $examscore = 0;

    // connect to db
    $conn = mysqli_connect($hostname, $username, $password, $database);
    if(!$conn) {
        die("Connection failed: " . mysqli_connect_error());
    }

    // grab answers from database for exam being graded
    $sql = "SELECT * FROM ExamLookup2 WHERE ExamNumber = $examnum";
    $result = $conn->query($sql);
    //echo "queried ExamLookup for answers<br>";
    while ($row = mysqli_fetch_assoc($result)) {

        // grab data from ExamLookup
        $qnum = $row["QuestionNumber"];
        $funcName = $row["FuncName"];
        $pnts = $row["Points"];
        $answer = (string)$row["Answer"];
        $numCorrect = 0;
        $resArray = array(0);

        // for each answer, put through grader -- need test case data
        $sql2 = "SELECT * FROM Questions WHERE QuestionNumber = $qnum";
        $result2 = $conn->query($sql2);
        $row2 = mysqli_fetch_assoc($result2);
        //echo "queried Questions for points<br>";
        $forflag = $row2["forconstraint"];
        $whileflag = $row2["whileconstraint"];
        $printflag = $row2["printconstraint"];

        // change this to loop and append() to 2 arrays -> inputarr & outputarr
        $tc_i1 = $row2["TC1"];
        $tc_i2 = $row2["TC2"];
        $tc_o1 = $row2["TR1"];
        $tc_o2 = $row2["TR2"];

        // string search Grading
        $code = (string)$row["Answer"];
        $parenSpot = strpos($code, "(");
        if ($parenSpot > 0) {
            $spaceSpot = strpos($code, " ");
            if ($spaceSpot > 0) {
                $userFuncName = substr($code, $spaceSpot+1, $parenSpot - $spaceSpot - 1);
                if ($userFuncName == $funcName) {
                    $numCorrect += 1;
                    $resArray[0] = 1;
                } else {
                    // update $answer -- fix for bad function name
                    $answer2 = "def " . $funcName . substr($answer, $parenSpot);
                    $answer = $answer2;
                }
            }
        }

        // check first 2 constraints:
        if ($forflag == 1) {
            if (strpos($answer, 'for') !== false) {
                // good!
                $numCorrect += 1;
                array_push($resArray,1);
            } else {
                // wrong!
                array_push($resArray,0);
            }
        }
        if ($whileflag == 1) {
            if (strpos($answer, 'while') !== false) {
                // good! do nothing
                $numCorrect += 1;
                array_push($resArray,1);
            } else {
                // deduct points
                array_push($resArray,0);
            }
        }

        // ------------------ test case 1 -----------------------

        // building code to place in file for test case 1
        $code = $answer . "\n\nif " . $funcName . "(" . (string)$tc_i1 .") != None: print(" . $funcName . "(" . (string)$tc_i1 ."))";
        //echo "code : " . $code . "<br>";

        // adding code to file for test case 1
        $testfile = fopen("test.py", "w");
        fwrite($testfile, $code);
        fclose($testfile);
        //echo "added text to file<br>";

        // executing file for test case 1
        $output = "";
        $rere = exec("python test.py", $output, $return_var); //2>&1
        //echo "output : " . (string)$output[0] . "<br>"; //print_r($output);
        exec("rm -r test.py");

        if ($output[0] == $tc_o1 || $rere == $tc_o1) {
            $numCorrect += 1;
            $resArray[1] = 1;
        }

        // ------------------ test case 2 -----------------------

        // building code to place in file for test case 2
        //$code2 = $answer . "\n\n" . $funcName . "(" . (string)$tc_i2 .")";
        $code2 = $answer . "\n\n" . "if " . $funcName . "(" . (string)$tc_i2 .") != None: print(" . $funcName . "(" . (string)$tc_i2 ."))";
        //echo "code : " . $code2 . "<br>";

        // adding code to file for test case 2
        $testfile2 = fopen("test.py", "w");
        fwrite($testfile2, $code2);
        fclose($testfile2);
        //echo "added text to file<br>";

        // executing file for test case 2
        $output2 = "";
        $rere2 = exec("python test.py", $output2, $return_var2); //2>&1
        //echo "output : " . (string)$output2[0] . "<br>"; //print_r($output);
        exec("rm -r test.py");

        if ($output2[0] == $tc_o2 || $rere2 == $tc_o2) {
            $numCorrect += 1;
            $resArray[2] = 1;
        }

        //echo "Number of Correct Answers for question " . (string)$qnum . ": " . (string)$numCorrect . "<br>";

        $grade = floor(((int)$numCorrect / 3) * $pnts);
        $single = floor((1/3)*$pnts);
        $examscore += $grade;
        //echo "grade : " . (string)$grade . "<br>";
        //echo "single : " . (string)$single . "<br>";
        $comments = "";
        if ($resArray[0] == 0) {
            $comments = (string)$single . " points lost for bad function name/bad formatting.";
        }
        if ($resArray[1] == 0) {
            $comments = $comments . "<br>" . (string)$single . " points lost for failing test case 1.";
        }
        if ($resArray[2] == 0) {
            $comments = $comments . "<br>" . (string)$single . " points lost for failing test case 2.";
        }

        //echo "comments : " . $comments . "<br>";

        $sql3 = "UPDATE ExamLookup2 SET Comments = '$comments' WHERE ExamNumber = $examnum AND QuestionNumber = $qnum";
        $sql3b = "UPDATE ExamLookup2 SET Grade = $grade WHERE ExamNumber = $examnum AND QuestionNumber = $qnum";
        //echo "sql3 : " . $sql3 . "<br>";
        //echo "sql3b : " . $sql3b . "<br>";
        $result3 = $conn->query($sql3);
        $result3b = $conn->query($sql3b);

    }

    // update database with exam score
    $examscore = floor($examscore); // just to be safe
    $sql4 = "UPDATE Exams SET Grade = $examscore WHERE ExamNum = $examnum";
    //echo "sql4 : " . $sql4 . "<br>";
    $result4 = $conn->query($sql4);

    //echo "Pushed exam to db" . "<br>";

    $arr = array("results" => "Success");
    echo json_encode($arr);

?>
