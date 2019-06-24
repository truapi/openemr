<?php
require_once("../globals.php");
require_once("../../library/patient.inc");
require_once("../../library/encounter.inc");

$pid = (isset($_REQUEST['pid'])) ? $_REQUEST['pid'] : '';
$ps_id = (isset($_REQUEST['ps_id'])) ? $_REQUEST['ps_id'] : '';
header('Content-type: application/json');

if (isset($_REQUEST['state'])) {
    $enc = $_REQUEST['enc'];
    $registry = $_REQUEST['registry'];
    $state = $_REQUEST['state'];
    setEncounterStatus($enc, $registry, $state);
    echo 1;
    exit();
}

if (!isset($_REQUEST['ps_id'])) {
    $patients = getPrimarySupportsOfPatient($pid);
    $encode=json_encode($patients);
    echo $encode;
    exit();
} else {
    $encounters = getEncountersForAssessment($pid, $ps_id);
    echo json_encode($encounters);
    exit();
}
?>
