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
        header('Location: ' . '/ContactAdminController');
        exit;
    }

    public function changeContactStatus() {
        // Clear any previous output and start new buffer
        ob_end_clean();
        ob_start();
        
        try {
            // Set proper headers
            header('Content-Type: application/json');
            header('Cache-Control: no-cache, must-revalidate');
            
            if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                $contactId = trim($_POST['contact_id'] ?? '');
                $status = trim($_POST['status'] ?? '');

                if (empty($contactId) || empty($status)) {
                    throw new Exception('Thiếu thông tin yêu cầu');
                }

                if (!in_array($status, ['unread', 'read', 'replied'])) {
                    throw new Exception('Trạng thái không hợp lệ');
                }

                $result = $this->contactAdminModel->updateContactStatus($contactId, $status);
                
                if ($result) {
                    echo json_encode(['success' => true, 'message' => 'Cập nhật trạng thái thành công']);
                } else {
                    throw new Exception('Không thể cập nhật trạng thái');
                }
            } else {
                throw new Exception('Phương thức không hợp lệ');
            }
        } catch (Exception $e) {
            // Log the error
            error_log("Error in changeContactStatus: " . $e->getMessage());
            
            // Send error response
            echo json_encode([
                'success' => false, 
                'message' => $e->getMessage()
            ]);
        }
        
        // End output buffering and send response
        ob_end_flush();
        exit;
    }

    public function replyToContact() {
        // Clear any previous output and start new buffer
        ob_end_clean();
        ob_start();
        
        try {
            // Set proper headers
            header('Content-Type: application/json');
            header('Cache-Control: no-cache, must-revalidate');
            
            if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                $contactId = trim($_POST['contact_id'] ?? '');
                $replyMessage = trim($_POST['reply_message'] ?? '');

                if (empty($contactId) || empty($replyMessage)) {
                    throw new Exception('Thiếu thông tin yêu cầu');
                }

                // Get contact details to validate
                $contact = $this->contactAdminModel->getContactMessageById($contactId);
                if (!$contact) {
                    throw new Exception('Không tìm thấy liên hệ');
                }

                // Save the reply
                $result = $this->contactAdminModel->saveReply($contactId, $replyMessage);
                
                if ($result) {
                    // TODO: Send an email to the user with the reply
                    // This would require an email service integration
                    echo json_encode(['success' => true, 'message' => 'Đã gửi phản hồi thành công']);
                } else {
                    throw new Exception('Không thể gửi phản hồi');
                }
            } else {
                throw new Exception('Phương thức không hợp lệ');
            }
        } catch (Exception $e) {
            // Log the error
            error_log("Error in replyToContact: " . $e->getMessage());
            
            // Send error response
            echo json_encode([
                'success' => false, 
                'message' => $e->getMessage()
            ]);
        }
        
        // End output buffering and send response
        ob_end_flush();
        exit;
    }

    public function deleteContact() {
        // Clear any previous output and start new buffer
        ob_end_clean();
        ob_start();
        
        try {
            // Set proper headers
            header('Content-Type: application/json');
            header('Cache-Control: no-cache, must-revalidate');
            
            if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                $contactId = trim($_POST['contact_id'] ?? '');

                if (empty($contactId)) {
                    throw new Exception('Thiếu ID liên hệ');
                }

                $result = $this->contactAdminModel->deleteContactMessage($contactId);
                
                if ($result) {
                    echo json_encode(['success' => true, 'message' => 'Xóa liên hệ thành công']);
                } else {
                    throw new Exception('Không thể xóa liên hệ');
                }
            } else {
                throw new Exception('Phương thức không hợp lệ');
            }
        } catch (Exception $e) {
            // Log the error
            error_log("Error in deleteContact: " . $e->getMessage());
            
            // Send error response
            echo json_encode([
                'success' => false, 
                'message' => $e->getMessage()
            ]);
        }
        
        // End output buffering and send response
        ob_end_flush();
        exit;
    }

    public function viewContactDetails($contactId = '') {
        // Clear any previous output and start new buffer
        ob_end_clean();
        ob_start();
        
        try {
            // Set proper headers
            header('Content-Type: application/json');
            header('Cache-Control: no-cache, must-revalidate');
            
            if ($_SERVER['REQUEST_METHOD'] !== 'GET') {
                throw new Exception('Phương thức không hợp lệ');
            }

            // Check if ID is passed in URL path first
            if (empty($contactId)) {
                // Fallback to GET parameter
                $contactId = trim($_GET['id'] ?? '');
            }

            if (empty($contactId)) {
                throw new Exception('Thiếu ID liên hệ');
            }

            $contact = $this->contactAdminModel->getContactMessageById($contactId);
            
            if (!$contact) {
                throw new Exception('Không tìm thấy liên hệ');
            }

            // Update status to read if currently unread
            if ($contact['status'] === 'unread') {
                $this->contactAdminModel->updateContactStatus($contactId, 'read');
            }
            
            // Send JSON response
            echo json_encode(['success' => true, 'data' => $contact]);
            
        } catch (Exception $e) {
            // Log the error
            error_log("Error in viewContactDetails: " . $e->getMessage());
            
            // Send error response
            echo json_encode([
                'success' => false, 
                'message' => $e->getMessage()
            ]);
        }
        
        // End output buffering and send response
        ob_end_flush();
        exit;
    }
} 