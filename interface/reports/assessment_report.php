<?php
/**
 * This report shows upcoming assessments with filtering and
 * sorting by patient, practitioner, appointment type, and date.
 *
 * @package   OpenEMR
 * @link      http://www.open-emr.org
 * @author    Rod Roark <rod@sunsetsystems.com>
 * @author    Brady Miller <brady.g.miller@gmail.com>
 * @copyright Copyright (c) 2005-2016 Rod Roark <rod@sunsetsystems.com>
 * @copyright Copyright (c) 2017 Brady Miller <brady.g.miller@gmail.com>
 * @license   https://github.com/openemr/openemr/blob/master/LICENSE GNU General Public License 3
 */


require_once("../globals.php");
require_once("../../library/patient.inc");
require_once "$srcdir/options.inc.php";
require_once("../../library/encounter.inc");

use OpenEMR\Core\Header;

$patient = isset($_POST['patient']) ? $_POST['patient']: 0;
$primary_patient = isset($_POST['primary_patient']) ? $_POST['primary_patient']: 0;
// $date = isset($_POST['assessment_date']) ? $_POST['assessment_date'] : date('Y-m-d');
$encounter = isset($_POST['encounter']) ? $_POST['encounter']: 0;
$state = isset($_POST['state']) ? $_POST['state']: 0;
?>

<html>
<head>
    <title><?php echo xlt('Assessments Report'); ?></title>
    <?php Header::setupHeader(["datetime-picker","report-helper"]); ?>
    <style type="text/css">
        /* specifically include & exclude from printing */
        @media print {
            #report_parameters {
                visibility: hidden;
                display: none;
            }
            #report_parameters_daterange {
                visibility: visible;
                display: inline;
            }
            #report_results table {
                margin-top: 0px;
            }
        }

        /* specifically exclude some from the screen */
        @media screen {
            #report_parameters_daterange {
                visibility: hidden;
                display: none;
            }
        }
    </style>
    <style>
        :root {
            --highest-bg-color: #c13030;
            --high-bg-color: #ec8835;
            --elevated-bg-color: #eeef26;
            --moderate-bg-color: #26b0ef;
            --low-bg-color: #23b934;
        }
        .highest {
            background: var(--highest-bg-color);
            color: white;
            padding: 3px;
        }
        .high {
            background: var(--high-bg-color);
            color: white;
            padding: 3px;
        }
        .elevated {
            background: var(--elevated-bg-color);
            color: #284229;
            padding: 3px;
        }
        .moderate {
            background: var(--moderate-bg-color);
            color: white;
            padding: 3px;
        }
        .low {
            background: var(--low-bg-color);
            color: white;
            padding: 3px;
        }
        .EncounterLink {
            cursor: pointer;
        }
    </style>
    <script type="text/javascript">
        $(document).ready(function() {

        });
    </script>
</head>
<body class="body_top">

<!-- Required for the popup date selectors -->
<div id="overDiv"
    style="position: absolute; visibility: hidden; z-index: 1000;"></div>
<span class='title'><?php echo xlt('Report'); ?> - <?php echo xlt('Assessments'); ?></span>

<div id="report_parameters">
    <table>
        <tr>
            <td width='650px'>
                <div style='float: left'>
                    <form method='post' name='theform' id='theform' action='assessment_report.php' onsubmit='return top.restoreSession()' style="margin-bottom: inherit !important;">
                        <table class='text'>
                            <tr>
                                <td class='control-label'><?php echo xlt('Patient'); ?>:</td>
                                <td>
                                    <?php
                                    $query = "SELECT * FROM patient_data";
                                    $res = sqlStatement($query);
                                    $names = array();
                                    $ids = array();
                                    echo "   <select name='patient' class='form-control' id='patient_select' required>\n";
                                    echo "    <option value='0'>-- " . xlt('Please Select Patient') . " --\n";
                                    while ($row = sqlFetchArray($res)) {
                                        $name = $row['lname'];
                                        if ($name && $row['fname']) {
                                            $name .= ', ';
                                        }

                                        if ($row['fname']) {
                                            $name .= $row['fname'];
                                        }

                                        if ($row['mname']) {
                                            $name .= ' ' . $row['mname'];
                                        }
                                        $names[] = $name;
                                        $ids[] = $row['id'];
                                        echo "    <option value='" . attr($row['id']) . "'" . ($patient==$row['id']?'selected':'');
                                        echo ">" . $name . "\n";
                                    }
                                    echo "   </select>\n";
                                    ?>
                                </td>
                                <td class='control-label'><?php echo xlt('Primary Support'); ?>:</td>
                                <td>
                                    <select name='primary_patient' class='form-control' id='primary_patient_select' required>
                                        <option value="0">None</option>
                                        <?php
                                        $ps_patients = getPrimarySupportsOfPatient($patient);
                                        foreach ($ps_patients as $ps_patient) {
                                            echo "<option value=\"".attr($ps_patient["id"])."\" ";
                                            if ($ps_patient["id"] === $primary_patient) {
                                                echo " selected>" . text(attr($ps_patient["lname"]) . " " . attr($ps_patient["fname"]));
                                            } else {
                                                echo ">" . text(attr($ps_patient["lname"]) . " " . attr($ps_patient["fname"]));
                                            }
                                            echo "</option>\n";
                                        }
                                        ?>
                                    </select>
                                </td>
                            </tr>
                            <tr>
                                <!-- <td class='control-label'><?php echo xlt('Date'); ?>:</td>
                                <td><input type='text' name='assessment_date' id="assessment_date"
                                    class='datepicker form-control' autocomplete="off" size='10' value="<?=$date?>">
                                </td> -->
                                <td class="control-label"><?php echo xlt('Encounter') ?></td>
                                <td>
                                    <select name="encounter" id="encounter_select" class="form-control" required>
                                        <option value="0">None</option>
                                        <?php
                                        $encounters = getEncountersForAssessment($patient, $primary_patient);
                                        if (sizeof($encounters) > 0) {
                                            foreach ($encounters as $encounter_data) {
                                                // if ($date && $date !== explode(" ", $encounter_data['date'])[0]) continue;
                                                echo "<option value=\"".attr($encounter_data["encounter"])."\" ";
                                                if ($encounter_data["encounter"] === $encounter) {
                                                    echo " selected>" . explode(" ", $encounter_data['date'])[0];
                                                } else {
                                                    echo ">" . explode(" ", $encounter_data['date'])[0];
                                                }
                                                echo "</option>\n";
                                            }
                                        }
                                        ?>
                                    </select>
                                </td>
                                <td class='control-label'><?php echo xlt('State'); ?>:</td>
                                <td>
                                    <select name="state" class="form-control">
                                        <option value="0" <?php echo $state==0?"selected":""?>>Open</option>
                                        <option value="1" <?php echo $state==1?"selected":""?>>Approved</option>
                                    </select>
                                </td>
                            </tr>

                        </table>
                    </form>
                </div>
            </td>
            <td align='left' valign='middle' height="100%">
                <table style='border-left: 1px solid; width: 100%; height: 100%'>
                    <tr>
                        <td>
                            <div class="text-center">
                                <div class="btn-group" role="group">
                                    <a href='#' class='btn btn-default btn-save' onclick='$("#theform").submit();'>
                                        <?php echo xlt('Submit'); ?>
                                    </a>
                                </div>
                            </div>
                        </td>
                    </tr>
                </table>
            </td>
        </tr>
    </table>
</div>
<div id='pnotes' style="padding: 30px;">
<?php
function getPatientImpressionQA($enc, $registry) {
    $e_query =
        "SELECT form_assessment_questions.id, form_assessment_questions.type, form_assessment_questions.question, form_assessment_answers.answer" .
        " FROM form_assessment_questions" .
        " INNER JOIN form_assessment_answers ON form_assessment_questions.id = form_assessment_answers.question_id".
        " INNER JOIN form_encounter ON form_assessment_answers.encounter = form_encounter.encounter" .
        " AND form_encounter.encounter = ?" .
        " WHERE form_assessment_answers.parent_reg = ?" .
        " ORDER BY form_encounter.encounter, form_assessment_questions.id";

    $e_questions_query= sqlStatement($e_query, array($enc, $registry));

    $e_question_array = array();
    while ($e_question = sqlFetchArray($e_questions_query)) {
        $e_question_array[] = $e_question;
    }
    return $e_question_array;
}

function getPrimarySupportImpressionQA($enc, $registry) {
    $e_query =
        "SELECT form_assessment_questions.id, form_assessment_questions.type, form_assessment_questions.question, form_assessment_answers.answer" .
        " FROM form_assessment_questions" .
        " INNER JOIN form_assessment_answers ON form_assessment_questions.id = form_assessment_answers.question_id".
        " INNER JOIN form_encounter ON form_assessment_answers.encounter = form_encounter.encounter" .
        " AND form_encounter.encounter = ?" .
        " WHERE form_assessment_answers.parent_reg = ?" .
        " ORDER BY form_encounter.encounter, form_assessment_questions.id";

    $e_questions_query= sqlStatement($e_query, array($enc, $registry));

    $e_question_array = array();
    while ($e_question = sqlFetchArray($e_questions_query)) {
        $e_question_array[] = $e_question;
    }
    return $e_question_array;
}

for ($x = 0; $x < sizeof($encounters); $x++) {
    $enc = $encounters[$x]['encounter'];
    if (($encounter > 0 && $enc != $encounter)) {
        continue;
    }
    $g_encounter_query =
    "SELECT form_encounter.*, pdata.fname as pdata_fname, pdata.lname as pdata_lname, supported_data.fname as supported_data_fname," .
    " supported_data.lname as supported_data_lname FROM form_encounter " .
    " LEFT JOIN patient_data as pdata ON pdata.id = form_encounter.pid " .
    " LEFT JOIN patient_data as supported_data ON supported_data.id = form_encounter.supported_patient " .
    " WHERE form_encounter.encounter = ?";
    $enc_data = sqlQuery($g_encounter_query, array($enc));
    if (!$enc_data) {
        continue;
    }

    $ps_query = sqlStatement("SELECT * FROM registry WHERE directory='primary_support_question' OR directory='patient_question'");
    while ($ps_item = sqlFetchArray($ps_query)) {
        $e_query =
            "SELECT form_assessment_questions.id, form_assessment_questions.type, form_assessment_questions.question, form_assessment_answers.answer, registry.name as registry_name, registry.id as registry" .
            " FROM form_assessment_questions" .
            " INNER JOIN registry ON form_assessment_questions.registry_id = registry.id AND registry.id = ?" .
            " INNER JOIN form_assessment_answers ON form_assessment_questions.id = form_assessment_answers.question_id".
            " INNER JOIN form_encounter ON form_assessment_answers.encounter = form_encounter.encounter";
        if ($patient > 0 && $primary_patient > 0) {
            $e_query .= " AND form_encounter.supported_patient = $patient";
            $e_query .= " AND form_encounter.pid = $primary_patient";
        } else if ($patient > 0 && $primary_patient == 0) {
            // $e_query .= " AND form_encounter.supported_patient = 0";
            $e_query .= " AND (form_encounter.pid = $patient OR form_encounter.supported_patient = $patient)";
        } else if ($patient == 0 && $primary_patient > 0) {
            $e_query .= " AND form_encounter.supported_patient <> 0";
            $e_query .= " AND form_encounter.pid = $primary_patient";
        }

        $e_query .= " AND form_encounter.encounter = ?" .
        " ORDER BY form_encounter.encounter, form_assessment_questions.id";
        $e_questions_query= sqlStatement($e_query, array($ps_item['id'], $enc));

        $e_question_array = array();
        while ($e_question = sqlFetchArray($e_questions_query)) {
            $e_question_array[] = $e_question;
        }

        if (sizeof($e_question_array) == 0) {
            continue;
        }

        $registry = $e_question_array[0]['registry'];
        $enc_state = getEncounterStatus($enc, $registry);
        if ($state != $enc_state) {
            continue;
        }

        if ($enc_data['supported_patient'] == 0) {
            echo "<p style='margin-left:-10px;'>".explode(" ", $enc_data['date'])[0].": <a class='EncounterLink' data-pid=".$enc_data['pid']." data-encounter=".$enc_data['encounter']." data-desc='".$e_question_array[0]['registry_name']."' data-registry='".$registry."'>".$e_question_array[0]['registry_name']."</a> for ".$enc_data['pdata_fname'].", ".$enc_data['pdata_lname']."</p>";
        } else {
            echo "<p style='margin-left:-10px;'>".explode(" ", $enc_data['date'])[0].": <a class='EncounterLink' data-pid=".$enc_data['pid']." data-encounter=".$enc_data['encounter']." data-desc='".$e_question_array[0]['registry_name']."' data-registry='".$registry."'>".$e_question_array[0]['registry_name']."</a> by ".$enc_data['pdata_fname'].", ".$enc_data['pdata_lname']." for ".$enc_data['supported_data_fname'].", ".$enc_data['supported_data_lname']."</p>";
        }

?>
    <table border='0' cellpadding="1" width="100%">
        <tbody>
        <tr style="border-bottom:2px solid #000;" class="text" align='left'>
            <td valign='top' style="width: 80%;">Question</td>
            <td valign='top'>Answer</td>
        </tr>

        <?php
        for ($i = 0; $i < sizeof($e_question_array); $i++) {
            $e_question = $e_question_array[$i];
            if ($e_question['type'] === 'final') {
                continue;
            }
        ?>
        <tr class="noterow">
            <td valign='top' style="width: 80%;"><?=$e_question['question']?></td>
            <td valign='top'><?=$e_question['answer']?></td>
        </tr>
        <?php
        }
        ?>
        </tbody>
    </table>
    <?php
    if ($enc_data['supported_patient'] == 0) {
        $p_im_qa = getPatientImpressionQA($enc, $registry);
    ?>
    <table border='0' cellpadding="1" width="100%" style="margin-top: 15px">
        <tbody>
        <tr style="border-bottom:2px solid #000;" class="text" align='left'>
            <td valign='top' style="width: 80%;">Patient Impression Questions</td>
            <td valign='top'>Answer</td>
        </tr>

        <?php
        for ($i = 0; $i < sizeof($p_im_qa); $i++) {
            $e_question = $p_im_qa[$i];
            if ($e_question['type'] === 'final') {
                continue;
            }
        ?>
        <tr class="noterow">
            <td valign='top' style="width: 80%;"><?=$e_question['question']?></td>
            <td valign='top'><?=$e_question['answer']?></td>
        </tr>
        <?php
        }
        ?>
        </tbody>
    </table>
    <?php
    } else {
        $p_s_im_qa = getPrimarySupportImpressionQA($enc, $registry);
    ?>
    <table border='0' cellpadding="1" width="100%" style="margin-top: 15px">
        <tbody>
        <tr style="border-bottom:2px solid #000;" class="text" align='left'>
            <td valign='top' style="width: 80%;">Primary Support Impression Questions</td>
            <td valign='top'>Answer</td>
        </tr>

        <?php
        for ($i = 0; $i < sizeof($p_s_im_qa); $i++) {
            $e_question = $p_s_im_qa[$i];
            if ($e_question['type'] === 'final') {
                continue;
            }
        ?>
        <tr class="noterow">
            <td valign='top' style="width: 80%;"><?=$e_question['question']?></td>
            <td valign='top'><?=$e_question['answer']?></td>
        </tr>
        <?php
        }
        ?>
        </tbody>
    </table>
    <?php
    }
    ?>

    <div style="margin-top: 20px; height: 30px;">
        <?php
        if ($state == 0) {
        ?>
        <button class="approve" data-enc="<?php echo $enc_data['encounter']; ?>"  data-registry="<?php echo $registry; ?>" style="float: right;">Approve</button>
        <?php
        } else if ($state == 1) {
        ?>
        <button class="disapprove" data-enc="<?php echo $enc_data['encounter']; ?>"  data-registry="<?php echo $registry; ?>" style="float: right;">Disapprove</button>
        <?php
        }
        ?>
    </div>
<?php
    }
}
?>
</div>

<script>
    $('#patient_select').on('change', function () {
        var pid = $(this).val();
        // Load Primary Patient List
        var xhttp = new XMLHttpRequest();
        xhttp.open("POST", "assessment_report_ajax.php", false);
        xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
        xhttp.send(`pid=${pid}`);
        let response = JSON.parse(xhttp.responseText);
        if (!response) {
            response = [];
        }

        var select = document.getElementById('primary_patient_select');
        if (!select) {
            return;
        }
        select.options.length = 0;
        var ht = '';
        select.options[0] = new Option('None', 0, false, false);
        for (let i = 0; i < response.length; i++) {
            var name = response[i].lname;
            if (name && response[i].fname) {
                name += ', ';
            }
            if (response[i].fname) {
                name += response[i].fname;
            }

            select.options[i+1] = new Option(name, response[i].id, false, false);
        }

        loadEncounter();
    })

    function loadEncounter() {
        var pid = $('#patient_select').val();
        var ps_id = $('#primary_patient_select').val();
        var date = $('#assessment_date').val();
        // Load Primary Patient List
        var xhttp = new XMLHttpRequest();
        xhttp.open("POST", "assessment_report_ajax.php", false);
        xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
        xhttp.send(`pid=${pid}&ps_id=${ps_id}`);
        let response = JSON.parse(xhttp.responseText);
        if (!response) {
            response = [];
        }

        var select = document.getElementById('encounter_select');
        if (!select) {
            return;
        }
        select.options.length = 0;
        var ht = '';
        select.options[0] = new Option('None', 0, false, false);
        let p = 0;
        for (let i = 0; i < response.length; i++) {
            var name = response[i].date.split(' ')[0];
            if (date && date !== response[i].date.split(' ')[0]) continue;
            select.options[++p] = new Option(name, response[i].encounter, false, false);
        }
    }

    $('#assessment_date').on('change', function () {
        loadEncounter();
    })

    $('#primary_patient_select').on('change', function () {
        loadEncounter();
    })

    $('.EncounterLink').click(function() {
        let encId = $(this).data('encounter');
        let pId = $(this).data('pid');
        let desc = $(this).data('desc');
        let registry = $(this).data('registry');
        let url;
        if (desc == 'Primary Support Questions') {
            url='patient_file/encounter/encounter_top.php?set_encounter='+encId+'&pid='+pId+'&formname=primary_support_question&formdesc='+desc+'&registry='+registry;
        } else {
            url='patient_file/encounter/encounter_top.php?set_encounter='+encId+'&pid='+pId+'&formname=patient_question&formdesc='+desc+'&registry='+registry;
        }
        top.restoreSession();
        parent.left_nav.loadFrame('enc', 'enc', url);
    })
    $('.approve').click(function() {
        let enc = $(this).data('enc');
        let registry = $(this).data('registry');
        var xhttp = new XMLHttpRequest();
        xhttp.open("POST", "assessment_report_ajax.php", false);
        xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
        xhttp.send(`enc=${enc}&state=1&registry=${registry}`);
        let response = xhttp.responseText;
        if (response == 1) {
            $(this).hide();
        }
    })
    $('.disapprove').click(function() {
        let enc = $(this).data('enc');
        let registry = $(this).data('registry');
        var xhttp = new XMLHttpRequest();
        xhttp.open("POST", "assessment_report_ajax.php", false);
        xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
        xhttp.send(`enc=${enc}&state=0&registry=${registry}`);
        let response = xhttp.responseText;
        if (response == 1) {
            $(this).hide();
        }
    })
</script>
</body>
</html>
