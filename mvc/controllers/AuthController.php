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

    // Hiển thị trang thông tin cá nhân
    public function profile() {
        // Kiểm tra xem người dùng đã đăng nhập chưa
        if (!isset($_COOKIE['access_token'])) {
            header("Location: http://localhost/Gear/AuthController/login");
            exit;
        }

        // Lấy thông tin người dùng
        $userId = $this->userModel->getUserIdFromToken($_COOKIE['access_token']);
        if (!$userId) {
            header("Location: http://localhost/Gear/AuthController/login");
            exit;
        }

        $userInfo = $this->userModel->getUserById($userId);
        $this->render("ProfileView", ['userInfo' => $userInfo]);
    }

    // Cập nhật thông tin cá nhân
    public function updateProfile() {
        // Kiểm tra xem người dùng đã đăng nhập chưa
        if (!isset($_COOKIE['access_token'])) {
            header("Location: http://localhost/Gear/AuthController/login");
            exit;
        }

        // Xử lý POST request
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $userId = $this->userModel->getUserIdFromToken($_COOKIE['access_token']);
            if (!$userId) {
                header("Location: http://localhost/Gear/AuthController/login");
                exit;
            }

            $email = trim($_POST['email']);
            $fullname = trim($_POST['fullname']);
            $dob = $_POST['dob'] ?? null;
            $address = trim($_POST['address'] ?? '');

            // Kiểm tra email hợp lệ
            if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                $userInfo = $this->userModel->getUserById($userId);
                $this->render("ProfileView", [
                    'userInfo' => $userInfo,
                    'updateError' => "Email không hợp lệ"
                ]);
                return;
            }

            // Cập nhật thông tin
            $updated = $this->userModel->updateUserProfile($userId, $email, $fullname, $dob, $address);
            if ($updated) {
                $userInfo = $this->userModel->getUserById($userId);
                $this->render("ProfileView", [
                    'userInfo' => $userInfo,
                    'updateSuccess' => true
                ]);
            } else {
                $userInfo = $this->userModel->getUserById($userId);
                $this->render("ProfileView", [
                    'userInfo' => $userInfo,
                    'updateError' => "Cập nhật thông tin thất bại"
                ]);
            }
        } else {
            // Redirect về trang profile nếu không phải POST request
            header("Location: http://localhost/Gear/AuthController/profile");
            exit;
        }
    }

    // Cập nhật mật khẩu
    public function updatePassword() {
        // Kiểm tra xem người dùng đã đăng nhập chưa
        if (!isset($_COOKIE['access_token'])) {
            header("Location: http://localhost/Gear/AuthController/login");
            exit;
        }

        // Xử lý POST request
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $userId = $this->userModel->getUserIdFromToken($_COOKIE['access_token']);
            if (!$userId) {
                header("Location: http://localhost/Gear/AuthController/login");
                exit;
            }

            $currentPassword = $_POST['current_password'];
            $newPassword = $_POST['new_password'];
            $confirmPassword = $_POST['confirm_password'];

            // Kiểm tra mật khẩu hiện tại
            $user = $this->userModel->getUserById($userId);
            if (!password_verify($currentPassword, $user['password'])) {
                $this->render("ProfileView", [
                    'userInfo' => $user,
                    'passwordError' => "Mật khẩu hiện tại không đúng"
                ]);
                return;
            }

            // Kiểm tra mật khẩu mới và xác nhận mật khẩu
            if ($newPassword !== $confirmPassword) {
                $this->render("ProfileView", [
                    'userInfo' => $user,
                    'passwordError' => "Mật khẩu mới và xác nhận mật khẩu không khớp"
                ]);
                return;
            }

            // Kiểm tra độ mạnh của mật khẩu
            if (strlen($newPassword) < 6) {
                $this->render("ProfileView", [
                    'userInfo' => $user,
                    'passwordError' => "Mật khẩu mới phải có ít nhất 6 ký tự"
                ]);
                return;
            }

            // Cập nhật mật khẩu
            $passwordHash = password_hash($newPassword, PASSWORD_DEFAULT);
            $updated = $this->userModel->updatePassword($userId, $passwordHash);

            if ($updated) {
                $this->render("ProfileView", [
                    'userInfo' => $user,
                    'passwordSuccess' => true
                ]);
            } else {
                $this->render("ProfileView", [
                    'userInfo' => $user,
                    'passwordError' => "Cập nhật mật khẩu thất bại"
                ]);
            }
        } else {
            // Redirect về trang profile nếu không phải POST request
            header("Location: http://localhost/Gear/AuthController/profile");
            exit;
        }
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
            setcookie('user_role', $user['user_role'], time()+7*24*60*60, '/');

            // Redirect
            header("Location: http://localhost/Gear/QAController/list");
            exit;
        } else {
            $error = "Tên đăng nhập hoặc mật khẩu không đúng.";
            $this->render("LoginView", ['loginError' => $error]);
        }
    }

    private function register() {
        $username = trim($_POST['register-username']);
        $password = $_POST['register-password'];
        $email = trim($_POST['register-email']);
        $fullname = trim($_POST['register-fullname'] ?? '');
        $dob = $_POST['register-dob'] ?? null;
        $address = trim($_POST['register-address'] ?? '');

        if ($this->userModel->getUserByUsername($username)) {
            $this->render("LoginView", ['registerError' => "Tên đăng nhập đã tồn tại.", 'showRegister' => true]);
            return;
        }

        $passwordHash = password_hash($password, PASSWORD_DEFAULT);
        $ok = $this->userModel->createUser($username, $passwordHash, $email, $fullname, $dob, $address);
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
        setcookie('user_role', $user['role'], time()+7*24*60*60, '/');

        header("Location: http://localhost/Gear/QAController/list");
        exit;
    }

    private function render($view, $data = []) {
        extract($data);
        require_once "./mvc/views/$view.php";
    }
}
