<?php
class CategoryModel
{
  private $conn;
  private $table_name = "category";

  public function __construct($db)
  {
    $this->conn = $db;
  }
  public function getCategories()
  {    $query = "SELECT c.id, c.name, c.description, COUNT(p.id) as product_count 
              FROM " . $this->table_name . " c
              LEFT JOIN product p ON c.id = p.category_id
              GROUP BY c.id, c.name, c.description
              ORDER BY c.id ASC";
    $stmt = $this->conn->prepare($query);
    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_OBJ);
  }

  public function getCategoryById($id)
  {
    $query = "SELECT * FROM " . $this->table_name . " WHERE id = :id";
    $stmt = $this->conn->prepare($query);
    $stmt->bindParam(':id', $id);
    $stmt->execute();
    return $stmt->fetch(PDO::FETCH_OBJ);
  }
  public function addCategory($name, $description)
  {
    $errors = [];
    
    if (empty($name)) {
      $errors['name'] = 'Tên danh mục không được để trống';
    } elseif (strlen($name) > 100) {
      $errors['name'] = 'Tên danh mục không được vượt quá 100 ký tự';
    }

    // Kiểm tra xem tên danh mục đã tồn tại chưa
    $query = "SELECT COUNT(*) FROM " . $this->table_name . " WHERE name = :name";
    $stmt = $this->conn->prepare($query);
    $stmt->bindParam(':name', $name);
    $stmt->execute();
    if ($stmt->fetchColumn() > 0) {
      $errors['name'] = 'Tên danh mục đã tồn tại';
    }

    if (strlen($description) > 500) {
      $errors['description'] = 'Mô tả không được vượt quá 500 ký tự';
    }

    if (count($errors) > 0) {
      return $errors;
    }

    $query = "INSERT INTO " . $this->table_name . " (name, description) VALUES (:name, :description)";
    $stmt = $this->conn->prepare($query);
    
    $name = htmlspecialchars(strip_tags($name));
    $description = htmlspecialchars(strip_tags($description));
    
    $stmt->bindParam(':name', $name);
    $stmt->bindParam(':description', $description);

    if ($stmt->execute()) {
      return true;
    }
    return false;
  }
  public function updateCategory($id, $name, $description)
  {
    $errors = [];
    
    if (empty($name)) {
      $errors['name'] = 'Tên danh mục không được để trống';
    } elseif (strlen($name) > 100) {
      $errors['name'] = 'Tên danh mục không được vượt quá 100 ký tự';
    }

    // Kiểm tra xem tên danh mục đã tồn tại chưa (trừ danh mục hiện tại)
    $query = "SELECT COUNT(*) FROM " . $this->table_name . " WHERE name = :name AND id != :id";
    $stmt = $this->conn->prepare($query);
    $stmt->bindParam(':name', $name);
    $stmt->bindParam(':id', $id);
    $stmt->execute();
    if ($stmt->fetchColumn() > 0) {
      $errors['name'] = 'Tên danh mục đã tồn tại';
    }

    if (strlen($description) > 500) {
      $errors['description'] = 'Mô tả không được vượt quá 500 ký tự';
    }

    if (count($errors) > 0) {
      return $errors;
    }

    $query = "UPDATE " . $this->table_name . " SET name = :name, description = :description WHERE id = :id";
    $stmt = $this->conn->prepare($query);
    
    $name = htmlspecialchars(strip_tags($name));
    $description = htmlspecialchars(strip_tags($description));
    
    $stmt->bindParam(':id', $id);
    $stmt->bindParam(':name', $name);
    $stmt->bindParam(':description', $description);

    if ($stmt->execute()) {
      return true;
    }
    return false;
  }

  public function deleteCategory($id)
  {
    // Kiểm tra xem có sản phẩm nào thuộc danh mục này không
    $query = "SELECT COUNT(*) FROM product WHERE category_id = :id";
    $stmt = $this->conn->prepare($query);
    $stmt->bindParam(':id', $id);
    $stmt->execute();
    $count = $stmt->fetchColumn();

    if ($count > 0) {
      return false; // Không thể xóa vì có sản phẩm liên quan
    }

    $query = "DELETE FROM " . $this->table_name . " WHERE id = :id";
    $stmt = $this->conn->prepare($query);
    $stmt->bindParam(':id', $id);
    
    if ($stmt->execute()) {
      return true;
    }
    return false;
  }
}
?>