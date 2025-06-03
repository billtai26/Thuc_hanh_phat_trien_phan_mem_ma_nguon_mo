<?php
class OrderModel {
    private $db;

    public function __construct() {
        $this->db = (new Database())->getConnection();
    }

    public function getOrdersByUserId($userId) {
        if ($userId === null) {
            return [];
        }
          $sql = "SELECT o.*, COUNT(od.id) as item_count,
                       SUM(od.quantity * od.price) as total_amount
                FROM orders o 
                LEFT JOIN order_details od ON o.id = od.order_id 
                WHERE o.user_id = ? 
                GROUP BY o.id 
                ORDER BY o.created_at DESC";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([$userId]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getOrderDetails($orderId) {
        $sql = "SELECT od.*, p.name as product_name, p.image 
                FROM order_details od 
                JOIN product p ON od.product_id = p.id 
                WHERE od.order_id = ?";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([$orderId]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }    public function getOrderById($orderId, $userId = null) {
        $sql = "SELECT o.*, 
                       (SELECT SUM(od.quantity * od.price) 
                        FROM order_details od 
                        WHERE od.order_id = o.id) as total_amount
                FROM orders o 
                WHERE o.id = ?";
        $params = [$orderId];
        
        if ($userId !== null) {
            $sql .= " AND o.user_id = ?";
            $params[] = $userId;
        }
        
        $stmt = $this->db->prepare($sql);
        $stmt->execute($params);
        $order = $stmt->fetch(PDO::FETCH_ASSOC);
        
        // Ensure total_amount is 0 if null
        $order['total_amount'] = $order['total_amount'] ?? 0;
        
        return $order;
    }

    public function createOrder($userId, $totalAmount, $items) {
        try {
            $this->db->beginTransaction();
            
            // Create order
            $sql = "INSERT INTO orders (user_id, total_amount) VALUES (?, ?)";
            $stmt = $this->db->prepare($sql);
            $stmt->execute([$userId, $totalAmount]);
            $orderId = $this->db->lastInsertId();

            // Create order details
            $sql = "INSERT INTO order_details (order_id, product_id, quantity, price) VALUES (?, ?, ?, ?)";
            $stmt = $this->db->prepare($sql);
            foreach ($items as $item) {
                $stmt->execute([$orderId, $item['id'], $item['quantity'], $item['price']]);
            }

            $this->db->commit();
            return $orderId;
        } catch (Exception $e) {
            $this->db->rollBack();
            throw $e;
        }
    }
}
