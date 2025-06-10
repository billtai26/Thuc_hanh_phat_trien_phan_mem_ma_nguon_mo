<?php
require_once('app/config/database.php');
require_once('app/models/ProductModel.php');
require_once('app/models/CategoryModel.php');

class ProductApiController
{
  private $productModel;
  private $db;
  
  public function __construct()
  {
    $this->db = (new Database())->getConnection();
    $this->productModel = new ProductModel($this->db);
  }
  // Lấy danh sách sản phẩm
  public function index()
  {
    header('Content-Type: application/json');
    $products = $this->productModel->getProducts();
    echo json_encode($products);
  }

  // Lấy thông tin sản phẩm theo ID
  public function show($id)
  {
    header('Content-Type: application/json');
    $product = $this->productModel->getProductById($id);
    if ($product) {
      echo json_encode($product);
    } else {
      http_response_code(404);
      echo json_encode(['message' => 'Product not found']);
    }
  }

  // Thêm sản phẩm mới
  public function store()
  {
    header('Content-Type: application/json');
    
    // Xử lý dữ liệu từ form-data hoặc JSON
    if ($_SERVER['REQUEST_METHOD'] === 'POST' && !empty($_FILES)) {
      // Xử lý dữ liệu từ form-data
      $name = $_POST['name'] ?? '';
      $description = $_POST['description'] ?? '';
      $price = $_POST['price'] ?? '';
      $category_id = $_POST['category_id'] ?? null;
      
      // Xử lý upload hình ảnh
      $image = null;
      if (isset($_FILES['image']) && $_FILES['image']['error'] == 0) {
        try {
          $image = $this->uploadImage($_FILES['image']);
        } catch (Exception $e) {
          http_response_code(400);
          echo json_encode(['error' => $e->getMessage()]);
          return;
        }
      }
    } else {
      // Xử lý dữ liệu từ JSON
      $data = json_decode(file_get_contents("php://input"), true);
      if (!$data) {
        http_response_code(400);
        echo json_encode(['error' => 'Invalid request data']);
        return;
      }

      $name = $data['name'] ?? '';
      $description = $data['description'] ?? '';
      $price = $data['price'] ?? '';
      $category_id = $data['category_id'] ?? null;
      $image = $data['image'] ?? null; // Base64 image data
    }

    $result = $this->productModel->addProduct(
      $name,
      $description,
      $price,
      $category_id,
      $image
    );

    if (is_array($result)) {
      http_response_code(400);
      echo json_encode(['errors' => $result]);
    } else {
      http_response_code(201);
      echo json_encode(['message' => 'Product created successfully']);
    }
  }

  // Cập nhật sản phẩm theo ID
  // Cập nhật sản phẩm theo ID
  public function update($id)
  {
      header('Content-Type: application/json');

      try {
          // Kiểm tra sản phẩm có tồn tại không
          $currentProduct = $this->productModel->getProductById($id);
          if (!$currentProduct) {
              http_response_code(404);
              echo json_encode(['error' => 'Product not found']);
              return;
          }

          $contentType = $_SERVER['CONTENT_TYPE'] ?? '';

          if (strpos($contentType, 'multipart/form-data') !== false) {
              // Xử lý form-data cho PUT request
              if ($_SERVER['REQUEST_METHOD'] === 'PUT') {
                  // Parse PUT form-data manually
                  $parsedData = $this->parsePutFormData();
                  
                  $name = !empty($parsedData['fields']['name']) ? $parsedData['fields']['name'] : $currentProduct->name;
                  $description = !empty($parsedData['fields']['description']) ? $parsedData['fields']['description'] : $currentProduct->description;
                  $price = !empty($parsedData['fields']['price']) ? $parsedData['fields']['price'] : $currentProduct->price;
                  $category_id = !empty($parsedData['fields']['category_id']) ? $parsedData['fields']['category_id'] : $currentProduct->category_id;

                  $imagePath = $currentProduct->image ?? null;

                  // Xử lý upload hình ảnh mới từ PUT
                  if (!empty($parsedData['files']['image'])) {
                      // Xóa hình cũ nếu có
                      if ($imagePath && file_exists($imagePath)) {
                          unlink($imagePath);
                      }
                      $imagePath = $this->uploadImageFromPutData($parsedData['files']['image']);
                  }
              } else {
                  // POST request - xử lý bình thường
                  $name = !empty($_POST['name']) ? $_POST['name'] : $currentProduct->name;
                  $description = !empty($_POST['description']) ? $_POST['description'] : $currentProduct->description;
                  $price = !empty($_POST['price']) ? $_POST['price'] : $currentProduct->price;
                  $category_id = !empty($_POST['category_id']) ? $_POST['category_id'] : $currentProduct->category_id;

                  $imagePath = $currentProduct->image ?? null;

                  // Xử lý upload hình ảnh mới
                  if (isset($_FILES['image']) && $_FILES['image']['error'] === UPLOAD_ERR_OK) {
                      // Xóa hình cũ nếu có
                      if ($imagePath && file_exists($imagePath)) {
                          unlink($imagePath);
                      }
                      $imagePath = $this->uploadImage($_FILES['image']);
                  }
              }
          } else {
              // Xử lý JSON data
              $input = file_get_contents("php://input");
              $data = json_decode($input, true);

              if (json_last_error() !== JSON_ERROR_NONE) {
                  http_response_code(400);
                  echo json_encode(['error' => 'Invalid JSON format']);
                  return;
              }

              $name = $data['name'] ?? null;
              $description = $data['description'] ?? null;
              $price = $data['price'] ?? null;
              $category_id = $data['category_id'] ?? null;
              $imagePath = $currentProduct->image ?? null;
          }

          // Chỉ validate các field được gửi lên (không null)
          $validationResult = $this->validateAndCleanData(
              $name ?? $currentProduct->name,
              $description ?? $currentProduct->description,
              $price ?? $currentProduct->price,
              $category_id ?? $currentProduct->category_id
          );

          if (!$validationResult['valid']) {
              http_response_code(400);
              echo json_encode(['errors' => $validationResult['errors']]);
              return;
          }

          $cleanData = $validationResult['data'];

          $result = $this->productModel->updateProduct(
              $id,
              $cleanData['name'],
              $cleanData['description'],
              $cleanData['price'],
              $cleanData['category_id'],
              $imagePath
          );

          if ($result) {
              $response = [
                  'message' => 'Product updated successfully',
                  'updated_data' => [
                      'id' => $id,
                      'name' => $cleanData['name'],
                      'description' => $cleanData['description'],
                      'price' => $cleanData['price'],
                      'category_id' => $cleanData['category_id']
                  ]
              ];

              if ($imagePath) {
                  $response['image_url'] = 'http://' . $_SERVER['HTTP_HOST'] . '/webbanhang/' . $imagePath;
              }

              echo json_encode($response);
          } else {
              http_response_code(400);
              echo json_encode(['message' => 'Product update failed']);
          }
      } catch (Exception $e) {
          http_response_code(500);
          echo json_encode(['error' => $e->getMessage()]);
      }
  }

  // Thêm method để parse PUT form-data
  private function parsePutFormData()
  {
      $input = file_get_contents("php://input");
      $boundary = substr($input, 0, strpos($input, "\r\n"));
      
      if (empty($boundary)) {
          return ['fields' => [], 'files' => []];
      }
      
      $parts = array_slice(explode($boundary, $input), 1);
      $data = ['fields' => [], 'files' => []];
      
      foreach ($parts as $part) {
          if ($part == "--\r\n" || empty(trim($part))) continue;
          
          $part = ltrim($part, "\r\n");
          if (empty($part)) continue;
          
          $headerEndPos = strpos($part, "\r\n\r\n");
          if ($headerEndPos === false) continue;
          
          $rawHeaders = substr($part, 0, $headerEndPos);
          $body = substr($part, $headerEndPos + 4);
          $body = rtrim($body, "\r\n");
          
          // Parse headers
          $name = '';
          $filename = '';
          $contentType = '';
          
          foreach (explode("\r\n", $rawHeaders) as $header) {
              if (stripos($header, "Content-Disposition") !== false) {
                  if (preg_match('/name="([^"]*)"/', $header, $matches)) {
                      $name = $matches[1];
                  }
                  if (preg_match('/filename="([^"]*)"/', $header, $matches)) {
                      $filename = $matches[1];
                  }
              }
              if (stripos($header, "Content-Type") !== false) {
                  $contentType = trim(substr($header, strpos($header, ':') + 1));
              }
          }
          
          if (!empty($filename)) {
              // File data
              $data['files'][$name] = [
                  'name' => $filename,
                  'data' => $body,
                  'type' => $contentType,
                  'size' => strlen($body)
              ];
          } else {
              // Field data
              $data['fields'][$name] = $body;
          }
      }
      
      return $data;
  }

  // Thêm method để upload image từ PUT data
  private function uploadImageFromPutData($fileData)
  {
      $uploadDir = 'uploads/';

      // Tạo thư mục nếu chưa tồn tại
      if (!is_dir($uploadDir)) {
          mkdir($uploadDir, 0755, true);
      }

      // Kiểm tra loại file
      $allowedTypes = ['image/jpeg', 'image/png', 'image/gif', 'image/webp'];
      
      if (!in_array($fileData['type'], $allowedTypes)) {
          throw new Exception('Chỉ chấp nhận file JPG, PNG, GIF, WEBP');
      }

      // Kiểm tra kích thước (2MB)
      if ($fileData['size'] > 2 * 1024 * 1024) {
          throw new Exception('File quá lớn. Tối đa 2MB');
      }

      // Tạo tên file unique
      $extension = pathinfo($fileData['name'], PATHINFO_EXTENSION);
      $filename = uniqid() . '_' . time() . '.' . strtolower($extension);
      $filePath = $uploadDir . $filename;

      // Ghi file
      if (file_put_contents($filePath, $fileData['data']) !== false) {
          return $filePath;
      }

      throw new Exception('Upload file thất bại');
  }

  // Validate và clean dữ liệu
  private function validateAndCleanData($name, $description, $price, $category_id)
  {
      $errors = [];
      $cleanData = [];

      // Validate name
      if (empty(trim($name))) {
          $errors[] = 'Product name is required';
      } else {
          $cleanData['name'] = trim(htmlspecialchars($name));
      }

      // Validate description
      if (empty(trim($description))) {
          $errors[] = 'Product description is required';
      } else {
          $cleanData['description'] = trim(htmlspecialchars($description));
      }

      // Validate price
      if (empty($price) || !is_numeric($price)) {
          $errors[] = 'Product price must be a valid number';
      } else {
          $priceValue = (float)$price;
          if ($priceValue <= 0) {
              $errors[] = 'Product price must be greater than 0';
          } else {
              $cleanData['price'] = $priceValue;
          }
      }

      // Validate category_id
      if (empty($category_id) || !is_numeric($category_id)) {
          $errors[] = 'Valid category ID is required';
      } else {
          $categoryValue = (int)$category_id;
          if ($categoryValue <= 0) {
              $errors[] = 'Category ID must be greater than 0';
          } else {
              $cleanData['category_id'] = $categoryValue;
          }
      }

      return [
          'valid' => empty($errors),
          'errors' => $errors,
          'data' => $cleanData
      ];
  }



  // Xóa sản phẩm theo ID
  public function destroy($id)
  {
    header('Content-Type: application/json');
    $result = $this->productModel->deleteProduct($id);
    if ($result) {
      echo json_encode(['message' => 'Product deleted successfully']);
    } else {
      http_response_code(400);
      echo json_encode(['message' => 'Product deletion failed']);
    }
  }

  
}
?>