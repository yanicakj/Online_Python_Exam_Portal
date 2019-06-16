<?php

    $ucid = 'professor';
    $upassword = '12345';
    $hashed = hash('sha512', $upassword);

    $hostname = 'sql.njit.edu';
    $username = 'am2272';
    $password = 'zy0sqcm7'; //NJIT given password
    $database = 'am2272';

    // database field values form post
    $question = $_POST['question'];
    $difficulty = $_POST['difficulty'];
    $category = $_POST['category'];

    // $tc1_input = intval($_POST['tc1_input']);
    // $tc1_output = intval($_POST['tc1_output']);
    // $tc2_input = intval($_POST['tc2_input']);
    // $tc2_output = intval($_POST['tc2_output']);

    $tc1_input = $_POST['tc1_input'];
    $tc1_output = $_POST['tc1_output'];
    $tc2_input = $_POST['tc2_input'];
    $tc2_output = $_POST['tc2_output'];
    $tc3_input = $_POST['tc3_input'];
    $tc3_output = $_POST['tc3_output'];
    $tc4_input = $_POST['tc4_input'];
    $tc4_output = $_POST['tc4_output'];
    $tc5_input = $_POST['tc5_input'];
    $tc5_output = $_POST['tc5_output'];
    $tc6_input = $_POST['tc6_input'];
    $tc6_output = $_POST['tc6_output'];

    $forconstraint = $_POST['forconstraint'];
    $whileconstraint = $_POST['whileconstraint'];
    $printconstraint = $_POST['printconstraint'];

    $fc = ($forconstraint == "Yes" ? 1 : 0);
    $wc = ($whileconstraint == "Yes" ? 1 : 0);
    $pc = ($printconstraint == "Yes" ? 1 : 0);

    $funcName = $_POST['funcName'];

    $conn = mysqli_connect($hostname, $username, $password, $database);

    if(!$conn) {
    	die("Connection failed: " . mysqli_connect_error());
    }

    $sql = "SELECT MAX(QuestionNumber) FROM Questions";
    $result = $conn->query($sql);

    while ($row = mysqli_fetch_assoc($result))
    {
    	foreach ($row as $field => $value)
    	{
    		$maxnum = $value;
    	}
    }

    $newnum = intval($maxnum + 1);

    $stmt = "insert into Questions values($newnum, '$question', '$difficulty', '$category', '$tc1_input', '$tc1_output', '$tc2_input', '$tc2_output', ' ', 0, 0, '$funcName', '$tc3_input', '$tc3_output', '$tc4_input', '$tc4_output', '$tc5_input', '$tc5_output', '$tc6_input', '$tc6_output', $fc, $wc, $pc);";
    //$stmt = "insert into Questions values($newnum, '$question', '$difficulty', '$category', $tc1_input, $tc1_output, $tc2_input, $tc2_output, ' ', 0, 0, '$funcName');";

    if(!($res = mysqli_query($conn, $stmt))) {
        //$arr = array("results" => "Failure \nnewnum: " + (string)$newnum + "\nquestion: " + (string)$question + "\ndiff: " + (string)$difficulty + "\ncat: " + (string)$category + "\ntc1in:" + (string)$tc1_input + "\n tc1out:" + (string)$tc1_output + "\n tc2in:" + (string)$tc2_input + "\n tc2out:" + (string)$tc2_output);
        $arr = array("results" => "Failure");
    } else {
        $arr = array("results" => "Success");
    }

    echo json_encode($arr);

?>
