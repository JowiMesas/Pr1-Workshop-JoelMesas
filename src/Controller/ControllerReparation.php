<?php
namespace App\Controller;

use App\Service\ServiceReparation;
use App\Model\Reparation;
use App\View\ViewReparation;
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
            if (isset($_POST['idReparation']) && isset($_POST['idWorkshop']) && isset($_POST['nameWorkshop']) && isset($_POST['dateRegister']) &&isset($_POST['licenseVehicle']) ) {
                $idReparation = $_POST['idReparation'];
                $idWorkshop = $_POST['idWorkshop'];
                $nameWorkshop = $_POST['nameWorkshop'];
                $registerDate = $_POST['registerDate'];
                $licenseVehicle = $_POST['licenseVehicle'];
                
                $reparation = new Reparation($idReparation, $idWorkshop, $nameWorkshop, $registerDate, $licenseVehicle);


                $service = new ServiceReparation();
                $service->insertReparation($reparation);
                echo "Reparation inserted successfully!";

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
        $view = new ViewReparation();
        $view->render($result);
    }
}