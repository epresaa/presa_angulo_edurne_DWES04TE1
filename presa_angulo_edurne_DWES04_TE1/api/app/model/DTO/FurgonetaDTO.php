<?php

/* Clase FurgonetaDTO: objeto que transporta los datos entre capas
 *                     implementa la interfaz JsonSerializable 
 */
class FurgonetaDTO extends VehiculoDTO implements JsonSerializable {
    // ---------------- ATRIBUTOS ---------------- 
    private $tamanio;
    private $volumen_carga_m3;
    
    // ---------------- METODOS ------------------ 
    // Constructor
    public function __construct($tipo, $marca, $modelo, $anio, $precio, $km, $combustible, $tamanio, $volumen_carga_m3) {  
        parent::__construct($tipo, $marca, $modelo, $anio, $precio, $km, $combustible);

        $this->tamanio = $tamanio;
        $this->volumen_carga_m3 = $volumen_carga_m3;
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
    // Get TAMANIO
    public function getTamanio() {
        return $this->tamanio;
    }
    // Get VOLUMEN DE CARGA
    public function getVolumenCargaM3() {
        return $this->volumen_carga_m3;
    }
}
?>
