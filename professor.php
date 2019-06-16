<?php
    session_start();
    if (!isset($_SESSION['user']) || $_SESSION['user'] != "professor") {
        //echo "user " . $_SESSION['user'];
        header('Location: https://web.njit.edu/~ecastela/cs490/login.php');
    }
?>
<!DOCTYPE html>
<html>
    <head>
        <style>
            button {
              display: inline-block;
              text-align: center;
              border: 1px solid #142846;
              border-radius: .25em;
              padding: .25em 1em;
              background-color: #43709F;
              color: #fff;
              font-size: 20px;
              box-shadow: 0 .125em 0 0em #7B99B5;
              -webkit-transition: all .15s;
              transition: all .15s;
              will-change: transform;
              width: 220px;
              height: 75px;
            }
            button:active,
            button:focus {
              border-color: #000;
              background-color: #033286;
            }
            button:active {
              -webkit-transform: translateY(.125em);
              transform: translateY(.125em);
            }
            #div2 {
                text-align:center;
                position:relative;
                font-size: 35px;
            }
            #addtoexam {
                position:relative;
                display: flex;
                justify-content: center;
            }
            .grouper {
                padding: 5px;
                font-size:20px;
            }
             .ta {
                height: 20px;
            }
            .btnNew {
                display: inline-block;
                text-align: center;
                border: 1px solid #142846;
                border-radius: .25em;
                padding: .25em 1em;
                background-color: #43709F;
                color: #fff;
                font-size: 20px;
                box-shadow: 0 .125em 0 0em #7B99B5;
                -webkit-transition: all .15s;
                transition: all .15s;
                will-change: transform;
                width: 120px;
                height: 36px;
            }
        </style>
        <title>Professor Page</title>
    </head>
    <h1 id="title1">Professor Page</h1>
    <body>
        <div id="div1" style="width: 20%; float:left">

            <div >
                <button class="btn" id="btn1" type="button">Home</button>
            </div>

            <div >
                <button class="btn" id="btn2" type="button">Question Bank</button>
            </div>

            <div >
                <button class="btn" id="btn3" type="button">Create Exam</button>
            </div>

            <div >
                <button class="btn" id="btn4" type="button">View Exam</button>
            </div>

            <div >
                <button class="btn" id="btn5" type="button">Exams Needing Grading</button>
            </div>

            <div >
                <button class="btn" id="btn6" type="button">Logout</button>
            </div>

        </div>

        <div id="div2" style="width: 80%; float:right">

            <p align="middle">Welcome Professor! Here's Your Landing Page</p>
        </div>

        <script>

            // button click for Create Question
            // document.getElementById("btn1").addEventListener("click", function(){
            //     return fetch ('button1content.txt')
            //         .then((response) => {
            //                return response.text();
            //             }
            //         )
            //         .then (
            //             (text) => document.getElementById("div2").innerHTML = text
            //         )
            // });
            document.getElementById("btn1").addEventListener("click", function(){
                document.getElementById("div2").innerHTML = "<p align=\"middle\">Welcome Professor! Here's Your Landing Page</p>";
            });

            // button click for title screen -- clicking banner
            document.getElementById("title1").addEventListener("click", function(){
                document.getElementById("div2").innerHTML = "<p align=\"middle\">Welcome Professor! Here's Your Landing Page</p>";
            });

            // button click for question bank
            document.getElementById("btn2").addEventListener("click", function(){

                // NEED TO CHANGE THIS, JUST NEED SIMPLE    const formData = new FormData();
                const formData = new FormData(document.getElementById('create_question'));
                formData.append('indicator', 'tableinit');

                console.log("here 1");

                return fetch('https://web.njit.edu/~ecastela/cs490/frontback.php', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                    },
                    //body: JSON.stringify(JSON_DATA),
                    body: formData,
                    mode: 'no-cors'
                })
                .then((res) => res.json())
                .then((response) => {
                    console.log("made it here 2");
                    var table = response.ankit;
                    //console.log("ankit value : " + response.ankit);

                    // BUTTONS PLACED IN data2.php
                    document.getElementById("div2").innerHTML = "<h1>Question Bank</h1><br>" + buttons + "<br>" + response.ankit + "<br>";
                }); // end of fetch

            });

            // button click for create exam -- display exam questions where flag field = 1
            document.getElementById("btn3").addEventListener("click", function(){

                // NEED TO CHANGE THIS, JUST NEED SIMPLE  const formData = new FormData();
                const formData2 = new FormData(document.getElementById('create_question'));
                formData2.append('indicator', 'examtable');

                console.log("here exam table");

                return fetch('https://web.njit.edu/~ecastela/cs490/frontback.php', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                    },
                    //body: JSON.stringify(JSON_DATA),
                    body: formData2,
                    mode: 'no-cors'
                })
                .then((res) => res.json())
                .then((response) => {
                    //console.log(response.ankit);
                    document.getElementById("div2").innerHTML = "<h1>Exam Questions</h1><br>" + buttons2 + "<br>" + response.ankit; //+ "<br><button id='publish' class=\"btn\" type=\"button\">Publish</button><br<br><br><br>";
                }); // end of fetch

            });

            // button click for view exams
            document.getElementById("btn4").addEventListener("click", function(){

                // NEED TO CHANGE THIS, JUST NEED SIMPLE  const formData = new FormData();
                const formData5 = new FormData(document.getElementById('create_question'));
                formData5.append('indicator', 'viewexams');

                return fetch('https://web.njit.edu/~ecastela/cs490/frontback.php', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                    },
                    //body: JSON.stringify(JSON_DATA),
                    body: formData5,
                    mode: 'no-cors'
                })
                .then((res) => res.json())
                .then((response) => {
                    document.getElementById("div2").innerHTML = "<h1>Available Exams</h1><br>" + response.ankit + "<br><button id='viewsingleexam' class=\"btn\" type=\"button\">View Exam</button><br<br><br><br>";
                }); // end of fetch

            });

            document.getElementById("btn5").addEventListener("click", function(){

                // NEED TO CHANGE THIS, JUST NEED SIMPLE  const formData = new FormData();
                const formData8 = new FormData();
                formData8.append('indicator', 'examsneedgrading');

                return fetch('https://web.njit.edu/~ecastela/cs490/frontback.php', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                    },
                    //body: JSON.stringify(JSON_DATA),
                    body: formData8,
                    mode: 'no-cors'
                })
                .then((res) => res.json())
                .then((response) => {
                    console.log(response.ankit);
                    document.getElementById("div2").innerHTML = "<h1>Exams Need Grading</h1><br>" + response.ankit + "<br><button id='gradeexam' class=\"btn\" type=\"button\">View Exam</button><br<br><br><br>";
                }); // end of fetch

            });

            document.getElementById("btn6").addEventListener("click", function(){

                //window.location.replace("https://web.njit.edu/~ecastela/cs490/login.php");
                window.location.replace("https://web.njit.edu/~jy425/CS490/login2.html");

            });

            document.addEventListener('click',function(e){
              if (e.target && e.target.id== 'btn6') {
                   return fetch ('button2content.txt')
                       .then((response) => {
                              return response.text();
                           }
                       )
                       .then (
                           (text) => document.getElementById("div2").innerHTML = text
                       )
               } else if (e.target && e.target.id== 'submit'){

                   const formData1 = new FormData(document.getElementById('create_question'));
                   formData1.append('indicator', 'createquestion');

                   console.log('question : ' + formData1.get('question'));

                   return fetch('https://web.njit.edu/~ecastela/cs490/frontback.php', {
                       method: 'POST',
                       headers: {
                           'Content-Type': 'application/json',
                       },
                       //body: JSON.stringify(JSON_DATA),
                       body: formData1,
                       mode: 'no-cors'
                   })
                   .then((res) => res.json())
                   .then((response) => {

                       console.log("made it here 3");
                       if (response.ankit === "Success") {

                           //document.getElementById("div2").innerHTML = "<h1>Question Successfully Added!</h1><br>" + document.getElementById("div2").innerHTML;

                           // NEED TO CHANGE THIS, JUST NEED SIMPLE    const formData = new FormData();
                           const formData = new FormData(document.getElementById('create_question'));
                           formData.append('indicator', 'tableinit');

                           console.log("here 1");

                           return fetch('https://web.njit.edu/~ecastela/cs490/frontback.php', {
                               method: 'POST',
                               headers: {
                                   'Content-Type': 'application/json',
                               },
                               //body: JSON.stringify(JSON_DATA),
                               body: formData,
                               mode: 'no-cors'
                           })
                           .then((res) => res.json())
                           .then((response) => {
                               console.log("made it here 2");
                               var table = response.ankit;
                               //console.log("ankit value : " + response.ankit);

                               // BUTTONS PLACED IN data2.php
                               document.getElementById("div2").innerHTML = "<h1>Question Successfully Added!</h1><h1>Question Bank</h1><br>" + buttons + "<br>" + response.ankit + "<br>";
                           }); // end of fetch

                       } else {
                           document.getElementById("div2").innerHTML = "<h1>Question Add Failed!</h1><br>" + document.getElementById("div2").innerHTML;
                       }

                   }); // end of fetch
               } else if (e.target && e.target.id== 'addtoexam'){

                   var sendstring = "";
                   // check for checkboxes that are clicked
                   // checkboxchecker();
                   sendstring = checkboxchecker("bank2");
                   console.log("sendstring : " + sendstring);
                   var formData3 = new FormData(document.getElementById('create_question'));
                   formData3.append('indicator', 'addtoexam');
                   formData3.append('numArray', sendstring);

                   return fetch('https://web.njit.edu/~ecastela/cs490/frontback.php', {
                       method: 'POST',
                       headers: {
                           'Content-Type': 'application/json',
                       },
                       //body: JSON.stringify(JSON_DATA),
                       body: formData3,
                       mode: 'no-cors'
                   })
                   .then((res) => res.json())
                   .then((response) => {

                       console.log("made it past return");
                       // check if flags were successfully flipped
                       if (response.ankit === "Success") {

                           // REFRESH RIGHT SIDE TABLE
                           const formData2 = new FormData(document.getElementById('create_question'));
                           formData2.append('indicator', 'examtable');

                           console.log("here exam table");

                           return fetch('https://web.njit.edu/~ecastela/cs490/frontback.php', {
                               method: 'POST',
                               headers: {
                                   'Content-Type': 'application/json',
                               },
                               //body: JSON.stringify(JSON_DATA),
                               body: formData2,
                               mode: 'no-cors'
                           })
                           .then((res) => res.json())
                           .then((response) => {
                               //console.log(response.ankit);
                               document.getElementById("div2").innerHTML = "<h1>Questions Successfully Added!</h1><br><h1>Exam Questions</h1><br>" + buttons2 + "<br>" + response.ankit; //+ "<br><button id='publish' class=\"btn\" type=\"button\">Publish</button><br<br><br><br>";
                           }); // end of fetch

                       } else {
                           document.getElementById("div2").innerHTML = "<h1>Questions Add Failed!</h1><br>" + document.getElementById("div2").innerHTML;
                       }

                   }); // end of fetch

               } else if (e.target && e.target.id == 'filterbutton') {

                   let formData = new FormData(document.getElementById('filters'));
                   //var formData4 = new FormData(document.getElementById('create_question'));
                   formData.append('indicator', 'filterer');

                   console.log(formData);
                   console.log("before filter");

                   // -------

                   return fetch('https://web.njit.edu/~ecastela/cs490/frontback.php', {
                       method: 'POST',
                       headers: {
                           'Content-Type': 'application/json',
                       },
                       //body: JSON.stringify(JSON_DATA),
                       body: formData,
                       mode: 'no-cors'
                   })
                   .then((res) => res.json())
                   .then((response) => {

                       console.log("made it past return");
                       // check if flags were successfully flipped
                       //document.getElementById("left").innerHTML = "<h1>Question Bank</h1><br>" + buttons + response.ankit + "<br><button id='addtoexam' class=\"btn\" type=\"button\">Add to Exam</button><br<br><br><br>";
                       document.getElementById("left").innerHTML = response.ankit + "<br><br><br><br>";
                   }); // end of fetch

               } else if (e.target && e.target.id == 'filterbutton2') {

                   let formData = new FormData(document.getElementById('filters'));
                   //var formData4 = new FormData(document.getElementById('create_question'));
                   formData.append('indicator', 'filterer2');

                   console.log(formData);
                   console.log("before filter");

                   // -------

                   return fetch('https://web.njit.edu/~ecastela/cs490/frontback.php', {
                       method: 'POST',
                       headers: {
                           'Content-Type': 'application/json',
                       },
                       //body: JSON.stringify(JSON_DATA),
                       body: formData,
                       mode: 'no-cors'
                   })
                   .then((res) => res.json())
                   .then((response) => {

                       console.log("made it past return");
                       // check if flags were successfully flipped
                       //document.getElementById("left").innerHTML = "<h1>Question Bank</h1><br>" + buttons + response.ankit + "<br><button id='addtoexam' class=\"btn\" type=\"button\">Add to Exam</button><br<br><br><br>";
                       document.getElementById("left2").innerHTML = response.ankit + "<br><br><br><br>";
                   }); // end of fetch

               } else if (e.target && e.target.id == 'viewsingleexam') {

                   var examnum = "";

                   examnum = checkboxchecker("viewexams");

                   console.log("examnum = " + examnum);

                   var formData6 = new FormData(document.getElementById('create_question'));
                   formData6.append('indicator', 'viewsingleexam');
                   formData6.append('examnum', examnum);

                   return fetch('https://web.njit.edu/~ecastela/cs490/frontback.php', {
                       method: 'POST',
                       headers: {
                           'Content-Type': 'application/json',
                       },
                       //body: JSON.stringify(JSON_DATA),
                       body: formData6,
                       mode: 'no-cors'
                   })
                   .then((res) => res.json())
                   .then((response) => {

                       console.log("made it to single exam fetch");
                       // check if flags were successfully flipped
                       document.getElementById("div2").innerHTML = response.ankit + "<br><button id='submitfinishedexam' class=\"btn\" type=\"button\">Submit</button><br<br><br><br>";
                   }); // end of fetch

               } else if (e.target && e.target.id == 'submitfinishedexam') {

                   console.log("submitting finished exam!");
                   document.getElementById("div2").innerHTML = "Submitted Exam for Grading! (JK you are the professor)";

               } else if (e.target && e.target.id == 'publish') {

                   var pointstring = getpointvalues("makeExam");

                   var formData7 = new FormData(document.getElementById('create_question'));
                   formData7.append('indicator', 'publishexam');
                   formData7.append('pointstring', pointstring);

                   console.log("pointstring : " + pointstring);

                   return fetch('https://web.njit.edu/~ecastela/cs490/frontback.php', {
                       method: 'POST',
                       headers: {
                           'Content-Type': 'application/json',
                       },
                       //body: JSON.stringify(JSON_DATA),
                       body: formData7,
                       mode: 'no-cors'
                   })
                   .then((res) => res.json())
                   .then((response) => {

                       console.log("sent points");
                       // check if flags were successfully flipped
                       document.getElementById("div2").innerHTML = "<h1>Published Exam!</h1>";
                   }); // end of fetch

               } else if (e.target && e.target.id == 'gradeexam') {

                   var formData8 = new FormData();
                   formData8.append('indicator', 'professorviewsgradedexam');
                   formData8.append('examnum', checkboxchecker("needgrading"));

                   console.log("examnum : " + checkboxchecker("needgrading"));

                   return fetch('https://web.njit.edu/~ecastela/cs490/frontback.php', {
                       method: 'POST',
                       headers: {
                           'Content-Type': 'application/json',
                       },
                       //body: JSON.stringify(JSON_DATA),
                       body: formData8,
                       mode: 'no-cors'
                   })
                   .then((res) => res.json())
                   .then((response) => {

                       console.log("loading graded exam");
                       // check if flags were successfully flipped
                       document.getElementById("div2").innerHTML = response.ankit + "<br><button id='submitregradedexam' class=\"btn\" type=\"button\">Finalize</button><br<br><br><br>";
                   }); // end of fetch

               } else if (e.target && e.target.id == 'submitregradedexam') {

                   var formData9 = new FormData();
                   console.log("regraded bigstring : " + getregradedstring());
                   console.log("regraded examnum : " + getexamnum());
                   formData9.append('indicator', 'submitregradedexam');
                   formData9.append('examnum', getexamnum());
                   formData9.append('bigstring', getregradedstring());

                   return fetch('https://web.njit.edu/~ecastela/cs490/frontback.php', {
                       method: 'POST',
                       headers: {
                           'Content-Type': 'application/json',
                       },
                       //body: JSON.stringify(JSON_DATA),
                       body: formData9,
                       mode: 'no-cors'
                   })
                   .then((res) => res.json())
                   .then((response) => {
                       console.log("submitting finalized exam");
                       // check if flags were successfully flipped
                       document.getElementById("div2").innerHTML = "<h1>Finalized Exam!</h1>";
                   }); // end of fetch

               } else if (e.target && e.target.id == 'remover') {

                   let formData10 = new FormData();
                   let numstring = "";
                   numstring = checkboxchecker2("makeExam");
                   console.log("sendstring : " + numstring);
                   formData10.append('indicator', 'remover');
                   formData10.append('numArray', numstring);

                   return fetch('https://web.njit.edu/~ecastela/cs490/frontback.php', {
                       method: 'POST',
                       headers: {
                           'Content-Type': 'application/json',
                       },
                       //body: JSON.stringify(JSON_DATA),
                       body: formData10,
                       mode: 'no-cors'
                   })
                   .then((res) => res.json())
                   .then((response) => {
                       document.getElementById("div2").innerHTML = "<h1>Questions Removed!</h1><br><h1>Exam Questions</h1><br>" + buttons2 + "<br>" + response.ankit;
                       // check if flags were successfully flipped
                   }); // end of fetch

               }

           });

           // listener for tab key in textarea
           document.addEventListener('keydown',function(e){
               if(e.target && (e.keyCode == 9)) {
                   insertTab(document.activeElement, e);
               }
           });

           var buttons = `<form id="filters"><label for="difficulty">Difficulty</label>
                <select id="difficultyfilter" name="difficulty">
                <option value="">--Please choose an option--</option>
                <option value="easy">Easy</option>
                <option value="medium">Medium</option>
                <option value="hard">Hard</option>
                </select>
                <br>
                <label for="category" name="category">Category</label>
                <select id="categoryfilter" name="category">
                <option value="">--Please choose an option--</option>
                <option value="for">For-loops</option>
                <option value="while">While-loops</option>
                <option value="string">String Manipulation</option>
                <option value="recursion">Recursion</option>
                <option value="math">Math Stuff</option>
                </select>
                <br>
                <label for="search">Search</label>
                <input type="search" id="searchfilter" name="search">
                <button onclick="" id ="filterbutton" class="btnNew" type="button" form="filters" value="Submit">Filter</button></form>`;

            var buttons2 = `<form id="filters"><label for="difficulty">Difficulty</label>
                 <select id="difficultyfilter" name="difficulty">
                 <option value="">--Please choose an option--</option>
                 <option value="easy">Easy</option>
                 <option value="medium">Medium</option>
                 <option value="hard">Hard</option>
                 </select>
                 <br>
                 <label for="category" name="category">Category</label>
                 <select id="categoryfilter" name="category">
                 <option value="">--Please choose an option--</option>
                 <option value="for">For-loops</option>
                 <option value="while">While-loops</option>
                 <option value="string">String Manipulation</option>
                 <option value="recursion">Recursion</option>
                 <option value="math">Math Stuff</option>
                 </select>
                 <br>
                 <label for="search">Search</label>
                 <input type="search" id="searchfilter" name="search">
                 <button onclick="" id ="filterbutton2" class="btnNew" type="button" form="filters" value="Submit">Filter</button></form>`;

            // function to get question number of rows selected by checkbox
            function checkboxchecker(tablename) {
                //Fetch all rows of the Table.
                let tablerows = document.getElementById(tablename).rows;
                let num = [];

                console.log("tablerows : " + tablerows.length);
                console.log("inside checkboxchecker");
                //Execute loop on all rows excluding the Header row.
                for (let i = 1; i < tablerows.length; i++) {
                    if (tablerows[i].getElementsByTagName("input")[0].checked === true) {
                        //console.log(i + " checked");
                        console.log("td : " + tablerows[i].getElementsByTagName("td")[0].innerText);
                        num.push(tablerows[i].getElementsByTagName("td")[0].innerText);
                    }
                }
                let questions = num.toString();
                return questions;
            }

            function checkboxchecker2(tablename) {
                //Fetch all rows of the Table.
                let tablerows = document.getElementById(tablename).rows;
                let num = [];

                console.log("tablerows : " + tablerows.length);
                console.log("inside checkboxchecker");
                //Execute loop on all rows excluding the Header row.
                for (let i = 1; i < tablerows.length; i++) {
                    if (tablerows[i].getElementsByTagName("input")[1].checked === true) {
                        //console.log(i + " checked");
                        console.log("td : " + tablerows[i].getElementsByTagName("td")[0].innerText);
                        num.push(tablerows[i].getElementsByTagName("td")[0].innerText);
                    }
                }
                let questions = num.toString();
                return questions;
            }

            // returns exam number from exam page
            function getexamnum() {

                var h1text = document.getElementById('examnumber').innerText;
                var examnum = h1text.substring(5, h1text.length);

                return examnum;

            }

            // function to get point values enterred by professor
            function getpointvalues(tablename) {
                //Fetch all rows of the Table.
                var tablerows = document.getElementById(tablename).rows;
                var num = [];
                //Execute loop on all rows excluding the Header row.
                for (var i = 1; i < tablerows.length; i++) {
                    num.push(tablerows[i].getElementsByTagName("td")[0].innerText + ":" + tablerows[i].getElementsByTagName("td")[4].getElementsByTagName("input")[0].value);
                }
                var questions = num.toString();
                console.log(questions);
                return questions;
            }

            // function to allow tabs in text area
            function insertTab(o, e) {
                var kC = e.keyCode ? e.keyCode : e.charCode ? e.charCode : e.which;
                if (kC == 9 && !e.shiftKey && !e.ctrlKey && !e.altKey) {
                    var oS = o.scrollTop;
                    if (o.setSelectionRange) {
                        var sS = o.selectionStart;
                        var sE = o.selectionEnd;
                        o.value = o.value.substring(0, sS) + "\t" + o.value.substr(sE);
                        o.setSelectionRange(sS + 1, sS + 1);
                        o.focus();
                    } else if (o.createTextRange) {
                        document.selection.createRange().text = "\t";
                        e.returnValue = false;
                    }
                    o.scrollTop = oS;
                    if (e.preventDefault) {
                        e.preventDefault();
                    }
                    return false;
                }
                return true;
            }

            function getregradedstring() {

                let bigstring = "";
                let h4collection = document.getElementsByTagName("h4");
                let groupercollection = document.getElementsByClassName("grouper");
                let extracomments = "";
                let textcoll = null;

                for (let i = 0; i < h4collection.length; i++) {
                    extracomments = document.getElementById("professorcomment" + (i + 1)).value;
                    //console.log("extra comments : " + extracomments);

                    // getting question verbiage
                    bigstring += h4collection.item(i).innerText + ',!%-';
                    // getting question table
                    if (extracomments.length > 0) {

                        // added this to change values
                        textcoll = groupercollection.item(i).getElementsByTagName("textarea");
                        for (let j = 0; j < textcoll.length; j++) {
                            textcoll.item(j).innerHTML = textcoll.item(j).value;
                            //textcoll.item(j).innerText = textcoll.item(j).innerHTML;
                            console.log("Value = " + textcoll.item(j).value + ", innerHTML = " + textcoll.item(j).innerHTML);
                            console.log("innerText = " + textcoll.item(j).innerText + ", innerHTML = " + textcoll.item(j).innerHTML);
                        }

                        bigstring += groupercollection.item(i).innerHTML;
                        bigstring += "<br>Additional Comments:<br><h5>" + extracomments + '</h5>,!%+';
                    } else {

                        // added this to change values
                        textcoll = groupercollection.item(i).getElementsByTagName("textarea");
                        for (let j = 0; j < textcoll.length; j++) {
                            textcoll.item(j).innerHTML = textcoll.item(j).value;
                            //textcoll.item(j).innerText = textcoll.item(j).innerHTML;
                            console.log("Value = " + textcoll.item(j).value + ", innerHTML = " + textcoll.item(j).innerHTML);
                            console.log("innerText = " + textcoll.item(j).innerText + ", innerHTML = " + textcoll.item(j).innerHTML);
                        }

                        bigstring += groupercollection.item(i).innerHTML + ',!%+';
                    }
                    // getting new points value
                    bigstring += getnewpoints("table" + i) + ',!%=';
                    //console.log("table " + i + " : " + groupercollection.item(i).innerHTML);
                }

                return bigstring.substring(0, bigstring.length-4);
            }

            function getnewpoints(tablename) {
                //Fetch all rows of the Table.
                let tablerows = document.getElementById(tablename).rows;
                let total = 0;

                //console.log("tablename : " + tablename);
                //console.log("tablerows : " + tablerows);

                //Execute loop on all rows excluding the Header row.
                for (let i = 0; i < tablerows.length; i++) {
                    //console.log("innertext = " + tablerows[i].getElementsByTagName('td')[1].getElementsByTagName("textarea")[0].value);
                    total += parseInt(tablerows[i].getElementsByTagName('td')[1].getElementsByTagName("textarea")[0].value);
                }
                console.log("total = " + total);
                return total.toString();
            }

        </script>
    </body>
</html>
