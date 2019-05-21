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
$date = isset($_POST['assessment_date']) ? $_POST['assessment_date'] : date('Y-m-d');
$encounter = isset($_POST['encounter']) ? $_POST['encounter']: 0;
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

    <script type="text/javascript">
        $(document).ready(function() {
            $('.datepicker').datetimepicker({
                <?php $datetimepicker_timepicker = false; ?>
                <?php $datetimepicker_showseconds = false; ?>
                <?php $datetimepicker_formatInput = true; ?>
                <?php require($GLOBALS['srcdir'] . '/js/xl/jquery-datetimepicker-2-5-4.js.php'); ?>
                <?php // can add any additional javascript settings to datetimepicker here; need to prepend first setting with a comma ?>
            });

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
                                    echo "    <option value=''>-- " . xlt('Please Select Patient') . " --\n";
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
                                        <?php
                                        $ps_patients = getPrimarySupportsOfPatient($patient);
                                        if ($primary_patient == 0) {
                                        ?>
                                        <option value="0">None</option>
                                        <?php
                                        } else {
                                            foreach ($ps_patients as $ps_patient) {
                                                echo "<option value=\"".attr($ps_patient["id"])."\" ";
                                                if ($ps_patient["id"] === $primary_patient) {
                                                    echo " selected>" . text(attr($ps_patient["lname"]) . " " . attr($ps_patient["fname"]));
                                                } else {
                                                    echo ">" . text(attr($ps_patient["lname"]) . " " . attr($ps_patient["fname"]));
                                                }
                                                echo "</option>\n";
                                            }
                                        }
                                        ?>
                                    </select>
                                </td>
                            </tr>
                            <tr>
                                <td class='control-label'><?php echo xlt('Date'); ?>:</td>
                                <td><input type='text' name='assessment_date' id="assessment_date"
                                    class='datepicker form-control' autocomplete="off" size='10' value="<?=$date?>">
                                </td>
                                <td class="control-label"><?php echo xlt('Encounter') ?></td>
                                <td>
                                    <select name="encounter" id="encounter_select" class="form-control" required>
                                        <?php
                                        if ($patient && $primary_patient) {
                                            $encounters = getEncountersForAssessment($patient, $primary_patient);
                                            foreach ($encounters as $encounter_data) {
                                                if ($date && $date !== explode(" ", $encounter_data['date'])[0]) continue;
                                                echo "<option value=\"".attr($encounter_data["encounter"])."\" ";
                                                if ($encounter_data["encounter"] === $encounter) {
                                                    echo " selected>" . explode(" ", $encounter_data['date'])[0];
                                                } else {
                                                    echo ">" . explode(" ", $encounter_data['date'])[0];
                                                }
                                                echo "</option>\n";
                                            }
                                        } else {
                                        ?>
                                        <option value="0">None</option>
                                        <?php
                                        }
                                        ?>
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
<div id='pnotes' style="padding: 50px;">
<?php
if ($encounter > 0) {
    $ps_query = sqlStatement("SELECT * FROM registry WHERE directory='primary_support'");
    while ($ps_item = sqlFetchArray($ps_query)) {
        if ($ps_item['name'] === 'Assessment') {
            $e_query =
                "SELECT form_assessment_questions.id, form_assessment_questions.type, form_assessment_questions.question, form_assessment_answers.answer FROM form_assessment_questions" .
                " INNER JOIN registry ON form_assessment_questions.registry_id = registry.id AND registry.id = ?" .
                " INNER JOIN form_assessment_answers ON form_assessment_questions.id = form_assessment_answers.question_id" .
                " INNER JOIN form_encounter ON form_assessment_answers.encounter = form_encounter.encounter AND (form_encounter.supported_patient = ? OR form_encounter.pid = ?) AND form_encounter.encounter = ?" .
                " ORDER BY form_encounter.encounter, form_assessment_questions.id";
            $e_questions_query= sqlStatement($e_query, array($ps_item['id'], $patient, $patient, $encounter));
?>
        <table border='0' cellpadding="1" width="100%">
            <tbody>
            <tr style="border-bottom:2px solid #000;" class="text" align='left'>
                <td valign='top' style="width: 80%;">Question</td>
                <td valign='top'>Answer</td>
            </tr>
        <?php
            while ($e_question = sqlFetchArray($e_questions_query)) {
        ?>
            <?php
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
        <div style="margin-top: 20px;">
            <button>Approve</button>
            <button>Decline</button>
        </div>
<?php
        }
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
    })

    function loadEncounter() {
        var pid = $('#patient_select').val();
        var ps_id = $('#primary_patient_select').val();
        var date = $('#assessment_date').val();
        if (pid === 0 || ps_id === 0) {
            return;
        }
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

</script>
</body>
</html>
