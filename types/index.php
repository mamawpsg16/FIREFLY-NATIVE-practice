<?php
//including the database connection file
include_once("../classes/Crud.php");
session_start();
$crud = new Crud();

//fetching data in descending order (lastest entry first)
$query = "SELECT * FROM types ORDER BY id DESC";
$types = $crud->getData($query);
//echo '<pre>'; print_r($result); exit;
?>
<html>

<head>
    <title>TYPES</title>
    <link rel="stylesheet" href="../css/style.css">
</head>

<body>
    <?php

    if (isset($_SESSION['update_success'])) {
        echo "<p  class='session-success'>Data Updated Successfully</p>.";
        unset($_SESSION['update_success']);
    }
    if (isset($_SESSION['deleted_success'])) {
        echo "<p  class='session-success'>Data Deleted Successfully</p>.";
        unset($_SESSION['deleted_success']);
    }
    ?>
    <div id="btn-container">
        <a href="add.php" id="create-btn">Create</a><br /><br />
    </div>
    <table>
        <thead>
            <tr>
                <td width="30%">CODE</td>
                <td width="50%">DESCRIPTION</td>
                <td width="20%">ACTIONS</td>
            </tr>
        </thead>
        <tbody>
            <?php
            if ($types) {
                foreach ($types as $key => $type) {
                    $code = str_replace(array(
                        '\'', '"',
                        ',', ';', '<', '>'
                    ), ' ', $type['code']);
                    $description = str_replace(array(
                        '\'', '"',
                        ',', ';', '<', '>'
                    ), ' ', $type['description']);
                    echo "<tr>";
                    echo "<td>" . $code . "</td>";
                    echo "<td>" . $description . "</td>";
                    echo "<td><a href=\"edit.php?id=$type[id]\" class='edit-btn'>Edit</a> <a href=\"delete.php?id=$type[id]\" class='delete-btn'>Delete</a>";
                    echo "</tr>";
                }
            } else {
                echo "<tr>";
                echo "<td colspan='3' class='center'>" . "No Data" . "</td>";
                echo "</tr>";
            }
            ?>
            <?php
            ?>
        </tbody>
    </table>
</body>

</html>