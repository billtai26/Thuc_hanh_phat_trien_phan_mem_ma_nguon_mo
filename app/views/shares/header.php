<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Quản lý sản phẩm</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #f8f9fa;
        }
        .navbar {
            background-color: #fff !important;
            box-shadow: 0 2px 4px rgba(0,0,0,.1);
            padding: 1rem 2rem;
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
        .nav-link:hover {
            color: #3498db !important;
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
    </style>
</head>

<body>    
  <nav class="navbar navbar-expand-lg navbar-light mb-4">
        <div class="container">
            <a class="navbar-brand" href="/webbanhang/Product/">
                <i class="fas fa-store mr-2"></i>Quản lý sản phẩm
            </a>
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" 
                    aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ml-auto">
                    <li class="nav-item">
                        <a class="nav-link" href="/webbanhang/Product/">
                            <i class="fas fa-list mr-1"></i>Danh sách sản phẩm
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="/webbanhang/Product/add">
                            <i class="fas fa-plus mr-1"></i>Thêm sản phẩm
                        </a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>
    <div class="container">
        <div class="main-content">