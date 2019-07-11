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
require_once("$srcdir/registry.inc");

use OpenEMR\Core\Header;

$patient_id = isset($_GET['patient_id']) ? $_GET['patient_id'] : "";
$supported_patient_id = isset($_GET['supported_patient_id']) ? $_GET['supported_patient_id'] : "";
$registry = isset($_GET['registry']) ? $_GET['registry'] : null;
/**
 * If registry is empty, this means it is called from Primary Support page
 * Then ingest Primary Support Question registry
 */
$r = getPrimarySupportRegistry();
if ($registry == null) {
    $registry = $r['id'];
}
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
        .quiz-wrapper {
            margin-top: 20px;
        }
        .options {
            padding-left: 20px;
            padding-right: 20px;
        }
        .extra {
            margin-left: 20px;
            margin-right: 20px;
            margin-bottom: 5px;
        }
        .more-info {
            margin-left: 20px;
            margin-right: 20px;
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
            /* background: var(--low-bg-color); */
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
            /* background: var(--low-bg-color); */
        }
        .end-button {
            background: #de4a4a;
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
        .top-btn {
            position: absolute;
            right: 50px;
        }
        .bottom-btn {
            position: relative;
            float: right;
            margin-right: 10px;
            margin-bottom: 30px;
            margin-top: 10px;
        }

    </style>
</head>

<?php
if ($encounter && !isset($_GET['patient_id'])) {
    $encounter_data = fetchEncounterDataById($encounter);
    $patient_id = $encounter_data['pid'];
    $supported_patient_id = $encounter_data['supported_patient'];
}
$patient = getPatientData($patient_id);
$supported_patient = getPatientData($supported_patient_id);
if (isset($_GET['patient_id']) || !isset($encounter)) {
    $encounter = createEncounter($patient_id, $supported_patient_id);
}
$q_s = getAssessmentQuestions($encounter, $registry);
$i_q_s = getAssessmentImpressionQuestions($encounter, 'primary_support_impression_question');
function generateOpt($q) {
    return array(
        'id' => $q['id'],
        'question' => $q['question'],
        'type' => $q['type'],
        'frequency' => $q['frequency'],
        'options' => explode('|', $q['options']),
        'answer' => $q['answer'],
        'more' => $q['more'],
        'date' => $q['date']
    );
}

$questions = array_map("generateOpt", $q_s);
$impression_questions = array_map("generateOpt", $i_q_s);
?>

<body class='body_top'>
    <?php
    // When quiz page is called directly from primary support page
    if (isset($_GET['patient_id'])) {
    ?>
    <script>
        var url='/interface/patient_file/encounter/encounter_top.php?set_encounter=' + <?php echo $encounter; ?> + '&formname=primary_support_question&formdesc=Assessment&back=1&patient_id=<?=$patient_id?>';
        window.location.href = url;
    </script>
    <?php
    }
    // When quiz page is called from PS page -> redirect -> this page
    else {
    ?>
    <div class="ml-15">
        <h2>
        <?php echo $patient['fname'].' '.$patient['lname'] ?>
        </h2>
    </div>
    <table class="profile_table">
        <tr>
            <td>
                <img src="/public/images/img_avatar.png" alt="Avatar" style="border-radius: 50%; width: 100px;">
            </td>
            <td>
                <table class="inner_table">
                    <tr>
                        <td>Patient :</td>
                        <td><?php echo $supported_patient['fname'].' '.$supported_patient['lname'] ?></td>
                    </tr>
                    <tr>
                        <td>Client #:</td>
                        <td>123</td>
                    </tr>
                    <?php echo $supported_patient['email'] ?>
                    <?php echo $supported_patient['phone_home'] ?>
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
                            <?php
                            $date = new DateTime($supported_patient['DOB']);
                            $now = new DateTime();
                            $interval = $now->diff($date);
                            $age = $interval->y;
                            ?>
                            <td> <?= $supported_patient['DOB'] ?> (<?= $age ?> Years Old)</td>
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
        <li class="primary current">
            <a href="#">Primary Support Question</a>
        </li>
        <li class="impression">
            <a href="#">Primary Support Impression</a>
        </li>
    </ul>
    <div class="tabContainer">
        <div class="tab current main">
            <div class="row">
                <div class="col-md-8 q-wrapper">

                </div>
                <div class="col-md-4">
                    <h5 class="text-center"><b>Session Notes</b></h5>
                    <textarea name="" rows="10" style="width: 100%;"></textarea>
                </div>
            </div>
        </div>
        <div class="tab impression">
            <div class="row">
                <div class="col-md-8 q-impression-wrapper">

                </div>
                <div class="col-md-4">
                    <h5 class="text-center"><b>Session Notes</b></h5>
                    <textarea name="" rows="10" style="width: 100%;"></textarea>
                </div>
            </div>
        </div>
        <a class="end-button bottom-btn"><i class="fa fa-stop" aria-hidden="true"></i> End Session</a>
    </div>
    <a class="end-button top-btn"><i class="fa fa-stop" aria-hidden="true"></i> End Session</a>

    <?php } ?>
</body>
<script language="Javascript">
    function getRiskText($value) {
        if ($value > 90) {
            return 'Highest';
        } else if ($value > 60) {
            return 'High';
        } else if ($value > 30) {
            return 'Elevated';
        } else if ($value > 10) {
            return 'Moderate';
        } else if ($value > 0) {
            return 'Low';
        } else {
            return 'Elevated';
        }
    }

    function getRiskCss($value) {
        if ($value > 90) {
            return 'highest';
        } else if ($value > 60) {
            return 'high';
        } else if ($value > 30) {
            return 'elevated';
        } else if ($value > 10) {
            return 'moderate';
        } else if ($value > 0) {
            return 'low';
        } else {
            return 'elevated';
        }
    }

    var current_quiz = 0;
    var questions = <?php echo json_encode($questions) ?>;
    var impression_questions = <?php echo json_encode($impression_questions) ?>;
    if (!questions) {
        questions = [];
    }
    var encounter = <?php echo $encounter; ?>;

    function genOption(question) {
        var ht = '';
        if (question.type === 'radio') {
            question.options.forEach(option => {
                ht += `
                    <div class="col-md-6">
                        <input type="radio" name="${question.id}" value="${option}" ${question.answer===option?'checked':''}> ${option}
                    </div>
                `;
            })
        } else if (question.type === 'checkbox') {
            question.options.forEach(option => {
                ht += `
                    <div class="col-md-6">
                        <input type="checkbox" name="${option}" value="${option}" ${question.answer&&question.answer.split('|').includes(option)?'checked':''}> ${option}
                    </div>
                `;
            })
        } else if (question.type === 'chart') {
            ht += `
                <div class="col-md-6">
                    <div class="slidecontainer">
                        <span>0</span>
                        <span style="position: absolute; right: 10px;">100</span>
                        <input type="range" min="0" max="100" value="${question.answer}" class="slider ${getRiskCss(question.answer)}" id="myRange">
                    </div>
                    <p class="mt-15 bold">Risk Level: <span id="spanCaption" class="${getRiskCss(question.answer)}">${getRiskText(question.answer)}</span></p>
                    <input type="text" id="myValue" value="${question.answer}" style="width: 100%; border-radius: 3px; border-color: rgb(169, 169, 169);">
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
        } else if (question.type === 'final') {
            let obj = question.answer && question.answer.length > 0?JSON.parse(question.answer):{};
            ht += `
                <div class="col-md-12">
                    <input class="copy_session" type="checkbox" ${obj.copy_session_notes==='on'?'checked':''}> Copy Session Notes
                </div>
                <div class="col-md-6">
                    <label>Subjective</label>
                    <textarea class="subjective name="" rows="4" style="width: 100%;">${obj.subjective?obj.subjective:''}</textarea>
                </div>
                <div class="col-md-6">
                    <label>Assessment</label>
                    <textarea class="assessment" name="" rows="4" style="width: 100%;">${obj.assessment?obj.assessment:''}</textarea>
                </div>
                <div class="col-md-6">
                    <label>Objective</label>
                    <textarea class="objective" name="" rows="4" style="width: 100%;">${obj.objective?obj.objective:''}</textarea>
                </div>
                <div class="col-md-6">
                    <label>Plan</label>
                    <textarea class="plan" name="" rows="4" style="width: 100%;">${obj.plan?obj.plan:''}</textarea>
                </div>
                <div class="col-md-12">
                    <input class="billable" type="checkbox" ${obj.billable==='on'?'checked':''}> Billable
                </div>
            `;
        }

        return ht;
    }

    function get_quiz() {
        var ht = '';
        var num = 0;
        for (let index = 0; index < questions.length; index++) {
            if (questions[index].frequency && (new Date().getTime()-new Date(questions[index].date).getTime())/(1000*60*60*24) < questions[index].frequency) {
                continue;
            }
            num++;
            ht +=
            `
            <div class="quiz-wrapper quiz-${index}">
                <h4 class="question">${num + '. ' + questions[index].question}</h4>
                <div class="row options">
                    ${genOption(questions[index])}
                </div>
                <h5 class="extra" style="display: ${questions[index].type === 'final'?'none':''}">
                    Add more information about this question:
                </h5>
                <textarea name="" rows="4" class="more-info" style="width: 100%; display: ${questions[index].type === 'final'?'none':''}">${questions[index].more?questions[index].more:''}</textarea>
            </div>
            `
        }
        $('.q-wrapper').html(ht);
        slider_init();
    }

    function get_impression_quiz() {
        var ht = '';
        var num = 0;
        for (let index = 0; index < impression_questions.length; index++) {
            if (impression_questions[index].frequency && (new Date().getTime()-new Date(impression_questions[index].date).getTime())/(1000*60*60*24) < impression_questions[index].frequency) {
                continue;
            }
            num++;
            ht +=
            `
            <div class="quiz-wrapper impression-quiz-${index}">
                <h4 class="question">${num + '. ' + impression_questions[index].question}</h4>
                <div class="row options">
                    ${genOption(impression_questions[index])}
                </div>
                <h5 class="extra" style="display: ${impression_questions[index].type === 'final'?'none':''}">
                    Add more information about this question:
                </h5>
                <textarea name="" rows="4" class="more-info" style="width: 100%; display: ${impression_questions[index].type === 'final'?'none':''}">${impression_questions[index].more?impression_questions[index].more:''}</textarea>
            </div>
            `
        }
        $('.q-impression-wrapper').html(ht);
        slider_init();
    }

    function slider_init() {
        var slider = document.getElementById("myRange");
        var myValue = document.getElementById("myValue");
        var spanCaption = document.getElementById('spanCaption');
        if (!slider) {
            return;
        }
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
            } else {
                this.style.background = 'var(--elevated-bg-color)';
                spanCaption.style.background = 'var(--elevated-bg-color)';
                spanCaption.innerHTML = 'Elevated';
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
            } else {
                slider.style.background = 'var(--elevated-bg-color)';
                spanCaption.style.background = 'var(--elevated-bg-color)';
                spanCaption.innerHTML = 'Elevated';
            }
        }
    }

    var is_saving = false;
    function answerQuiz(questions) {
        var xhttp = new XMLHttpRequest();
        xhttp.open("POST", "/interface/forms/primary_support_question/save_ajax.php", false);
        xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
        xhttp.send(`encounter=${encounter}&questions=${JSON.stringify(questions)}&pid=<?php echo $supported_patient_id?>`);
        alert('Answers are stored successfully.');
        is_saving = false;
    }

    function answerImpressionQuiz(questions) {
        var xhttp = new XMLHttpRequest();
        xhttp.open("POST", "/interface/forms/primary_support_question/save_ajax.php", false);
        xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
        xhttp.send(`encounter=${encounter}&questions=${JSON.stringify(questions)}&pid=<?php echo $supported_patient_id?>&registry=<?php echo $registry?>`);
        alert('Answers are stored successfully.');
        is_saving = false;
    }

    $('.end-button').on('click', function () {
        if (is_saving) {
            return;
        }
        is_saving = true;
        if ($('.primary').hasClass('current')) {
            for(let i = 0; i < questions.length; i++) {
                if (questions[i].type === 'radio' && document.querySelector(`.quiz-${i} input:checked`)) {
                    questions[i].answer = document.querySelector(`.quiz-${i} input:checked`).value;
                    questions[i].more = document.querySelector(`.quiz-${i} .more-info`).value;
                } else if (questions[i].type === 'checkbox') {
                    let checkboxes = document.querySelectorAll(`.quiz-${i} input:checked`)
                    let str = '';
                    if (checkboxes.length > 0) {
                        checkboxes.forEach(v => {
                            str += v.value + '|'
                        })
                        str = str.slice(0, -1);
                    }
                    questions[i].answer = str;
                    questions[i].more = document.querySelector(`.quiz-${i} .more-info`).value;
                } else if (questions[i].type === 'chart') {
                    let myRange = document.getElementById('myRange');
                    if (myRange.value !== '') {
                        questions[i].answer = myRange.value;
                        questions[i].more = document.querySelector(`.quiz-${i} .more-info`).value;
                    }
                } else if (questions[i].type === 'text') {
                    questions[i].more = document.querySelector(`.quiz-${i} .more-info`).value;
                }
            }
            answerQuiz(questions);
            $(this).parent().find('.tabNav>.impression>a').click();
        } else if ($('.impression').hasClass('current')) {
            for(let i = 0; i < impression_questions.length; i++) {
                if (impression_questions[i].type === 'radio' && document.querySelector(`.impression-quiz-${i} input:checked`)) {
                    impression_questions[i].answer = document.querySelector(`.impression-quiz-${i} input:checked`).value;
                    impression_questions[i].more = document.querySelector(`.impression-quiz-${i} .more-info`).value;
                } else if (impression_questions[i].type === 'checkbox') {
                    let checkboxes = document.querySelectorAll(`.impression-quiz-${i} input:checked`)
                    let str = '';
                    if (checkboxes.length > 0) {
                        checkboxes.forEach(v => {
                            str += v.value + '|'
                        })
                        str = str.slice(0, -1);
                    }
                    impression_questions[i].answer = str;
                    impression_questions[i].more = document.querySelector(`.impression-quiz-${i} .more-info`).value;
                } else if (impression_questions[i].type === 'chart') {
                    let myRange = document.getElementById('myRange');
                    if (myRange.value !== '') {
                        impression_questions[i].answer = myRange.value;
                        impression_questions[i].more = document.querySelector(`.impression-quiz-${i} .more-info`).value;
                    }
                } else if (impression_questions[i].type === 'text') {
                    impression_questions[i].more = document.querySelector(`.impression-quiz-${i} .more-info`).value;
                }
            }
            answerImpressionQuiz(impression_questions);
        }
    })

    $(document).ready(function(){
        tabbify();
        get_quiz();
        get_impression_quiz();
    })
</script>


<?php
if ($patient_id === $pid) {
// Update Encounter count of top page
$result4 = sqlStatement("SELECT fe.encounter,fe.date,openemr_postcalendar_categories.pc_catname FROM form_encounter AS fe ".
" left join openemr_postcalendar_categories on fe.pc_catid=openemr_postcalendar_categories.pc_catid  WHERE fe.pid = ? order by fe.date desc", array($pid));
?>
<script language='JavaScript'>
    EncounterDateArray=new Array;
    CalendarCategoryArray=new Array;
    EncounterIdArray=new Array;
    Count=0;
    <?php
    if (sqlNumRows($result4)>0) {
        while ($rowresult4 = sqlFetchArray($result4)) {
    ?>
        EncounterIdArray[Count]='<?php echo attr($rowresult4['encounter']); ?>';
        EncounterDateArray[Count]='<?php echo attr(oeFormatShortDate(date("Y-m-d", strtotime($rowresult4['date'])))); ?>';
        CalendarCategoryArray[Count]='<?php echo attr(xl_appt_category($rowresult4['pc_catname'])); ?>';
        Count++;
    <?php
        }
    }
    ?>

    // Get the left_nav window, and the name of its sibling (top or bottom) frame that this form is in.
    // This works no matter how deeply we are nested.
    var my_left_nav = top.left_nav;
    var w = window;
    for (; w.parent != top; w = w.parent);
    var my_win_name = w.name;
    my_left_nav.setPatientEncounter(EncounterIdArray,EncounterDateArray,CalendarCategoryArray);
    top.restoreSession();
</script>
<?php
}
?>
</html>
