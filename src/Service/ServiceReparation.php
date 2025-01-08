<?php

namespace App\Service;
use App\Model\Reparation;
use Intervention\Image\Drivers\Gd\Driver;
use Intervention\Image\ImageManager;
use mysqli;
// require_once __DIR__ . '/../Utils/LoggerManager.php';
require_once __DIR__ . '/../../vendor/autoload.php';
use App\Utils\LoggerManager;
use Intervention\Image\Decoders\Base64ImageDecoder;

class ServiceReparation {
    function connect() {
        $logger = LoggerManager::getLogger();
        $db = parse_ini_file(__DIR__ . '/../../cfg/db_config.ini', true)["params_db_sql"];
         $mysqli = new mysqli($db["host"], $db["user"], $db["pwd"], $db["db_name"]); 
        if($mysqli->connect_error) {
            $logger->error("Database connection failed: " . $mysqli->connect_error);
        }
        return $mysqli;
    }
    function insertReparation(Reparation $reparation) {
        $logger = LoggerManager::getLogger();
        $conn = $this->connect();
        $query = "INSERT INTO workshop.reparation (idReparation, idWorkshop, nameWorkshop, registerDate, licenseVehicle, photoVehicle) VALUES (?, ?, ?, ?, ?, ?);";
        $stmt = $conn->prepare($query);
        if (!$stmt) {
            $logger->error("Failed to prepare SQL statement: " . $conn->error);
            echo "Failed to prepare SQL statement: " . $conn->error;
            return false;
        }
        $idReparation = $reparation->getIdReparation();
        $idWorkshop = $reparation->getIdWorkshop();
        $nameWorkshop = $reparation->getNameWorkshop();
        $registerDate = $reparation->getRegisterDate();
        $licenseVehicle = $reparation->getLicenseVehicle();
         $stmt->bind_param("sisssb", $idReparation,$idWorkshop,$nameWorkshop, $registerDate, $licenseVehicle, $null);
         $stmt->send_long_data(5, $reparation->getPhotoVehicle());
         if ($stmt->execute()) {
            $logger->info("INSERT operation successful for ID: " . $reparation->getIdReparation());
            $stmt->close();
            $conn->close();
            return $reparation;
        } else {
            $logger->error("INSERT operation failed: " . $stmt->error);
            $stmt->close();
            $conn->close();
            return null;
        }
    

    }
    function getReparation($idReparation,$role) {
        $logger = LoggerManager::getLogger();

        $conn = $this->connect();
        $query = "SELECT * FROM workshop.reparation WHERE idReparation = ?";
        $stmt = $conn->prepare($query);
        
        if (!$stmt) {
        $logger->warning("Failed to prepare SELECT statement: " . $conn->error);
        return null;
        }
        $stmt->bind_param("s", $idReparation);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();
            $photoVehicle = $row['photoVehicle'];
            if ($role === 'client' && $photoVehicle !== null) {
                $photoVehicle = $this->pixelateImage($photoVehicle);
            }
            $reparation = new Reparation(
                $row['idReparation'],
                $row['idWorkshop'],
                $row['nameWorkshop'],
                $row['registerDate'],
                $row['licenseVehicle'],
                $photoVehicle
               
            );
            $logger->info("SELECT operation successful for ID: $idReparation");
            $stmt->close();
            $conn->close();
            return $reparation;
        } else {
            $logger->warning("No results found for ID: $idReparation");
            $stmt->close();
            $conn->close();
            return null;  
        }

    }
    function pixelateImage($imageVehicle) {
        if (!$imageVehicle) {
            return null;
        }
    
        $imagePixelate = new ImageManager(new Driver());
        // Since the data is coming from LONGBLOB, we first need to encode it to base64
        $base64Image = base64_encode(string: $imageVehicle);

        $newImage = $imagePixelate->read($base64Image, Base64ImageDecoder::class);
        $newImage->pixelate(30);
    
        return base64_encode($newImage->encode());
    }
}