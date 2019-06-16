<?php

    $hostname = 'sql.njit.edu';
    $username = 'am2272';
    $password = 'zy0sqcm7'; //NJIT given password
    $database = 'am2272';

    // grabbing post data
    $examnum = $_POST["examnum"];
    //$examnum = 9;
    //$examnum = 5;
    $examscore = 0;

    // for exam table
    $cur = 0;

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
        $comments = "<div id=\"divq$qnum\" class=\"grouper\" style=\"margin: auto; width: 100%;\">";
        $comments = $comments . "<table style=\"margin-left: auto; margin-right: auto\" align=\"center\" border=\"1\" width=\"90%\" id=\"table$cur\" class=\"datatable\" style=\"font-size:80%\">";
        //$comments = "<table style=\"margin-left: auto; margin-right: auto\" align=\"center\" border=\"1\" width=\"90%\" id=\"table$qnum\" style=\"font-size:80%\">";

        // for each answer, put through grader -- need test case data
        $sql2 = "SELECT * FROM Questions WHERE QuestionNumber = $qnum";
        $result2 = $conn->query($sql2);
        $row2 = mysqli_fetch_assoc($result2);

        // checking flags
        $forflag = $row2["forconstraint"];
        $whileflag = $row2["whileconstraint"];
        $printflag = $row2["printconstraint"];

        // loop and append() to 2 arrays -> inputarr & outputarr
        $input_arr = array();
        $output_arr = array();
        for ($i = 1; $i <= 6; $i++) {
            if ( strlen( (string)$row2["TC".(string)$i] ) > 0 ) {
                //echo "<br> TC" . (string)$i . " : " . (string)$row2["TC".(string)$i];
                //echo "<br> TR" . (string)$i . " : " . (string)$row2["TR".(string)$i];
                array_push($input_arr, (string)$row2["TC".(string)$i]);
                array_push($output_arr, (string)$row2["TR".(string)$i]);
            }
        }

        $totalCases = 1 + sizeof($input_arr) + $whileflag + $forflag;
        $finalgrade = 0;
        // get grade single value for each test case
        //$single = (string)ceil( (double)$pnts / (double)$totalCases );
        $single = (string)floor( (double)$pnts / (double)$totalCases );
        $namepointsint = (int)$single + $pnts - ((int)$single * $totalCases);
        $namepoints = (string)$namepointsint;

        // string search Grading
        $code = (string)$row["Answer"];
        //echo "<br>code : " . $code;
        $parenSpot = strpos($code, "(");
        //$comments = $comments . "<tr><td>Points for function name/formatting : </td><td><textarea class=\"ta\" rows=\"1\" cols=\"1\">";
        $comments = $comments . "<tr><td>Points for function name/formatting : </td><td><textarea rows=\"2\" cols=\"2\">";
        if ($parenSpot > 0) {
            //echo "<br>parenspot > 0";
            $spaceSpot = strpos($code, " ");
            if ($spaceSpot > 0) {
                //echo "<br>spacespot > 0";
                $userFuncName = substr($code, $spaceSpot+1, $parenSpot - $spaceSpot - 1);
                if ($userFuncName == $funcName) {
                    //echo "<br>good func name";
                    $numCorrect += 1;
                    $finalgrade += (int)$namepoints;
                    //$comments = "<tr><td>Points for function name/formatting : </td><td><textarea rows=\"10\" cols=\"10\"></textarea></td></tr>";

                    $line_array = explode("\n", $answer);
                    if (substr($line_array[0], -1) <> ":") {
                        $line_array[0] = $line_array[0] . ":";
                        $answer = implode("\n", $line_array);

                        $comments = $comments . "0";

                    } else {
                        //echo "<br>namepoints : " . $namepoints;
                        $comments = $comments . $namepoints;

                    }

                } else {
                    // update $answer -- fix for bad function name
                    //echo "<br>bad func name";
                    $answer2 = "def " . $funcName . substr($answer, $parenSpot);
                    $answer = $answer2;
                    $comments = $comments . "0";
                }
            }
        }
        //echo "<br>out of string searcher, namepoints : " . $namepoints;
        $comments = $comments . "</textarea> / " . (string)$namepoints . " </td></tr>";
        $line_array = explode("\n", $answer);
        if (substr($line_array[0], -1) <> ":") {
            $line_array[0] = $line_array[0] . ":";
            $answer = implode("\n", $line_array);
        }

        // check for loop constraint
        if ($forflag == 1) {

            $comments = $comments . "<tr><td>Points for FOR loop constraint : </td><td><textarea rows=\"2\" cols=\"2\">";
            if (strpos($answer, 'for') !== false) {
                // good!
                $numCorrect += 1;
                $finalgrade += (int)$single;
                $comments = $comments . $single;
            } else {
                // wrong!
                $comments = $comments . "0";
            }
            $comments = $comments . "</textarea> / " . (string)$single . " </td></tr>";
        }

        // check for while constraint
        if ($whileflag == 1) {

            $comments = $comments . "<tr><td>Points for WHILE loop constraint : </td><td><textarea rows=\"2\" cols=\"2\">";
            if (strpos($answer, 'while') !== false) {
                // good! do nothing
                $numCorrect += 1;
                $finalgrade += (int)$single;
                $comments = $comments . $single;
            } else {
                // deduct points
                $extra = (strlen($comments) > 0 ? $comments . "<br>" : "");
                $comments = $comments . "0";
            }
            $comments = $comments . "</textarea> / " . (string)$single . " </td></tr>";
        }

        // executing test cases
        for ($i = 0; $i < sizeof($input_arr); $i++) {

            // building code to place in file for test case
            // check for print flag
            if ($printflag == 1) {
                $code = $answer . "\n\n" . $funcName . "(" . (string)$input_arr[$i] .")";
            } else {
                // print("Yes" if func(x) == y else "No")
                $code = $answer . "\n\nprint('Yes' if " . $funcName . "(" . (string)$input_arr[$i] .") == " . (string)$output_arr[$i] . " else 'No')";
            }

            // adding code to file for test case
            $testfile = fopen("test.py", "w");
            //echo "<br>code : " . $code;
            fwrite($testfile, $code);
            fclose($testfile);

            // setup table row for comments`
            $j = $i + 1;
            $comments = $comments . "<tr><td>Test case $j. "; //"Expected  : </td><td><textarea rows=\"10\" cols=\"10\">";

            // if answer needs to be PRINTED
            if ($printflag == 1) {

                $output = "";
                $output = shell_exec('python test.py 2>&1');

                $tempoutput = (strlen((string)trim($output)) > 0 ? trim($output) : "Nothing");

                //echo "<br>output : " . $output;
                //echo "<br>output_arr[i] : " . $output_arr[$i];

                if (is_numeric($output_arr[$i]) == false) {
                    $output = '"' . trim($output) . '"';
                    $tempoutput = '"' . trim($output) . '"';
                }

                $tempoutput = (strlen((string)trim($output)) > 0 ? trim($output) : "Nothing");

                // comment table line
                $comments = $comments .  "Expected " . trim($output_arr[$i]) . ", printed " . trim($tempoutput) . " - Points : </td><td><textarea rows=\"2\" cols=\"2\">";

                if (trim($output) == trim($output_arr[$i])) {
                    $numCorrect += 1;
                    $finalgrade += (int)$single;
                    $comments = $comments . $single;
                } else {
                    $j = $i + 1;
                    $comments = $comments . "0";
                }

            // answer needs to be RETURNED
            } else {

                // executing file for test case
                $output = array();
                $return_var = "";
                $rere = "";
                $rere = exec("python test.py 2>&1", $output, $return_var); //2>&1

                $tempoutput = (strlen((string)trim($rere)) > 0 ? trim($rere) : "Nothing");

                // setup comments table
                $comments = $comments .  "Expected " . trim($output_arr[$i]) . ", returned ";

                //echo "<br>output[0] : " . $output[0];
                //echo "<br>output[i] : " . $output_arr[$i];
                //echo "<br>rere : " . $rere;
                if ($output[0] == "Yes" || $rere == "Yes") {
                    $numCorrect += 1;
                    $finalgrade += (int)$single;
                    $comments = $comments . (string)$output_arr[$i] . " - Points : </td><td><textarea rows=\"2\" cols=\"2\">" . $single;
                } else {
                    $j = $i + 1;
                    $comments = $comments . "Something Else" . " - Points : </td><td><textarea rows=\"2\" cols=\"2\">0";
                }
            }

            $comments = $comments . "</textarea> / " . (string)$single . " </td></tr>";

            // remove test file from server
            exec("rm -r test.py");

        }

        $comments = $comments . "</table>";

        // overall points for that specific question
        //$grade = ceil(((double)$numCorrect / (double)$totalCases) * (double)$pnts);
        $grade = $finalgrade;
        // points for each test case
        //$single = ceil( (double)$pnts / (double)$totalCases );
        $examscore += $grade;

        // //validate point vals
        // if ($grade > $pnts) {
        //     $grade = $pnts;
        //     $comments = $comments .  "<br>Additional Comments : <br>Max points acheived, score was cut-off at " . (string)$grade;
        // }

        // close centering div
        $comments = $comments . "</div>";

        //echo "<br>qnum = " . (string)$qnum;
        //echo "<br>ExamNumber = " . (string)$examnum;
        //echo "<br>Comments = <br>" . (string)$comments;
        //echo "<br>Grade = " . (string)$grade;
        $sql3 = "UPDATE ExamLookup2 SET Comments = '$comments' WHERE ExamNumber = $examnum AND QuestionNumber = $qnum";
        $sql3b = "UPDATE ExamLookup2 SET Grade = $grade WHERE ExamNumber = $examnum AND QuestionNumber = $qnum";
        $result3 = $conn->query($sql3);
        $result3b = $conn->query($sql3b);

        //echo "result3 = " . (string)$result3;
        //echo "result3b = " . (string)$result3b;

        $cur += 1;

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
