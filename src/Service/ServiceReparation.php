<?php

namespace App\Service;
use App\Model\Reparation;
use mysqli;
class ServiceReparation {
    function connect() {
        $db = parse_ini_file("../../cfg/db_config.ini", true) ["params_db_sql"];
        $mysqli = new mysqli($db["host"], $db["user"], $db["pwd"], $db["db_name"]); 
        if($mysqli->connect_error) {
            echo "Connection is failed: " . $mysqli->connect_error;
        }
        return $mysqli;
    }
    function insertReparation(Reparation $reparation) {
        $conn = $this->connect();
        $query = "INSERT INTO workshop.reparation (idReparation, idWorkshop, nameWorkshop, registerDate, licenseVehicle) VALUES (?, ?, ?, ?, ?);";
    }
    function getReparation($idReparation,$role) {
        $conn = $this->connect();
        $query = "SELECT * FROM workshop.reparation WHERE idReparation = ?";
        $stmt = $conn->prepare($query);
        $stmt->bind_param("i", $idReparation);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();
            $reparation = new Reparation(
                $row['idReparation'],
                $row['idWorkshop'],
                $row['nameWorkshop'],
                $row['registerDate'],
                $row['licenseVehicle']
            );
            $stmt->close();
            $conn->close();
            return $reparation;
        } else {
 
            $stmt->close();
            $conn->close();
            return null;  
        }

    }
}