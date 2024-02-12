<?php 

/* Clase Concesionario: maneja los métodos usados por las peticiones CRUD
 *                      utiliza los métodos de VehiculoDAO
 */

class Concesionario {
    // ---------------- ATRIBUTOS ------------------ 
    private $vehiculoDAO;

    // ---------------- METODOS -------------------- 
    // Constructor
    function __construct() {
        $this->vehiculoDAO = new VehiculoDAO();
    }

    
    // Métodos del CRUD
    // - - - - GET - - - -
    public function getAllVehicles() {
        $vehicles = $this->vehiculoDAO->obtenerTodosVehiculos();
        echo json_encode($vehicles);
    }

    // Obtener vehículo por ID
    public function getVehicleById($id) {
        $vehicle = $this->vehiculoDAO->obtenerVehiculoPorId($id);
        echo json_encode($vehicle);
    }

    // - - - - POST - - - - 
    // Crear vehículo
    public function createVehicle($data) {
        $datosCoche = [];
        $datosFurgo = [];

        // Verifica si se ha incluido el tipo
        if (isset($data['tipo'])) {
            $tipo = $data['tipo'];

            // Decide qué método de VehiculoDAO llamar según el tipo de vehículo
            if($tipo == "coche") {
                $datosCoche = array(
                    'matricula' => $data['matricula'],
                    'tipo' => $data['tipo'],
                    'marca' => $data['marca'],
                    'modelo' => $data['modelo'],
                    'anio' => $data['anio'],
                    'color' => $data['color'],
                    'precio' => $data['precio'],
                    'km' => $data['km'],
                    'combustible' => $data['combustible'],
                    'categoria' => $data['categoria']
                );
                $vehicle = $this->vehiculoDAO->crearCoche($datosCoche);
            }

            if($tipo == "furgoneta") {
                $datosFurgo = array(
                    'matricula' => $data['matricula'],
                    'tipo' => $data['tipo'],
                    'marca' => $data['marca'],
                    'modelo' => $data['modelo'],
                    'anio' => $data['anio'],
                    'color' => $data['color'],
                    'precio' => $data['precio'],
                    'km' => $data['km'],
                    'combustible' => $data['combustible'],
                    'tamanio' => $data['tamanio'],
                    'volumen_carga_m3' => $data['volumen_carga_m3']
                );
                $vehicle = $this->vehiculoDAO->crearFurgoneta($datosFurgo);
            }
                    
        }
        if ($vehicle) {
            echo json_encode($vehicle);
        }
    }

    // - - - - PUT- - - - 
    // Actualizar vehículo por ID
    public function updateVehicle($id, $data) {
        $actualizar = $this->vehiculoDAO->obtenerVehiculoPorId($id);

        // Si hay vehiculo que actualizar
        if ($actualizar) {
            $actualizado = $this->vehiculoDAO->actualizarVehiculoPorId($id, $data);

            // Si se ha actualizado
            if ($actualizado) {
                echo json_encode($actualizado);
            } else {
                return "Error al actualizar el vehículo.";
            }
        } else {
            return "El vehículo con el ID proporcionado no existe.";
        }
    }

    // - - - - DELETE - - - - 
    // Eliminar vehículo por ID
    public function deleteVehicle($id) {
        $vehicle = $this->vehiculoDAO->eliminarVehiculoPorId($id);
        echo json_encode($vehicle);
    }
}
?>