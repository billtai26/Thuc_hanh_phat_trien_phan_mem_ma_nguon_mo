<?php include 'app/views/shares/header.php'; ?>
<h1>Danh sách sản phẩm</h1>
<a href="/webbanhang/Product/add" class="btn btn-success mb-2">Thêm sản phẩm mới</a>
<div class="row" id="product-list">
    <!-- Danh sách sản phẩm sẽ được tải từ API và hiển thị tại đây -->
</div>
<?php include 'app/views/shares/footer.php'; ?>
<script>
    document.addEventListener("DOMContentLoaded", function() {
        fetch('/webbanhang/api/product')
            .then(response => response.json())
            .then(data => {
                const productList = document.getElementById('product-list');
                data.forEach(product => {
                    const productItem = document.createElement('div');
                    productItem.className = 'col-md-4 mb-4';
                    productItem.innerHTML = `
                        <div class="card h-100">
                            <div class="product-image-container" style="height: 200px; display: flex; align-items: center; justify-content: center; background-color: #f8f9fa;">
                                ${product.image ? 
                                    `<img src="/webbanhang/${product.image}" class="img-fluid" alt="${product.name}" style="max-height: 100%; object-fit: contain;">` :
                                    `<i class="fas fa-image text-muted" style="font-size: 4rem;"></i>`
                                }
                            </div>
                            <div class="card-body">
                                <h5 class="card-title">
                                    <a href="/webbanhang/Product/show/${product.id}" class="text-dark">${product.name}</a>
                                </h5>
                                <p class="card-text text-muted">${product.description}</p>
                                <p class="card-text">
                                    <span class="text-primary font-weight-bold" style="font-size: 1.2rem;">
                                        ${new Intl.NumberFormat('vi-VN', { style: 'currency', currency: 'VND' }).format(product.price)}
                                    </span>
                                </p>
                                <p class="card-text">
                                    <span class="badge badge-info">${product.category_name}</span>
                                </p>
                                <div class="btn-group">
                                    <a href="/webbanhang/Product/edit/${product.id}" class="btn btn-warning btn-sm">Sửa</a>
                                    <button class="btn btn-danger btn-sm" onclick="deleteProduct(${product.id})">Xóa</button>
                                </div>
                            </div>
                        </div>
                    `;
                    productList.appendChild(productItem);
                });
            });
    });

    function deleteProduct(id) {
        if (confirm('Bạn có chắc chắn muốn xóa sản phẩm này?')) {
            fetch(`/webbanhang/api/product/${id}`, {
                method: 'DELETE'
            })
            .then(response => response.json())
            .then(data => {
                if (data.message === 'Product deleted successfully') {
                    location.reload();
                } else {
                    alert('Xóa sản phẩm thất bại');
                }
            });
        }
    }
</script>