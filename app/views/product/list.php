<?php include 'app/views/shares/header.php'; ?>
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
        <form id="filterForm" action="/webbanhang/Product/index" method="GET" class="row align-items-center">
            <div class="col-md-4">
                <div class="form-group mb-0">
                    <label for="price_range" class="text-muted mb-2">Lọc theo giá:</label>
                    <select name="price_range" id="price_range" class="form-control" onchange="this.form.submit()">
                        <option value="">Tất cả mức giá</option>
                        <option value="0-1000000" <?php echo (isset($_GET['price_range']) && $_GET['price_range'] == '0-1000000') ? 'selected' : ''; ?>>Dưới 1 triệu</option>
                        <option value="1000000-5000000" <?php echo (isset($_GET['price_range']) && $_GET['price_range'] == '1000000-5000000') ? 'selected' : ''; ?>>1 triệu - 5 triệu</option>
                        <option value="5000000-10000000" <?php echo (isset($_GET['price_range']) && $_GET['price_range'] == '5000000-10000000') ? 'selected' : ''; ?>>5 triệu - 10 triệu</option>
                        <option value="10000000-999999999" <?php echo (isset($_GET['price_range']) && $_GET['price_range'] == '10000000-999999999') ? 'selected' : ''; ?>>Trên 10 triệu</option>
                    </select>
                </div>
            </div>
        </form>
    </div>
</div>

<div class="row" id="productList">
    <?php foreach ($products as $product): ?>    
    <div class="col-md-6 col-lg-4 mb-4">
        <div class="card h-100 shadow-sm product-card">            <a href="/webbanhang/Product/show/<?php echo $product->id; ?>" class="card-img-wrapper" style="height: 200px; overflow: hidden; display: flex; align-items: center; justify-content: center; background-color: #ffffff; text-decoration: none;">
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
                <p class="card-text text-muted" style="height: 48px; overflow: hidden;">
                    <?php echo htmlspecialchars($product->description, ENT_QUOTES, 'UTF-8'); ?>
                </p>
                <p class="card-text text-primary font-weight-bold">
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
                    <a href="/webbanhang/Product/delete/<?php echo $product->id; ?>" 
                       class="btn btn-outline-danger btn-sm"
                       onclick="return confirm('Bạn có chắc chắn muốn xóa sản phẩm này?');">
                        <i class="fas fa-trash-alt mr-1"></i>Xóa
                    </a>
                </div>
            </div>
        </div>
    </div>
    <?php endforeach; ?>
</div>

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