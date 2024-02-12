<?php
ini_set("display_errors", "On");

// Clase DatabaseSingleton
class DatabaseSingleton {
    // ---------------- ATRIBUTOS ---------------- 
    private static $instance;       // Almacena la instancia unica de la clase
    private $connection;
    private $config = [];

    // ---------------- METODOS ------------------ 
    // Constructor
    private function __construct() {
        $this->loadConfig();
        // Se crea conexion y la asigno a $connection
        $opciones = array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8");
        $this->connection = new PDO(
            "mysql:host={$this->config['host']};dbname={$this->config['db_name']}",
            $this->config['user'], 
            $this->config['password'], 
            $opciones
        );
    }

    // Funcion que carga el contenido del JSON de credenciales a un array
    private function loadConfig() {
        $json_file = file_get_contents('../config/db-conf.json');
        $config = json_decode($json_file, true);
        
        $this->config['host'] = $config['host'];
        $this->config['user'] = $config['user'];
        $this->config['password'] = $config['password'];
        $this->config['db_name'] = $config['db_name'];        
    }     
    
    // Función que crea la instancia única de la clase 
    public static function getInstance() {
        // si no hay instancia la crea, si ya hay una no la crea
        if(!self::$instance) {
            self::$instance = new self();
        }
        return self::$instance;
    }

    // Función que devuelve la conexión a la BD
    public function getConnection() {
        return $this->connection; 
    }
}


?>