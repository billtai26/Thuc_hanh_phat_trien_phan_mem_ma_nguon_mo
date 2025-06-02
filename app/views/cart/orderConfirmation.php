<?php include 'app/views/shares/header.php'; ?>

<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <?php if (isset($_SESSION['success'])): ?>
                <div class="alert alert-success">
                    <?php 
                        echo $_SESSION['success'];
                        unset($_SESSION['success']);
                    ?>
                </div>
            <?php endif; ?>

            <div class="card shadow">
                <div class="card-header bg-success text-white py-3">
                    <h2 class="h4 mb-0">Xác nhận đơn hàng #<?php echo $order['id']; ?></h2>
                </div>
                <div class="card-body p-4">
                    <div class="mb-5">
                        <h5 class="border-bottom pb-2">Thông tin khách hàng</h5>
                        <div class="ps-3 mt-3">
                            <p class="mb-3"><strong>Họ tên:</strong> <?php echo htmlspecialchars($order['name']); ?></p>
                            <p class="mb-3"><strong>Số điện thoại:</strong> <?php echo htmlspecialchars($order['phone']); ?></p>
                            <p class="mb-3"><strong>Địa chỉ:</strong> <?php echo htmlspecialchars($order['address']); ?></p>
                        </div>
                    </div>

                    <div class="mb-4">
                        <h5 class="border-bottom pb-2">Chi tiết đơn hàng</h5>
                        <div class="table-responsive mt-3">
                            <table class="table table-hover">
                                <thead class="table-light">
                                    <tr>
                                        <th>Sản phẩm</th>
                                        <th>Số lượng</th>
                                        <th>Đơn giá</th>
                                        <th>Thành tiền</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($orderDetails as $item): ?>
                                        <tr>
                                            <td>
                                                <div class="d-flex align-items-center py-2">
                                                    <?php if ($item['image']): ?>                                                <div class="me-3">
                                                            <img src="/webbanhang/<?php echo htmlspecialchars($item['image']); ?>" 
                                                                 alt="<?php echo htmlspecialchars($item['product_name']); ?>" 
                                                                 class="img-thumbnail" style="width: 100px; height: 100px; object-fit: contain; padding: 5px;">
                                                        </div>
                                                    <?php endif; ?>
                                                    <span><?php echo htmlspecialchars($item['product_name']); ?></span>
                                                </div>
                                            </td>
                                            <td class="align-middle"><?php echo $item['quantity']; ?></td>
                                            <td class="align-middle"><?php echo number_format($item['price'], 0, ',', '.'); ?> VND</td>
                                            <td class="align-middle"><?php echo number_format($item['price'] * $item['quantity'], 0, ',', '.'); ?> VND</td>
                                        </tr>
                                    <?php endforeach; ?>
                                </tbody>
                                <tfoot>
                                    <tr class="table-light">
                                        <td colspan="3" class="text-end pe-3"><strong>Tổng cộng:</strong></td>
                                        <td><strong><?php echo number_format($order['total_amount'], 0, ',', '.'); ?> VND</strong></td>
                                    </tr>
                                </tfoot>
                            </table>
                        </div>
                    </div>

                    <div class="text-center mt-5">
                        <a href="/webbanhang/Product" class="btn btn-primary px-4 py-2">
                            <i class="fas fa-shopping-cart me-2"></i>Tiếp tục mua sắm
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?php include 'app/views/shares/footer.php'; ?>
