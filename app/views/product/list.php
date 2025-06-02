<?php include 'app/views/shares/header.php'; ?>

<div class="container mt-4">
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
        <h1 class="h3 mb-0">
            <i class="fas fa-box-open me-2"></i>Danh sách sản phẩm
        </h1>
        <?php if (SessionHelper::isAdmin()): ?>
            <a href="/webbanhang/Product/add" class="btn btn-success">
                <i class="fas fa-plus me-2"></i>Thêm sản phẩm mới
            </a>
        <?php endif; ?>
    </div>

    <div class="row g-4">
        <?php foreach ($products as $product): ?>
            <div class="col-sm-6 col-lg-4">
                <div class="card h-100 border-0 shadow-sm hover-shadow transition">
                    <div class="position-relative product-img-container">
                        <?php if ($product->image): ?>
                            <img src="/webbanhang/<?php echo $product->image; ?>" 
                                 alt="<?php echo htmlspecialchars($product->name, ENT_QUOTES, 'UTF-8'); ?>" 
                                 class="card-img-top p-3" 
                                 style="height: 250px; object-fit: contain;">
                        <?php else: ?>
                            <div class="no-image-placeholder" style="height: 250px;">
                                <i class="fas fa-image fa-3x text-muted"></i>
                            </div>
                        <?php endif; ?>
                    </div>

                    <div class="card-body pt-2">
                        <div class="d-flex align-items-start justify-content-between mb-2">
                            <h5 class="card-title">
                                <a href="/webbanhang/Product/show/<?php echo $product->id; ?>" 
                                   class="text-decoration-none text-dark">
                                    <?php echo htmlspecialchars($product->name, ENT_QUOTES, 'UTF-8'); ?>
                                </a>
                            </h5>
                            <span class="badge bg-info rounded-pill ms-2" style="font-size: 0.8rem;">
                                <?php echo htmlspecialchars($product->category_name ?? 'Chưa phân loại', ENT_QUOTES, 'UTF-8'); ?>
                            </span>
                        </div>
                        
                        <p class="text-muted small mb-3">
                            <?php 
                            $description = $product->description ?? 'Chưa có mô tả';
                            echo htmlspecialchars(
                                strlen($description) > 100 
                                    ? substr($description, 0, 100) . '...' 
                                    : $description, 
                                ENT_QUOTES, 
                                'UTF-8'
                            ); 
                            ?>
                        </p>

                        <div class="d-flex justify-content-between align-items-center">                            <h6 class="text-primary fw-bold mb-0">
                                <span style="white-space: nowrap;"><?php echo number_format($product->price, 0, ',', '.'); ?> VND</span>
                            </h6>
                        </div>
                    </div>

                    <div class="card-footer bg-transparent border-top-0 pb-3">
                        <div class="d-flex gap-2">                            <?php if (SessionHelper::isAdmin()): ?>
                                <div class="d-flex" style="gap: 0.5rem; width: 50%;">
                                    <a href="/webbanhang/Product/edit/<?php echo $product->id; ?>" 
                                       class="btn btn-outline-warning btn-sm flex-grow-1">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    <a href="/webbanhang/Product/delete/<?php echo $product->id; ?>" 
                                       class="btn btn-outline-danger btn-sm flex-grow-1"
                                       onclick="return confirm('Bạn có chắc chắn muốn xóa sản phẩm này?');">
                                        <i class="fas fa-trash"></i>
                                    </a>
                                </div>
                            <?php endif; ?><form action="/webbanhang/Cart/add" method="post" class="flex-grow-1">
                                <input type="hidden" name="product_id" value="<?php echo $product->id; ?>">
                                <input type="hidden" name="quantity" value="1">
                                <button type="submit" class="btn btn-primary btn-sm w-100">
                                    <i class="fas fa-cart-plus"></i>Thêm vào giỏ
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        <?php endforeach; ?>
    </div>
</div>

<?php include 'app/views/shares/footer.php'; ?>