<?php include 'app/views/shares/header.php'; ?>

<div class="container mt-4">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header bg-primary text-white">
                    <h1 class="h3 mb-0">Thông tin thanh toán</h1>
                </div>
                <div class="card-body">
                    <!-- Hiển thị thông báo lỗi nếu có -->
                    <?php if (isset($_SESSION['error'])): ?>
                        <div class="alert alert-danger">
                            <?php 
                                echo $_SESSION['error'];
                                unset($_SESSION['error']);
                            ?>
                        </div>
                    <?php endif; ?>                    <form method="POST" action="/webbanhang/Cart/processCheckout">
                        <div class="form-group mb-3">
                            <label for="name" class="form-label">Họ tên:</label>
                            <input type="text" id="name" name="name" class="form-control" 
                                   required placeholder="Nhập họ tên của bạn">
                        </div>

                        <div class="form-group mb-3">
                            <label for="phone" class="form-label">Số điện thoại:</label>
                            <input type="tel" id="phone" name="phone" class="form-control" 
                                   required placeholder="Nhập số điện thoại của bạn"
                                   pattern="[0-9]{10}" title="Vui lòng nhập số điện thoại hợp lệ">
                        </div>

                        <div class="form-group mb-4">
                            <label for="address" class="form-label">Địa chỉ:</label>
                            <textarea id="address" name="address" class="form-control" 
                                    rows="3" required placeholder="Nhập địa chỉ giao hàng của bạn"></textarea>
                        </div>

                        <!-- Hiển thị tổng giá trị đơn hàng -->
                        <div class="alert alert-info mb-4">
                            <div class="d-flex justify-content-between align-items-center">
                                <strong>Tổng giá trị đơn hàng:</strong>
                                <span class="h5 mb-0"><?php echo isset($total) ? number_format($total, 0, ',', '.') . ' VND' : '0 VND'; ?></span>
                            </div>
                        </div>

                        <div class="d-flex justify-content-between">
                            <a href="/webbanhang/Cart" class="btn btn-outline-secondary">
                                <i class="fas fa-arrow-left me-2"></i>Quay lại giỏ hàng
                            </a>
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-check me-2"></i>Xác nhận thanh toán
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<?php include 'app/views/shares/footer.php'; ?>
