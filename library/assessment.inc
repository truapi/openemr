<?php
include_once("../../globals.php");
include_once("$srcdir/forms.inc");

function getAssessmentQuestions() {
    global $sqlconf;
    $host = $sqlconf["host"];
    $port = $sqlconf["port"];
    $login = $sqlconf["login"];
    $pass = $sqlconf["pass"];
    $dbase = $sqlconf["dbase"];
    $dbh = mysqli_connect("$host", "$login", "$pass", $dbase, $port);
    if (!$dbh) {
        echo "MySQL connect failed";
    }
    $query  =
        "SELECT * FROM form_assessment_questions";

    $result = mysqli_query($dbh, $query);
    while($question = mysqli_fetch_array($result)) {
        if ($question) {
            $res[] = $question;
        }
    }
    return $res;
}

function saveAssessmentAnswer($q_id, $answer, $encounter, $more) {
    $query = "SELECT * FROM form_assessment_answers WHERE question_id = " . $q_id . " AND encounter = " .$encounter . " LIMIT 1";
    $row = sqlFetchArray(sqlStatement($query));
    if ($row) {
        sqlStatement("UPDATE form_assessment_answers SET answer = '" . $answer . "', more = '" .$more . "' WHERE question_id = " . $q_id . " AND encounter = " .$encounter);
    } else {
        sqlInsert("INSERT INTO form_assessment_answers(question_id, answer, encounter, more) VALUES(?,?,?,?)", array($q_id, $answer, $encounter, $more));
    }
}

function getAssessmentAnswer($q_id, $encounter) {
    global $sqlconf;
    $host = $sqlconf["host"];
    $port = $sqlconf["port"];
    $login = $sqlconf["login"];
    $pass = $sqlconf["pass"];
    $dbase = $sqlconf["dbase"];
    $dbh = mysqli_connect("$host", "$login", "$pass", $dbase, $port);
    if (!$dbh) {
        echo "MySQL connect failed";
    }
    $query  =
        "SELECT * FROM form_assessment_answers WHERE question_id = " . $q_id . " AND encounter = " .$encounter;
    $result = mysqli_query($dbh, $query);
    while($question = mysqli_fetch_array($result)) {
        if ($question) {
            $res[] = $question;
        }
    }
    return $res;
}
