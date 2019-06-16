<?php

    // grabbing post data
    $un = $_POST["username"];
    $pw = $_POST["password"];
    $indicator = $_POST["indicator"];

    // set up post array
    $arr = array('username'=>$un,'password'=>$pw);

    // login flag - request professor or student token
    if ($indicator == "login") {

        $curl = curl_init();
        curl_setopt($curl, CURLOPT_URL, 'https://web.njit.edu/~am2272/CS490/mysqlconnect.php');
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, TRUE);
        curl_setopt($curl, CURLOPT_POSTFIELDS, http_build_query($arr));
        $ret1 = curl_exec($curl);
        curl_close($curl);

        $ankitjson = json_decode($ret1);
        $jsonarray = array('njit'=>'NJIT login irrelevant!', 'ankit'=>$ankitjson->results);

        $myJSON = json_encode($jsonarray, JSON_FORCE_OBJECT);
        echo $myJSON;

    // for table init
    } elseif ($indicator == "tableinit") {

        $curl = curl_init();
        //curl_setopt($curl, CURLOPT_URL, 'https://web.njit.edu/~am2272/CS490/data.php');
        curl_setopt($curl, CURLOPT_URL, 'https://web.njit.edu/~jy425/CS490/data3.php');
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, TRUE);
        curl_setopt($curl, CURLOPT_POSTFIELDS, http_build_query($arr));
        $ret1 = curl_exec($curl);
        curl_close($curl);

        $ankitjson = json_decode($ret1);
        $jsonarray = array('ankit'=>$ankitjson->results);
        //$jsonarray = array('ankit'=>'hello');

        $myJSON = json_encode($jsonarray, JSON_FORCE_OBJECT);
        echo $myJSON;

    } elseif ($indicator == "createquestion") {

        $curl = curl_init();
        curl_setopt($curl, CURLOPT_URL, 'https://web.njit.edu/~jy425/CS490/addquestion.php');
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, TRUE);
        curl_setopt($curl, CURLOPT_POSTFIELDS, $_POST);
        $ret1 = curl_exec($curl);
        curl_close($curl);

        $ankitjson = json_decode($ret1);
        $jsonarray = array('ankit'=>$ankitjson->results);
        //$jsonarray = array('ankit'=>'test');

        $myJSON = json_encode($jsonarray, JSON_FORCE_OBJECT);
        echo $myJSON;

    } elseif ($indicator == "examtable") {

        $curl = curl_init();
        curl_setopt($curl, CURLOPT_URL, 'https://web.njit.edu/~jy425/CS490/CreateExam.php');
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, TRUE);
        curl_setopt($curl, CURLOPT_POSTFIELDS, $_POST);
        $ret1 = curl_exec($curl);
        curl_close($curl);

        $ankitjson = json_decode($ret1);
        $jsonarray = array('ankit'=>$ankitjson->results);
        //$jsonarray = array('ankit'=>'test');

        $myJSON = json_encode($jsonarray, JSON_FORCE_OBJECT);
        echo $myJSON;

    // professor adds questions to staging area
    } elseif ($indicator == "addtoexam") {

        $curl = curl_init();
        curl_setopt($curl, CURLOPT_URL, 'https://web.njit.edu/~jy425/CS490/update.php');
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, TRUE);
        curl_setopt($curl, CURLOPT_POSTFIELDS, $_POST);
        $ret1 = curl_exec($curl);
        curl_close($curl);

        $ankitjson = json_decode($ret1);
        $jsonarray = array('ankit' => $ankitjson->results);
        //$jsonarray = array('ankit'=>'test');

        $myJSON = json_encode($jsonarray, JSON_FORCE_OBJECT);
        echo $myJSON;

    // professor views question bank
    } elseif ($indicator == "filterer") {

        $curl = curl_init();
        curl_setopt($curl, CURLOPT_URL, 'https://web.njit.edu/~ecastela/cs490/filterer.php');
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, TRUE);
        curl_setopt($curl, CURLOPT_POSTFIELDS, $_POST);
        $ret1 = curl_exec($curl);
        curl_close($curl);

        $ankitjson = json_decode($ret1);
        $jsonarray = array('ankit' => $ankitjson->results);
        //$jsonarray = array('ankit'=>'test');

        $myJSON = json_encode($jsonarray, JSON_FORCE_OBJECT);
        echo $myJSON;

    // filter for 2nd page
    } elseif ($indicator == "filterer2") {

            $curl = curl_init();
            curl_setopt($curl, CURLOPT_URL, 'https://web.njit.edu/~ecastela/cs490/filterer2.php');
            curl_setopt($curl, CURLOPT_RETURNTRANSFER, TRUE);
            curl_setopt($curl, CURLOPT_POSTFIELDS, $_POST);
            $ret1 = curl_exec($curl);
            curl_close($curl);

            $ankitjson = json_decode($ret1);
            $jsonarray = array('ankit' => $ankitjson->results);
            //$jsonarray = array('ankit'=>'test');

            $myJSON = json_encode($jsonarray, JSON_FORCE_OBJECT);
            echo $myJSON;

    // professor views table of all exams
    } elseif ($indicator == "viewexams") {

        $curl = curl_init();
        curl_setopt($curl, CURLOPT_URL, 'https://web.njit.edu/~jy425/CS490/viewexams.php');
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, TRUE);
        curl_setopt($curl, CURLOPT_POSTFIELDS, $_POST);
        $ret1 = curl_exec($curl);
        curl_close($curl);

        $ankitjson = json_decode($ret1);
        $jsonarray = array('ankit' => $ankitjson->results);
        //$jsonarray = array('ankit'=>'test');

        $myJSON = json_encode($jsonarray, JSON_FORCE_OBJECT);
        echo $myJSON;

    // student views table of exams NOT taken
    } elseif ($indicator == "availableexams") {

        $curl = curl_init();
        curl_setopt($curl, CURLOPT_URL, 'https://web.njit.edu/~am2272/CS490/StudentTakeExam.php');
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, TRUE);
        curl_setopt($curl, CURLOPT_POSTFIELDS, $_POST);
        $ret1 = curl_exec($curl);
        curl_close($curl);

        $ankitjson = json_decode($ret1);
        $jsonarray = array('ankit' => $ankitjson->results);
        //$jsonarray = array('ankit'=>'test');

        $myJSON = json_encode($jsonarray, JSON_FORCE_OBJECT);
        echo $myJSON;

    // student views table of graded exams
    } elseif ($indicator == "gradedexams") {

        $curl = curl_init();
        curl_setopt($curl, CURLOPT_URL, 'https://web.njit.edu/~jy425/CS490/ViewGraded.php');
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, TRUE);
        curl_setopt($curl, CURLOPT_POSTFIELDS, $_POST);
        $ret1 = curl_exec($curl);
        curl_close($curl);

        $ankitjson = json_decode($ret1);
        $jsonarray = array('ankit' => $ankitjson->results);
        //$jsonarray = array('ankit'=>'test');

        $myJSON = json_encode($jsonarray, JSON_FORCE_OBJECT);
        echo $myJSON;

    // professor views single exam from global list
    } elseif ($indicator == "viewsingleexam") {

        $curl = curl_init();
        curl_setopt($curl, CURLOPT_URL, 'https://web.njit.edu/~jy425/CS490/ViewSingleExamProfessor.php');
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, TRUE);
        curl_setopt($curl, CURLOPT_POSTFIELDS, $_POST);
        $ret1 = curl_exec($curl);
        curl_close($curl);

        $ankitjson = json_decode($ret1);
        $jsonarray = array('ankit' => $ankitjson->results);
        //$jsonarray = array('ankit'=>'test');

        $myJSON = json_encode($jsonarray, JSON_FORCE_OBJECT);
        echo $myJSON;

    // student selects which exam to take
    } elseif ($indicator == "studentselectexam") {

        $curl = curl_init();
        curl_setopt($curl, CURLOPT_URL, 'https://web.njit.edu/~jy425/CS490/ViewSingleExamStudent.php');
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, TRUE);
        curl_setopt($curl, CURLOPT_POSTFIELDS, $_POST);
        $ret1 = curl_exec($curl);
        curl_close($curl);

        $ankitjson = json_decode($ret1);
        $jsonarray = array('ankit' => $ankitjson->results);
        //$jsonarray = array('ankit'=>'test');

        $myJSON = json_encode($jsonarray, JSON_FORCE_OBJECT);
        echo $myJSON;

    // professor publishes exam to world
    } elseif ($indicator == "publishexam") {

        $curl = curl_init();
        curl_setopt($curl, CURLOPT_URL, 'https://web.njit.edu/~jy425/CS490/PublishExam.php');
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, TRUE);
        curl_setopt($curl, CURLOPT_POSTFIELDS, $_POST);
        $ret1 = curl_exec($curl);
        curl_close($curl);

        $ankitjson = json_decode($ret1);
        $jsonarray = array('ankit' => $ankitjson->results);
        //$jsonarray = array('ankit'=>'test');

        $myJSON = json_encode($jsonarray, JSON_FORCE_OBJECT);
        echo $myJSON;

    // student submits exam for grading
    } elseif ($indicator == "studentsubmitexam") {

        $curl = curl_init();
        curl_setopt($curl, CURLOPT_URL, 'https://web.njit.edu/~jy425/CS490/CollectAnswers.php');
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, TRUE);
        curl_setopt($curl, CURLOPT_POSTFIELDS, $_POST);
        $ret1 = curl_exec($curl);
        curl_close($curl);

        $curl = curl_init();
        //curl_setopt($curl, CURLOPT_URL, 'https://web.njit.edu/~jy425/CS490/testgrader.php');
        curl_setopt($curl, CURLOPT_URL, 'https://web.njit.edu/~jy425/CS490/testgraderlive3.php');
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, TRUE);
        curl_setopt($curl, CURLOPT_POSTFIELDS, $_POST);
        $ret1 = curl_exec($curl);
        curl_close($curl);

        $ankitjson = json_decode($ret1);
        $jsonarray = array('ankit' => $ankitjson->results);
        //$jsonarray = array('ankit'=>'test');

        $myJSON = json_encode($jsonarray, JSON_FORCE_OBJECT);
        echo $myJSON;

    // table for professor -- exams that still need grading
    } elseif ($indicator == "examsneedgrading") {

        $curl = curl_init();
        curl_setopt($curl, CURLOPT_URL, 'https://web.njit.edu/~jy425/CS490/NeedGrading.php');
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, TRUE);
        curl_setopt($curl, CURLOPT_POSTFIELDS, $_POST);
        $ret1 = curl_exec($curl);
        curl_close($curl);

        $ankitjson = json_decode($ret1);
        $jsonarray = array('ankit' => $ankitjson->results);
        //$jsonarray = array('ankit'=>'test');

        $myJSON = json_encode($jsonarray, JSON_FORCE_OBJECT);
        echo $myJSON;

    // student views graded exam feedback
    }  elseif ($indicator == "viewsinglegradedexam") {

        $curl = curl_init();
        curl_setopt($curl, CURLOPT_URL, 'https://web.njit.edu/~jy425/CS490/ViewGradedExam.php');
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, TRUE);
        curl_setopt($curl, CURLOPT_POSTFIELDS, $_POST);
        $ret1 = curl_exec($curl);
        curl_close($curl);

        $ankitjson = json_decode($ret1);
        $jsonarray = array('ankit' => $ankitjson->results);
        //$jsonarray = array('ankit'=>'test');

        $myJSON = json_encode($jsonarray, JSON_FORCE_OBJECT);
        echo $myJSON;

    // professor views single graded exam to add extra comments and change grade
    } elseif ($indicator == "professorviewsgradedexam") {

        $curl = curl_init();
        curl_setopt($curl, CURLOPT_URL, 'https://web.njit.edu/~jy425/CS490/ProfessorViewsGradedExam.php');
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, TRUE);
        curl_setopt($curl, CURLOPT_POSTFIELDS, $_POST);
        $ret1 = curl_exec($curl);
        curl_close($curl);

        $ankitjson = json_decode($ret1);
        $jsonarray = array('ankit' => $ankitjson->results);
        //$jsonarray = array('ankit'=>'test');

        $myJSON = json_encode($jsonarray, JSON_FORCE_OBJECT);
        echo $myJSON;

    // professor pushes updated comments and grades to the database
    } elseif ($indicator == "submitregradedexam") {

        $curl = curl_init();
        curl_setopt($curl, CURLOPT_URL, 'https://web.njit.edu/~jy425/CS490/PushComments.php');
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, TRUE);
        curl_setopt($curl, CURLOPT_POSTFIELDS, $_POST);
        $ret1 = curl_exec($curl);
        curl_close($curl);

        $ankitjson = json_decode($ret1);
        $jsonarray = array('ankit' => $ankitjson->results);
        //$jsonarray = array('ankit'=>'test');

        $myJSON = json_encode($jsonarray, JSON_FORCE_OBJECT);
        echo $myJSON;

    } elseif ($indicator == "remover") {

        $curla = curl_init();
        curl_setopt($curla, CURLOPT_URL, 'https://web.njit.edu/~jy425/CS490/RemoveFromExam.php');
        curl_setopt($curla, CURLOPT_RETURNTRANSFER, TRUE);
        curl_setopt($curla, CURLOPT_POSTFIELDS, $_POST);
        $reta = curl_exec($curla);
        curl_close($curla);

        $curl = curl_init();
        curl_setopt($curl, CURLOPT_URL, 'https://web.njit.edu/~jy425/CS490/CreateExam.php');
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, TRUE);
        curl_setopt($curl, CURLOPT_POSTFIELDS, $_POST);
        $ret1 = curl_exec($curl);
        curl_close($curl);

        $ankitjson = json_decode($ret1);
        $jsonarray = array('ankit'=>$ankitjson->results);
        //$jsonarray = array('ankit'=>'test');

        $myJSON = json_encode($jsonarray, JSON_FORCE_OBJECT);
        echo $myJSON;

    }

?>
