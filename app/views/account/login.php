<?php include 'app/views/shares/header.php'; ?>
<style>
.gradient-custom {
    background: linear-gradient(to right, #36D1DC, #5B86E5);
}
.login-card {
    background: rgba(0, 0, 0, 0.8) !important;
    backdrop-filter: blur(10px);
    border: 1px solid rgba(255, 255, 255, 0.1);
    box-shadow: 0 0 40px rgba(0, 0, 0, 0.3);
}
.form-control:focus {
    border-color: #5B86E5;
    box-shadow: 0 0 0 0.2rem rgba(91, 134, 229, 0.25);
}
.social-link {
    transition: all 0.3s ease;
    opacity: 0.8;
}
.social-link:hover {
    opacity: 1;
    transform: translateY(-3px);
}
.btn-login {
    background: linear-gradient(45deg, #36D1DC, #5B86E5);
    border: none;
    transition: all 0.3s ease;
}
.btn-login:hover {
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

<section class="vh-100 gradient-custom">  
  <div class="container py-0 h-100">
    <div class="row d-flex justify-content-center align-items-center h-100">
      <div class="col-12 col-md-8 col-lg-6 col-xl-5">
        <div class="card login-card text-white" style="border-radius: 1.5rem;">
          <div class="card-body p-5">
            <form action="/webbanhang/account/checklogin" method="post">
              <div class="text-center mb-4">
                <h2 class="fw-bold text-uppercase mb-2">Đăng nhập</h2>
                <p class="text-white-50">Vui lòng nhập thông tin tài khoản của bạn</p>
              </div>

              <div class="form-group mb-4">
                <label class="form-label">Tên đăng nhập</label>
                <div class="input-group">
                  <span class="input-group-text text-white border-white">
                    <i class="fas fa-user"></i>
                  </span>
                  <input type="text" name="username" class="form-control form-control-lg text-white border-white" 
                         placeholder="Nhập tên đăng nhập" required />
                </div>
              </div>

              <div class="form-group mb-4">
                <label class="form-label">Mật khẩu</label>
                <div class="input-group">
                  <span class="input-group-text text-white border-white">
                    <i class="fas fa-lock"></i>
                  </span>
                  <input type="password" name="password" class="form-control form-control-lg text-white border-white" 
                         placeholder="Nhập mật khẩu" required />
                </div>
              </div>

              <div class="text-end mb-4">
                <a href="#" class="text-white-50 text-decoration-none">Quên mật khẩu?</a>
              </div>

              <button class="btn btn-login text-white w-100 btn-lg mb-4" type="submit">
                Đăng nhập
              </button>             
              <div class="text-center mb-4">                <p class="text-white-50 mb-2">Hoặc đăng nhập với</p>
                <div class="d-flex justify-content-center gap-5 mb-2">
                  <a href="#" class="social-link text-white px-3">
                    <i class="fab fa-facebook-f fa-lg"></i>
                  </a>
                  <a href="#" class="social-link text-white px-3">
                    <i class="fab fa-twitter fa-lg"></i>
                  </a>
                  <a href="#" class="social-link text-white px-3">
                    <i class="fab fa-google fa-lg"></i>
                  </a>
                </div>
              </div>

              <div class="text-center">
                <p class="mb-0">Chưa có tài khoản?
                  <a href="/webbanhang/account/register" class="text-white-50 fw-bold text-decoration-none">
                    Đăng ký ngay
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