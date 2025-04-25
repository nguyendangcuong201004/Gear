<?php
class ContactAdminController extends Controller {
    private $contactAdminModel;

    public function __construct() {
        $this->contactAdminModel = $this->model("ContactAdminModel");
    }

    public function index() {
        $contacts = $this->contactAdminModel->getAllContactMessages();
        $this->view("ContactAdminView", [
            "contacts" => $contacts
        ]);
    }

    public function contact() {
        header('Location: ' . '/ContactAdmin');
        exit;
    }

    public function changeContactStatus() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $contactId = trim($_POST['contact_id'] ?? '');
            $status = trim($_POST['status'] ?? '');

            if (empty($contactId) || empty($status)) {
                echo json_encode(['success' => false, 'message' => 'Thiếu thông tin yêu cầu']);
                return;
            }

            if (!in_array($status, ['unread', 'read', 'replied'])) {
                echo json_encode(['success' => false, 'message' => 'Trạng thái không hợp lệ']);
                return;
            }

            $result = $this->contactAdminModel->updateContactStatus($contactId, $status);
            
            if ($result) {
                echo json_encode(['success' => true, 'message' => 'Cập nhật trạng thái thành công']);
            } else {
                echo json_encode(['success' => false, 'message' => 'Không thể cập nhật trạng thái']);
            }
        } else {
            echo json_encode(['success' => false, 'message' => 'Phương thức không hợp lệ']);
        }
    }

    public function replyToContact() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $contactId = trim($_POST['contact_id'] ?? '');
            $replyMessage = trim($_POST['reply_message'] ?? '');

            if (empty($contactId) || empty($replyMessage)) {
                echo json_encode(['success' => false, 'message' => 'Thiếu thông tin yêu cầu']);
                return;
            }

            // Get contact details to validate
            $contact = $this->contactAdminModel->getContactMessageById($contactId);
            if (!$contact) {
                echo json_encode(['success' => false, 'message' => 'Không tìm thấy liên hệ']);
                return;
            }

            // Save the reply
            $result = $this->contactAdminModel->saveReply($contactId, $replyMessage);
            
            if ($result) {
                // TODO: Send an email to the user with the reply
                // This would require an email service integration
                
                echo json_encode(['success' => true, 'message' => 'Đã gửi phản hồi thành công']);
            } else {
                echo json_encode(['success' => false, 'message' => 'Không thể gửi phản hồi']);
            }
        } else {
            echo json_encode(['success' => false, 'message' => 'Phương thức không hợp lệ']);
        }
    }

    public function deleteContact() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $contactId = trim($_POST['contact_id'] ?? '');

            if (empty($contactId)) {
                echo json_encode(['success' => false, 'message' => 'Thiếu ID liên hệ']);
                return;
            }

            $result = $this->contactAdminModel->deleteContactMessage($contactId);
            
            if ($result) {
                echo json_encode(['success' => true, 'message' => 'Xóa liên hệ thành công']);
            } else {
                echo json_encode(['success' => false, 'message' => 'Không thể xóa liên hệ']);
            }
        } else {
            echo json_encode(['success' => false, 'message' => 'Phương thức không hợp lệ']);
        }
    }

    public function viewContactDetails($contactId = '') {
        if ($_SERVER['REQUEST_METHOD'] === 'GET') {
            // Check if ID is passed in URL path first
            if (empty($contactId)) {
                // Fallback to GET parameter
                $contactId = trim($_GET['id'] ?? '');
            }

            if (empty($contactId)) {
                echo json_encode(['success' => false, 'message' => 'Thiếu ID liên hệ']);
                return;
            }

            $contact = $this->contactAdminModel->getContactMessageById($contactId);
            
            if ($contact) {
                // Update status to read if currently unread
                if ($contact['status'] === 'unread') {
                    $this->contactAdminModel->updateContactStatus($contactId, 'read');
                }
                echo json_encode(['success' => true, 'data' => $contact]);
            } else {
                echo json_encode(['success' => false, 'message' => 'Không tìm thấy liên hệ']);
            }
        } else {
            echo json_encode(['success' => false, 'message' => 'Phương thức không hợp lệ']);
        }
    }
} 