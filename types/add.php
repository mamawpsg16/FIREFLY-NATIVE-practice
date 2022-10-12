<?php
include_once "../classes/Crud.php";
include_once("../classes/TypeValidator.php");

$crud = new Crud();
if (isset($_POST['submit'])) {
    $code = $_POST['code'];
    $description = $_POST['description'];
    $_POST['operation'] = 'create';
    $validation = new TypeValidator($_POST);
    $errors = $validation->validateForm();

    if (!array_filter($errors)) {
        //insert data to database	
        $result = $crud->createType($code, $description);
        $_POST['code'] = '';
        $_POST['description'] = '';
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
    <?php
    // print_r($errors);
    ?>
    <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
        <div id="add-container">
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
            <!-- <input type="text" id="description" name="description" placeholder="Enter description" value="<?php echo (!empty($_POST['description'])) ? htmlspecialchars($_POST['description']) : '' ?>" required> -->
            <div class="error">
                <?php echo $errors['description'] ?? '' ?>
            </div>
            <input type="submit" value="Save" name="submit">
        </div>/
    </form>
</body>

</html>