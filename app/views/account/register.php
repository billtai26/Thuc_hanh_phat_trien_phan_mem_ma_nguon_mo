<?php include 'app/views/shares/header.php'; ?>
<style>
.gradient-custom {
    background: linear-gradient(to right, #36D1DC, #5B86E5);
    min-height: 100vh;
    padding: 20px 0;
    display: flex;
    align-items: flex-start;
}
.register-card {
    background: rgba(0, 0, 0, 0.8) !important;
    backdrop-filter: blur(10px);
    border: 1px solid rgba(255, 255, 255, 0.1);
    box-shadow: 0 0 40px rgba(0, 0, 0, 0.3);
}
.form-control:focus {
    border-color: #5B86E5;
    box-shadow: 0 0 0 0.2rem rgba(91, 134, 229, 0.25);
}
.btn-register {
    background: linear-gradient(45deg, #36D1DC, #5B86E5);
    border: none;
    transition: all 0.3s ease;
}
.btn-register:hover {
    transform: translateY(-2px);
    box-shadow: 0 5px 15px rgba(91, 134, 229, 0.4);
}
.input-group-text {
    background: transparent;
    border-right: none;
}
.form-control {
    border-left: none;
    background: transparent;
    color: #fff;
    transition: color 0.3s ease, background 0.3s ease;
}
.form-control:focus {
    color: #000 !important;
    background: rgba(255, 255, 255, 0.9) !important;
}
.form-control::placeholder {
    color: rgba(255, 255, 255, 0.7);
}
.form-control:focus::placeholder {
    color: rgba(0, 0, 0, 0.5) !important;
}
</style>

<section class="gradient-custom"> 
   <div class="container">
    <div class="row justify-content-center">
      <div class="col-12 col-md-8 col-lg-6 col-xl-5">
        <div class="card register-card text-white" style="border-radius: 1.5rem;">
          <div class="card-body p-5">
            <?php
            if (isset($errors)) {
              echo "<div class='alert alert-danger'><ul class='mb-0'>";
              foreach ($errors as $err) {
                echo "<li>$err</li>";
              }
              echo "</ul></div>";
            }
            ?>
            
            <form action="/webbanhang/account/save" method="post">
              <div class="text-center mb-4">
                <h2 class="fw-bold text-uppercase mb-2">Đăng ký</h2>
                <p class="text-white-50">Vui lòng điền thông tin tài khoản</p>
              </div>

              <div class="form-group mb-4">
                <label class="form-label">Tên đăng nhập</label>
                <div class="input-group">
                  <span class="input-group-text text-white border-white">
                    <i class="fas fa-user"></i>
                  </span>
                  <input type="text" name="username" class="form-control form-control-lg border-white" 
                         placeholder="Nhập tên đăng nhập" required />
                </div>
              </div>

              <div class="form-group mb-4">
                <label class="form-label">Họ và tên</label>
                <div class="input-group">
                  <span class="input-group-text text-white border-white">
                    <i class="fas fa-id-card"></i>
                  </span>
                  <input type="text" name="fullname" class="form-control form-control-lg border-white" 
                         placeholder="Nhập họ và tên" required />
                </div>
              </div>

              <div class="form-group mb-4">
                <label class="form-label">Mật khẩu</label>
                <div class="input-group">
                  <span class="input-group-text text-white border-white">
                    <i class="fas fa-lock"></i>
                  </span>
                  <input type="password" name="password" class="form-control form-control-lg border-white" 
                         placeholder="Nhập mật khẩu" required />
                </div>
              </div>

              <div class="form-group mb-4">
                <label class="form-label">Xác nhận mật khẩu</label>
                <div class="input-group">
                  <span class="input-group-text text-white border-white">
                    <i class="fas fa-lock"></i>
                  </span>
                  <input type="password" name="confirmpassword" class="form-control form-control-lg border-white" 
                         placeholder="Nhập lại mật khẩu" required />
                </div>
              </div>

              <button class="btn btn-register text-white w-100 btn-lg mb-4" type="submit">
                Đăng ký
              </button>

              <div class="text-center">
                <p class="mb-0">Đã có tài khoản? 
                  <a href="/webbanhang/account/login" class="text-white-50 fw-bold text-decoration-none">
                    Đăng nhập ngay
                  </a>
                </p>
              </div>
            </form>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>
<?php include 'app/views/shares/footer.php'; ?>