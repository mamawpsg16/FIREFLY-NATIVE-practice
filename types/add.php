<?php
        include_once "../classes/Crud.php";
        include_once("../classes/TypeValidator.php");

        $crud = new Crud();
        if(isset($_POST['submit'])){
            $code = $crud->escape_string($_POST['code']);
            $description = $crud->escape_string($_POST['description']);
            
            $validation = new Validator($_POST);
            $errors = $validation->validateForm();
            print_r($errors);

            $user = $conn->checkCode('code', $_POST['reg_username']);
            if ($user && $user->id != $_POST['reg_id']) {
                die("Username '{$_POST['reg_username']}' is already taken");
            }
            if(!array_filter($errors)){
                print_r($_POST);
                //insert data to database	
                $result = $crud->execute("INSERT INTO types(code,description) VALUES('$code','$description')");
                
                //display success message
                echo "<font color='green'>Data added successfully.";
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
    <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
        <div id="add-container">
            <p for="code">Code</p>
            <input type="text" id="code" name="code" placeholder="Enter code">
            <div class="error">
                <?php echo $errors['code'] ?? '' ?>
            </div>
            <p for="lname">Description</p>
            <input type="text" id="description" name="description" placeholder="Enter description">
            <div class="error">
                <?php echo $errors['description'] ?? '' ?>
            </div>
            <input type="submit" value="Save" name="submit">
        </div>/
    </form>
</body>
</html>