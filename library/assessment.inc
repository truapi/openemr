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
    sqlInsert("INSERT INTO form_assessment_answers(question_id, answer, encounter, more) VALUES(?,?,?,?)", array($q_id, $answer, $encounter, $more));
}
