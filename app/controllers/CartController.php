<?php
class CartController {
    private $cartModel;
    private $db;
    
    public function __construct() {
        $this->cartModel = new CartModel();
        $this->db = (new Database())->getConnection();
    }
    
    public function index() {
        $cartItems = $this->cartModel->getCartItems();
        $total = $this->cartModel->getCartTotal();
        
        require_once 'app/views/shares/header.php';
        require_once 'app/views/cart/cart.php';
        require_once 'app/views/shares/footer.php';
    }
      public function add() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $productId = $_POST['product_id'] ?? null;
            $quantity = $_POST['quantity'] ?? 1;
            
            if ($productId) {
                // Kiểm tra sự tồn tại của sản phẩm
                $stmt = $this->db->prepare("SELECT * FROM product WHERE id = ?");
                $stmt->execute([$productId]);
                $product = $stmt->fetch(PDO::FETCH_ASSOC);                
                if ($product) {
                    $this->cartModel->addToCart($productId, $quantity);
                    $_SESSION['success'] = 'Đã thêm sản phẩm vào giỏ hàng thành công!';
                    // Chuyển hướng đến trang giỏ hàng
                    header('Location: /webbanhang/Cart');
                } else {
                    $_SESSION['error'] = 'Không tìm thấy sản phẩm!';
                    header('Location: /webbanhang/Product');
                }
                exit;
            }
        }
        $_SESSION['error'] = 'Có lỗi xảy ra, vui lòng thử lại!';
        header('Location: /webbanhang/Product');
        exit;
    }
    
    public function update() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $productId = $_POST['product_id'] ?? null;
            $quantity = $_POST['quantity'] ?? 0;
            
            if ($productId !== null && $quantity > 0) {
                // Verify product exists
                $stmt = $this->db->prepare("SELECT * FROM product WHERE id = ?");
                $stmt->execute([$productId]);
                $product = $stmt->fetch(PDO::FETCH_ASSOC);
                
                if ($product) {
                    $this->cartModel->updateCart($productId, $quantity);
                    $_SESSION['success'] = 'Số lượng đã được cập nhật thành công!';
                } else {
                    $_SESSION['error'] = 'Không tìm thấy sản phẩm!';
                }
            } else {
                $_SESSION['error'] = 'Dữ liệu không hợp lệ!';
            }
        }
        
        // Redirect back to cart page
        header('Location: /webbanhang/Cart');
        exit;
    }
    
    public function remove($productId = null) {
        if ($productId) {
            $this->cartModel->removeFromCart($productId);
            $_SESSION['success'] = 'Sản phẩm đã được xóa khỏi giỏ hàng!';
        } else {
            $_SESSION['error'] = 'Không tìm thấy sản phẩm để xóa!';
        }
        header('Location: /webbanhang/Cart');
        exit;
    }

    public function clear() {
        $this->cartModel->emptyCart();
        $_SESSION['success'] = 'Giỏ hàng đã được xóa!';
        header('Location: /webbanhang/Cart');
        exit;
    }    public function checkout() {
        if (!SessionHelper::isLoggedIn()) {
            $_SESSION['error'] = 'Vui lòng đăng nhập để tiếp tục thanh toán!';
            header('Location: /webbanhang/account/login');
            exit;
        }

        $cartItems = $this->cartModel->getCartItems();
        $total = $this->cartModel->getCartTotal();
        
        if (empty($cartItems)) {
            $_SESSION['error'] = 'Giỏ hàng của bạn đang trống!';
            header('Location: /webbanhang/Cart');
            exit;
        }

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            require_once('app/models/OrderModel.php');
            $orderModel = new OrderModel();
            
            try {
                $userId = $_SESSION['user_id'];
                $orderId = $orderModel->createOrder($userId, $total, $cartItems);
                
                if ($orderId) {
                    // Clear the cart after successful order
                    $this->cartModel->emptyCart();
                    
                    $_SESSION['success'] = 'Đặt hàng thành công!';
                    header('Location: /webbanhang/Order/detail/' . $orderId);
                    exit;
                }
            } catch (Exception $e) {
                $_SESSION['error'] = 'Có lỗi xảy ra khi đặt hàng. Vui lòng thử lại!';
                header('Location: /webbanhang/Cart');
                exit;
            }
        }

        require_once 'app/views/shares/header.php';
        require_once 'app/views/cart/checkout.php';
        require_once 'app/views/shares/footer.php';
    }

    public function processCheckout() {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            header('Location: /webbanhang/Cart');
            exit;
        }

        $name = $_POST['name'] ?? '';
        $phone = $_POST['phone'] ?? '';
        $address = $_POST['address'] ?? '';

        if (empty($name) || empty($phone) || empty($address)) {
            $_SESSION['error'] = 'Vui lòng điền đầy đủ thông tin!';
            header('Location: /webbanhang/Cart/checkout');
            exit;
        }

        try {
            $this->db->beginTransaction();

            // Get user_id if user is logged in
            $userId = isset($_SESSION['user_id']) ? $_SESSION['user_id'] : null;

            // Lưu thông tin đơn hàng cơ bản
            $query = "INSERT INTO orders (user_id, name, phone, address, created_at) 
                     VALUES (:user_id, :name, :phone, :address, NOW())";
            
            $stmt = $this->db->prepare($query);
            $stmt->bindParam(':user_id', $userId);
            $stmt->bindParam(':name', $name);
            $stmt->bindParam(':phone', $phone);
            $stmt->bindParam(':address', $address);
            $stmt->execute();
            
            $orderId = $this->db->lastInsertId();

            // Lưu chi tiết đơn hàng
            $cartItems = $this->cartModel->getCartItems();
            foreach ($cartItems as $item) {
                $query = "INSERT INTO order_details (order_id, product_id, quantity, price) 
                         VALUES (:order_id, :product_id, :quantity, :price)";
                
                $stmt = $this->db->prepare($query);
                $stmt->bindParam(':order_id', $orderId);
                $stmt->bindParam(':product_id', $item['id']);
                $stmt->bindParam(':quantity', $item['quantity']);
                $stmt->bindParam(':price', $item['price']);
                $stmt->execute();
            }

            // Xóa giỏ hàng sau khi đặt hàng thành công
            $this->cartModel->emptyCart();

            $this->db->commit();

            $_SESSION['success'] = 'Đơn hàng của bạn đã được đặt thành công!';
            header('Location: /webbanhang/Cart/orderConfirmation/' . $orderId);
            exit;

        } catch (Exception $e) {
            $this->db->rollBack();
            $_SESSION['error'] = 'Có lỗi xảy ra: ' . $e->getMessage();
            header('Location: /webbanhang/Cart/checkout');
            exit;
        }
    }

    public function orderConfirmation($orderId = null) {
        if (!$orderId) {
            header('Location: /webbanhang/Cart');
            exit;
        }

        // Lấy thông tin cơ bản của đơn hàng
        $query = "SELECT o.*, 
                        (SELECT SUM(quantity * price) 
                         FROM order_details 
                         WHERE order_id = o.id) as total_amount
                 FROM orders o 
                 WHERE o.id = ?";
        
        $stmt = $this->db->prepare($query);
        $stmt->execute([$orderId]);
        $order = $stmt->fetch(PDO::FETCH_ASSOC);

        if (!$order) {
            $_SESSION['error'] = 'Không tìm thấy đơn hàng!';
            header('Location: /webbanhang/Cart');
            exit;
        }

        // Lấy chi tiết từng sản phẩm trong đơn hàng
        $query = "SELECT od.*, p.name as product_name, p.image
                 FROM order_details od
                 JOIN product p ON od.product_id = p.id 
                 WHERE od.order_id = ?";
        
        $stmt = $this->db->prepare($query);
        $stmt->execute([$orderId]);
        $orderDetails = $stmt->fetchAll(PDO::FETCH_ASSOC);

        require_once 'app/views/shares/header.php';
        require_once 'app/views/cart/orderConfirmation.php';
        require_once 'app/views/shares/footer.php';
    }
}