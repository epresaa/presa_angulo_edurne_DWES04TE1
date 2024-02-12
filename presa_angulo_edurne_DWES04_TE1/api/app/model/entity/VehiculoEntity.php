<?php

// CLASE VEHICULO
class VehiculoEntity {
    // ---------------- ATRIBUTOS ----------------
    private $matricula;
    private $tipo;
    private $marca;
    private $modelo;
    private $anio;
    private $km;
    private $precio;
    private $color;
    private $combustible;
    private $categoria;
    private $volumen_carga_m3;
    private $tamanio;

    // ---------------- METODOS ------------------
    // Constructor
    function __construct($matricula, $tipo,  $marca, $modelo, $anio, $color, $km, $precio, $combustible, $categoria, $volumen_carga_m3, $tamanio) {
        $this->matricula = $matricula;
        $this->marca = $marca;
        $this->modelo = $modelo;
        $this->anio = $anio;
        $this->color = $color;
        $this->km = $km;
        $this->precio = $precio;
        $this->combustible = $combustible;
        $this->volumen_carga_m3 = $volumen_carga_m3;

        // Tipo: validación -> solo 'Coche' o 'Furgoneta'
        $tiposPermitidos = ["coche", "furgoneta"];
        if (in_array(strtolower($tipo), $tiposPermitidos)) {
            // El valor se encuentra en el array de opciones: se almacena
            $this->tipo = strtolower($tipo);
        
        } else {
            // El valor no es válido: Excepción
            throw new InvalidArgumentException("Error: el vehiculo solo puede ser Coche o Furgoneta");
        }

        // Categoria: validación -> solo 'sedan', 'SUV' o 'compacto'
        $catPermitidas = ["sedan", "suv", "compacto"];
        if (in_array(strtolower($categoria), $catPermitidas)) {
            // El valor se encuentra en el array de opciones: se almacena
            $this->categoria = strtolower($categoria);
        
        } else {
            // El valor no es válido: Excepción
            throw new InvalidArgumentException("Error: la categoría de coche debe ser compacto, sedan o SUV");
        }

        // Tamanio: validación -> solo 'corta', 'mediana' o 'larga'
        $tamaPermitidos = ["corta", "mediana", "larga"];
        
        if (in_array(strtolower($tamanio), $tamaPermitidos)) {
            // El valor se encuentra en el array de opciones: se almacena
            $this->tamanio = strtolower($tamanio);
        
        } else {
            // El valor no es válido: Excepción
            throw new InvalidArgumentException("Error: el tamaño de furgoneta debe ser corta, mediana o larga");
        }
    }

    // Getter MATRICULA
    public function getMatricula() {
        return $this->matricula;
    }

    // Setter MATRICULA
    public function setMatricula($matricula): self {
        $this->matricula = $matricula;
        return $this;
    }

    // Getter TIPO
    public function getTipo() {
        return $this->tipo;
    }

    // Setter TIPO
    public function setTipo($tipo): self {
        $this->tipo = $tipo;
        return $this;
    }

    // Getter MARCA
    public function getMarca() {
        return $this->marca;
    }

    // Setter MARCA
    public function setMarca($marca): self {
        $this->marca = $marca;
        return $this;
    }

    // Getter MODELO
    public function getModelo() {
        return $this->modelo;
    }

    // Setter MODELO
    public function setModelo($modelo): self {
        $this->modelo = $modelo;
        return $this;
    }

    // Getter ANIO
    public function getAnio() {
        return $this->anio;
    }

    // Setter ANIO
    public function setAnio($anio): self {
        $this->anio = $anio;
        return $this;
    }

    // Getter KM
    public function getKm() {
        return $this->km;
    }

    // Setter KM
    public function setKm($km): self {
        $this->km = $km;
        return $this;
    }

    // Getter PRECIO
    public function getPrecio() {
        return $this->precio;
    }

    // Setter PRECIO
    public function setPrecio($precio): self {
        $this->precio = $precio;
        return $this;
    }

    // Getter COLOR
    public function getColor() {
        return $this->color;
    }

    // Setter COLOR
    public function setColor($color): self {
        $this->color = $color;
        return $this;
    }

    // Getter COMBUSTIBLE
    public function getCombustible() {
        return $this->combustible;
    }

    // Setter COMBUSTIBLE
    public function setCombustible($combustible): self {
        $this->combustible = $combustible;
        return $this;
    }

    // Getter CATEGORIA
    public function getCategoria() {
        return $this->categoria;
    }

    // Setter CATEGORIA
    public function setCategoria($categoria): self {
        $this->categoria = $categoria;
        return $this;
    }

    // Getter VOLUMEN_CARGA_M3
    public function getVolumenCargaM3() {
        return $this->volumen_carga_m3;
    }

    // Setter VOLUMEN_CARGA_M3
    public function setVolumenCargaM3($volumen_carga_m3): self {
        $this->volumen_carga_m3 = $volumen_carga_m3;
        return $this;
    }

    // Getter TAMANIO
    public function getTamanio() {
        return $this->tamanio;
    }
    
    // Setter TAMANIO
    public function setTamanio($tamanio): self {
        $this->tamanio = $tamanio;
        return $this;
    }
}

?>