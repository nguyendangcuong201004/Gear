<?php
class HomeAdminController extends Controller {
    private $homeAdminModel;

    public function __construct() {
        $this->homeAdminModel = $this->model("HomeAdminModel");
    }

    public function index() {
        // Get site settings
        $settings = $this->homeAdminModel->getSiteSettings();
        
        // Get carousel slides
        $slides = $this->homeAdminModel->getCarouselSlides();
        
        $this->view("HomeAdminView", [
            "settings" => $settings,
            "slides" => $slides
        ]);
    }

    // Update site settings
    public function updateSettings() {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            header('Location: /Gear/homeadmin');
            exit;
        }
        
        // Initialize error array
        $errors = [];
        
        // Validate and sanitize inputs
        $companyName = trim($_POST['company_name'] ?? '');
        if (empty($companyName)) {
            $errors[] = 'Tên công ty không được để trống';
        }
        
        $phone = trim($_POST['phone'] ?? '');
        if (!empty($phone) && !preg_match('/^[0-9]{10,11}$/', $phone)) {
            $errors[] = 'Số điện thoại không hợp lệ';
        }
        
        $address = trim($_POST['address'] ?? '');
        $email = trim($_POST['email'] ?? '');
        if (!empty($email) && !filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $errors[] = 'Email không hợp lệ';
        }
        
        // About section fields
        $aboutText = trim($_POST['about_text'] ?? '');
        $aboutTitle = trim($_POST['about_title'] ?? '');
        $aboutContent = trim($_POST['about_content'] ?? '');
        
        // Additional About fields
        $aboutHistoryTitle = trim($_POST['about_history_title'] ?? '');
        $aboutHistoryContent = trim($_POST['about_history_content'] ?? '');
        $aboutMissionTitle = trim($_POST['about_mission_title'] ?? '');
        $aboutMissionContent = trim($_POST['about_mission_content'] ?? '');
        $aboutVisionTitle = trim($_POST['about_vision_title'] ?? '');
        $aboutVisionContent = trim($_POST['about_vision_content'] ?? '');
        $aboutValuesTitle = trim($_POST['about_values_title'] ?? '');
        $aboutValuesContent = trim($_POST['about_values_content'] ?? '');
        $aboutAchievementsTitle = trim($_POST['about_achievements_title'] ?? '');
        $aboutAchievementsContent = trim($_POST['about_achievements_content'] ?? '');
        
        // Check for errors before proceeding
        if (!empty($errors)) {
            if ($this->isAjaxRequest()) {
                // Return JSON error response for AJAX requests
                $this->sendJsonResponse(false, implode('<br>', $errors));
            } else {
                $_SESSION['error_message'] = implode('<br>', $errors);
                header('Location: /Gear/homeadmin');
            }
            exit;
        }
        
        try {
            // Begin transaction
            $this->homeAdminModel->beginTransaction();
            
            // Initialize updateResults array
            $updateResults = [];
            
            // Only update settings that were actually included in the form submission
            if (isset($_POST['company_name'])) {
                $updateResults[] = $this->homeAdminModel->updateSetting('company_name', $companyName);
            }
            
            if (isset($_POST['phone'])) {
                $updateResults[] = $this->homeAdminModel->updateSetting('phone', $phone);
            }
            
            if (isset($_POST['address'])) {
                $updateResults[] = $this->homeAdminModel->updateSetting('address', $address);
            }
            
            if (isset($_POST['email'])) {
                $updateResults[] = $this->homeAdminModel->updateSetting('email', $email);
            }
            
            if (isset($_POST['about_text'])) {
                $updateResults[] = $this->homeAdminModel->updateSetting('about_text', $aboutText);
            }
            
            // About section settings - only update if they were part of the form
            if (isset($_POST['about_title'])) {
                $updateResults[] = $this->homeAdminModel->updateSetting('about_title', $aboutTitle);
            }
            
            if (isset($_POST['about_content'])) {
                $updateResults[] = $this->homeAdminModel->updateSetting('about_content', $aboutContent);
            }
            
            if (isset($_POST['about_history_title'])) {
                $updateResults[] = $this->homeAdminModel->updateSetting('about_history_title', $aboutHistoryTitle);
            }
            
            if (isset($_POST['about_history_content'])) {
                $updateResults[] = $this->homeAdminModel->updateSetting('about_history_content', $aboutHistoryContent);
            }
            
            if (isset($_POST['about_mission_title'])) {
                $updateResults[] = $this->homeAdminModel->updateSetting('about_mission_title', $aboutMissionTitle);
            }
            
            if (isset($_POST['about_mission_content'])) {
                $updateResults[] = $this->homeAdminModel->updateSetting('about_mission_content', $aboutMissionContent);
            }
            
            if (isset($_POST['about_vision_title'])) {
                $updateResults[] = $this->homeAdminModel->updateSetting('about_vision_title', $aboutVisionTitle);
            }
            
            if (isset($_POST['about_vision_content'])) {
                $updateResults[] = $this->homeAdminModel->updateSetting('about_vision_content', $aboutVisionContent);
            }
            
            if (isset($_POST['about_values_title'])) {
                $updateResults[] = $this->homeAdminModel->updateSetting('about_values_title', $aboutValuesTitle);
            }
            
            if (isset($_POST['about_values_content'])) {
                $updateResults[] = $this->homeAdminModel->updateSetting('about_values_content', $aboutValuesContent);
            }
            
            if (isset($_POST['about_achievements_title'])) {
                $updateResults[] = $this->homeAdminModel->updateSetting('about_achievements_title', $aboutAchievementsTitle);
            }
            
            if (isset($_POST['about_achievements_content'])) {
                $updateResults[] = $this->homeAdminModel->updateSetting('about_achievements_content', $aboutAchievementsContent);
            }
            
            if (isset($_POST['map_embed_url'])) {
                $updateResults[] = $this->homeAdminModel->updateSetting('map_embed_url', $_POST['map_embed_url']);
            }
            
            if (isset($_POST['map_url'])) {
                $updateResults[] = $this->homeAdminModel->updateSetting('map_url', $_POST['map_url']);
            }
            
            // Handle logo upload if provided
            if (isset($_FILES['logo']) && $_FILES['logo']['error'] === UPLOAD_ERR_OK) {
                // Validate file type
                $allowedTypes = ['image/jpeg', 'image/png', 'image/gif', 'image/webp'];
                $fileInfo = finfo_open(FILEINFO_MIME_TYPE);
                $detectedType = finfo_file($fileInfo, $_FILES['logo']['tmp_name']);
                finfo_close($fileInfo);
                
                if (!in_array($detectedType, $allowedTypes)) {
                    throw new Exception('Chỉ chấp nhận file hình ảnh (JPEG, PNG, GIF, WEBP)');
                }
                
                // Validate file size (5MB max)
                if ($_FILES['logo']['size'] > 5 * 1024 * 1024) {
                    throw new Exception('Kích thước file không được vượt quá 5MB');
                }
                
                $logoPath = $this->homeAdminModel->saveImage($_FILES['logo'], 'logos');
                if ($logoPath) {
                    $updateResults[] = $this->homeAdminModel->updateSetting('logo', $logoPath);
                } else {
                    throw new Exception('Không thể lưu file logo');
                }
            }
            
            // Handle about image upload if provided
            if (isset($_FILES['about_image']) && $_FILES['about_image']['error'] === UPLOAD_ERR_OK) {
                // Validate file type
                $allowedTypes = ['image/jpeg', 'image/png', 'image/gif', 'image/webp'];
                $fileInfo = finfo_open(FILEINFO_MIME_TYPE);
                $detectedType = finfo_file($fileInfo, $_FILES['about_image']['tmp_name']);
                finfo_close($fileInfo);
                
                if (!in_array($detectedType, $allowedTypes)) {
                    throw new Exception('Chỉ chấp nhận file hình ảnh (JPEG, PNG, GIF, WEBP) cho hình ảnh giới thiệu');
                }
                
                // Validate file size (5MB max)
                if ($_FILES['about_image']['size'] > 5 * 1024 * 1024) {
                    throw new Exception('Kích thước file hình ảnh giới thiệu không được vượt quá 5MB');
                }
                
                $aboutImagePath = $this->homeAdminModel->saveImage($_FILES['about_image'], 'about');
                if ($aboutImagePath) {
                    $updateResults[] = $this->homeAdminModel->updateSetting('about_image', $aboutImagePath);
                } else {
                    throw new Exception('Không thể lưu file hình ảnh giới thiệu');
                }
            }
            
            // Check if all updates were successful
            if (in_array(false, $updateResults, true)) {
                throw new Exception('Có lỗi xảy ra khi cập nhật một số cài đặt');
            }
            
            // Commit transaction
            $commitResult = $this->homeAdminModel->commit();
            if (!$commitResult) {
                throw new Exception('Không thể lưu các thay đổi');
            }
            
            // Set success message
            if ($this->isAjaxRequest()) {
                // Return JSON success response for AJAX requests
                $this->sendJsonResponse(true, 'Thông tin trang Home đã được cập nhật thành công!');
            } else {
                $_SESSION['success_message'] = 'Thông tin trang Home đã được cập nhật thành công!';
                header('Location: /Gear/homeadmin');
            }
        } catch (Exception $e) {
            // Rollback transaction
            $this->homeAdminModel->rollback();
            
            // Log error
            error_log('Error updating settings: ' . $e->getMessage());
            
            // Set error message
            if ($this->isAjaxRequest()) {
                // Return JSON error response for AJAX requests
                $this->sendJsonResponse(false, 'Lỗi: ' . $e->getMessage());
            } else {
                $_SESSION['error_message'] = 'Lỗi: ' . $e->getMessage();
                header('Location: /Gear/homeadmin');
            }
        }
        
        // This exit is only reached for non-AJAX requests
        exit;
    }

    // Manage carousel slides
    public function manageCarousel() {
        $slides = $this->homeAdminModel->getCarouselSlides();
        
        $this->view("HomeAdminView", [
            "slides" => $slides
        ]);
    }

    // Add a new carousel slide
    public function addCarouselSlide() {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            header('Location: /Gear/homeadmin');
            exit;
        }
        
        $title = trim($_POST['title'] ?? '');
        $description = trim($_POST['description'] ?? '');
        $buttonText = trim($_POST['button_text'] ?? '');
        $buttonLink = trim($_POST['button_link'] ?? '');
        $displayOrder = (int)($_POST['display_order'] ?? 0);
        
        $imagePath = '';
        if (isset($_FILES['image']) && $_FILES['image']['error'] === UPLOAD_ERR_OK) {
            $imagePath = $this->homeAdminModel->saveImage($_FILES['image'], 'carousel');
        }
        
        if (empty($imagePath)) {
            if ($this->isAjaxRequest()) {
                $this->sendJsonResponse(false, 'Vui lòng tải lên hình ảnh cho slide!');
            } else {
                $_SESSION['error_message'] = 'Vui lòng tải lên hình ảnh cho slide!';
                header('Location: /Gear/homeadmin');
            }
            exit;
        }
        
        $result = $this->homeAdminModel->addCarouselSlide($title, $description, $buttonText, $buttonLink, $imagePath, $displayOrder);
        
        if ($result) {
            if ($this->isAjaxRequest()) {
                $this->sendJsonResponse(true, 'Thêm slide mới thành công!');
            } else {
                $_SESSION['success_message'] = 'Thêm slide mới thành công!';
                header('Location: /Gear/homeadmin');
            }
        } else {
            if ($this->isAjaxRequest()) {
                $this->sendJsonResponse(false, 'Không thể thêm slide mới!');
            } else {
                $_SESSION['error_message'] = 'Không thể thêm slide mới!';
                header('Location: /Gear/homeadmin');
            }
        }
        
        exit;
    }

    // Update an existing carousel slide
    public function updateCarouselSlide() {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            header('Location: /Gear/homeadmin');
            exit;
        }
        
        $id = (int)($_POST['id'] ?? 0);
        $title = trim($_POST['title'] ?? '');
        $description = trim($_POST['description'] ?? '');
        $buttonText = trim($_POST['button_text'] ?? '');
        $buttonLink = trim($_POST['button_link'] ?? '');
        $displayOrder = (int)($_POST['display_order'] ?? 0);
        
        $imagePath = '';
        if (isset($_FILES['image']) && $_FILES['image']['error'] === UPLOAD_ERR_OK) {
            $imagePath = $this->homeAdminModel->saveImage($_FILES['image'], 'carousel');
        }
        
        $result = $this->homeAdminModel->updateCarouselSlide($id, $title, $description, $buttonText, $buttonLink, $imagePath, $displayOrder);
        
        if ($result) {
            if ($this->isAjaxRequest()) {
                $this->sendJsonResponse(true, 'Cập nhật slide thành công!');
            } else {
                $_SESSION['success_message'] = 'Cập nhật slide thành công!';
                header('Location: /Gear/homeadmin');
            }
        } else {
            if ($this->isAjaxRequest()) {
                $this->sendJsonResponse(false, 'Không thể cập nhật slide!');
            } else {
                $_SESSION['error_message'] = 'Không thể cập nhật slide!';
                header('Location: /Gear/homeadmin');
            }
        }
        
        exit;
    }

    // Delete a carousel slide
    public function deleteCarouselSlide() {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            header('Location: /Gear/homeadmin');
            exit;
        }
        
        $id = (int)($_POST['id'] ?? 0);
        
        if ($id <= 0) {
            if ($this->isAjaxRequest()) {
                $this->sendJsonResponse(false, 'ID slide không hợp lệ!');
            } else {
                $_SESSION['error_message'] = 'ID slide không hợp lệ!';
                header('Location: /Gear/homeadmin');
            }
            exit;
        }
        
        $result = $this->homeAdminModel->deleteCarouselSlide($id);
        
        if ($result) {
            if ($this->isAjaxRequest()) {
                $this->sendJsonResponse(true, 'Xóa slide thành công!');
            } else {
                $_SESSION['success_message'] = 'Xóa slide thành công!';
                header('Location: /Gear/homeadmin');
            }
        } else {
            if ($this->isAjaxRequest()) {
                $this->sendJsonResponse(false, 'Không thể xóa slide!');
            } else {
                $_SESSION['error_message'] = 'Không thể xóa slide!';
                header('Location: /Gear/homeadmin');
            }
        }
        
        exit;
    }
    
    // Helper method to check if the request is AJAX
    private function isAjaxRequest() {
        return !empty($_SERVER['HTTP_X_REQUESTED_WITH']) && 
               strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest';
    }
    
    // Helper method to send JSON responses
    private function sendJsonResponse($success, $message, $data = []) {
        // Set appropriate HTTP status code
        if (!$success) {
            http_response_code(200); // Still use 200 but with success:false in content
        }
        
        header('Content-Type: application/json');
        echo json_encode([
            'success' => $success,
            'message' => $message,
            'data' => $data
        ]);
        exit;
    }
} 