<?php
include_once "../classes/Crud.php";
include_once "../config/Db.php";
include_once("../classes/TypeValidator.php");
session_start();
// check GET request id parameter
if (isset($_GET['id'])) {
    $id = $_GET['id'];
    $crud = new Crud();
    $result = $crud->delete($id, 'types');
    if ($result) {
        header("Location: index.php");
        $_SESSION["deleted_success"] = "Deleted.";
    }
}
