<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Quản lý sản phẩm</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" rel="stylesheet">
    <style>
        :root {
            --transition-speed: 0.3s;
        }

        body {
            background-color: #f8f9fa;
        }

        .transition {
            transition: all var(--transition-speed) ease;
        }

        .hover-shadow:hover {
            transform: translateY(-5px);
            box-shadow: 0 .5rem 1rem rgba(0,0,0,.15)!important;
        }

        .card-title {
            font-size: 1.1rem;
            line-height: 1.4;
            margin-right: 0.5rem;
            flex: 1;
        }

        .badge {
            padding: 0.5em 0.8em;
            font-weight: 500;
            white-space: nowrap;
        }

        .bg-info {
            background-color: #ffeaa7 !important;
            color: #2d3436 !important;
        }

        .card-title {
            font-size: 1.1rem;
            line-height: 1.4;
        }

        .btn-sm {
            padding: .375rem .75rem;
        }

        .gap-2 {
            gap: .5rem;
        }

        .flex-grow-1 {
            flex: 1;
        }

        /* Existing navbar styles */
        .cart-count {
            position: absolute;
            top: -8px;
            right: -8px;
            background-color: #dc3545;
            color: white;
            border-radius: 50%;
            padding: 0.25rem 0.6rem;
            font-size: 0.75rem;
            font-weight: bold;
            min-width: 1.5rem;
            text-align: center;
        }

        /* Nút thêm vào giỏ hàng */
        .btn-sm.w-100 {
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
            padding: 0.5rem 1rem;
            font-size: 0.875rem;
            line-height: 1;
        }

        .btn-sm.w-100 i {
            margin-right: 0.3rem;
        }
        
        .cart-icon {
            position: relative;
            font-size: 1.2rem;
        }
        
        .navbar {
            background-color: rgba(255, 255, 255, 0.98) !important;
            box-shadow: 0 2px 4px rgba(0,0,0,.1);
            padding: 1rem 2rem;
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            z-index: 1000;
        }
        
        /* Add padding-top to body to prevent content from being hidden under fixed navbar */
        body {
            padding-top: 76px;
        }
        
        /* Hiệu ứng khi scroll */
        .navbar.scrolled {
            background-color: rgba(255, 255, 255, 0.95) !important;
            box-shadow: 0 4px 20px rgba(0,0,0,.1);
            backdrop-filter: blur(10px);
        }
        
        .navbar-brand {
            font-weight: bold;
            color: #2c3e50 !important;
            font-size: 1.5rem;
        }
        .nav-link {
            color: #34495e !important;
            font-weight: 500;
            margin: 0 10px;
            transition: color 0.3s;
        }
        
        .cart-icon {
            position: relative;
            font-size: 1.5rem;
        }
        
        
        @media (max-width: 991.98px) {
            .cart-link {
                margin-top: 1rem;
            }
        }
        .main-content {
            background-color: #fff;
            border-radius: 8px;
            box-shadow: 0 2px 4px rgba(0,0,0,.1);
            padding: 2rem;
            margin-top: 2rem;
        }
        .btn {
            border-radius: 5px;
            padding: 8px 20px;
            font-weight: 500;
        }
        .form-control {
            border-radius: 5px;
            border: 1px solid #ddd;
        }        .form-control:focus {
            border-color: #3498db;
            box-shadow: 0 0 0 0.2rem rgba(52,152,219,.25);
        }
        .product-card {
            transition: all 0.3s ease;
            position: relative;
            top: 0;
        }
        .product-card:hover {
            top: -5px;
            box-shadow: 0 8px 16px rgba(0,0,0,.1) !important;
            transform: translateY(2px);
        }
        .product-card .card-img-wrapper {
            transition: all 0.3s ease;
        }
        .product-card:hover .card-img-wrapper {
            background-color: #ffffff !important;
        }
        .product-card .btn {
            transition: all 0.3s ease;
        }
        .product-card:hover .btn-outline-primary {
            background-color: #0984e3;
            color: white;
        }
        .product-card:hover .btn-outline-danger {
            background-color: #d63031;
            color: white;
        }        .product-card .card-title a {
            transition: color 0.3s ease;
        }
        .product-card:hover .card-title a {
            color: #007bff !important;
        }
        .btn-primary {
            transition: all 0.3s ease;
            position: relative;
            overflow: hidden;
            z-index: 1;
        }
        .btn-primary:hover {
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(0,123,255,0.4);
        }
        .btn-primary:active {
            transform: translateY(0);
        }
        .btn-primary::before {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: linear-gradient(120deg, transparent, rgba(255,255,255,0.2), transparent);
            transition: all 0.5s ease;
            z-index: -1;
        }
        .btn-primary:hover::before {
            left: 100%;
        }
        .btn-outline-warning, .btn-outline-danger {
            padding: 0.4rem;
            line-height: 1;
            width: 40px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
        }

        .btn-outline-warning:hover, .btn-outline-danger:hover {
            transform: translateY(-1px);
        }

        .btn-outline-danger {
            transition: all 0.3s ease;
        }

        .btn-outline-danger:hover {
            background-color: #dc3545;
            color: white;
            transform: translateY(-2px);
            box-shadow: 0 3px 8px rgba(220, 53, 69, 0.3);
        }

        .btn-outline-danger:active {
            transform: translateY(0);
        }

        .btn-success {
            transition: all 0.3s ease;
        }

        .btn-success:hover {
            transform: translateY(-2px);
            box-shadow: 0 3px 8px rgba(40, 167, 69, 0.3);
        }

        .btn-success:active {
            transform: translateY(0);
        }

        /* Thêm hiệu ứng cho tooltip */
        .tooltip {
            font-size: 0.875rem;
        }

        .tooltip .tooltip-inner {
            background-color: rgba(0, 0, 0, 0.8);
            padding: 6px 12px;
            border-radius: 4px;
        }

        /* ...existing code... */
    </style>
</head>

<body>    
  <nav class="navbar navbar-expand-lg navbar-light bg-light">
    <a class="navbar-brand" href="/webbanhang/Product">Quản lý sản phẩm</a>

    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav"
            aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
    </button>      <div class="collapse navbar-collapse" id="navbarNav">
        <ul class="navbar-nav mr-auto">
            <?php if (SessionHelper::isLoggedIn()): ?>
                <li class="nav-item">
                    <a class="nav-link" href="/webbanhang/Product">
                        <i class="fas fa-box mr-1"></i>Sản phẩm
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="/webbanhang/Category">
                        <i class="fas fa-tags mr-1"></i>Danh mục
                    </a>
                </li>
            <?php endif; ?>
        </ul>
        <ul class="navbar-nav ml-auto">
            <li class="nav-item">
                <?php
                if (SessionHelper::isLoggedIn()) {
                    echo "<a class='nav-link'><i class='fas fa-user mr-1'></i>" . htmlspecialchars($_SESSION['username']) . " (" . SessionHelper::getRole() . ")</a>";
                } else {
                    echo "<a class='nav-link' href='/webbanhang/account/login'><i class='fas fa-sign-in-alt mr-1'></i>Đăng nhập</a>";
                }
                ?>
            </li>
            <li class="nav-item">
                <?php
                if (SessionHelper::isLoggedIn()) {
                    echo "<a class='nav-link' href='/webbanhang/account/logout'>Đăng xuất</a>";
                }
                ?>
            </li>
            <!-- Thêm nút giỏ hàng -->
            <li class="nav-item">
                <a href="/webbanhang/Cart" class="nav-link cart-icon">
                    <i class="fas fa-shopping-cart"></i>
                    <?php if (isset($_SESSION['cart']) && count($_SESSION['cart']) > 0): ?>
                        <span class="cart-count"><?php echo count($_SESSION['cart']); ?></span>
                    <?php endif; ?>
                </a>
            </li>
        </ul>
    </div>
</nav>
<div class="container mt-4">
    <!-- Thêm padding-top để tránh nội dung bị che bởi navbar -->
    <div style="padding-top: 70px;">
        <?php if (isset($_SESSION['error'])): ?>
            <div class="alert alert-danger">
                <?php 
                    echo $_SESSION['error'];
                    unset($_SESSION['error']);
                ?>
            </div>
        <?php endif; ?>

        <?php if (isset($_SESSION['success'])): ?>
            <div class="alert alert-success">
                <?php 
                    echo $_SESSION['success'];
                    unset($_SESSION['success']);
                ?>
            </div>
        <?php endif; ?>