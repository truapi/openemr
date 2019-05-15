<?php

require_once("../globals.php");
require_once("../../library/patient.inc");
require_once("../../library/encounter.inc");

$pid = (isset($_REQUEST['pid'])) ? $_REQUEST['pid'] : '';
$ps_id = (isset($_REQUEST['ps_id'])) ? $_REQUEST['ps_id'] : '';
if (!isset($_REQUEST['ps_id'])) {
    $patients = getPrimarySupportsOfPatient($pid);
    echo json_encode($patients);
} else {
    $encounters = getEncountersForAssessment($pid, $ps_id);
    echo json_encode($encounters);
}
?>
