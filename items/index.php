<?php
//including the database connection file
include_once("../classes/Crud.php");
session_start();
$crud = new Crud();

//fetching data in descending order (lastest entry first)
$query = "SELECT Items.id, Items.type_id,  Items.code, Items.description , Types.code AS type_code, Types.description AS type_description
FROM Items
INNER JOIN Types
ON Items.type_id = Types.id ORDER BY Items.id DESC";

$items = $crud->getData($query);

?>
<html>

<head>
    <script type="text/javascript">
        if (isset($_SESSION['update_success'])) {
            unset('update_success');
        }
    </script>
    <title>ITEMS</title>
    <link rel="stylesheet" href="../css/style.css">
</head>

<body>
    <?php

    if (isset($_SESSION['update_success'])) {
        echo "<p  color='green' class='session-success'>Data Updated Successfully</p>.";
        unset($_SESSION['update_success']);
    }
    if (isset($_SESSION['deleted_success'])) {
        echo "<p  color='green' class='session-success'>Data Deleted Successfully</p>.";
        unset($_SESSION['deleted_success']);
    }
    ?>
    <div id="btn-container">
        <a href="add.php" id="create-btn">Create</a><br /><br />
    </div>
    <table>
        <thead>
            <tr>
                <td>ITEM TYPE CODE</td>
                <td>ITEM TYPE DESCRIPTION</td>
                <td>ITEM CODE</td>
                <td>ITEM DESCRIPTION</td>
                <td>ACTIONS</td>
            </tr>
        </thead>
        <tbody>
            <?php
            if ($items) {
                foreach ($items as $key => $item) {
                    echo "<tr>";
                    echo "<td>" . $item['type_code'] . "</td>";
                    echo "<td>" . $item['type_description'] . "</td>";
                    echo "<td>" . $item['code'] . "</td>";
                    echo "<td>" . $item['description'] . "</td>";
                    echo "<td><a href=\"edit.php?id=$item[id]\" class='edit-btn'>Edit</a> <a href=\"delete.php?id=$item[id]\" class='delete-btn'>Delete</a>";
                    echo "</tr>";
                }
            } else {
                echo "<tr>";
                echo "<td colspan='5' class='center'>" . "No Data" . "</td>";
                echo "</tr>";
            }
            ?>
            <?php
            ?>
        </tbody>
    </table>
</body>

</html>