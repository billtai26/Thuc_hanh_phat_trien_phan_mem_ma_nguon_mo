<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Quản lý sản phẩm</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" rel="stylesheet">    <style>
        body {
            background-color: #f8f9fa;
            opacity: 1;
            transition: opacity 0.3s ease-in-out;
        }
        
        body.page-transition {
            opacity: 0;
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
            transition: all 0.3s ease;
        }
        
        /* Thêm padding-top cho body để tránh content bị che khuất bởi navbar */
        body {
            padding-top: 80px;
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
            </button>            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ml-auto">
                    <li class="nav-item">
                        <a class="nav-link" href="/webbanhang/Product/">
                            <i class="fas fa-box mr-1"></i>Sản phẩm
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="/webbanhang/Category">
                            <i class="fas fa-tags mr-1"></i>Danh mục
                        </a>
                    </li>
                </ul>            </div>
        </div>
    </nav>    <script>
        // Xử lý hiệu ứng scroll cho navbar
        window.addEventListener('scroll', function() {
            const navbar = document.querySelector('.navbar');
            if (window.scrollY > 20) {
                navbar.classList.add('scrolled');
            } else {
                navbar.classList.remove('scrolled');
            }
        });

        // Xử lý hiệu ứng chuyển trang
        document.addEventListener('DOMContentLoaded', function() {
            // Lấy tất cả các liên kết trong nav
            const navLinks = document.querySelectorAll('.nav-link');
            
            navLinks.forEach(link => {
                link.addEventListener('click', function(e) {
                    e.preventDefault(); // Ngăn chặn hành vi mặc định
                    const targetUrl = this.getAttribute('href'); // Lấy URL đích
                    
                    // Thêm class để fade out
                    document.body.classList.add('page-transition');
                    
                    // Đợi animation kết thúc rồi mới chuyển trang
                    setTimeout(() => {
                        window.location.href = targetUrl;
                    }, 300); // Thời gian bằng với transition trong CSS
                });
            });
            
            // Xử lý khi trang mới load
            window.addEventListener('pageshow', function(event) {
                document.body.classList.remove('page-transition');
            });
        });
    </script>

    <div class="container">
        <div class="main-content">