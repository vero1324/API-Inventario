<?php
header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json; charset=utf-8');
header('Access-Control-Allow-Methods: PUT, POST, DELETE, GET, OPTIONS');
header('Access-Control-Max-Age: 3600');
header('Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Origin, Authorization, X-Requested-With');

include_once '../config/database.php';

$database = new DatabasesConexion();
$db = $database->obtenerConn();

class Proveedores {
    private $conn;
    private $table_name = "Proveedores";

    public function __construct($db) {
        $this->conn = $db;
    }

    public function get() {
        $query = "SELECT * FROM " . $this->table_name;
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        $providers = $stmt->fetchAll(PDO::FETCH_ASSOC);
        echo json_encode($providers);
    }

    public function post() {
        $data = json_decode(file_get_contents("php://input"));
        $query = "INSERT INTO " . $this->table_name . " (nombre, contacto, direccion, creado_por, modificado_por) VALUES (?, ?, ?, ?, ?)";
        $stmt = $this->conn->prepare($query);
        $stmt->execute([$data->nombre, $data->contacto, $data->direccion, $data->creado_por, $data->modificado_por]);
        echo json_encode(["message" => "Proveedor creado"]);
    }

    public function put() {
        $data = json_decode(file_get_contents("php://input"));
        $query = "UPDATE " . $this->table_name . " SET nombre = ?, contacto = ?, direccion = ?, modificado_por = ? WHERE id = ?";
        $stmt = $this->conn->prepare($query);
        $stmt->execute([$data->nombre, $data->contacto, $data->direccion, $data->modificado_por, $data->id]);
        echo json_encode(["message" => "Proveedor actualizado"]);
    }

    public function delete() {
        $data = json_decode(file_get_contents("php://input"));
        $query = "DELETE FROM " . $this->table_name . " WHERE id = ?";
        $stmt = $this->conn->prepare($query);
        $stmt->execute([$data->id]);
        echo json_encode(["message" => "Proveedor eliminado"]);
    }
}

$database = new Database();
$db = $database->getConnection();
$provider = new Proveedores($db);

$request_method = $_SERVER["REQUEST_METHOD"];

switch($request_method) {
    case 'GET':
        $provider->get();
        break;
    case 'POST':
        $provider->
