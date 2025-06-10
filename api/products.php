<?php
header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: GET, POST, PUT, DELETE');
header('Access-Control-Allow-Headers: Content-Type');

require_once '../config/Database.php';
require_once '../app/models/ProductModel.php';

$database = new Database();
$db = $database->getConnection();
$productModel = new ProductModel($db);

$method = $_SERVER['REQUEST_METHOD'];

switch ($method) {
    case 'GET':
        if (isset($_GET['id'])) {
            $result = $productModel->getProductById($_GET['id']);
            echo json_encode($result);
        } else {
            $result = $productModel->getProducts();
            echo json_encode($result);
        }
        break;

    case 'POST':
        $data = json_decode(file_get_contents("php://input"), true);
        if (!$data) {
            $data = $_POST;
        }
        
        $result = $productModel->addProduct(
            $data['name'],
            $data['description'],
            $data['price'],
            $data['category_id']
        );
        
        if ($result === true) {
            echo json_encode(['success' => true, 'message' => 'Product added successfully']);
        } else {
            echo json_encode(['success' => false, 'message' => $result]);
        }
        break;

    case 'PUT':
        $data = json_decode(file_get_contents("php://input"), true);
        if (!$data) {
            parse_str(file_get_contents("php://input"), $data);
        }
        
        $result = $productModel->updateProduct(
            $data['id'],
            $data['name'],
            $data['description'],
            $data['price'],
            $data['category_id']
        );
        
        if ($result === true) {
            echo json_encode(['success' => true, 'message' => 'Product updated successfully']);
        } else {
            echo json_encode(['success' => false, 'message' => 'Failed to update product']);
        }
        break;

    case 'DELETE':
        $data = json_decode(file_get_contents("php://input"), true);
        if (!$data) {
            parse_str(file_get_contents("php://input"), $data);
        }
        
        $result = $productModel->deleteProduct($data['id']);
        
        if ($result === true) {
            echo json_encode(['success' => true, 'message' => 'Product deleted successfully']);
        } else {
            echo json_encode(['success' => false, 'message' => 'Failed to delete product']);
        }
        break;

    default:
        http_response_code(405);
        echo json_encode(['success' => false, 'message' => 'Method not allowed']);
        break;
} 