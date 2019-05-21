<?php
include_once("../../globals.php");

function getPatientMetaData($name, $pid) {
    $sql = "select value from patient_meta where pid=? AND name=? order by id DESC limit 1";
    return sqlQuery($sql, array($pid, $name));
}

function insertPatientMetaData($pid, $name, $risk, $encounter) {
    $sql = "INSERT INTO patient_meta (pid,name,value,encounter) VALUES(?,?,?,?)";
    return sqlQuery($sql, array($pid, $name, $risk, $encounter));
}
?>
