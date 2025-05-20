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
        <i class="fas fa-tags mr-2"></i>Danh sách danh mục
    </h1>
    <a href="/webbanhang/Category/add" class="btn btn-primary">
        <i class="fas fa-plus mr-2"></i>Thêm danh mục mới
    </a>
</div>

<div class="card">
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-hover">
                <thead class="thead-light">                    <tr>
                        <th>ID</th>
                        <th>Tên danh mục</th>
                        <th>Mô tả</th>
                        <th>Số sản phẩm</th>
                        <th>Thao tác</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($categories as $category): ?>
                        <tr>
                            <td><?php echo $category->id; ?></td>
                            <td><?php echo htmlspecialchars($category->name, ENT_QUOTES, 'UTF-8'); ?></td>
                            <td><?php echo htmlspecialchars($category->description, ENT_QUOTES, 'UTF-8'); ?></td>
                            <td>
                                <span class="badge badge-primary">
                                    <?php echo $category->product_count; ?> sản phẩm
                                </span>
                            </td>
                            <td>
                                <a href="/webbanhang/Category/edit/<?php echo $category->id; ?>" 
                                   class="btn btn-sm btn-outline-primary mr-2">
                                    <i class="fas fa-edit"></i>
                                </a>
                                <button class="btn btn-sm btn-outline-danger" 
                                        onclick="confirmDelete(<?php echo $category->id; ?>, '<?php echo htmlspecialchars($category->name, ENT_QUOTES, 'UTF-8'); ?>')">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
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
                Bạn có chắc chắn muốn xóa danh mục <strong id="categoryName"></strong>?
                <p class="text-danger mt-2">
                    <i class="fas fa-exclamation-triangle mr-1"></i>
                    Lưu ý: Xóa danh mục sẽ ảnh hưởng đến các sản phẩm thuộc danh mục này.
                </p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Hủy</button>
                <a href="#" id="confirmDeleteButton" class="btn btn-danger">Xóa danh mục</a>
            </div>
        </div>
    </div>
</div>

<script>
function confirmDelete(id, name) {
    document.getElementById('categoryName').textContent = name;
    document.getElementById('confirmDeleteButton').href = '/webbanhang/Category/delete/' + id;
    $('#deleteModal').modal('show');
}

// Tự động ẩn thông báo sau 5 giây
setTimeout(function() {
    $('.alert').alert('close');
}, 5000);
</script>

<?php include 'app/views/shares/footer.php'; ?>
