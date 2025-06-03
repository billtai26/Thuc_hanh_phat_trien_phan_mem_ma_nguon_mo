<?php include 'app/views/shares/header.php'; ?>

<div class="container mt-4">
    <div class="mb-4">
        <a href="/webbanhang/Order" class="text-decoration-none">
            <i class="fas fa-arrow-left me-2"></i>Quay lại danh sách đơn hàng
        </a>
    </div>

    <div class="card mb-4">
        <div class="card-body">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h4 class="mb-0">
                    <i class="fas fa-receipt me-2"></i>Chi tiết đơn hàng #<?php echo str_pad($order['id'], 6, '0', STR_PAD_LEFT); ?>
                </h4>
            </div>

            <div class="ps-3 mt-3">
                <p class="mb-3"><strong>Họ tên:</strong> <?php echo htmlspecialchars($order['name']); ?></p>
                <p class="mb-3"><strong>Số điện thoại:</strong> <?php echo htmlspecialchars($order['phone']); ?></p>
                <p class="mb-3"><strong>Địa chỉ:</strong> <?php echo htmlspecialchars($order['address']); ?></p>
            </div>
            <div class="row mb-4">
                <div class="col-md-6">
                    <p class="mb-1"><strong>Ngày đặt hàng:</strong></p>
                    <p><?php echo date('d/m/Y H:i', strtotime($order['created_at'])); ?></p>
                </div>
            </div>

            <div class="table-responsive">
                <table class="table">
                    <thead>
                        <tr>
                            <th>Sản phẩm</th>
                            <th>Giá</th>
                            <th>Số lượng</th>
                            <th class="text-end">Thành tiền</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($orderDetails as $item): ?>
                            <tr>
                                <td>
                                    <div class="d-flex align-items-center">
                                        <?php if ($item['image']): ?>
                                            <img src="/webbanhang/<?php echo htmlspecialchars($item['image']); ?>" 
                                                 alt="<?php echo htmlspecialchars($item['product_name']); ?>"
                                                 class="me-3" style="width: 50px; height: 50px; object-fit: contain;">
                                        <?php endif; ?>
                                        <?php echo htmlspecialchars($item['product_name']); ?>
                                    </div>
                                </td>
                                <td>
                                    <span style="white-space: nowrap;">
                                        <?php echo number_format($item['price'], 0, ',', '.'); ?> VND
                                    </span>
                                </td>
                                <td><?php echo $item['quantity']; ?></td>
                                <td class="text-end">
                                    <span style="white-space: nowrap;">
                                        <?php echo number_format($item['price'] * $item['quantity'], 0, ',', '.'); ?> VND
                                    </span>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>                    
                    <tfoot>
                        <tr>
                            <td></td>
                            <td></td>
                            <td class="text-end"><strong>Tổng cộng:</strong></td>
                            <td class="text-end">
                                <strong style="white-space: nowrap;">
                                    <?php echo number_format($order['total_amount'] ?? 0, 0, ',', '.'); ?> VND
                                </strong>
                            </td>
                        </tr>
                    </tfoot>
                </table>
            </div>
        </div>
    </div>
</div>

<?php include 'app/views/shares/footer.php'; ?>
