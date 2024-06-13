<?php
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST, GET, PUT, DELETE");
header("Access-Control-Allow-Origin: *");

include_once 'db.php';

class Categorias {
    private $conn;
    private $table_name = "Categorías";

    public function __construct($db) {
        $this->conn = $db;
    }

    public function get() {
        $query = "SELECT * FROM " . $this->table_name;
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        $categories = $stmt->fetchAll(PDO::FETCH_ASSOC);
        echo json_encode($categories);
    }

    public function post() {
        $data = json_decode(file_get_contents("php://input"));
        $query = "INSERT INTO " . $this->table_name . " (nombre, descripcion, creado_por, modificado_por) VALUES (?, ?, ?, ?)";
        $stmt = $this->conn->prepare($query);
        $stmt->execute([$data->nombre, $data->descripcion, $data->creado_por, $data->modificado_por]);
        echo json_encode(["message" => "Categoría creada"]);
    }

    public function put() {
        $data = json_decode(file_get_contents("php://input"));
        $query = "UPDATE " . $this->table_name . " SET nombre = ?, descripcion = ?, modificado_por = ? WHERE id = ?";
        $stmt = $this->conn->prepare($query);
        $stmt->execute([$data->nombre, $data->descripcion, $data->modificado_por, $data->id]);
        echo json_encode(["message" => "Categoría actualizada"]);
    }

    public function delete() {
        $data = json_decode(file_get_contents("php://input"));
        $query = "DELETE FROM " . $this->table_name . " WHERE id = ?";
        $stmt = $this->conn->prepare($query);
        $stmt->execute([$data->id]);
        echo json_encode(["message" => "Categoría eliminada"]);
    }
}

$database = new Database();
$db = $database->getConnection();
$categoria = new Categorias($db);

$request_method = $_SERVER["REQUEST_METHOD"];

switch($request_method) {
    case 'GET':
        $categoria->get();
        break;
    case 'POST':
        $categoria->post();
        break;
    case 'PUT':
        $categoria->put();
        break;
    case 'DELETE':
        $categoria->delete();
        break;
    default:
        header("HTTP/1.0 405 Method Not Allowed");
        break;
}
?>
