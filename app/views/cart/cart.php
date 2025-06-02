<?php include 'app/views/shares/header.php'; ?>

<div class="container mt-4">
    <h1>Giỏ hàng</h1>
    
    <?php if (!empty($cartItems)): ?>
        <div class="card mb-4">
            <div class="card-body">
                <ul class="list-group list-group-flush">
                    <?php foreach ($cartItems as $id => $item): ?>
                        <li class="list-group-item">
                            <div class="row align-items-center">
                                <div class="col-md-2">
                                    <?php if ($item['image']): ?>
                                        <img src="/webbanhang/<?php echo htmlspecialchars($item['image'], ENT_QUOTES, 'UTF-8'); ?>" 
                                             alt="<?php echo htmlspecialchars($item['name'], ENT_QUOTES, 'UTF-8'); ?>" 
                                             class="img-fluid" style="max-width: 100px;">
                                    <?php endif; ?>
                                </div>
                                <div class="col-md-4">
                                    <h5 class="mb-0"><?php echo htmlspecialchars($item['name'], ENT_QUOTES, 'UTF-8'); ?></h5>
                                </div>                                <div class="col-md-2">
                                    <p class="mb-0">Giá: <span style="white-space: nowrap;"><?php echo number_format($item['price'], 0, ',', '.'); ?> VND</span></p>
                                </div>
                                <div class="col-md-2">                                    <form action="/webbanhang/Cart/update" method="post" class="d-flex align-items-center">
                                        <input type="hidden" name="product_id" value="<?php echo $item['id']; ?>">
                                        <input type="number" name="quantity" value="<?php echo $item['quantity']; ?>" 
                                               min="1" class="form-control form-control-sm" style="width: 70px;">
                                        <button type="submit" class="btn btn-sm btn-outline-primary ms-2">
                                            <i class="fas fa-sync-alt"></i>
                                        </button>
                                    </form>
                                </div>
                                <div class="col-md-2 text-end">
                                    <a href="/webbanhang/Cart/remove/<?php echo $item['id']; ?>" 
                                       class="btn btn-sm btn-outline-danger"
                                       onclick="return confirm('Bạn có chắc muốn xóa sản phẩm này?')">
                                        <i class="fas fa-trash"></i>
                                    </a>
                                </div>
                            </div>
                        </li>
                    <?php endforeach; ?>
                </ul>
            </div>
        </div>

        <div class="card mb-4">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center">                    
                  <h4 class="mb-0">Tổng cộng:</h4>
                    <h4 class="mb-0 text-primary"><span style="white-space: nowrap;"><?php echo number_format($total, 0, ',', '.'); ?> VND</span></h4>
                </div>
            </div>
        </div>

        <div class="d-flex justify-content-between">
            <a href="/webbanhang/Product" class="btn btn-outline-primary">
                <i class="fas fa-arrow-left me-2"></i>Tiếp tục mua sắm
            </a>
            <div>                    
              <a href="/webbanhang/Cart/clear" 
                   class="btn btn-outline-danger me-2"
                   onclick="return confirm('Bạn có chắc muốn xóa tất cả sản phẩm trong giỏ hàng?')"
                   data-toggle="tooltip" 
                   data-placement="top" 
                   title="Xóa tất cả sản phẩm">
                    <i class="fas fa-trash-alt"></i>
                </a>
                <a href="/webbanhang/Cart/checkout" 
                   class="btn btn-success px-4"
                   data-toggle="tooltip" 
                   data-placement="top" 
                   title="Tiến hành thanh toán">
                    <i class="fas fa-shopping-cart me-2"></i>Thanh toán
                </a>
            </div>
        </div>
    <?php else: ?>
        <div class="alert alert-info">
            <i class="fas fa-shopping-cart me-2"></i>Giỏ hàng của bạn đang trống.
        </div>
        <a href="/webbanhang/Product" class="btn btn-primary">
            <i class="fas fa-arrow-left me-2"></i>Tiếp tục mua sắm
        </a>
    <?php endif; ?>
</div>

<script>
    $(document).ready(function(){
        $('[data-toggle="tooltip"]').tooltip();
    });
</script>
<?php include 'app/views/shares/footer.php'; ?>
</div>