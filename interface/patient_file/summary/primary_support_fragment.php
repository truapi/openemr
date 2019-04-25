<?php
//
// Copyright (C) 2010 Brady Miller (brady.g.miller@gmail.com)
//
// This program is free software; you can redistribute it and/or
// modify it under the terms of the GNU General Public License
// as published by the Free Software Foundation; either version 2
// of the License, or (at your option) any later version.
//
// This simply shows the Clinical Reminder Widget
//



require_once(dirname(__FILE__) . "/../../globals.php");
// require_once(dirname(__FILE__) . "/../../../sites/default/sqlconf.php");
//To improve performance and not freeze the session when running this
// report, turn off session writing. Note that php session variables
// can not be modified after the line below. So, if need to do any php
// session work in the future, then will need to remove this line.
session_write_close();

function printPrimarySupportPatient($patient_id) {
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
        "SELECT patient_data.id, patient_data.fname, patient_data.lname FROM patient_data " .
        "INNER JOIN patient_support ON patient_data.id = patient_support.sid " .
        "WHERE patient_support.pid = '$patient_id'";

    $result = mysqli_query($dbh, $query);
    while($patient_data = mysqli_fetch_array($result)) {
        if ($patient_data) {
            echo ($patient_data['lname'].", ".$patient_data['fname']." <a class='small' href='../../patient_file/summary/demographics.php?set_pid=".$patient_data["id"]."'>View</a><br>");
        }
    }

    mysqli_close($dbh);
}

printPrimarySupportPatient($pid);
?>
