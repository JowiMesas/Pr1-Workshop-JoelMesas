<?php
namespace App\Controller;

use App\Service\ServiceReparation;

$controller = new ControllerReparation;
$controller->getReparation();

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