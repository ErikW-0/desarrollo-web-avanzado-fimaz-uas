<?php
 Class Producto{
    private $id;
    private $nombre;
    private $descripcion;
    private $existencia;
    private $precio;

    function __construct($id= NULL,$nombre="",$descripcion="",$existencia=0,$precio= 0.00){
    {
        $this->id = $id;
        $this->nombre = $nombre;
        $this->descripcion = $descripcion;
        $this->existencia = $existencia;
        $this->precio = $precio;  
    }
    }
    function getId(){
        return $this->id;
    } 
    function getNombre(){
        return $this->nombre;
       } 
       function getDescripcion(){
        return $this->descripcion;
    }
        function getExistencia(){
            return $this->existencia;
    }
        function getPrecio(){
            return $this->precio;   
    }

        function setId($id){
            $this->id = $id;
    }
        function setNombre($nombre){
            $this->nombre = $nombre;
    }
        function setDescripcion($descripcion){
            $this->descripcion = $descripcion;
    }
        function setPrecio($precio){
            $this->precio = $precio;
    }
        function setExistencia($existencia){
            $this->existencia = $existencia;
    }
  
 }

?>
