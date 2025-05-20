<?php include 'app/views/shares/header.php'; ?>

<?php if (isset($_SESSION['success'])): ?>
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        <?php 
        echo $_SESSION['success'];
        unset($_SESSION['success']);
        ?>
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
    </div>
<?php endif; ?>

<?php if (isset($_SESSION['error'])): ?>
    <div class="alert alert-danger alert-dismissible fade show" role="alert">
        <?php 
        echo $_SESSION['error'];
        unset($_SESSION['error']);
        ?>
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
    </div>
<?php endif; ?>

<div class="d-flex justify-content-between align-items-center mb-4">
    <h1 class="text-primary">
        <i class="fas fa-box-open mr-2"></i>Danh sách sản phẩm
    </h1>
    <a href="/webbanhang/Product/add" class="btn btn-primary">
        <i class="fas fa-plus mr-2"></i>Thêm sản phẩm mới
    </a>
</div>

<div class="card mb-4">    
    <div class="card-body">
        <form id="filterForm" action="/webbanhang/Product/index" method="GET">
            <div class="row g-3 align-items-end">
                <div class="col-md-4">
                    <div class="search-box">
                        <label for="search" class="form-label">
                            <i class="text-primary me-2"></i>Tìm kiếm sản phẩm
                        </label>
                        <input type="text" id="search" class="form-control" 
                               placeholder="Nhập tên sản phẩm..." 
                               style="padding-left: 2.5rem;">
                    </div>
                </div>
                
                <div class="col-md-4">
                    <div class="price-filter">
                        <label for="price_range" class="form-label">
                            <i class="sign text-primary me-2"></i>Lọc theo giá
                        </label>
                        <select name="price_range" id="price_range" class="form-select custom-select" 
                                onchange="document.getElementById('filterForm').submit()">
                            <option value="">Tất cả mức giá</option>
                            <option value="0-1000000" <?php echo (isset($_GET['price_range']) && $_GET['price_range'] == '0-1000000') ? 'selected' : ''; ?>>
                                <i class="fas fa-tags"></i> Dưới 1 triệu
                            </option>
                            <option value="1000000-5000000" <?php echo (isset($_GET['price_range']) && $_GET['price_range'] == '1000000-5000000') ? 'selected' : ''; ?>>
                                1 triệu - 5 triệu
                            </option>
                            <option value="5000000-10000000" <?php echo (isset($_GET['price_range']) && $_GET['price_range'] == '5000000-10000000') ? 'selected' : ''; ?>>
                                5 triệu - 10 triệu
                            </option>
                            <option value="10000000-999999999" <?php echo (isset($_GET['price_range']) && $_GET['price_range'] == '10000000-999999999') ? 'selected' : ''; ?>>
                                Trên 10 triệu
                            </option>
                        </select>
                    </div>
                </div>

                <div class="col-md-4">
                    <button type="button" 
                            class="btn btn-outline-secondary" 
                            onclick="window.location.href='/webbanhang/Product'"
                            title="Xóa bộ lọc">
                        <i class="fas fa-sync-alt me-2"></i>Đặt lại bộ lọc
                    </button>
                </div>
            </div>
        </form>
    </div>
</div>

<div class="row" id="productList">
    <?php foreach ($products as $product): ?>    
    <div class="col-md-6 col-lg-4 mb-4">
        <div class="card h-100 shadow-sm product-card">
            <a href="/webbanhang/Product/show/<?php echo $product->id; ?>" class="card-img-wrapper" style="height: 200px; overflow: hidden; display: flex; align-items: center; justify-content: center; background-color: #ffffff; text-decoration: none;">
                <?php if ($product->image): ?>
                    <img src="/webbanhang/<?php echo $product->image; ?>" 
                         class="card-img-top" 
                         alt="<?php echo htmlspecialchars($product->name, ENT_QUOTES, 'UTF-8'); ?>" 
                         style="width: 100%; height: 100%; object-fit: contain; padding: 10px;">
                <?php else: ?>
                    <i class="fas fa-image text-muted" style="font-size: 3rem;"></i>
                <?php endif; ?>
            </a>
            
            <div class="card-body">
                <h5 class="card-title">
                    <a href="/webbanhang/Product/show/<?php echo $product->id; ?>" class="text-decoration-none text-dark">
                        <?php echo htmlspecialchars($product->name, ENT_QUOTES, 'UTF-8'); ?>
                    </a>
                </h5>                
                <p class="card-text text-muted mb-2" style="height: 42px; overflow: hidden;">
                    <?php echo htmlspecialchars($product->description, ENT_QUOTES, 'UTF-8'); ?>
                </p>
                <p class="card-text text-primary font-weight-bold mb-2">
                    <?php echo number_format($product->price, 0, ',', '.'); ?> VND
                </p>
                <p class="card-text">
                    <small class="text-muted">
                        <i class="fas fa-tag mr-1"></i>
                        <?php echo htmlspecialchars($product->category_name, ENT_QUOTES, 'UTF-8'); ?>
                    </small>
                </p>
            </div>
            <div class="card-footer bg-white border-top-0">
                <div class="d-flex justify-content-between">
                    <a href="/webbanhang/Product/edit/<?php echo $product->id; ?>" class="btn btn-outline-primary btn-sm">
                        <i class="fas fa-edit mr-1"></i>Sửa
                    </a>
                    <button type="button" class="btn btn-outline-danger btn-sm" 
                            onclick="confirmDelete(<?php echo $product->id; ?>, '<?php echo htmlspecialchars($product->name, ENT_QUOTES, 'UTF-8'); ?>')">
                        <i class="fas fa-trash-alt mr-1"></i>Xóa
                    </button>
                </div>
            </div>
        </div>
    </div>
    <?php endforeach; ?>
</div>

<!-- Modal Xác nhận xóa -->
<div class="modal fade" id="deleteModal" tabindex="-1" role="dialog" aria-labelledby="deleteModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="deleteModalLabel">Xác nhận xóa</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                Bạn có chắc chắn muốn xóa sản phẩm <strong id="productName"></strong>?
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Hủy</button>
                <a href="#" id="confirmDeleteButton" class="btn btn-danger">Xóa sản phẩm</a>
            </div>
        </div>
    </div>
</div>

<script>
function confirmDelete(id, name) {
    document.getElementById('productName').textContent = name;
    document.getElementById('confirmDeleteButton').href = '/webbanhang/Product/delete/' + id;
    $('#deleteModal').modal('show');
}

// Tự động ẩn thông báo sau 5 giây
setTimeout(function() {
    $('.alert').alert('close');
}, 5000);

// Live Search
let searchTimeout;
document.getElementById('search').addEventListener('input', function(e) {
    clearTimeout(searchTimeout);
    const keyword = e.target.value;
    
    // Chờ 500ms sau khi người dùng ngừng gõ
    searchTimeout = setTimeout(() => {
        if (keyword.length > 0) {
            fetch(`/webbanhang/Product/search?keyword=${encodeURIComponent(keyword)}`)
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        updateProductList(data.products);
                    }
                })
                .catch(error => console.error('Error:', error));
        } else {
            // Nếu ô tìm kiếm trống, load lại tất cả sản phẩm
            window.location.reload();
        }
    }, 500);
});

function updateProductList(products) {
    const productList = document.getElementById('productList');
    
    // Xóa danh sách sản phẩm hiện tại
    productList.innerHTML = '';
    
    if (products.length === 0) {
        productList.innerHTML = `
            <div class="col-12">
                <div class="alert alert-info text-center">
                    <i class="fas fa-info-circle mr-2"></i>
                    Không tìm thấy sản phẩm nào phù hợp.
                </div>
            </div>
        `;
        return;
    }
    
    // Thêm sản phẩm mới
    products.forEach(product => {
        const card = `
            <div class="col-md-6 col-lg-4 mb-4">
                <div class="card h-100 shadow-sm product-card">
                    <a href="/webbanhang/Product/show/${product.id}" class="card-img-wrapper" style="height: 200px; overflow: hidden; display: flex; align-items: center; justify-content: center; background-color: #ffffff; text-decoration: none;">
                        ${product.image 
                            ? `<img src="/webbanhang/${product.image}" class="card-img-top" alt="${product.name}" style="width: 100%; height: 100%; object-fit: contain; padding: 10px;">` 
                            : '<i class="fas fa-image text-muted" style="font-size: 3rem;"></i>'}
                    </a>
                    
                    <div class="card-body">
                        <h5 class="card-title">
                            <a href="/webbanhang/Product/show/${product.id}" class="text-decoration-none text-dark">
                                ${product.name}
                            </a>
                        </h5>
                        <p class="card-text text-muted" style="height: 48px; overflow: hidden;">
                            ${product.description}
                        </p>
                        <p class="card-text text-primary font-weight-bold">
                            ${new Intl.NumberFormat('vi-VN', { style: 'currency', currency: 'VND' }).format(product.price)}
                        </p>
                        <p class="card-text">
                            <small class="text-muted">
                                <i class="fas fa-tag mr-1"></i>
                                ${product.category_name || 'Chưa phân loại'}
                            </small>
                        </p>
                    </div>
                    <div class="card-footer bg-white border-top-0">
                        <div class="d-flex justify-content-between">
                            <a href="/webbanhang/Product/edit/${product.id}" class="btn btn-outline-primary btn-sm">
                                <i class="fas fa-edit mr-1"></i>Sửa
                            </a>
                            <button type="button" class="btn btn-outline-danger btn-sm" 
                                    onclick="confirmDelete(${product.id}, '${product.name}')">
                                <i class="fas fa-trash-alt mr-1"></i>Xóa
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        `;
        productList.innerHTML += card;
    });
}
</script>

<style>
.form-control {
    border-radius: 5px;
    border: 1px solid #ddd;
    transition: all 0.3s ease;
}
.form-control:focus {
    border-color: #3498db;
    box-shadow: 0 0 0 0.2rem rgba(52,152,219,.25);
}
select.form-control {
    cursor: pointer;
}
</style>

<?php include 'app/views/shares/footer.php'; ?>