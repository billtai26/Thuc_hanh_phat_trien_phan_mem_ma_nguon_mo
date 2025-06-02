<?php
class CartModel {
    private $db;

    public function __construct() {
        $this->db = (new Database())->getConnection();
    }

    public function addToCart($productId, $quantity = 1) {
        if(!isset($_SESSION['cart'])) {
            $_SESSION['cart'] = array();
        }
        
        if(isset($_SESSION['cart'][$productId])) {
            $_SESSION['cart'][$productId] += $quantity;
        } else {
            $_SESSION['cart'][$productId] = $quantity;
        }
    }

    public function updateCart($productId, $quantity) {
        if(isset($_SESSION['cart'][$productId])) {
            if($quantity <= 0) {
                unset($_SESSION['cart'][$productId]);
            } else {
                $_SESSION['cart'][$productId] = $quantity;
            }
        }
    }

    public function removeFromCart($productId) {
        if(isset($_SESSION['cart'][$productId])) {
            unset($_SESSION['cart'][$productId]);
        }
    }

    public function getCartItems() {
        if(!isset($_SESSION['cart'])) {
            return array();
        }

        $items = array();
        foreach($_SESSION['cart'] as $productId => $quantity) {
            $sql = "SELECT p.*, c.name as category_name 
                    FROM product p 
                    LEFT JOIN category c ON p.category_id = c.id 
                    WHERE p.id = ?";
            $stmt = $this->db->prepare($sql);
            $stmt->execute([$productId]);
            $product = $stmt->fetch(PDO::FETCH_ASSOC);
            
            if($product) {
                $product['quantity'] = $quantity;
                $product['total'] = $quantity * $product['price'];
                $items[] = $product;
            }
        }
        return $items;
    }

    public function getCartTotal() {
        $total = 0;
        $items = $this->getCartItems();
        foreach($items as $item) {
            $total += $item['total'];
        }
        return $total;
    }

    public function emptyCart() {
        unset($_SESSION['cart']);
    }
}