<?php
   
    require_once("../../controllers/torneosControllers.php");

    
    $objTorneosController = new torneosController();
    $id = $_GET['id'];
    $objTorneosController->delete($id);
?>