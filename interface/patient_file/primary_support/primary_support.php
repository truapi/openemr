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
        "INNER JOIN patient_support ON patient_data.id = patient_support.sid " .
        "WHERE patient_support.pid = '$patient_id'";

    $result = mysqli_query($dbh, $query);
    while($patient_data = mysqli_fetch_array($result)) {
        if ($patient_data) {
            $res[] = $patient_data;
        }
    }

    mysqli_close($dbh);
    return $res;
}
?>

<body class='body_top'>
<div>
  <a href="../summary/demographics.php?set_pid=<?php echo $patient_id?>" class="css_button" onclick="top.restoreSession()">
    <span><?php echo htmlspecialchars(xl('Back'), ENT_NOQUOTES); ?></span>
  </a>
</div>

<br>
<br>

<!-- <div id='primary_support'> -->
<div id="patient_stats">
<?php
echo "<a href='javascript:;' class='css_button_small' onclick='dopclick($patient_id)'><span>" . xlt('Add') . "</span></a>\n";
echo "  <span class='title'>Primary Support Patient</span>\n";
?>
    <table style='margin-bottom:1em;'>
        <tr class='head'>
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
</div>
</body>
</html>

