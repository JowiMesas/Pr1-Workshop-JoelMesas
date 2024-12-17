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

    }
    function getReparation() {
        $idReparation = $_POST['idReparation'];
        $service = new ServiceReparation;
        $result = $service->getReparation($idReparation);
        $view = new ViewReparation();
        $view->render($result);
    }
}