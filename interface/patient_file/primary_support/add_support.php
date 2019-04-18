<?php
/**
 * clinical reminders gui
 *
 * @package OpenEMR
 * @link    http://www.open-emr.org
 * @author  Brady Miller <brady.g.miller@gmail.com>
 * @author  Ensofttek, LLC
 * @copyright Copyright (c) 2011-2017 Brady Miller <brady.g.miller@gmail.com>
 * @copyright Copyright (c) 2011 Ensofttek, LLC
 * @license https://github.com/openemr/openemr/blob/master/LICENSE GNU General Public License 3
 */

require_once "../../globals.php";

use OpenEMR\Core\Header;
?>

<html>
<head>
    <?php Header::setupHeader(['common']);?>
    <title><?php echo xlt('Primary Support'); ?></title>
    <script language="javascript">
        function dopclick(patient_id) {
            top.restoreSession();
            dlgopen('add_support.php?patient_id=' + patient_id, '_blank', 650, 600);
        }
        function closeme() {
            dlgclose();
        }
        function save() {
            dlgclose();
        }
        function activeClicked(p_id) {
            console.log(p_id);
        }
    </script>
</head>

<?php
$patient_id = ($_GET['patient_id']) ? $_GET['patient_id'] : "";

function getPatients($patient_id) {
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
        "SELECT patient_data.* FROM patient_data " .
        "LEFT JOIN patient_support ON patient_data.id = patient_support.sid ";

    $result = mysqli_query($dbh, $query);
    while($patient_data = mysqli_fetch_array($result)) {
        if ($patient_data) {
            $res[] = $patient_data;
        }
    }

    mysqli_close($dbh);
    return $res;
}

function isSPatient($patients, $patient) {
    return true;
}
?>

<body class='body_top'>
<!-- <div id='primary_support'> -->
<div id="patient_stats">
<?php
echo "<span class='title'>Edit Primary Support Patient</span>\n";
?>
    <table style='margin-bottom:1em;'>
        <tr class='head'>
            <th></th>
            <th style='text-align:left'><?php echo xlt('Full Name'); ?></th>
            <th style='text-align:left'><?php echo xlt('Home Phone'); ?></th>
            <th style='text-align:left'><?php echo xlt('SSN'); ?></th>
            <th style='text-align:left'><?php echo xlt('DOB'); ?></th>
            <th style='text-align:left'><?php echo xlt('External ID'); ?></th>
        </tr>
        <?php
            $patients = getPatients($patient_id);
            foreach($patients as $patient) {
                ++$encount;
                $bgclass = (($encount & 1) ? "bg1" : "bg2");
                ?>
                <tr class="<?php echo $bgclass?> detail">
                    <td>
                        <input type='checkbox' name='form_active' value='1' <?php echo isSPatient($patients, $patient) ? "" : "checked"; ?>
                            onclick='activeClicked($patient.id);'
                            title='<?php echo xla('Indicates if this patient is currently active'); ?>' />
                    </td>
                    <td><?php echo $patient['lname']." ".$patient['fname'] ?></td>
                    <td><?php echo $patient['phone_home'] ?></td>
                    <td><?php echo $patient['ss'] ?></td>
                    <td><?php echo $patient['DOB'] ?></td>
                    <td><?php echo $patient['pid'] ?></td>
                </tr>
                <?php
            }
        ?>
    </table>
    <input type='button' name='form_save' value='<?php echo xla('Save'); ?>'  onclick='save();' />&nbsp;
    <input type='button' value='<?php echo xla('Cancel'); ?>' onclick='closeme();' />
</div>
</body>
</html>

