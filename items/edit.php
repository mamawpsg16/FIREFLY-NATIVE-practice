<?php
include_once "../classes/Crud.php";
include_once "../config/Db.php";
include_once("../classes/ItemValidator.php");
session_start();
// check GET request id parameter
$crud = new Crud();
$query = "SELECT id, CONCAT(code,':',description) AS type FROM types ORDER BY id asc";
$types = $crud->getData($query);
if (isset($_GET['id'])) {

    $id = $_GET['id'];
    $db  = new Db();
    $stmt = $db->connection()->prepare("SELECT Items.id, Items.type_id,  Items.code, Items.description , Types.code AS type_code, Types.description AS type_description
            FROM Items
            INNER JOIN Types
            ON Items.type_id = Types.id WHERE Items.id=:id");
    $stmt->execute(['id' => $id]);
    $item = $stmt->fetch();
}
if (isset($_POST['submit'])) {
    $code = $_POST['code'];
    $description = $_POST['description'];
    $type_id = $_POST['type_id'];
    $_POST['operation'] = 'update';
    $validation = new ItemValidator($_POST);
    $errors = $validation->validateForm();

    if (!array_filter($errors)) {
        //insert data to database	
        $id = $_POST['id'];
        $result = $crud->updateItem($code, $description, $id, $type_id);
        if ($result) {
            header("Location: index.php");
            echo "<p  color='green'>Data updated successfully</p>.";
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
    <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"] . '?id=' . $item['id']); ?>">
        <input type="hidden" name="id" value="<?php echo htmlspecialchars($item['id']); ?>">
        <div id="add-container">
            <p for="type">Types</p>
            <select name="type_id">
                <?php
                foreach ($types as $type) { ?>
                <?php print_r($type)?>
                <option value="<?= $type['id'] ?>" <?php if($item['type_id'] == $type['id']){ ?> selected="selected" <?php }?>><?= $type['type'] ?></option>
                <?php
                } ?>
            </select>
            <div class="error">
                <?php echo $errors['type_id'] ?? '' ?>
            </div>
            <p for="code">Code</p>
            <input type="text" id="code" name="code" placeholder="Enter code" value="<?php echo (empty($_POST['code'])) ? htmlspecialchars($item['code']) :  htmlspecialchars($_POST['code'])  ?>" required>
            <div class="error">
                <?php echo $errors['code'] ?? '' ?>
            </div>
            <div class="error">
                <?php echo $errors['code_taken'] ?? '' ?>
            </div>
            <p for="lname">Description</p>
            <textarea name="description" id="" cols="10" rows="5" required placeholder="Enter description"><?php echo (empty($_POST['description'])) ? htmlspecialchars($item['description']) : htmlspecialchars($_POST['description']) ?></textarea>
            <div class="error">
                <?php echo $errors['description'] ?? '' ?>
            </div>
            <input type="submit" value="Update" name="submit">
        </div>/
    </form>
</body>

</html>