<?php
class ContactController extends Controller {
    private $contactModel;
    private $homeAdminModel;

    public function __construct() {
        $this->contactModel = $this->model("ContactModel");
        $this->homeAdminModel = $this->model("HomeAdminModel");
    }

    // Hiển thị trang liên hệ
    public function index() {
        $settings = $this->homeAdminModel->getSiteSettings();
        $this->view("ContactView", [
            "settings" => $settings
        ]);
    }
    
    // Xử lý gửi form liên hệ
    public function submit() {
        try {
            // Clear any previous output
            ob_clean();
            
            // Set proper headers
            header('Content-Type: application/json');
            header('Cache-Control: no-cache, must-revalidate');
            
            if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
                echo json_encode(['success' => false, 'message' => 'Invalid request method']);
                return;
            }

            // Validate required fields
            $requiredFields = ['name', 'email', 'message'];
            foreach ($requiredFields as $field) {
                if (empty($_POST[$field])) {
                    echo json_encode(['success' => false, 'message' => 'Vui lòng điền đầy đủ thông tin bắt buộc']);
                    return;
                }
            }

            // Validate email format
            if (!filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)) {
                echo json_encode(['success' => false, 'message' => 'Email không hợp lệ']);
                return;
            }

            // Validate phone if provided
            if (!empty($_POST['phone']) && !preg_match('/^[0-9\+\-\(\) ]{10,15}$/', $_POST['phone'])) {
                echo json_encode(['success' => false, 'message' => 'Số điện thoại không hợp lệ']);
                return;
            }

            // Process newsletter subscription
            $newsletter = isset($_POST['newsletter']) ? 1 : 0;

            // Save contact message
            $result = $this->contactModel->saveContactMessage(
                $_POST['name'],
                $_POST['email'],
                $_POST['subject'] ?? '',
                $_POST['phone'] ?? '',
                $_POST['message'],
                $newsletter
            );

            if ($result) {
                echo json_encode(['success' => true, 'message' => 'success']);
            } else {
                echo json_encode(['success' => false, 'message' => 'Có lỗi xảy ra khi lưu thông tin liên hệ']);
            }
        } catch (Exception $e) {
            error_log("Error in ContactController::submit: " . $e->getMessage());
            echo json_encode(['success' => false, 'message' => 'Đã xảy ra lỗi. Vui lòng thử lại sau.']);
        }
        exit; // Ensure no further output
    }
} 