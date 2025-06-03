<?php
require_once('app/models/OrderModel.php');
require_once('app/helpers/SessionHelper.php');

class OrderController {
    private $orderModel;

    public function __construct() {
        $this->orderModel = new OrderModel();
    }

    public function index() {
        if (!SessionHelper::isLoggedIn()) {
            $_SESSION['error'] = "Bạn cần đăng nhập để xem lịch sử đơn hàng.";
            header('Location: /webbanhang/account/login');
            exit();
        }

        $userId = $_SESSION['user_id'];
        $orders = $this->orderModel->getOrdersByUserId($userId);
        include 'app/views/order/history.php';
    }

    public function detail($orderId) {
        if (!SessionHelper::isLoggedIn()) {
            $_SESSION['error'] = "Bạn cần đăng nhập để xem chi tiết đơn hàng.";
            header('Location: /webbanhang/account/login');
            exit();
        }

        $userId = $_SESSION['user_id'];
        $order = $this->orderModel->getOrderById($orderId, $userId);
        
        if (!$order) {
            $_SESSION['error'] = "Không tìm thấy đơn hàng.";
            header('Location: /webbanhang/Order');
            exit();
        }

        $orderDetails = $this->orderModel->getOrderDetails($orderId);
        include 'app/views/order/detail.php';
    }
}
