<?php
//including the database connection file
include_once("../classes/Crud.php");

$crud = new Crud();

//fetching data in descending order (lastest entry first)
$query = "SELECT * FROM types ORDER BY id";
$types = $crud->getData($query);
//echo '<pre>'; print_r($result); exit;
?>

<html>
    <head>	
        <title>Types</title>
        <link rel="stylesheet" href="../css/style.css">
</head>

<body>
    <div id="btn-container">
        <a href="add.php" id="create-btn">Create</a><br/><br/>
    </div>
	<table>
        <thead>
            <tr>
                <td>Code</td>
                <td>Description</td>
                <td>Actions</td>
            </tr>
        </thead>
        <tbody>
            <?php
            if($types){
                foreach ($types as $key => $type) {
                    echo "<tr>";
                        echo "<td>".$type['code']."</td>";
                        echo "<td>".$type['description']."</td>";
                        echo "<td><a href=\"edit.php?id=$type[id]\">Edit</a>";  		
                    echo "</tr>";
                }
            }else{
                echo "<tr>";
                    echo "<td colspan='3' class='center'>"."No Data"."</td>";
                echo"</tr>";
            }
            ?>
            <?php 
            ?>
        </tbody>
	</table>
</body>
</html>