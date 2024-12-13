<?php
namespace App\View;
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Type of Role</title>
</head>
<body>
    <h2>Search Reparation</h2>
    <form action="../Controller/ControllerReparation.php" method="post" >
    <label for="idReparation">
        Reparation ID:
        <input type="text" name="idReparation">
    </label> 
    <input type="submit" value="Send" >   
    </form>
    <?php
        $role = $_GET["role"];
        if($role == "employee") {
        ?> 
        <h2>Insert reparation</h2>
        <form action="../Controller/ControllerReparation.php">
            <label for=""></label>
        </form>
        <?php 
        }
        ?>
</body>
</html>
