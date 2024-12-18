<?php
namespace App\Model;
class Reparation {
  private $idReparation;
  private $idWorkshop;
  private $nameWorkshop;
  private $registerDate;
  private $licenseVehicle;

  public function __construct($idReparation, $idWorkshop, $nameWorkshop, $registerDate, $licenseVehicle) {
      $this->idReparation = $idReparation;
      $this->idWorkshop = $idWorkshop;
      $this->nameWorkshop = $nameWorkshop;
      $this->registerDate = $registerDate;
      $this->licenseVehicle = $licenseVehicle;
  }   


public function getIdReparation() {
    return $this->idReparation;
}

public function getIdWorkshop() {
    return $this->idWorkshop;
}

public function getNameWorkshop() {
    return $this->nameWorkshop;
}

public function getRegisterDate() {
    return $this->registerDate;
}

public function getLicenseVehicle() {
    return $this->licenseVehicle;
}
public function setIdReparation($idReparation) {
    $this->idReparation = $idReparation;
}
public function setIdWorkshop($idWorkshop) {
    $this->idWorkshop = $idWorkshop;
}

public function setNameWorkshop($nameWorkshop) {
    $this->nameWorkshop = $nameWorkshop;
}

public function setRegisterDate($registerDate) {
    $this->registerDate = $registerDate;
}

public function setLicenseVehicle($licenseVehicle) {
    $this->licenseVehicle = $licenseVehicle;
}
}