<?php
include_once("../../globals.php");
include_once("$srcdir/forms.inc");

function getAssessmentQuestions($encounter, $registry) {
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
        "SELECT form_assessment_questions.*, form_assessment_answers.answer, form_assessment_answers.more, form_assessment_answers.date ".
        "FROM form_assessment_questions ".
        "LEFT JOIN form_assessment_answers ON form_assessment_questions.id=form_assessment_answers.question_id AND form_assessment_answers.encounter=".$encounter.
        " WHERE form_assessment_questions.registry_id=".$registry.
        " ORDER BY form_assessment_questions.id";

    $result = mysqli_query($dbh, $query);
    while($question = mysqli_fetch_array($result)) {
        if ($question) {
            $res[] = $question;
        }
    }
    return $res;
}

function getAssessmentImpressionQuestions($encounter, $directory) {
    /**
     * $directory is directory of registry
     * primary_support_impression_question|patient_impression_question
     */
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
        "SELECT form_assessment_questions.*, form_assessment_answers.answer, form_assessment_answers.more, form_assessment_answers.date".
        " FROM form_assessment_questions".
        " LEFT JOIN form_assessment_answers ON form_assessment_questions.id=form_assessment_answers.question_id AND form_assessment_answers.encounter=".$encounter.
        " INNER JOIN registry ON registry.directory='".$directory."'".
        " WHERE form_assessment_questions.registry_id=registry.id".
        " ORDER BY form_assessment_questions.id";

    $result = mysqli_query($dbh, $query);
    while($question = mysqli_fetch_array($result)) {
        if ($question) {
            $res[] = $question;
        }
    }
    return $res;
}

function getPatientImpressionQuestions($encounter, $registry) {
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
        "SELECT form_assessment_questions.*, form_assessment_answers.answer, form_assessment_answers.more, form_assessment_answers.date".
        " FROM form_assessment_questions".
        " LEFT JOIN form_assessment_answers ON form_assessment_questions.id=form_assessment_answers.question_id AND form_assessment_answers.encounter=".$encounter." AND form_assessment_answers.parent_reg=".$registry.
        " INNER JOIN registry ON registry.directory='patient_impression_question' ".
        " WHERE form_assessment_questions.registry_id=registry.id".
        " ORDER BY form_assessment_questions.id";

    $result = mysqli_query($dbh, $query);
    while($question = mysqli_fetch_array($result)) {
        if ($question) {
            $res[] = $question;
        }
    }
    return $res;
}

function saveAssessmentAnswer($q_id, $answer, $encounter, $more, $registry=null) {
    if ($registry) {
        $query = "SELECT * FROM form_assessment_answers WHERE question_id = " . $q_id . " AND encounter = " .$encounter . " AND parent_reg = " .$registry. " LIMIT 1";
        $row = sqlFetchArray(sqlStatement($query));
        if ($row) {
            sqlStatement("UPDATE form_assessment_answers SET answer = '" . $answer . "', more = '" .$more . "', date = '" .date("Y-m-d H:i:s"). "' WHERE question_id = " . $q_id . " AND encounter = " .$encounter . " AND parent_reg = " .$registry);
        } else {
            sqlInsert("INSERT INTO form_assessment_answers(question_id, answer, encounter, more, parent_reg, date) VALUES(?,?,?,?,?,?)", array($q_id, $answer, $encounter, $more, $registry, date("Y-m-d H:i:s")));
        }
    } else {
        $query = "SELECT * FROM form_assessment_answers WHERE question_id = " . $q_id . " AND encounter = " .$encounter . " LIMIT 1";
        $row = sqlFetchArray(sqlStatement($query));
        if ($row) {
            sqlStatement("UPDATE form_assessment_answers SET answer = '" . $answer . "', more = '" .$more . "', date = '" .date("Y-m-d H:i:s"). "' WHERE question_id = " . $q_id . " AND encounter = " .$encounter);
        } else {
            sqlInsert("INSERT INTO form_assessment_answers(question_id, answer, encounter, more, date) VALUES(?,?,?,?,?)", array($q_id, $answer, $encounter, $more, date("Y-m-d H:i:s")));
        }
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
    while($answer = mysqli_fetch_array($result)) {
        if ($answer) {
            $res[] = $answer;
        }
    }
    return $res;
}
