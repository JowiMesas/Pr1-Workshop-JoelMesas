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
    <style>
      * {
    margin: 0;
    padding: 0;
    box-sizing: border-box;
    font-family: 'Arial', sans-serif;
}

/* Body Styling */
body {
    background-color: #f4f4f9;
    color: #333;
    padding: 20px;
    line-height: 1.6;
}

/* Main Headings */
h2 {
    font-size: 1.8rem;
    color: #2c3e50;
    text-align: center;
    margin-bottom: 20px;
}

/* Containers */
.container {
    display: flex;
    justify-content: space-between;
    gap: 30px;
    flex-wrap: wrap;
}

/* Forms */
form {
    background-color: #ffffff;
    padding: 20px;
    border-radius: 8px;
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
    margin: 20px auto;
    max-width: 500px;
    width: 100%;
}

form label {
    display: block;
    margin-bottom: 10px;
    font-weight: bold;
    color: #34495e;
}

form input[type="text"],
form input[type="date"],
form input[type="file"],
form input[type="number"],
form select {
    width: 100%;
    padding: 10px;
    margin-bottom: 15px;
    border: 1px solid #ccc;
    border-radius: 5px;
}

form input[type="submit"] {
    background-color: #3498db;
    color: #fff;
    padding: 10px 20px;
    border: none;
    border-radius: 5px;
    cursor: pointer;
    transition: background-color 0.3s ease;
}

form input[type="submit"]:hover {
    background-color: #2980b9;
}

/* Repair Details */
.details {
    background-color: #ffffff;
    padding: 20px;
    border-radius: 8px;
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
    margin: 20px auto;
    max-width: 500px;
    width: 100%;
}

.details ul {
    list-style-type: none;
    padding: 0;
}

.details li {
    margin-bottom: 10px;
    font-size: 1rem;
    color: #34495e;
}

.details li strong {
    color: #2c3e50;
}

/* Images */
img {
    display: block;
    max-width: 100%;
    margin: 20px auto;
    border-radius: 8px;
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
}

/* Estilo del Taller */
form, .details {
    border: 3px solid #2c3e50;
}

form input[type="text"],
form input[type="number"],
form input[type="date"] {
    background-color: #e6f2f7;
}

.details {
    background-color: #f9f9f9;
}

.details li {
    border-bottom: 1px solid #dcdcdc;
    padding-bottom: 10px;
}

.details h2 {
    text-align: center;
    font-size: 1.8rem;
    color: #2c3e50;
}

.details img {
    box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.1);
}
    </style>
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
    
    class ViewReparation {
        function render(Reparation | null $result) {
            if ($result != null) {
                echo '<div class="details">';
                echo "<h2>Reparation Details</h2>";
                echo "<ul>";
                echo "<li><strong>ID Reparation:</strong> " . $result->getIdReparation() . "</li>";
                echo "<li><strong>ID Workshop:</strong> " . $result->getIdWorkshop() . "</li>";
                echo "<li><strong>Workshop Name:</strong> " . $result->getNameWorkshop() . "</li>";
                echo "<li><strong>Register Date:</strong> " . $result->getRegisterDate() . "</li>";
                echo "<li><strong>License Plate:</strong> " . $result->getLicenseVehicle() . "</li>";
                echo "</ul>";
    
                if ($result->getPhotoVehicle()) {
                    echo '<img src="data:image/png;base64,' . $result->getPhotoVehicle() . '" alt="Vehicle Image">';
                } else {
                    echo "<p>No image available</p>";
                }
                echo '</div>';
            } else {
                echo "<p>No reparation found.</p>";
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
