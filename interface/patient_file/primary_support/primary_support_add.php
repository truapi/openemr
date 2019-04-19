<?php
// Copyright (C) 2009, 2017 Rod Roark <rod@sunsetsystems.com>
//
// This program is free software; you can redistribute it and/or
// modify it under the terms of the GNU General Public License
// as published by the Free Software Foundation; either version 2
// of the License, or (at your option) any later version.

/**
 * This page is being used for primary support patient.
 * Same with normal new page, but it adds to primary_support table
 */
require_once("../../globals.php");

$patient_id = isset($_GET["patient_id"]) ? $_GET["patient_id"]: '';
$sid = isset($_GET["sid"]) ? $_GET["sid"]: '';
newPrimarySupportPatient($patient_id, $sid);
?>
<html>
<body>
<script language="Javascript">
<?php
  echo "window.location='$rootdir/patient_file/primary_support/primary_support.php?" .
  "patient_id=" . $patient_id . "';\n";
?>
</script>

</body>
</html>

