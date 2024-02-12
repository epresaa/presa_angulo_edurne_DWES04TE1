<?php

require_once '../core/DatabaseSingleton.php';
require_once '../app/model/DTO/VehiculoDTO.php';
require_once '../app/model/DTO/FurgonetaDTO.php';
require_once '../app/model/DTO/CocheDTO.php';


// Clase VehiculoDAO: clase intermedia que contiene los métodos del CRUD que se llaman desde Concesionario
class VehiculoDAO {
    private $db;

    // Constructor
    public function __construct() {
        $this->db = DatabaseSingleton::getInstance();
    }

    // ------------- Métodos del CRUD ---------------
    // GET: todos
    public function obtenerTodosVehiculos() {
        $connection = $this->db->getConnection();
        $query = "SELECT * FROM VEHICULOS";
        $statement = $connection->query($query);
        $result = $statement->fetchAll(PDO::FETCH_ASSOC);

        return $result;
    }

    // GET: por id
    public function obtenerVehiculoPorId($id) {
        $connection = $this->db->getConnection();
        $query = "SELECT * FROM VEHICULOS WHERE ID_VEHICULO = '" . $id . "'";
        $statement = $connection->query($query);
        $result = $statement->fetchAll(PDO::FETCH_ASSOC);
        return $result;
    }

    // GET: por matricula
    public function obtenerVehiculoPorMatricula($matricula) {
        $connection = $this->db->getConnection();
        $query = "SELECT * FROM VEHICULOS WHERE MATRICULA = '" . $matricula . "'";
        $statement = $connection->query($query);
        $result = $statement->fetchAll(PDO::FETCH_ASSOC);
        return $result;
    }

    // GET: por clase (furgonetas o coches)
    public function obtenerVehiculosPorTipo($tipo) {
        $connection = $this->db->getConnection();
        $query = "SELECT * FROM VEHICULOS WHERE TIPO = '" . $tipo . "'";
        $statement = $connection->query($query);
        $result = $statement->fetchAll(PDO::FETCH_ASSOC);

        $vehiculosDTO = array();

        for($i = 0; $i < count($result); $i++) {
            $fila = $result[$i];

            // Determina si es coche o furgoneta
            if($tipo == "coche") {
                $cocheDTO = new CocheDTO(
                    $fila["TIPO"],
                    $fila["MARCA"],
                    $fila["MODELO"],
                    $fila["ANIO"],
                    $fila["PRECIO"],
                    $fila["KM"],
                    $fila["COMBUSTIBLE"],
                    $fila["CATEGORIA"]
                );
                $vehiculosDTO[] = $cocheDTO;
            }
            if($tipo == "furgoneta") {
                $furgoDTO = new FurgonetaDTO(
                    $fila["TIPO"],
                    $fila["MARCA"],
                    $fila["MODELO"],
                    $fila["ANIO"],
                    $fila["PRECIO"],
                    $fila["KM"],
                    $fila["COMBUSTIBLE"],
                    $fila["TAMANIO"], 
                    $fila["VOLUMEN_CARGA_M3"]
                );
                $vehiculosDTO[] = $furgoDTO;
            }
        }
        return $vehiculosDTO;
    } 

    // POST: crear coche
    public function crearCoche($datos) {       
        $connection = $this->db->getConnection();

        // Insertar datos en la tabla de vehiculos
        $query = "INSERT INTO VEHICULOS (MATRICULA, TIPO, MARCA, MODELO, ANIO, COLOR, PRECIO, KM, COMBUSTIBLE, CATEGORIA) 
                 VALUES (:matricula, :tipo, :marca, :modelo, :anio, :color, :precio, :km, :combustible, :categoria)";
        $statement = $connection->prepare($query);
        $statement->bindParam(':matricula', $datos['matricula']);
        $statement->bindParam(':tipo', $datos['tipo']);
        $statement->bindParam(':marca', $datos['marca']);
        $statement->bindParam(':modelo', $datos['modelo']);
        $statement->bindParam(':anio', $datos['anio']);
        $statement->bindParam(':color', $datos['color']);
        $statement->bindParam(':precio', $datos['precio']);
        $statement->bindParam(':km', $datos['km']);
        $statement->bindParam(':combustible', $datos['combustible']);
        $statement->bindParam(':categoria', $datos['categoria']);
        $statement->execute();

        // Obtener información del coche insertado
        $id = $connection->lastInsertId();
        $nuevoCoche = $this->obtenerVehiculoPorId($id);

        // Insertar datos en la tabla de coches
        $queryCoches = "INSERT INTO COCHES (ID_VEHICULO, MATRICULA, TIPO, MARCA, MODELO, ANIO, COLOR, KM, PRECIO, COMBUSTIBLE, CATEGORIA) 
                       VALUES (:id, :matricula, :tipo, :marca, :modelo, :anio, :color, :km, :precio, :combustible, :categoria)";
        $statementCoches = $connection->prepare($queryCoches);
        $statementCoches->bindParam(':id', $id);
        $statementCoches->bindParam(':matricula', $datos['matricula']);
        $statementCoches->bindParam(':tipo', $datos['tipo']);
        $statementCoches->bindParam(':marca', $datos['marca']);
        $statementCoches->bindParam(':modelo', $datos['modelo']);
        $statementCoches->bindParam(':anio', $datos['anio']);
        $statementCoches->bindParam(':color', $datos['color']);
        $statementCoches->bindParam(':km', $datos['km']);
        $statementCoches->bindParam(':precio', $datos['precio']);
        $statementCoches->bindParam(':combustible', $datos['combustible']);
        $statementCoches->bindParam(':categoria', $datos['categoria']);
        $statementCoches->execute();
        
        return $nuevoCoche;
    }
    
    // POST: crear furgoneta
    public function crearFurgoneta($datos) {       
        $connection = $this->db->getConnection();
        
        // Insertar datos en la tabla de vehiculos
        $query = "INSERT INTO VEHICULOS (MATRICULA, TIPO, MARCA, MODELO, ANIO, COLOR, PRECIO, KM, COMBUSTIBLE, TAMANIO, VOLUMEN_CARGA_M3) 
            VALUES (:matricula, :tipo, :marca, :modelo, :anio, :color, :precio, :km, :combustible, :tamanio, :volumen_carga_m3)";
 
        $statement = $connection->prepare($query);
        $statement->bindParam(':matricula', $datos['matricula']);
        $statement->bindParam(':tipo', $datos['tipo']);
        $statement->bindParam(':marca', $datos['marca']);
        $statement->bindParam(':modelo', $datos['modelo']);
        $statement->bindParam(':anio', $datos['anio']);
        $statement->bindParam(':color', $datos['color']);
        $statement->bindParam(':precio', $datos['precio']);
        $statement->bindParam(':km', $datos['km']);
        $statement->bindParam(':combustible', $datos['combustible']);
        $statement->bindParam(':tamanio', $datos['tamanio']);
        $statement->bindParam(':volumen_carga_m3', $datos['volumen_carga_m3']);
        $statement->execute();

        // Obtener información de la furgoneta insertada
        $id = $connection->lastInsertId();
        $nuevaFurgo = $this->obtenerVehiculoPorId($id);

        // Insertar datos en la tabla de furgonetas
        $queryFurgonetas = "INSERT INTO FURGONETAS (ID_VEHICULO, MATRICULA, TIPO, MARCA, MODELO, ANIO, COLOR, KM, PRECIO, COMBUSTIBLE, TAMANIO, VOLUMEN_CARGA_M3) 
                        VALUES (:id, :matricula, :tipo, :marca, :modelo, :anio, :color, :km, :precio, :combustible, :tamanio, :volumen_carga_m3)";
        $statementFurgonetas = $connection->prepare($queryFurgonetas);
        $statementFurgonetas->bindParam(':id', $id);
        $statementFurgonetas->bindParam(':matricula', $datos['matricula']);
        $statementFurgonetas->bindParam(':tipo', $datos['tipo']);
        $statementFurgonetas->bindParam(':marca', $datos['marca']);
        $statementFurgonetas->bindParam(':modelo', $datos['modelo']);
        $statementFurgonetas->bindParam(':anio', $datos['anio']);
        $statementFurgonetas->bindParam(':color', $datos['color']);
        $statementFurgonetas->bindParam(':km', $datos['km']);
        $statementFurgonetas->bindParam(':precio', $datos['precio']);
        $statementFurgonetas->bindParam(':combustible', $datos['combustible']);
        $statementFurgonetas->bindParam(':tamanio', $datos['tamanio']);
        $statementFurgonetas->bindParam(':volumen_carga_m3', $datos['volumen_carga_m3']);
        $statementFurgonetas->execute();
        
        return $nuevaFurgo;
    }

    // DELETE: por ID
    public function eliminarVehiculoPorId($id) {
        $connection = $this->db->getConnection();

        // Obtener información del coche a eliminar 
        $eliminar = $this->obtenerVehiculoPorId($id);

        // Consulta: primero determinar COCHE o FURGONETA 
        $queryTipoVehiculo = "SELECT TIPO FROM VEHICULOS WHERE ID_VEHICULO = :id";
        $statementTipoVehiculo = $connection->prepare($queryTipoVehiculo);
        $statementTipoVehiculo->bindParam(':id', $id);
        $statementTipoVehiculo->execute();
        $tipoVehiculo = $statementTipoVehiculo->fetch(PDO::FETCH_COLUMN);

        // Si no hay resultados, el vehículo no existe
        if (!$tipoVehiculo) {
            echo "No existe ningún vehículo con ese ID.";
            return null;
        }

        // Consulta eliminar de COCHE o FURGONETA
        if ($tipoVehiculo === "coche") {
            $queryEliminarCoche = "DELETE FROM COCHES WHERE ID_VEHICULO = :id";
            $statementEliminarCoche = $connection->prepare($queryEliminarCoche);
            $statementEliminarCoche->bindParam(':id', $id);
            $statementEliminarCoche->execute();
        } elseif ($tipoVehiculo === "furgoneta") {
            $queryEliminarFurgoneta = "DELETE FROM FURGONETAS WHERE ID_VEHICULO = :id";
            $statementEliminarFurgoneta = $connection->prepare($queryEliminarFurgoneta);
            $statementEliminarFurgoneta->bindParam(':id', $id);
            $statementEliminarFurgoneta->execute();
        }

        // Consulta eliminar de VEHICULOS
        $queryEliminarVehiculo = "DELETE FROM VEHICULOS WHERE ID_VEHICULO = :id";
        $statementEliminarVehiculo = $connection->prepare($queryEliminarVehiculo);
        $statementEliminarVehiculo->bindParam(':id', $id);
        $statementEliminarVehiculo->execute();

        // Verificar si se eliminó correctamente y devolver el resultado
        return $eliminar;
    }
    
    // DELETE: por matricula
    public function eliminarVehiculoPorMatricula($matricula) {
        $connection = $this->db->getConnection();
        
        /// Obtener información del vehiculo a eliminar
        $query = "SELECT * FROM VEHICULOS WHERE MATRICULA = :matricula";
        $statement = $connection->prepare($query);
        $statement->bindParam(':matricula', $matricula);
        $statement->execute();
        $result = $statement->fetch(PDO::FETCH_ASSOC);

        // Si existe: 
        if($result) {
            // Determina el tipo de vehículo
            $tipoVehiculo = $result['tipo'];
            
            // Consulta eliminar de VEHICULOS
            $queryDelete = "DELETE FROM VEHICULOS WHERE MATRICULA = :matricula";
            $statementDelete = $connection->prepare($queryDelete);
            $statementDelete->bindParam(':matricula', $matricula);
            $statementDelete->execute();

            // Consulta eliminar de COCHES o FURGONETAS
            if ($tipoVehiculo === "coche") {
                $queryDeleteCoche = "DELETE FROM COCHES WHERE MATRICULA = :matricula";
                $statementDeleteCoche = $connection->prepare($queryDeleteCoche);
                $statementDeleteCoche->bindParam(':matricula', $matricula);
                $statementDeleteCoche->execute();
            } elseif ($tipoVehiculo === "furgoneta") {
                $queryDeleteFurgoneta = "DELETE FROM FURGONETAS WHERE MATRICULA = :matricula";
                $statementDeleteFurgoneta = $connection->prepare($queryDeleteFurgoneta);
                $statementDeleteFurgoneta->bindParam(':matricula', $matricula);
                $statementDeleteFurgoneta->execute();
            }
            return $result;

        } else {
            echo "No existe ningún vehiculo con esa matricula";
        }
    }
    
    // UPDATE: por ID
    public function actualizarVehiculoPorId($id, $datos) {
        $connection = $this->db->getConnection();

        // Construccion de la Query
        $queryTEMP = "";
        $i = 0; 

        // Comprobar qué actualiza
        $campos_actualizables = array("matricula", "tipo", "marca", "modelo", "anio", "color", "precio", "km", "combustible", "categoria", "volumen_carga_m3", "tamanio");
        
        // Para cada campo que se quiere actualizar: lo busca en los posibles
        foreach($campos_actualizables as $campo) {
            if(array_key_exists($campo, $datos)) {
                // Si no es la primera vuelta: añade coma
                if($i != 0) {
                    $queryTEMP .= ", ";
                }
                
                // Se añade ese campo
                $queryTEMP .= "$campo = :$campo";
                $i++;
            }
        }

        // 1ª Consulta VEHICULOS: actualizar
        $query = "UPDATE VEHICULOS SET $queryTEMP WHERE ID_VEHICULO = :id";
        $statement = $connection->prepare($query);
        foreach ($campos_actualizables as $campo) {
            // Indica el valor de cada campo
            if (array_key_exists($campo, $datos)) {
                $statement->bindValue(":$campo", $datos[$campo]);
            }
        }
        $statement->bindParam(':id', $id);
        $statement->execute();

        // Obtener información del coche actualizado
        $actualizado = $this->obtenerVehiculoPorId($id);
        
        // 2ª Consulta: determinar si es COCHE o FURGONETA 
        $queryTipoVehiculo = "SELECT tipo FROM VEHICULOS WHERE ID_VEHICULO = :id";
        $statementTipoVehiculo = $connection->prepare($queryTipoVehiculo);
        $statementTipoVehiculo->bindParam(':id', $id);
        $statementTipoVehiculo->execute();
        $tipoVehiculo = $statementTipoVehiculo->fetch(PDO::FETCH_COLUMN);
    
        // 3ª Consulta - actualizar
        $queryTablaCoF = "";
        if ($tipoVehiculo === "coche") {
            $queryTablaCoF = "UPDATE COCHES SET $queryTEMP WHERE ID_VEHICULO = :id";
        } elseif ($tipoVehiculo === "furgoneta") {
            $queryTablaCoF = "UPDATE FURGONETAS SET $queryTEMP WHERE ID_VEHICULO = :id";
        }
        $queryTablaCoF = $connection->prepare($queryTablaCoF);
        foreach ($campos_actualizables as $campo) {
            // Indica el valor de cada campo para la tabla correspondiente
            if (array_key_exists($campo, $datos)) {
                $queryTablaCoF->bindValue(":$campo", $datos[$campo]);
            }
        }
        $queryTablaCoF->bindParam(':id', $id);
        $queryTablaCoF->execute();

        return $actualizado;
    }

    // UPDATE: por matricula
    public function actualizarVehiculoPorMatricula($matricula, $datos) {
        $connection = $this->db->getConnection();
    
        // Construcción de la Query
        $queryTEMP = "";
        $i = 0; 
    
        // Comprobar qué actualiza
        $campos_actualizables = array("matricula", "tipo", "marca", "modelo", "anio", "color", "precio", "km", "combustible", "categoria", "volumen_carga_m3", "tamanio");
        
        // Para cada campo que se quiere actualizar: lo busca en los posibles
        foreach($campos_actualizables as $campo) {
            if(array_key_exists($campo, $datos)) {
                // Si no es la primera vuelta: añade coma
                if($i != 0) {
                    $queryTEMP .= ", ";
                }
                
                // Se añade ese campo
                $queryTEMP .= "$campo = :$campo";
                $i++;
            }
        }
    
        // 1ª Consulta VEHICULOS: busca el vehiculo a actualizar
        $query = "UPDATE VEHICULOS SET $queryTEMP WHERE MATRICULA = :matricula";
        $statement = $connection->prepare($query);
        foreach ($campos_actualizables as $campo) {
            // Indica el valor de cada campo
            if (array_key_exists($campo, $datos)) {
                $statement->bindValue(":$campo", $datos[$campo]);
            }
        }
        $statement->bindParam(':matricula', $matricula);
        $statement->execute();
    
        // Obtener información del coche actualizado
        $actualizado = $this->obtenerVehiculoPorMatricula($matricula);
        
        // 2ª Consulta: determinar si es COCHE o FURGONETA 
        $queryTipoVehiculo = "SELECT tipo FROM VEHICULOS WHERE MATRICULA = :matricula";
        $statementTipoVehiculo = $connection->prepare($queryTipoVehiculo);
        $statementTipoVehiculo->bindParam(':matricula', $matricula);
        $statementTipoVehiculo->execute();
        $tipoVehiculo = $statementTipoVehiculo->fetch(PDO::FETCH_COLUMN);

        // 3ª Consulta - actualizar
        $queryTablaCoF = "";
        if ($tipoVehiculo === "coche") {
            $queryTablaCoF = "UPDATE COCHES SET $queryTEMP WHERE MATRICULA = :matricula";
        } elseif ($tipoVehiculo === "furgoneta") {
            $queryTablaCoF = "UPDATE FURGONETAS SET $queryTEMP WHERE MATRICULA = :matricula";
        }
        $queryTablaCoF = $connection->prepare($queryTablaCoF);
        foreach ($campos_actualizables as $campo) {
            // Indica el valor de cada campo para la tabla correspondiente
            if (array_key_exists($campo, $datos)) {
                $queryTablaCoF->bindValue(":$campo", $datos[$campo]);
            }
        }
        $queryTablaCoF->bindParam(':matricula', $matricula);
        $queryTablaCoF->execute();

        return $actualizado;
    }
}

?>


