<?php
include_once("../../globals.php");
include_once("$srcdir/forms.inc");

//function called to set the global session variable for encounter number
function setencounter($enc)
{

    // Escape $enc by forcing it to an integer to protect from sql injection
    $enc = intval($enc);

    $return_val = 1;
    global $encounter;
    global $pid;
    global $attendant_type;

    $attendant_id = $attendant_type == 'pid' ? $pid : $_SESSION['therapy_group'];
    if ($enc == "") {
        $enc = date("Ymd");
        if (getFormByEncounter($attendant_id, $enc)) {
            //there is an encounter enterred for today
        } else {
            //addForm($enc, "New Patient Encounter", 0, $pid, 1);
            $return_val = 0;
        }
    }

    $_SESSION['encounter']=$enc;
    $encounter=$enc;


    //returns 1 on successful global set, or 0 if there was no
    //current encounter, signifying that the interface should load
    //the screen for a new encounter
    return $return_val;
}


//fetches encounter pc_catid by encounter number
function fetchCategoryIdByEncounter($encounter)
{
    global $attendant_type;
    $table = $attendant_type == 'pid' ? 'form_encounter' : 'form_groups_encounter';
    $sql = "select pc_catid from $table where encounter=? limit 1";
    $result = sqlQuery($sql, array($encounter));
    return $result['pc_catid'];
}

function createEncounter($patient_id, $supported_patient_id) {
    $enc_id = generate_id();
    sqlInsert("INSERT INTO form_encounter (date, pid, encounter, supported_patient, pc_catid) VALUES(?,?,?,?,?)", array(date('Y-m-d H:i:s'), $patient_id, $enc_id, $supported_patient_id, 16));
    return $enc_id;
}

function fetchEncounterDataById($encounter) {
    global $attendant_type;
    $table = $attendant_type == 'pid' ? 'form_encounter' : 'form_groups_encounter';
    $sql = "select * from $table where encounter=? limit 1";
    $result = sqlQuery($sql, array($encounter));
    return $result;
}

function getEncountersForAssessment($pid, $ps_id) {
    global $sqlconf;
    $host = $sqlconf["host"];
    $port = $sqlconf["port"];
    $login = $sqlconf["login"];
    $pass = $sqlconf["pass"];
    $dbase = $sqlconf["dbase"];
    $dbh = mysqli_connect("$host", "$login", "$pass", $dbase, $port);
    if (!$dbh) {
        echo "MySQL connect failed";
    };
    $table = 'form_encounter';
    $query = "select * from $table";
    if ($ps_id > 0 && $pid > 0) {
        $query .= " where pc_catid = 16";
        $query .= " AND pid = $ps_id";
        $query .= " AND supported_patient = $pid";
    } else if ($ps_id == 0 && $pid > 0) {
        $query .= " WHERE (pid = $pid AND supported_patient = 0) OR (supported_patient = $pid AND pc_catid = 16)";
    } else if ($ps_id > 0 && $pid == 0) {
        $query .= " where pc_catid = 16";
        $query .= " AND pid = $ps_id AND supported_patient <> 0";
    }
    // $query = "select * from $table where pc_catid = 16 AND pid = $ps_id AND supported_patient = $pid";
    $result = mysqli_query($dbh, $query);
    while($encounter = mysqli_fetch_array($result)) {
        if ($encounter) {
            $res[] = $encounter;
        }
    }
    return $res;
}

function getEncounterStatus($enc, $registry) {
    global $sqlconf;
    $host = $sqlconf["host"];
    $port = $sqlconf["port"];
    $login = $sqlconf["login"];
    $pass = $sqlconf["pass"];
    $dbase = $sqlconf["dbase"];
    $dbh = mysqli_connect("$host", "$login", "$pass", $dbase, $port);
    if (!$dbh) {
        echo "MySQL connect failed";
    };
    $table = 'form_encounter_review';
    $query = "select * from $table where encounter = $enc AND registry = $registry";

    $result = mysqli_query($dbh, $query);
    $res = array();
    while($review = mysqli_fetch_array($result)) {
        if ($review) {
            $res[] = $review;
        }
    }
    if (sizeof($res) == 1) {
        return $res[0]['status'];
    } else {
        return 0;
    }
}

function setEncounterStatus($enc, $registry, $state) {
    global $sqlconf;
    $host = $sqlconf["host"];
    $port = $sqlconf["port"];
    $login = $sqlconf["login"];
    $pass = $sqlconf["pass"];
    $dbase = $sqlconf["dbase"];
    $dbh = mysqli_connect("$host", "$login", "$pass", $dbase, $port);
    if (!$dbh) {
        echo "MySQL connect failed";
    };

    $table = 'form_encounter_review';
    $query = "select * from $table where encounter = $enc AND registry = $registry";

    $result = mysqli_query($dbh, $query);
    $res = array();
    while($review = mysqli_fetch_array($result)) {
        if ($review) {
            $res[] = $review;
        }
    }
    if (sizeof($res) == 1) {
        sqlQuery("update form_encounter_review set status = $state where encounter = $enc and registry = $registry");
    } else {
        sqlInsert("INSERT INTO form_encounter_review (encounter, status, registry) VALUES(?,?,?)", array($enc, $state, $registry));
    }
    return;
}
