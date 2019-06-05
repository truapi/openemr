<?php
// Copyright (C) 2009, 2017 Rod Roark <rod@sunsetsystems.com>
//
// This program is free software; you can redistribute it and/or
// modify it under the terms of the GNU General Public License
// as published by the Free Software Foundation; either version 2
// of the License, or (at your option) any later version.

/**
 * This file is to save assessment quiz result.
 */
require_once("../../globals.php");
require_once("$srcdir/assessment.inc");
require_once("$srcdir/patient_risk.inc");

$pid = isset($_POST["pid"]) ? $_POST["pid"]: '';
$question_id = isset($_POST["question_id"]) ? $_POST["question_id"]: '';
$answer = isset($_POST["answer"]) ? $_POST["answer"]: '';
$encounter = isset($_POST["encounter"]) ? $_POST["encounter"]: '';
$more = isset($_POST["more"]) ? $_POST["more"]: '';
$questions = isset($_POST['questions']) ? json_decode($_POST['questions']): null;
if ($questions) {
    foreach($questions as $q) {
        if (strlen($q->answer) > 0 || strlen($q->more) > 0) {
            saveAssessmentAnswer($q->id, $q->answer, $encounter, $q->more);
            if ($q->type === 'chart') {
                $risk = getPatientMetaData('Risk',$pid, $encounter);
                if ($risk['value']) {
                    updatePatientMetaData($pid,'Risk',$q->answer, $encounter);
                } else {
                    insertPatientMetaData($pid,'Risk',$q->answer, $encounter);
                }

            }
        }
    }
}
echo "done";
?>
