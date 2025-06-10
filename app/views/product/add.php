<?php include 'app/views/shares/header.php'; ?>
<h1>Thêm sản phẩm mới</h1>
<form id="add-product-form" enctype="multipart/form-data">
  <div class="form-group">
    <label for="name">Tên sản phẩm:</label>
    <input type="text" id="name" name="name" class="form-control" required>
  </div>
  
  <div class="form-group">
    <label for="description">Mô tả:</label>
    <textarea id="description" name="description" class="form-control" required></textarea>
  </div>
  
  <div class="form-group">
    <label for="price">Giá:</label>
    <input type="number" id="price" name="price" class="form-control" step="0.01" required>
  </div>
  
  <div class="form-group">
    <label for="category_id">Danh mục:</label>
    <select id="category_id" name="category_id" class="form-control" required>
      <option value="">-- Chọn danh mục --</option>
    </select>
  </div>

  <div class="form-group">
    <label for="image">Hình ảnh sản phẩm:</label>
    <input type="file" id="image" name="image" class="form-control-file" accept="image/*">
    <small class="form-text text-muted">Chỉ chấp nhận file JPG, JPEG, PNG và GIF. Kích thước tối đa: 10MB</small>
  </div>
  
  <button type="submit" class="btn btn-primary">Thêm sản phẩm</button>
</form>
<a href="/webbanhang/Product/list" class="btn btn-secondary mt-2">Quay lại</a>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
$(document).ready(function() {
  // Load categories
  $.get('/webbanhang/api/category', function(categories) {
    let options = '<option value="">-- Chọn danh mục --</option>';
    
    $.each(categories, function(i, category) {
      options += `<option value="${category.id}">${category.name}</option>`;
    });
    
    $('#category_id').html(options);
  });

  // Form submission
  $('#add-product-form').submit(function(e) {
    e.preventDefault();
    
    const formData = new FormData(this);
    
    $.ajax({
      url: '/webbanhang/api/product',
      type: 'POST',
      data: formData,
      processData: false,
      contentType: false,
      success: function() {
        alert('Thêm sản phẩm thành công!');
        window.location.href = '/webbanhang/Product/list';
      },
      error: function(xhr) {
        if(xhr.status === 400) {
          const errors = xhr.responseJSON.errors;
          let errorMsg = '';
          for(const key in errors) {
            errorMsg += `${errors[key]}\n`;
          }
          alert(`Lỗi:\n${errorMsg}`);
        } else {
          alert('Thêm sản phẩm thất bại!');
        }
      }
    });
  });
});
</script>