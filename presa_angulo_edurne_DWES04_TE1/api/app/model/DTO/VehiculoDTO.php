<?php

/* Clase VehiculoDTO: objeto que transporta los datos entre capas
 *                    implementa la interfaz JsonSerializable 
 */
class VehiculoDTO implements JsonSerializable {
    // ---------------- ATRIBUTOS ---------------- 
    protected  $tipo;
    protected  $marca;
    protected  $modelo;
    protected  $anio;
    protected  $precio;
    protected  $km;
    protected  $combustible;

    // ---------------- METODOS ------------------ 
    // Constructor
    public function __construct($tipo, $marca, $modelo, $anio, $precio, $km, $combustible) {  
        $this->tipo = $tipo;
        $this->marca = $marca;
        $this->modelo = $modelo;
        $this->anio = $anio;
        $this->precio = $precio;
        $this->km = $km;
        $this->combustible = $combustible;
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
}
?>