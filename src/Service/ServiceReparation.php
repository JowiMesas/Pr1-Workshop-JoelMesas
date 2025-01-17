<?php

namespace App\Service;
require_once __DIR__ . '/../../vendor/autoload.php';

use App\Model\Reparation;
use Intervention\Image\Drivers\Gd\Driver;
use Intervention\Image\ImageManager;
use mysqli;
use Ramsey\Uuid\Nonstandard\Uuid;
// require_once __DIR__ . '/../Utils/LoggerManager.php';
use App\Utils\LoggerManager;
use Intervention\Image\Decoders\Base64ImageDecoder;
use Intervention\Image\Typography\FontFactory;
use Exception;
class ServiceReparation {
    function connect() {
        $logger = LoggerManager::getLogger();
        $db = parse_ini_file(__DIR__ . '/../../cfg/db_config.ini', true)["params_db_sql"];
        
        try {
            $mysqli = new mysqli($db["host"], $db["user"], $db["pwd"], $db["db_name"]);
            
        } catch (Exception $e) {
            // Log the error
            $logger->error("Connection error: " . $e->getMessage());
            exit; 
        }
    
        return $mysqli;
    }
    function insertReparation(Reparation $reparation) {
        $logger = LoggerManager::getLogger();
        try {
            $conn = $this->connect();
            $query = "INSERT INTO workshop.reparation (idReparation, idWorkshop, nameWorkshop, registerDate, licenseVehicle, photoVehicle) VALUES (?, ?, ?, ?, ?, ?);";
            $stmt = $conn->prepare($query);
            if (!$stmt) {
                $logger->error("Failed to prepare SQL statement: " . $conn->error);
                echo "Failed to prepare SQL statement: " . $conn->error;
                return false;
            }
            $idReparation = $this->generateUUID();
            $idWorkshop = $reparation->getIdWorkshop();
            $nameWorkshop = $reparation->getNameWorkshop();
            $registerDate = $reparation->getRegisterDate();
            $licenseVehicle = $reparation->getLicenseVehicle();
            $photoVehicle = $reparation->getPhotoVehicle();
            $photovehicleWaterMark = $this->addWatermark($photoVehicle, $licenseVehicle, $idReparation);
             $stmt->bind_param("sissss", $idReparation,$idWorkshop,$nameWorkshop, $registerDate, $licenseVehicle, $photovehicleWaterMark);
             if ($stmt->execute()) {
                $reparation->setIdReparation($idReparation);
                $photoVehicle = base64_encode($photoVehicle);
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
        } catch(Exception $e) {
            $logger->error("Error in insertReparation: " . $e->getMessage());
        }
    

    }
    function getReparation($idReparation, $role) {
        $logger = LoggerManager::getLogger();
        try {
            $conn = $this->connect();
            $query = "SELECT * FROM workshop.reparation WHERE idReparation = ?";
            $stmt = $conn->prepare($query);
            
            if (!$stmt) {
                throw new Exception("Failed to prepare SELECT statement: " . $conn->error);
            }
            
            $stmt->bind_param("s", $idReparation);
            $stmt->execute();
            $result = $stmt->get_result();
    
            if ($result->num_rows > 0) {
                $row = $result->fetch_assoc();
                $photoVehicle = $row['photoVehicle'];
                $licenseVehicle = $row['licenseVehicle'];
    
                if ($role === 'client' && $photoVehicle !== null) {
                    $photoVehicle = $this->pixelateImage($photoVehicle);
                }
                if ($role === 'client' && $licenseVehicle !== null) {
                    $licenseVehicle = str_repeat('*', strlen($licenseVehicle));
                }
    
                $reparation = new Reparation(
                    $row['idReparation'],
                    $row['idWorkshop'],
                    $row['nameWorkshop'],
                    $row['registerDate'],
                    $licenseVehicle,
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
        } catch (Exception $e) {
            $logger->warning("Error in getReparation: " . $e->getMessage());
        }
    }
    function pixelateImage($imageVehicle) {
        if (!$imageVehicle) {
            return null;
        }
    
        $imagePixelate = new ImageManager(new Driver());
        // Since the data is coming from LONGBLOB, we first need to encode it to base64

        $newImage = $imagePixelate->read($imageVehicle, Base64ImageDecoder::class);
        $newImage->pixelate(20);
    
        return base64_encode($newImage->encode());
    }
    function generateUUID() {
        return Uuid::uuid4();
    }
    function addWatermark($photo, $licensePlate, $idReparation): string
    {
        $manager = new ImageManager(new Driver);
        $imageWithWaterMark = $manager->read($photo, Base64ImageDecoder::class);
 
        $imageWithWaterMark->text($licensePlate . ' - ' . $idReparation, 20, 50, function (FontFactory $font) {
            $font->size(48);
            $font->color('#ff0000');
            $font->stroke('#000000', 9);
        });
 
        return base64_encode($imageWithWaterMark->encode());
    }
}