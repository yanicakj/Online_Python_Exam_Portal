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
            #resDiv {
                zoom: 0.66;
                -moz-transform: scale(0.66);
            }
            /*input {
               text-alight:top;padding: 15px 22px;width: 600px;
               height: 320px;
               /*background-image: url('https://americansongwriter.com/wp-content/uploads/2013/03/Taylor-Swift-22.jpg');*/
            // }*/
        </style>
        <!--<link rel="stylesheet" href="style.css">-->
        <title>Student Page</title>
    </head>
    <body>
        <h1 id="title1">Student Page</h1>
        <div id="div1" style="width: 20%; float:left">

            <div>
                <button id="takebutton" class="btn" type="button">Take Exam</button>
            </div>

            <div id="but1">
                <button id="viewbutton" class="btn" type="button">View Grades and Feedback</button>
            </div>

            <div id="but1">
                <button id="logoutbutton" class="btn" type="button">Logout</button>
            </div>

        </div>
        <div id="div2" style="width: 80%; float:right">
            <p align="middle">Welcome Student! Here's Your Landing Page</p>
        </div>

        <script>

            // get to student landing page
            document.getElementById("title1").addEventListener("click", function(){
                document.getElementById("div2").innerHTML = "<p align=\"middle\">Welcome Student! Here's Your Landing Page</p>";
            });

            // take exam
            document.getElementById("takebutton").addEventListener("click", function(){

                // NEED TO CHANGE THIS, JUST NEED SIMPLE    const formData = new FormData();
                //const formData = new FormData(document.getElementById('create_question'));
                let formData = new FormData();
                formData.append('indicator', 'availableexams');

                console.log("here at view exams prefetch");

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
                    console.log("made view exams post fetch");
                    document.getElementById("div2").innerHTML = "<h1>Available Exams</h1><br>" + response.ankit + "<br><button id='takeexambutton' class=\"btn\" type=\"button\">Take Exam</button><br<br><br><br>";
                })
                .catch(error => console.log(error)); // end of fetch

            });

            // view graded exams
            document.getElementById("viewbutton").addEventListener("click", function(){

                // NEED TO CHANGE THIS, JUST NEED SIMPLE    const formData = new FormData();
                //const formData = new FormData(document.getElementById('create_question'));
                let formData = new FormData();
                formData.append('indicator', 'gradedexams');

                console.log("here at view graded exams prefetch");

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
                    console.log("made view graded exams post fetch");
                    document.getElementById("div2").innerHTML = "<h1>Exam Results</h1><br>" + response.ankit + "<br><button id='viewexam' class=\"btn\" type=\"button\">View</button><br<br><br><br>";
                })
                .catch(error => console.log(error)); // end of fetch

            });

            document.getElementById("logoutbutton").addEventListener("click", function(){

                window.location.replace("https://web.njit.edu/~jy425/CS490/login2.html");

            });

            //listeners for buttons in the faux pages
            document.addEventListener('click',function(e){

                // submit exam button
                if (e.target && e.target.id== 'takeexambutton'){

                    let formData = new FormData();
                    let sendstring = "";

                    sendstring = checkboxchecker("availableexams");
                    console.log("sendstring : " + sendstring);

                    formData.append("indicator", "studentselectexam");
                    formData.append("examnum", sendstring);

                    return fetch('https://web.njit.edu/~ecastela/cs490/frontback.php', {
                        method: 'POST',
                        headers: {
                           'Content-Type': 'application/json',
                        },
                        //body: JSON.stringify(JSON_DATA),
                        body: formData,
                        mode: 'no-cors'
                    })
                    .then(res => res.json())
                    .then(response => {
                        console.log('submit exam', response.ankit);
                        document.getElementById("div2").innerHTML = "<h1>Exam time!</h1><br>" + response.ankit + "<br><button id='submitexambutton' class=\"btn\" type=\"button\">Submit Exam</button><br<br><br><br>";
                    })

                // student views a single graded exam
                } else if (e.target && e.target.id== 'viewexam') {

                    let formData = new FormData();
                    let sendstring = "";

                    sendstring = checkboxchecker("availableexams");
                    console.log("sendstring : " + sendstring);

                    formData.append("indicator", "viewsinglegradedexam");
                    formData.append("examnum", sendstring);

                    return fetch('https://web.njit.edu/~ecastela/cs490/frontback.php', {
                        method: 'POST',
                        headers: {
                           'Content-Type': 'application/json',
                        },
                        //body: JSON.stringify(JSON_DATA),
                        body: formData,
                        mode: 'no-cors'
                    })
                    .then(res => res.json())
                    .then(response => {
                        console.log('view single exam table: ', response.ankit);
                        //document.getElementById("div2").innerHTML = "<h1>Exam Results</h1>" + response.ankit + "<br><br><br><br><p></p>";
                        document.getElementById("div2").innerHTML = response.ankit + "<br><br><br><br><p></p>";
                    })

                }

                // student finishes exam and submits answers
                else if (e.target && e.target.id == 'submitexambutton') {
                    let formData = new FormData();

                    formData.append("indicator", "studentsubmitexam");
                    formData.append("bigstring", getbigstring());
                    formData.append("examnum", getexamnum());

                    console.log("examnum : " + getexamnum());
                    console.log("bigstring : " + getbigstring());

                    return fetch('https://web.njit.edu/~ecastela/cs490/frontback.php', {
                        method: 'POST',
                        headers: {
                           'Content-Type': 'application/json',
                        },
                        //body: JSON.stringify(JSON_DATA),
                        body: formData,
                        mode: 'no-cors'
                    })
                    .then(res => res.json())
                    .then(response => {
                        console.log('submit exam', response.ankit);
                        document.getElementById("div2").innerHTML = "<h1>Exam Successfully Submitted!</h1><br>";
                    })
                    .catch(error => console.log(error)); // end of fetch

                }
            })

            // listener for tab key in textarea
            document.addEventListener('keydown',function(e){
                if(e.target && (e.keyCode == 9)) {
                    insertTab(document.activeElement, e);
                }
            });

            function checkboxchecker(tab) {
                // Fetch all rows of the Table.
                var tablerows = document.getElementById(tab).rows;
                var num = [];
                // Execute loop on all rows excluding the Header row.
                for (var i = 1; i < tablerows.length; i++) {
                    if (tablerows[i].getElementsByTagName("input")[0].checked === true) {
                        //console.log(i + " checked");
                        console.log("td : " + tablerows[i].getElementsByTagName("td")[0].innerText);
                        num.push(tablerows[i].getElementsByTagName("td")[0].innerText);
                    }
                }
                var questions = num.toString();
                return questions;
            };

            // grab questions and answers and puts it in a big string
            // after question delimiter: ,!%+
            // after answer delimiter: ,!%-

            function getbigstring() {
                let questionarray = [];
                let responsearray = [];

                let answerhtml = document.getElementsByTagName("textarea");
                let questionhtml = document.getElementsByTagName("p");

                for (i = 0; i < answerhtml.length; i++) {
                    //console.log(answerhtml.item(i).value, 'for');
                    responsearray.push(answerhtml.item(i).value + ',!%+');
                }

                for (i = 0; i < questionhtml.length; i++) {
                    //console.log(questionhtml.item(i).innerHTML, 'for', i);
                    questionarray.push(questionhtml.item(i).innerHTML + ',!%-');
                }

                //create string to return
                let bigstring = "1";
                let bigarray = [];

                for (i = 0; i < questionarray.length; i++) {
                    //console.log('i: ', i, 'question: ', questionarray[i], 'answer: ', responsearray[i], 'big string: ', bigstring);
                    bigarray.push(questionarray[i]);
                    bigarray.push(responsearray[i]);
                }

                //console.log('bigstring: ', bigarray.join(""));
                bigstring = bigarray.join("");
                var res = bigstring.substring(0, bigstring.length-4);
                //console.log("res : " + res);
                return res;
            }

            // returns exam number from exam page
            function getexamnum() {

                var h1text = document.getElementById('examnumber').innerText;
                var examnum = h1text.substring(5, h1text.length);

                return examnum;

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

        </script>
    </body>
</html>
