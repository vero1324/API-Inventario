<?php
header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json; charset=utf-8');
header('Access-Control-Allow-Methods: PUT, POST, DELETE, GET, OPTIONS');
header('Access-Control-Max-Age: 3600');
header('Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Origin, Authorization, X-Requested-With');

include_once '../config/database.php';

$database = new DatabasesConexion();
$db = $database->obtenerConn();

$request_method = $_SERVER["REQUEST_METHOD"];

class Inventarios {
    private $conn;
    private $table_name = "Inventarios";

    public function __construct($db) {
        $this->conn = $db;
    }

    public function get() {
        $query = "SELECT * FROM " . $this->table_name;
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        $inventories = $stmt->fetchAll(PDO::FETCH_ASSOC);
        echo json_encode($inventories);
    }

    public function post() {
        $data = json_decode(file_get_contents("php://input"));
        $query = "INSERT INTO " . $this->table_name . " (producto_id, cantidad, ubicacion, creado_por, modificado_por) VALUES (?, ?, ?, ?, ?)";
        $stmt = $this->conn->prepare($query);
        $stmt->execute([$data->producto_id, $data->cantidad, $data->ubicacion, $data->creado_por, $data->modificado_por]);
        echo json_encode(["message" => "Inventario creado"]);
    }

    public function put() {
        $data = json_decode(file_get_contents("php://input"));
        $query = "UPDATE " . $this->table_name . " SET producto_id = ?, cantidad = ?, ubicacion = ?, modificado_por = ? WHERE id = ?";
        $stmt = $this->conn->prepare($query);
        $stmt->execute([$data->producto_id, $data->cantidad, $data->ubicacion, $data->modificado_por, $data->id]);
        echo json_encode(["message" => "Inventario actualizado"]);
    }

    public function delete() {
        $data = json_decode(file_get_contents("php://input"));
        $query = "DELETE FROM " . $this->table_name . " WHERE id = ?";
        $stmt = $this->conn->prepare($query);
        $stmt->execute([$data->id]);
        echo json_encode(["message" => "Inventario eliminado"]);
    }
}

$database = new Database();
$db = $database->getConnection();
$inventory = new Inventarios($db);

$request_method = $_SERVER["REQUEST_METHOD"];

switch($request_method) {
    case 'GET':
        $inventory->get();
        break;
    case 'POST':
        $inventory->post();
        break;
    case 'PUT':
        $inventory->put();
        break;
    case 'DELETE':
        $inventory->delete();
        break;
    default:
        header("HTTP/1.0 405 Method Not Allowed");
        break;
}
?>
