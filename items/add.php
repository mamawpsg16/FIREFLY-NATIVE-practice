<?php

include_once "../classes/Crud.php";
include_once("../classes/ItemValidator.php");

$crud = new Crud();

//fetching data in descending order (lastest entry first)
$query = "SELECT id, CONCAT(code,': ',description) AS type FROM types ORDER BY id asc";
$types = $crud->getData($query);

if (isset($_POST['submit'])) {
    $code = $_POST['code'];
    $description = $_POST['description'];
    $type_id = $_POST['type_id'];
    $_POST['operation'] = 'create';
    $validation = new ItemValidator($_POST);
    $errors = $validation->validateForm();

    if (!array_filter($errors)) {
        //insert data to database	
        $result = $crud->createItem($code, $description, $type_id);
        $_POST['code'] = '';
        $_POST['description'] = '';
        $_POST['type_id'] = '';
        $_POST['submit'] = '';
        //display success message
        echo "<p  color='green'>Data added successfully</p>.";
        echo "<br/><a href='index.php'>View Result</a>";
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
    <title>Create Type</title>
</head>

<body>
    <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
        <div id="add-container">
            <p for="type">Types</p>
            <select name="type_id">
                <?php
                foreach ($types as $type) { ?>
                    <option value="<?= $type['id'] ?>"><?= $type['type'] ?></option>
                <?php
                } ?>
            </select>
            <div class="error">
                <?php echo $errors['type_id'] ?? '' ?>
            </div>

            <p for="code">Code</p>
            <input type="text" id="code" name="code" placeholder="Enter code" value="<?php echo (!empty($_POST['code'])) ? htmlspecialchars($_POST['code']) : '' ?>" required>
            <div class="error">
                <?php echo $errors['code'] ?? '' ?>
            </div>
            <div class="error">
                <?php echo $errors['code_taken'] ?? '' ?>
            </div>
            <p for="lname">Description</p>
            <textarea name="description" id="" cols="10" rows="5" required><?php echo (!empty($_POST['description'])) ? htmlspecialchars($_POST['description']) : '' ?></textarea>
            <!-- <input type="text" id="description" name="description" placeholder="Enter description" > -->
            <div class="error">
                <?php echo $errors['description'] ?? '' ?>
            </div>
            <input type="submit" value="Save" name="submit">
        </div>/
    </form>
</body>

</html>