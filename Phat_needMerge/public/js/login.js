document.addEventListener('DOMContentLoaded', function() {
    // Đảm bảo rằng hiệu ứng được chạy sau khi trang đã tải xong
    const inputs = document.querySelectorAll('input');
    const buttons = document.querySelectorAll('button');

    // Thêm sự kiện cho tất cả input để áp dụng hiệu ứng
    inputs.forEach(input => {
        input.addEventListener('focus', function() {
            this.parentElement.querySelector('label').classList.add('float-up');
        });
        input.addEventListener('blur', function() {
            if (this.value === "") {
                this.parentElement.querySelector('label').classList.remove('float-up');
            }
        });
    });

    // Thêm hiệu ứng cho button khi hover
    buttons.forEach(button => {
        button.addEventListener('click', function() {
            this.classList.add('clicked');
        });
    });

    // Chức năng chuyển đổi giữa form đăng nhập và form đăng ký
    const loginForm = document.getElementById('login-form');
    const registerForm = document.getElementById('register-form');
    const showRegisterFormLink = document.getElementById('show-register-form');
    const showLoginFormLink = document.getElementById('show-login-form');

    // Khi nhấn vào "Đăng ký", ẩn form đăng nhập và hiển thị form đăng ký
    showRegisterFormLink.addEventListener('click', function(e) {
        e.preventDefault();
        loginForm.style.display = 'none';  // Ẩn form đăng nhập
        registerForm.style.display = 'block';  // Hiển thị form đăng ký
    });

    // Khi nhấn vào "Đăng nhập", ẩn form đăng ký và hiển thị form đăng nhập
    showLoginFormLink.addEventListener('click', function(e) {
        e.preventDefault();
        registerForm.style.display = 'none';  // Ẩn form đăng ký
        loginForm.style.display = 'block';  // Hiển thị form đăng nhập
    });

    // Hiệu ứng "clicked" cho nút đăng nhập và đăng ký
    document.querySelector('button[type="submit"]').addEventListener('click', function(e) {
        var btn = e.target;

        // Thêm lớp để kích hoạt hiệu ứng
        btn.classList.add('clicked');

        // Sau khi hiệu ứng hoàn thành, loại bỏ lớp clicked (khi hiệu ứng hoàn tất)
        setTimeout(function() {
            btn.classList.remove('clicked');
        }, 400); // Thời gian hiệu ứng (400ms)
    });
});


