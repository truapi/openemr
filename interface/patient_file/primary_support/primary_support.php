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

$patient_id = ($_GET['patient_id']) ? $_GET['patient_id'] : "";
?>

<html>
<head>
    <?php Header::setupHeader(['common']);?>
    <title><?php echo xlt('Primary Support'); ?></title>
    <script language="javascript">
        function refreshme() {
            top.restoreSession();
            document.getElementById('modalframe').contentWindow.save();
        }
        function del() {
            // Submit form to delete
            var form = document.createElement("form");
            form.method = "POST";
            form.action = "patient_support_delete.php";
            var element1 = document.createElement("input");
            var patient_id = <?php echo $patient_id ?>;
            element1.value=<?php echo $patient_id ?>;
            element1.name="patient_id";
            element1.type = "hidden";
            form.appendChild(element1);

            var array = []
            var checkboxes = document.querySelectorAll('input[type=checkbox]:checked')
            for (var i = 0; i < checkboxes.length; i++) {
                array.push(checkboxes[i].value)
            }
            var element2 = document.createElement("input");
            element2.value=JSON.stringify(array);
            element2.name="s_id_array";
            element2.type = "hidden";
            form.appendChild(element2);

            document.body.appendChild(form);
            form.submit();
        }
    </script>
</head>

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
    echo "<a href='../../new/new_primary_support_patient.php?patient_id=$patient_id' class='css_button_small'><span>" . xlt('Add') . "</span></a>\n";
    echo "<button class='css_button_small' onclick='del()'>". xlt('Delete') ."</button>"
    ?>
    <table style='margin-bottom:1em;'>
        <tr class='head'>
        <th class="srName"><?php echo htmlspecialchars(xl('Name'), ENT_NOQUOTES);?></th>
        <th class="srGender"><?php echo htmlspecialchars(xl('Sex'), ENT_NOQUOTES);?></th>
        <th class="srPhone"><?php echo htmlspecialchars(xl('Phone'), ENT_NOQUOTES);?></th>
        <th class="srSS"><?php echo htmlspecialchars(xl('SS'), ENT_NOQUOTES);?></th>
        <th class="srDOB"><?php echo htmlspecialchars(xl('DOB'), ENT_NOQUOTES);?></th>
        <th class="srID"><?php echo htmlspecialchars(xl('ID'), ENT_NOQUOTES);?></th>
        <th class="srPID"><?php echo htmlspecialchars(xl('PID'), ENT_NOQUOTES);?></th>
        <th class="srStartCall"><?php echo htmlspecialchars(xl('Assessment'), ENT_NOQUOTES);?></th>
        <th></th>
        </tr>
        <?php
            $patients = getPrimarySupportsOfPatient($patient_id);
            foreach($patients as $patient) {
                ++$encount;
                $bgclass = (($encount & 1) ? "bg1" : "bg2");
                ?>
                <tr class="<?php echo $bgclass?> detail">
                    <td>
                        <a href="../summary/demographics.php?set_pid=<?php echo $patient['id']?>">
                            <?php echo $patient['lname']." ".$patient['fname'] ?>
                        </a>
                    </td>
                    <td><?php echo $patient['sex'] ?></td>
                    <td><?php echo $patient['phone_home'] ?></td>
                    <td><?php echo $patient['ss'] ?></td>
                    <td><?php echo $patient['DOB'] ?></td>
                    <td><?php echo $patient['pubpid'] ?></td>
                    <td><?php echo $patient['pid'] ?></td>
                    <td class="small">
                        <a href="../../forms/primary_support_question/new.php?supported_patient_id=<?php echo $patient_id?>&patient_id=<?php echo $patient['id'] ?>&back=1">Assessment</a>
                    </td>
                    <td><input type='checkbox' name='form_active' value='<?php echo $patient['id'] ?>' /></td>
                </tr>
                <?php
            }
        ?>
    </table>
</div>
</body>
</html>

