<?php
include_once("../../globals.php");

function getPatientMetaData($name, $pid, $encounter = null) {
    if ($encounter) {
        $sql = "select value from patient_meta where pid=? AND name=? AND encounter = ? order by id DESC limit 1";
        return sqlQuery($sql, array($pid, $name, $encounter));
    } else {
        $sql = "select value from patient_meta where pid=? AND name=? order by id DESC limit 1";
        return sqlQuery($sql, array($pid, $name));
    }
}

function insertPatientMetaData($pid, $name, $risk, $encounter) {
    $sql = "INSERT INTO patient_meta (pid,name,value,encounter) VALUES(?,?,?,?)";
    return sqlQuery($sql, array($pid, $name, $risk, $encounter));
}

function updatePatientMetaData($pid, $name, $risk, $encounter) {
    sqlStatement("UPDATE patient_meta SET value = " . $risk . " WHERE pid = " . $pid . " AND name = '" .$name . "' AND encounter = " .$encounter);
    // return sqlQuery($sql);
}

?>
