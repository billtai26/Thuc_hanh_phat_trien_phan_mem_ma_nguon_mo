<?php
require_once('app/config/database.php');
require_once('app/models/CategoryModel.php');
require_once('app/helpers/SessionHelper.php');

class CategoryController
{
  private $categoryModel;
  private $db;

  public function __construct()
  {
    $this->db = (new Database())->getConnection();
    $this->categoryModel = new CategoryModel($this->db);
  }

  public function index()
  {
    if (!SessionHelper::isLoggedIn()) {
      $_SESSION['error'] = "Bạn cần đăng nhập để xem danh mục.";
      header('Location: /webbanhang/account/login');
      exit();
    }
    $categories = $this->categoryModel->getCategories();
    include 'app/views/category/list.php';
  }

  public function add()
  {
    if (!SessionHelper::isAdmin()) {
      $_SESSION['error'] = "Bạn không có quyền thêm danh mục.";
      header('Location: /webbanhang/Category');
      exit();
    }
    include 'app/views/category/add.php';
  }

  public function save()
  {
    if (!SessionHelper::isAdmin()) {
      $_SESSION['error'] = "Bạn không có quyền thêm danh mục.";
      header('Location: /webbanhang/Category');
      exit();
    }

    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
      $name = $_POST['name'] ?? '';
      $description = $_POST['description'] ?? '';

      $result = $this->categoryModel->addCategory($name, $description);

      if (is_array($result)) {
        $errors = $result;
        include 'app/views/category/add.php';
      } else {
        $_SESSION['success'] = "Thêm danh mục thành công!";
        header('Location: /webbanhang/Category');
        exit();
      }
    }
  }

  public function edit($id)
  {
    if (!SessionHelper::isAdmin()) {
      $_SESSION['error'] = "Bạn không có quyền sửa danh mục.";
      header('Location: /webbanhang/Category');
      exit();
    }

    $category = $this->categoryModel->getCategoryById($id);
    if ($category) {
      include 'app/views/category/edit.php';
    } else {
      $_SESSION['error'] = "Không tìm thấy danh mục.";
      header('Location: /webbanhang/Category');
      exit();
    }
  }

  public function update()
  {
    if (!SessionHelper::isAdmin()) {
      $_SESSION['error'] = "Bạn không có quyền sửa danh mục.";
      header('Location: /webbanhang/Category');
      exit();
    }

    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
      $id = $_POST['id'];
      $name = $_POST['name'];
      $description = $_POST['description'];

      $result = $this->categoryModel->updateCategory($id, $name, $description);

      if (is_array($result)) {
        $errors = $result;
        $category = (object) ['id' => $id, 'name' => $name, 'description' => $description];
        include 'app/views/category/edit.php';
      } else {
        $_SESSION['success'] = "Cập nhật danh mục thành công!";
        header('Location: /webbanhang/Category');
        exit();
      }
    }
  }

  public function delete($id)
  {
    if (!SessionHelper::isAdmin()) {
      $_SESSION['error'] = "Bạn không có quyền xóa danh mục.";
      header('Location: /webbanhang/Category');
      exit();
    }

    if ($this->categoryModel->deleteCategory($id)) {
      $_SESSION['success'] = "Xóa danh mục thành công!";
    } else {
      $_SESSION['error'] = "Không thể xóa danh mục này vì có sản phẩm đang sử dụng!";
    }
    header('Location: /webbanhang/Category');
    exit();
  }
}
?>