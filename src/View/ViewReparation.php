<?php
namespace App\View;

use App\Model\Reparation;

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
    <input type="submit"  name="getReparation" >   
    </form>
    <?php
    
    class ViewReparation{
        function render(Reparation | null $result) {
            if ($result != null) {
                echo "<h2>Reparation Details</h2>";
                echo "<ul>";
                echo "<li><strong>ID Reparation:</strong> " . $result->getIdReparation() . "</li>";
                echo "<li><strong>ID Workshop:</strong> " . $result->getIdWorkshop() . "</li>";
                echo "<li><strong>Workshop Name:</strong> " . $result->getNameWorkshop() . "</li>";
                echo "<li><strong>Register Date:</strong> " . $result->getRegisterDate() . "</li>";
                echo "<li><strong>License Plate:</strong> " . $result->getLicenseVehicle() . "</li>";
                echo "</ul>";
                if ($result->getPhotoVehicle()) {
                    echo '<img src="data:image/png;base64,' . $result->getPhotoVehicle() . '" alt="Vehicle Image" style="max-width:200px;">';
                } else {
                    echo "<p>No image available</p>";
                }

            } else {
                echo "No reparation found.";
            }
          }
    }
    

    ?>
    <?php
        session_start();
        $_SESSION["role"] = $_GET["role"] ?? $_SESSION["role"] ?? null;
        if($_SESSION["role"] == "employee") {
        ?> 
        <h2>Insert reparation</h2>
        <form action="../Controller/ControllerReparation.php" method="post" enctype="multipart/form-data">
            <label for="idReparation">
                ID Reparation:
                <input type="text" name="idReparation" max="40" placeholder="Introduce ID Reparation" required>
            </label>
            <br> <br>
            <label for="idWorkshop">
                ID Workshop:
                <input type="number" name="idWorkshop"  placeholder="Introduce ID workshop" required>
            </label>
            <br>
            <br>
            <label for="nameWorkshop">
                Workshop Name:
                <input type="text" name="nameWorkshop" required>
            </label>
            <br>
            <br>
            <label for="dateRegister">
                Register Date:
                <input type="date" name="dateRegister" placeholder="Date of Register" >
            </label>
            <br>
            <br>
            <label for="licenseVehicle">
                License Plate:
                <input type="text" name="licenseVehicle" max="7" required >
            </label>
            <br>
            <br>
            <label for="photoVehicle">
                Vehicle Image:
                <input type="file" name="photoVehicle" accept="image/*" required>
            </label>
            <input type="submit"  name="insertReparation">
        </form>
        <?php 
        }
        ?>

</body>
</html>
