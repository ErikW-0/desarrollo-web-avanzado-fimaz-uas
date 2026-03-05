<?php

class Mensaje {
  public $mensaje = "hola ";

  public function minombre($nombre){
    return $this->mensaje.$nombre;
  }
}
$objMesaje = new Mensaje();
echo $objMesaje->minombre('Erik Watson')."\n";

?>
