<?php

/* Clase CocheDTO:  objeto que transporta los datos entre capas
 *                  implementa la interfaz JsonSerializable 
 */
class CocheDTO extends VehiculoDTO implements JsonSerializable {
    // ---------------- ATRIBUTOS ---------------- 
    private $categoria;
    
    // ---------------- METODOS ------------------ 
    // Constructor
    public function __construct($tipo, $marca, $modelo, $anio, $precio, $km, $combustible, $categoria) {  
        parent::__construct($tipo, $marca, $modelo, $anio, $precio, $km, $combustible);

        $this->categoria = $categoria;
    }

    // Funcion jsonSerialize: función de la interfaz JsonSerializable 
    public function jsonSerialize(): array {
        return get_object_vars($this);
    }

    // - - - - GETTERS - - - -
    // Get TIPO
    public function getTipo() {
        return $this->tipo;
    }
    // Get MARCA
    public function getMarca() {
        return $this->marca;
    }
    // Get MODELO
    public function getModelo() {
        return $this->modelo;
    }
    // Get ANIO
    public function getAnio() {
        return $this->anio;
    }
    // Get PRECIO
    public function getPrecio() {
        return $this->precio;
    }
    // Get KM
    public function getKm() {
        return $this->km;
    }
    // Get COMBUSTIBLE
    public function getCombustible() {
        return $this->combustible;
    }
    // Get CATEGORIA
    public function getCategoria() {
        return $this->categoria;
    }
}
?>
