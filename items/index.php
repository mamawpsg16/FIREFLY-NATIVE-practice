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
                foreach ($items as $key => $item) { ?>
                    <tr>
                        <td> <?php echo $item['type_code']; ?></td>
                        <td> <?php echo $item['type_description']; ?></td>
                        <td> <?php echo $item['code']; ?> </td>
                        <td> <?php echo $item['description']; ?></td>
                        <td> 
                            <a href="edit.php?id=<?php echo $item['id'] ?>" class='edit-btn'>Edit</a>
                            <a href="delete.php?id=<?php echo $item['id'] ?>" class='delete-btn'>Delete</a>
                        </td>
                    </tr>
                <?php }  ?>
            <?php } else { ?>
                <tr>
                    <td colspan='5' class='center'>No Data</td>
                </tr>
            <?php }
            ?>
            <?php
            ?>
        </tbody>
    </table>
</body>

</html>