<?php include 'app/views/shares/header.php'; ?>

<div class="container">
    <div class="row">
        <div class="col-md-5">
            <div class="card mb-4">
                <?php if ($product->image): ?>
                    <div class="product-image-container" style="height: 400px; display: flex; align-items: center; justify-content: center; background-color: #ffffff; padding: 20px;">
                        <img src="/webbanhang/<?php echo $product->image; ?>" 
                             class="img-fluid" 
                             alt="<?php echo htmlspecialchars($product->name, ENT_QUOTES, 'UTF-8'); ?>"
                             style="max-height: 100%; object-fit: contain;">
                    </div>
                <?php else: ?>
                    <div class="product-image-container" style="height: 400px; display: flex; align-items: center; justify-content: center; background-color: #f8f9fa;">
                        <i class="fas fa-image text-muted" style="font-size: 8rem;"></i>
                    </div>
                <?php endif; ?>
            </div>
        </div>
        
        <div class="col-md-7">
            <nav aria-label="breadcrumb" class="mb-3">
                <ol class="breadcrumb bg-white">
                    <li class="breadcrumb-item"><a href="/webbanhang/Product" class="text-primary">Danh sách sản phẩm</a></li>
                    <li class="breadcrumb-item active" aria-current="page"><?php echo htmlspecialchars($product->name, ENT_QUOTES, 'UTF-8'); ?></li>
                </ol>
            </nav>

            <h1 class="mb-4"><?php echo htmlspecialchars($product->name, ENT_QUOTES, 'UTF-8'); ?></h1>
            
            <div class="card mb-4">
                <div class="card-body">
                    <h3 class="text-primary mb-3">
                        <?php echo number_format($product->price, 0, ',', '.'); ?> VND
                    </h3>

                    <div class="mb-4">
                        <h5 class="text-muted mb-3">Thông tin chi tiết:</h5>
                        <p class="product-description">
                            <?php echo nl2br(htmlspecialchars($product->description, ENT_QUOTES, 'UTF-8')); ?>
                        </p>
                    </div>

                    <div class="mb-4">
                        <h5 class="text-muted mb-2">Danh mục:</h5>
                        <span class="badge badge-primary p-2">
                            <i class="fas fa-tag mr-1"></i>
                            <?php echo htmlspecialchars($product->category_name, ENT_QUOTES, 'UTF-8'); ?>
                        </span>
                    </div>

                    <div class="border-top pt-4">
                        <div class="row">
                            <div class="col-6">
                                <a href="/webbanhang/Product/edit/<?php echo $product->id; ?>" class="btn btn-primary btn-block">
                                    <i class="fas fa-edit mr-1"></i>Chỉnh sửa
                                </a>
                            </div>
                            <div class="col-6">
                                <a href="/webbanhang/Product/delete/<?php echo $product->id; ?>" 
                                   class="btn btn-danger btn-block"
                                   onclick="return confirm('Bạn có chắc chắn muốn xóa sản phẩm này?');">
                                    <i class="fas fa-trash-alt mr-1"></i>Xóa
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
.product-description {
    line-height: 1.8;
    color: #2c3e50;
}

.badge {
    font-size: 0.9rem;
}

.product-image-container {
    border-radius: 8px;
    overflow: hidden;
}

.breadcrumb {
    border-radius: 8px;
    box-shadow: 0 1px 3px rgba(0,0,0,0.1);
}

.card {
    border-radius: 8px;
    box-shadow: 0 2px 4px rgba(0,0,0,0.1);
    border: none;
}
</style>

<?php include 'app/views/shares/footer.php'; ?>