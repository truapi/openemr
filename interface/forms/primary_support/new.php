<?php
/**
 * clinical reminders gui
 *
 * @package OpenEMR
 * @link    http://www.open-emr.org
 * @author  Brady Miller <brady.g.miller@gmail.com>
 * @author  Ensofttek, LLC
 * @copyright Copyright (c) 2011-2017 Brady Miller <brady.g.miller@gmail.com>
 * @copyright Copyright (c) 2011 Ensofttek, LLC
 * @license https://github.com/openemr/openemr/blob/master/LICENSE GNU General Public License 3
 */

require_once "../../globals.php";
require_once("$srcdir/assessment.inc");
require_once("$srcdir/encounter.inc");

use OpenEMR\Core\Header;

$patient_id = ($_GET['patient_id']) ? $_GET['patient_id'] : "";
$primary_patient_id = ($_GET['primary_patient_id']) ? $_GET['primary_patient_id'] : "";
?>
<html>
<head>
    <?php Header::setupHeader(['common']);?>
    <title><?php echo xlt('Assessment'); ?></title>
    <style>
        .profile_table tr td {
            vertical-align: top;
            padding-left: 20px;
            padding-right: 20px;
        }
        .profile_table .inner_table tr td {
            padding: 5px;
        }
        .ml-15 {
            margin-left: 15px;
        }
        .mt-15 {
            margin-top: 15px;
        }
        hr {
            margin-top: 10px;
            margin-bottom: 10px;
        }
        .inner-wrapper {
            background-color: #f4f4f4;
        }
        .tabNav {
            background-color: #f4f4f4 !important;
            padding-top: 20px !important;
            padding-left: 20px !important;
        }
        .tabContainer {
            padding: 20px;
            background-color: #f4f4f4;
        }
        .tab {
            width: 100% !important;
        }
        ul.tabNav a {
            color: #585858 !important;
        }
        .extra {
            margin-top: 20px;
        }
        .button-wrapper {
            margin-top: 20px;
        }
        .button-wrapper .btn-next, .button-wrapper .btn-prev {
            color: white;
            background-color: #29a57f;
            margin-right: 10px;
        }

        :root {
            --highest-bg-color: #c13030;
            --high-bg-color: #ec8835;
            --elevated-bg-color: #eeef26;
            --moderate-bg-color: #26b0ef;
            --low-bg-color: #23b934;
        }

        .slidecontainer {
            width: 100%;
        }

        .slider {
            margin-top: 10px;
            -webkit-appearance: none;
            width: 100%;
            height: 15px;
            border-radius: 5px;
            background: var(--low-bg-color);
            outline: none;
            opacity: 0.7;
            -webkit-transition: .2s;
            transition: opacity .2s;
        }

        .slider:hover {
            opacity: 1;
        }

        .slider::-webkit-slider-thumb {
            -webkit-appearance: none;
            appearance: none;
            width: 30px;
            height: 30px;
            border-radius: 50%;
            background: white;
            cursor: pointer;
            border: solid 10px #00a4ff;
        }

        .slider::-moz-range-thumb {
            width: 30px;
            height: 30px;
            border-radius: 50%;
            background: white;
            cursor: pointer;
            border: solid 10px #00a4ff;
        }

        .highest {
            background: var(--highest-bg-color);
            color: white;
        }
        .high {
            background: var(--high-bg-color);
            color: white;
        }
        .elevated {
            background: var(--elevated-bg-color);
            color: #284229;
        }
        .moderate {
            background: var(--moderate-bg-color);
            color: white;
        }
        .low {
            background: var(--low-bg-color);
            color: white;
        }
        .level-table tr td{
            height: 35px;
        }
        #spanCaption {
            color: white;
            padding: 5px;
            background: var(--low-bg-color);
        }
        .end-button {
            position: absolute;
            background: #de4a4a;
            right: 50px;
            padding: 10px 15px;
            color: white;
            border-radius: 5px;
            margin-top: 20px;
            cursor: pointer;
        }
        .end-button:hover {
            color: white;
            text-decoration: none;
        }
    </style>
</head>

<?php
$patient = getPatientData($patient_id);
$primary_patient = getPatientData($primary_patient_id);
if (isset($_GET['patient_id']) || !isset($encounter)) {
    $encounter = createEncounter($patient_id, $primary_patient_id);
}
$q_s = getAssessmentQuestions();
function generateOpt($q) {
    return array(
        'id' => $q['id'],
        'question' => $q['question'],
        'type' => $q['type'],
        'options' => explode('|', $q['options'])
    );
}

$questions = array_map("generateOpt", $q_s);
?>

<body class='body_top'>
    <div class="ml-15">
        <h2>
        <?php echo $patient['fname'].' '.$patient['lname'] ?>
        </h2>
    </div>
    <?php
    if (isset($_GET['patient_id'])) {
    ?>

        <hr>
        <a href="../../patient_file/summary/demographics.php?set_pid=<?php echo $patient_id?>" class="" onclick="top.restoreSession()">
            <span><?php echo htmlspecialchars(xl('Back'), ENT_NOQUOTES); ?></span>
        </a>
        <hr>
    <?php
    }
    ?>

    <table class="profile_table">
        <tr>
            <td>
                <img src="/public/images/img_avatar.png" alt="Avatar" style="border-radius: 50%; width: 100px;">
            </td>
            <td>
                <table class="inner_table">
                    <tr>
                        <td>Session Contract :</td>
                        <td><?php echo $primary_patient['fname'].' '.$primary_patient['lname'] ?></td>
                    </tr>
                    <tr>
                        <td>Associated Case :</td>
                        <td><?php echo $patient['fname'].' '.$patient['lname'] ?></td>
                    </tr>
                    <tr>
                        <td>Client #:</td>
                        <td>123</td>
                    </tr>
                    <?php echo $primary_patient['email'] ?>
                    <?php echo $primary_patient['phone_home'] ?>
                </table>
            </td>
            <td>
                <table class="table table-striped table-condensed">
                    <tbody>
                        <tr>
                            <td>Status</td>
                            <td>Active 2019-01-14</td>
                        </tr>
                        <tr>
                            <td>Date of Birth</td>
                            <td>01/21/2000(19 Years Old)</td>
                        </tr>
                        <tr>
                            <td>Gender</td>
                            <td>Female</td>
                        </tr>
                        <tr>
                            <td>Risk Profile</td>
                            <td></td>
                        </tr>
                        <tr>
                            <td>PDOC</td>
                            <td>Heroin</td>
                        </tr>
                        <tr>
                            <td>Sober Date</td>
                            <td>07/04/2018</td>
                        </tr>
                        <tr>
                            <td>Treatment Center</td>
                            <td>MAP Recovery(Facility)</td>
                        </tr>
                    </tbody>
                </table>
            </td>
        </tr>
    </table>

    <ul class="tabNav">
        <li class="current">
            <a href="#">Questions</a>
        </li>
        <li class="">
            <a href="">Use Event</a>
        </li>
    </ul>
    <div class="tabContainer">
        <div class="tab current">
            <div class="row">
                <div class="col-md-9">
                    <div class="quiz-wrapper">
                        <h4 class="question"></h4>
                        <div class="row options">
                        </div>
                        <h5 class="extra">
                            As more information about this question:
                        </h5>
                        <textarea name="" rows="4" style="width: 100%;"></textarea>
                    </div>
                    <div class="button-wrapper text-right">
                        <a href="javascript:void(0);" class="btn btn-prev">Previous</a>
                        <a href="javascript:void(0);" class="btn btn-next">Next</a>
                    </div>
                </div>
                <div class="col-md-3">
                    <h5 class="extra text-center"><b>Session Notes</b></h5>
                    <textarea name="" rows="10" class="more" style="width: 100%;"></textarea>
                </div>
            </div>
        </div>
        <div class="tab event">
            Use Event
        </div>
    </div>
    <a class="end-button"><i class="fa fa-stop" aria-hidden="true"></i> End Session</a>
</body>
<script language="Javascript">
    var current_quiz = 0;
    var questions = <?php echo json_encode($questions) ?>;
    var encounter = <?php echo $encounter; ?>;
    function gen_quiz_form(index) {
        var ht = '';
        if (index < 0 || index >= questions.length) {
            return;
        }
        if (questions[index].type === 'radio') {
            $('.question').html(questions[index].question);
            questions[index].options.forEach(option => {
                ht += `
                    <div class="col-md-6">
                        <input type="radio" name="radio" value="${option}"> ${option}
                    </div>
                `;
            })
            $('.options').html(ht);
        } else if (questions[index].type === 'checkbox') {
            $('.question').html(questions[index].question);
            questions[index].options.forEach(option => {
                ht += `
                    <div class="col-md-6">
                        <input type="checkbox" name="${option}" value="${option}"> ${option}
                    </div>
                `;
            })
            $('.options').html(ht);
        } else if (questions[index].type === 'chart') {
            $('.question').html(questions[index].question);
            ht += `
                <div class="col-md-6">
                    <div class="slidecontainer">
                        <span>0</span>
                        <span style="position: absolute; right: 10px;">100</span>
                        <input type="range" min="0" max="100" value="0" class="slider" id="myRange">
                    </div>
                    <p class="mt-15 bold">Risk Level: <span id="spanCaption">Low</span></p>
                    <input type="text" id="myValue" style="width: 100%; border-radius: 3px; border-color: rgb(169, 169, 169);">
                </div>
                <div class="col-md-6">
                    <table class="table table-bordered level-table" style="width: 300px; margin: auto;">
                        <tr>
                            <td>Level</td>
                            <td>Scores</td>
                        </tr>
                        <tr>
                            <td class="highest">Highest</td>
                            <td>90-100</td>
                        </tr>
                        <tr>
                            <td class="high">High</td>
                            <td>60-89</td>
                        </tr>
                        <tr>
                            <td class="Elevated">Elevated</td>
                            <td>30-59</td>
                        </tr>
                        <tr>
                            <td class="moderate">Moderate</td>
                            <td>10-29</td>
                        </tr>
                        <tr>
                            <td class="low">Low</td>
                            <td>0-9</td>
                        </tr>
                    </table>
                </div>
            `;
            $('.options').html(ht);
            slider_init();
        } else if (questions[index].type === 'final') {
            $('.question').html(questions[index].question);
            ht += `
                <div class="col-md-12">
                    <input class="copy_session" type="checkbox"> Copy Session Notes
                </div>
                <div class="col-md-6">
                    <label>Subjective</label>
                    <textarea class="subjective name="" rows="4" style="width: 100%;"></textarea>
                </div>
                <div class="col-md-6">
                    <label>Assessment</label>
                    <textarea class="assessment" name="" rows="4" style="width: 100%;"></textarea>
                </div>
                <div class="col-md-6">
                    <label>Objective</label>
                    <textarea class="objective" name="" rows="4" style="width: 100%;"></textarea>
                </div>
                <div class="col-md-6">
                    <label>Plan</label>
                    <textarea class="plan" name="" rows="4" style="width: 100%;"></textarea>
                </div>
                <div class="col-md-12">
                    <input class="billable" type="checkbox"> Billable
                </div>
            `;
            $('.options').html(ht);
        }

    }

    function slider_init() {
        var slider = document.getElementById("myRange");
        var myValue = document.getElementById("myValue");
        var spanCaption = document.getElementById('spanCaption');
        myValue.value = slider.value;

        slider.oninput = function() {
            myValue.value = this.value;
            if (this.value >= 90 && this.value < 100) {
                this.style.background = 'var(--highest-bg-color)';
                spanCaption.style.background = 'var(--highest-bg-color)';
                spanCaption.innerHTML = 'Highest';
            } else if (this.value >= 60 && this.value < 90) {
                this.style.background = 'var(--high-bg-color)';
                spanCaption.style.background = 'var(--high-bg-color)';
                spanCaption.innerHTML = 'High';
            } else if (this.value >= 30 && this.value < 60) {
                this.style.background = 'var(--elevated-bg-color)';
                spanCaption.style.background = 'var(--elevated-bg-color)';
                spanCaption.innerHTML = 'Elevated';
            } else if (this.value >= 10 && this.value < 29) {
                this.style.background = 'var(--moderate-bg-color)';
                spanCaption.style.background = 'var(--moderate-bg-color)';
                spanCaption.innerHTML = 'Moderate';
            } else if (this.value >= 0 && this.value < 10) {
                this.style.background = 'var(--low-bg-color)';
                spanCaption.style.background = 'var(--low-bg-color)';
                spanCaption.innerHTML = 'Low';
            }
        }
        myValue.onchange = function () {
            slider.value = this.value;
            if (this.value >= 90 && this.value < 100) {
                slider.style.background = 'var(--highest-bg-color)';
                spanCaption.style.background = 'var(--highest-bg-color)';
                spanCaption.innerHTML = 'Highest';
            } else if (this.value >= 60 && this.value < 90) {
                slider.style.background = 'var(--high-bg-color)';
                spanCaption.style.background = 'var(--high-bg-color)';
                spanCaption.innerHTML = 'High';
            } else if (this.value >= 30 && this.value < 60) {
                slider.style.background = 'var(--elevated-bg-color)';
                spanCaption.style.background = 'var(--elevated-bg-color)';
                spanCaption.innerHTML = 'Elevated';
            } else if (this.value >= 10 && this.value < 29) {
                slider.style.background = 'var(--moderate-bg-color)';
                spanCaption.style.background = 'var(--moderate-bg-color)';
                spanCaption.innerHTML = 'Moderate';
            } else if (this.value >= 0 && this.value < 10) {
                slider.style.background = 'var(--low-bg-color)';
                spanCaption.style.background = 'var(--low-bg-color)';
                spanCaption.innerHTML = 'Low';
            }
        }
    }

    function answerQuiz(body) {
        var xhttp = new XMLHttpRequest();
        xhttp.open("POST", "/interface/forms/primary_support/save_ajax.php", true);
        xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
        xhttp.send(`question_id=${body.question_id}&answer=${body.answer}&encounter=${encounter}`);
    }

    $('.btn-next').on('click', function () {
        if (questions[current_quiz].type === 'radio' && document.querySelector('input:checked')) {
            let body = {
                question_id: questions[current_quiz].id,
                answer: document.querySelector('input:checked').value,
                more: document.getElementsByClassName('more')[0].value
            }
            answerQuiz(body);
        } else if (questions[current_quiz].type === 'checkbox') {
            let checkboxes = document.querySelectorAll('input:checked')
            let str = '';
            if (checkboxes.length > 0) {
                checkboxes.forEach(v => {
                    str += v.value + '|'
                })
                str = str.slice(0, -1);
            }
            let body = {
                question_id: questions[current_quiz].id,
                answer: str,
                more: document.getElementsByClassName('more')[0].value
            }
            answerQuiz(body);
        } else if (questions[current_quiz].type === 'chart') {
            let myRange = document.getElementById('myRange');
            if (myRange.value !== '') {
                let body = {
                question_id: questions[current_quiz].id,
                answer: myRange.value,
                more: document.getElementsByClassName('more')[0].value
            }
            answerQuiz(body);
            }
        } else if (questions[current_quiz].type === 'final') {
            let str = JSON.stringify({
                "copy_session_notes": document.getElementsByClassName("copy_session")[0].value,
                "subjective": document.getElementsByClassName("subjective")[0].value,
                "assessment": document.getElementsByClassName("assessment")[0].value,
                "objective": document.getElementsByClassName("objective")[0].value,
                "plan": document.getElementsByClassName("plan")[0].value,
                "billable": document.getElementsByClassName("billable")[0].value
            })
            let body = {
                question_id: questions[current_quiz].id,
                answer: str,
                more: document.getElementsByClassName('more')[0].value
            }
            answerQuiz(body);
        }
        current_quiz++;
        if (current_quiz >= questions.length) {
            current_quiz = questions.length - 1;
        }
        gen_quiz_form(current_quiz);
    })
    $('.btn-prev').on('click', function () {
        current_quiz--;
        if (current_quiz < 0) {
            current_quiz = 0;
        }
        gen_quiz_form(current_quiz);
    })

    $(document).ready(function(){
        tabbify();
        gen_quiz_form(current_quiz);
    })
</script>
</html>

