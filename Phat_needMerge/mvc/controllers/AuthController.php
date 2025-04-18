<?php
require_once "./mvc/models/UserModel.php";

class AuthController {
    private $userModel;

    public function __construct() {
        $this->userModel = new UserModel();
    }

    public function login(...$params) {
        // Đăng ký
        if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['register-username'])) {
            $this->register();
            return;
        }

        // Đăng nhập
        if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['username'])) {
            $this->doLogin();
            return;
        }

        // GET: hiển thị form
        $this->render("LoginView");
    }
    public function logout() {
        // Xóa cookies
        setcookie('access_token', '', time() - 3600, '/');
        setcookie('user_name',    '', time() - 3600, '/');
        setcookie('user_role',    '', time() - 3600, '/');

        // (Tuỳ chọn) Xóa token trong DB nếu có method tương ứng:
        // if ($token = $_COOKIE['access_token'] ?? false) {
        //     $this->userModel->revokeAccessToken($token);
        // }

        // Redirect về trang login
        header("Location: http://localhost/Gear/AuthController/login");
        exit;
    }

    private function doLogin() {
        $username = trim($_POST['username']);
        $password = $_POST['password'];

        $user = $this->userModel->getUserByUsername($username);
        if ($user && password_verify($password, $user['password'])) {
            // Tạo token
            $token = bin2hex(random_bytes(32));
            $this->userModel->storeAccessToken($user['id'], $token);

            // Set cookie
            setcookie('access_token', $token, time()+7*24*60*60, '/');
            setcookie('user_name', $user['username'], time()+7*24*60*60, '/');
            setcookie('user_role', $user['role'], time()+7*24*60*60, '/');

            // Redirect
            header("Location: http://localhost/Gear/BlogController/list");
            exit;
        } else {
            $error = "Tên đăng nhập hoặc mật khẩu không đúng.";
            $this->render("LoginView", ['loginError' => $error]);
        }
    }

    private function register() {
        $username = trim($_POST['register-username']);
        $password = $_POST['register-password'];
        $email    = trim($_POST['register-email']);

        if ($this->userModel->getUserByUsername($username)) {
            $this->render("LoginView", ['registerError' => "Tên đăng nhập đã tồn tại.", 'showRegister' => true]);
            return;
        }

        $passwordHash = password_hash($password, PASSWORD_DEFAULT);
        $ok = $this->userModel->createUser($username, $passwordHash, $email);
        if (!$ok) {
            $dbError = $this->userModel->con->error ?? 'Unknown error';
            $this->render("LoginView", ['registerError' => "Đăng ký thất bại: $dbError", 'showRegister' => true]);
            return;
        }

        // Lấy lại user vừa tạo
        $user = $this->userModel->getUserByUsername($username);

        // Tạo token
        $token = bin2hex(random_bytes(32));
        $this->userModel->storeAccessToken($user['id'], $token);

        // Set cookie
        setcookie('access_token', $token, time()+7*24*60*60, '/');
        setcookie('user_name', $user['username'], time()+7*24*60*60, '/');

        header("Location: http://localhost/Gear/BlogController/list");
        exit;
    }

    private function render($view, $data = []) {
        extract($data);
        require_once "./mvc/views/$view.php";
    }
}
