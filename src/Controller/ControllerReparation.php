<?php
namespace App\Controller;
require_once __DIR__ . '/../../vendor/autoload.php';

use App\Service\ServiceReparation;
use App\Model\Reparation;
use App\View\ViewReparation;
use Intervention\Image\ImageManager;
require_once __DIR__ . '/../Service/ServiceReparation.php';
require_once __DIR__ . '/../Model/Reparation.php';
require_once __DIR__ . '/../View/ViewReparation.php';
$controller = new ControllerReparation();


if (isset($_POST['insertReparation'])) {
    $controller->insertReparation();  
} elseif (isset($_POST['getReparation'])) {
    $controller->getReparation();  
}

class ControllerReparation {
    function insertReparation() {
        if($_SESSION["role"] = "employee") {
            if (isset($_POST['idReparation']) && isset($_POST['idWorkshop']) && isset($_POST['nameWorkshop']) && isset($_POST['dateRegister'])
             &&isset($_POST['licenseVehicle']) && isset($_FILES['photoVehicle']) ) {
                $idReparation = $_POST['idReparation'];
                $idWorkshop = $_POST['idWorkshop'];
                $nameWorkshop = $_POST['nameWorkshop'];
                $registerDate = $_POST['dateRegister'];
                $licenseVehicle = $_POST['licenseVehicle'];
                $photoVehicle = file_get_contents($_FILES['photoVehicle']['tmp_name']);
                
                $reparation = new Reparation($idReparation, $idWorkshop, $nameWorkshop, $registerDate, $licenseVehicle, $photoVehicle);


                $service = new ServiceReparation();
                $reparationInserted = $service->insertReparation($reparation);
                if($reparationInserted) {
                $view = new ViewReparation();
                $view->render($reparationInserted);
                } else {
                    echo "Failed to insert reparation";
                }

            } else {
                echo "All fields are required.";
            }
        }
    }
    function getReparation() {
        $idReparation = $_POST['idReparation'];
        $role = $_SESSION["role"];
        $service = new ServiceReparation;
        $result = $service->getReparation($idReparation,$role);
        // if ($result && $result->getPhotoVehicle()) {
        //     $photo = $result->getPhotoVehicle();
    
        //     if ($role === 'client') {
        //         $imageManager = new ImageManager('gd'); 
    
        //         $image = $imageManager->read($photo);
        //         $image->pixelate(15); 
    
        //         $photo = (string) $image->encode('data-url'); 
        //     }
        // }
        $view = new ViewReparation();
        $view->render($result);
    }
}