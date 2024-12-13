<?php
namespace App\Controller;

use App\Service\ServiceReparation;

$controller = new ControllerReparation;
if(isset($_POST['getReparation'])) {
    $controller->getReparation();
}
if(isset($_POST['insertReparation'])) {
    $controller->insertReparation();
}

class ControllerReparation {
    function insertReparation() {

    }
    function getReparation() {
       // $role = $_SESSION['role'];
        $idReparation = $_POST['idReparation'];
        $service = new ServiceReparation;
        $service->getReparation($idReparation);

    }
}