<?php
include_once "../classes/Crud.php";
include_once "../config/Db.php";
include_once("../classes/TypeValidator.php");
session_start();
// check GET request id parameter
if (isset($_GET['id'])) {
    $id = $_GET['id'];
    $db  = new Db();
    $stmt = $db->connection()->prepare("SELECT * FROM types WHERE id=:id");
    $stmt->execute(['id' => $id]);
    $type = $stmt->fetch();
}
$crud = new Crud();
if (isset($_POST['submit'])) {
    $code = $_POST['code'];
    $description = $_POST['description'];
    $_POST['operation'] = 'update';
    $_POST['id'] = $_GET['id'];
    $validation = new TypeValidator($_POST);
    $errors = $validation->validateForm();

    if (!array_filter($errors)) {
        //insert data to database	
        $id = $_POST['id'];
        $result = $crud->updateType($code, $description, $id);
        if ($result) {
            header("Location: index.php");
            $_SESSION["update_success"] = "Updated.";
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../css/style.css">
    <title>Edit Type</title>
</head>

<body>
    <?php
    // print_r($errors);
    ?>
    <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"] . '?id=' . $type['id']); ?>">
        <input type="hidden" name="id" value="<?php echo htmlspecialchars($type['id']); ?>">
        <div id="add-container">
            <p for="code">Code</p>
            <input type="text" id="code" name="code" placeholder="Enter code" value="<?php echo (empty($_POST['code'])) ? htmlspecialchars($type['code']) :  htmlspecialchars($_POST['code'])  ?>" required>
            <div class="error">
                <?php echo $errors['code'] ?? '' ?>
            </div>
            <div class="error">
                <?php echo $errors['code_taken'] ?? '' ?>
            </div>
            <p for="lname">Description</p>
            <textarea name="description" id="" cols="10" rows="5" required placeholder="Enter description"><?php echo (empty($_POST['description'])) ? htmlspecialchars($type['description']) : htmlspecialchars($_POST['description']) ?></textarea>
            <div class="error">
                <?php echo $errors['description'] ?? '' ?>
            </div>
            <input type="submit" value="Update" name="submit">
        </div>/
    </form>
</body>

</html>