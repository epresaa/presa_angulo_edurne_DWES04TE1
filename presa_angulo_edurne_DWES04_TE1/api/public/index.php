<?php

"use-strict";

// ------------------------------ IMPORTS -----------------------------------------
// Importar documentos
require_once "../app/model/entity/CocheEntity.php";
require_once "../app/model/entity/FurgonetaEntity.php";
require_once "../core/Codes.php";
require_once "../core/Router.php";
require_once "../app/controllers/Concesionario.php";
require_once "../core/HTTPNotFoundException.php";
require_once '../app/model/DAO/VehiculoDAO.php';

// ------------------------------ MAIN --------------------------------------------

// - - - - - - - - ROUTER - - - - - - - -
$url = $_SERVER["QUERY_STRING"];

// Crea una instancia el Router
$router = new Router(); 

// Se almacenan 5 rutas
// Ruta GET: para mostrar todo
$router->add("/api/public/concesionario/get", array(
    "controller"=>"Concesionario",
    "action"=>"getAllVehicles"
    )
);
// Ruta GET con {id}: para mostrar vehículo con ese id 
$router->add("/api/public/concesionario/get/{id}", array(
    "controller"=>"Concesionario",
    "action"=>"getVehicleById"
    )
);
// Ruta POST: para añadir un vehículo 
$router->add("/api/public/concesionario/create", array(
    "controller"=>"Concesionario",
    "action"=>"createVehicle"
    )
);
// Ruta update/{id}: para actualizar la información de vehículo con ese id 
$router->add("/api/public/concesionario/update/{id}", array(
    "controller"=>"Concesionario",
    "action"=>"updateVehicle"
    )
);
// Ruta delete/{id}: para borrar vehículo con ese id
$router->add("/api/public/concesionario/delete/{id}", array(
    "controller"=>"Concesionario",
    "action"=>"deleteVehicle"
    )
);


// - - - - - - - - CONTROLADOR FRONTAL - - - - - - - -
// Array con los parámetros de la url recibida
$urlParams = explode("/", $url);

// Array con la petición recibida desglosada en valores
$urlArray = array (
    "HTTP"=>$_SERVER["REQUEST_METHOD"], // Método CRUD llamado
    "path"=>$url,                       // Guarda url del nav: para buscarlo en ruter (existe?) 
    "controller"=>"",                   // Controlador: qué controlador se llama
    "action"=>"",                       // Método: qué método se llama en el controlador
    "params"=>""                        // Parámetros: parámetros recibidos por URL para el método 
);

// Validación: existe el controlador?
// Primero: comprueba si está recibiendo un controlador
if(!empty($urlParams[3])) {
    // Si recibe: lo rellena con eso
    $urlArray["controller"] = ucwords($urlParams[3]);
    

    // Comprueba si hay 'action'
    if(!empty($urlParams[4])) {
        // Sí hay: lo rellena con eso
        $urlArray["action"] = $urlParams[4];

        // Comprueba si hay parámetros y si hay los pasa
        if(!empty($urlParams[5])) {
            $urlArray["params"] = $urlParams[5];
        }
    } else {
        // No hay: el defecto
        $urlArray["action"] = "index";
    }
} else {
    // Si viene vacío: 
    $urlArray["controller"] = "Home";
    $urlArray["action"] = "index";
}


// - - - - - - - - MATCH DINAMICO - - - - - - - -
// Si la ruta está en el Router
try {
    if($router->matchRoutes($urlArray)) {
        
        // Qué método usa el cliente en la petición (CRUD)
        $method = $_SERVER["REQUEST_METHOD"];

        // Define un array de parámetros que se pasa a matchRoutes() -> en función del metodo recibido define unos u otros parámetros
        $params = [];

        switch ($method) {
            case "GET":
                // Puede necesitar id
                $params[] = intval($urlArray["params"]) ?? null;         // si no encuentra ningún id lo pone a null
                break;
            
            case "POST":
                // Necesita datos JSON
                $json = file_get_contents("php://input");
                $params[] = json_decode($json, true);
                break;
        
            case "PUT":
                // Necesita id
                $id = intval($urlArray["params"]) ?? null;
                $params[] = $id;
                // Necesita datos JSON
                $json = file_get_contents("php://input");
                $params[] = json_decode($json, true);
                break;
        
            case "DELETE":
                // Necesita id
                $params[] = intval($urlArray["params"]) ?? null;
                break;
        }

        // Crea controlador y métodos dinámicamente
        $controller = $router->getParams()["controller"];
        $action = $router->getParams()["action"];
        // Se le pasa la ruta del JSON al crearlo
        $controller = new $controller();               
        
        // Llamada de métodos: debe comprobar si la action existe en el controller
        if(method_exists($controller, $action)) {
            
            $respuesta = call_user_func_array([$controller, $action], $params);
        } else {
            echo "El método no existe";
        }

    // Cuando la URL no existe
    } else {
        // Lanza la excepción
        throw new HTTPNotFoundException();
    }

} catch(HTTPNotFoundException $e) {
    // Maneja la excepción
    echo "Error 404: " . $e->getMessage();
}


// - - - - - - - - BASE DE DATOS - - - - - - - -

// LLAMADAS CRUD: descomentando los siguientes apartados se pueden probar los metodos de vehiculoDAO
//$vehiculoDAO = new VehiculoDAO();

// Obtener todos los vehiculos
// $vehiculos = $vehiculoDAO->obtenerTodosVehiculos();
// echo json_encode($vehiculos);

// Obtener vehiculo por ID
//$vehiculo = $vehiculoDAO->obtenerVehiculoPorId(4);
//echo json_encode($vehiculo);

// Obtener vehiculo por ID
// $vehiculo = $vehiculoDAO->obtenerVehiculoPorMatricula("5035VWX");
// echo json_encode($vehiculo);

// Obtener vehiculos por tipo: por ejemplo solo los coches
//$vehiculos = $vehiculoDAO->obtenerVehiculosPorTipo("coche");
//echo json_encode($vehiculos);

// Insertar vehiculo: por ejemplo una furgoneta
//$furgoneta = $vehiculoDAO->crearFurgoneta("ASD1234", "furgoneta", "MarcaFurgo", "ModeloA", 2023, "rosa", 4000, 15000, "gasolina", "mediana", 12);
//echo json_encode($furgoneta);

// Eliminar vehiculo por ID:
//$eliminado = $vehiculoDAO->eliminarVehiculoPorId();       // INDICAR ID: para que funcione 
//echo json_encode($eliminado);

// Eliminar vehiculo por matricula: 
// Primero creo un vehiculo para eliminar 
//$coche = $vehiculoDAO->crearCoche("ZZZ1111", "coche", "marca", "modelo", 2023, "rosa", 4000, 15000, "gasolina", "suv");
//$eliminado = $vehiculoDAO->eliminarVehiculoPorMatricula("ZZZ1111");
//echo json_encode($eliminado);

// Actualizar vehiculo por ID: solo se pasan los datos que se quiere actualizar
// $nuevosDatos = array(
//     "color"=>"Verde",
//     "km"=>"60000"
// );
// $actualizado = $vehiculoDAO->actualizarVehiculoPorId(1, $nuevosDatos);
// echo json_encode($actualizado);

// Actualizar vehiculo por Matricula:
// $nuevosDatos = array(
//     "anio"=>"2019",
//     "color"=>"Negro"
// );
// $actualizado = $vehiculoDAO->actualizarVehiculoPorMatricula("1223BBC", $nuevosDatos);
// echo json_encode($actualizado);


?>