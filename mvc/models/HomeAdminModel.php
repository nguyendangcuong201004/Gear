<?php
class HomeAdminModel {
    private $db;

    public function __construct() {
        $this->db = new Database();
    }

    // Get all site settings
    public function getSiteSettings() {
        $query = "SELECT * FROM site_settings";
        $result = mysqli_query($this->db->con, $query);
        $settings = [];
        
        if ($result) {
            while ($row = mysqli_fetch_assoc($result)) {
                $settings[$row['setting_key']] = $row['setting_value'];
            }
        }
        
        return $settings;
    }

    // Update a single site setting
    public function updateSetting($key, $value) {
        try {
            // Validate inputs
            if (empty($key)) {
                return false;
            }
            
            // Properly escape the key for the SELECT query
            $key_escaped = mysqli_real_escape_string($this->db->con, $key);
            
            // Check if setting exists first
            $checkQuery = "SELECT * FROM site_settings WHERE setting_key = '$key_escaped'";
            $checkResult = mysqli_query($this->db->con, $checkQuery);
            
            if (!$checkResult) {
                throw new Exception("Database error on check: " . mysqli_error($this->db->con));
            }
            
            if (mysqli_num_rows($checkResult) > 0) {
                // Update existing setting
                $stmt = $this->db->con->prepare("UPDATE site_settings SET setting_value = ? WHERE setting_key = ?");
                if (!$stmt) {
                    throw new Exception("Prepare failed for UPDATE: " . $this->db->con->error);
                }
                $stmt->bind_param("ss", $value, $key);
            } else {
                // Insert new setting
                $stmt = $this->db->con->prepare("INSERT INTO site_settings (setting_key, setting_value) VALUES (?, ?)");
                if (!$stmt) {
                    throw new Exception("Prepare failed for INSERT: " . $this->db->con->error);
                }
                $stmt->bind_param("ss", $key, $value);
            }
            
            $updateResult = $stmt->execute();
            $stmt->close();
            
            if (!$updateResult) {
                throw new Exception("Database error on execute: " . $this->db->con->error);
            }
            
            return true;
        } catch (Exception $e) {
            // Log error
            error_log("Error updating setting: " . $e->getMessage());
            return false;
        }
    }

    // Upload and save an image
    public function saveImage($file, $destination = '') {
        try {
            // Validate inputs
            if (!isset($file) || !is_array($file)) {
                return false;
            }
            
            // Set default destination if not provided
            if (empty($destination)) {
                $destination = 'carousel';
            }
            
            // Sanitize destination folder name
            $destination = preg_replace('/[^a-zA-Z0-9_-]/', '', $destination);
            $targetDir = "public/images/" . $destination . "/";
            
            // Check if directory exists, if not create it
            if (!file_exists($targetDir)) {
                if (!mkdir($targetDir, 0755, true)) {
                    throw new Exception("Unable to create directory: $targetDir");
                }
            }
            
            // Validate file
            if (!isset($file['tmp_name']) || !is_uploaded_file($file['tmp_name'])) {
                throw new Exception("Invalid file upload");
            }
            
            // Validate file type using finfo
            $allowedTypes = ['image/jpeg', 'image/png', 'image/gif', 'image/webp'];
            $fileInfo = finfo_open(FILEINFO_MIME_TYPE);
            $detectedType = finfo_file($fileInfo, $file['tmp_name']);
            finfo_close($fileInfo);
            
            if (!in_array($detectedType, $allowedTypes)) {
                throw new Exception("Invalid file type: $detectedType");
            }
            
            // Get file extension based on MIME type
            $extensions = [
                'image/jpeg' => 'jpg',
                'image/png' => 'png',
                'image/gif' => 'gif',
                'image/webp' => 'webp'
            ];
            
            $fileExtension = $extensions[$detectedType];
            
            // Generate a unique filename with a cryptographically secure random value
            $newFilename = bin2hex(random_bytes(8)) . '_' . time() . '.' . $fileExtension;
            $targetFile = $targetDir . $newFilename;
            
            // Move uploaded file to target directory
            if (!move_uploaded_file($file['tmp_name'], $targetFile)) {
                throw new Exception("Failed to move uploaded file");
            }
            
            // Set appropriate permissions
            chmod($targetFile, 0644);
            
            // For carousel, about, and logo images, return just the filename
            if ($destination === 'carousel' || $destination === 'about' || $destination === 'logos') {
                return $newFilename;
            }
            
            // For other images, return the relative path
            return str_replace("public/images/", "", $targetFile);
        } catch (Exception $e) {
            // Log error
            error_log("Error saving image: " . $e->getMessage());
            return false;
        }
    }

    // Get carousel slides
    public function getCarouselSlides() {
        $query = "SELECT * FROM carousel_slides WHERE deleted = FALSE ORDER BY display_order";
        $result = mysqli_query($this->db->con, $query);
        $slides = [];
        
        if ($result) {
            while ($row = mysqli_fetch_assoc($result)) {
                $slides[] = $row;
            }
        }
        
        return $slides;
    }

    // Add a new carousel slide
    public function addCarouselSlide($title, $description, $buttonText, $buttonLink, $image, $displayOrder) {
        $title = mysqli_real_escape_string($this->db->con, $title);
        $description = mysqli_real_escape_string($this->db->con, $description);
        $buttonText = mysqli_real_escape_string($this->db->con, $buttonText);
        $buttonLink = mysqli_real_escape_string($this->db->con, $buttonLink);
        $image = mysqli_real_escape_string($this->db->con, $image);
        $displayOrder = (int)$displayOrder;
        
        $query = "INSERT INTO carousel_slides (title, description, button_text, button_link, image_url, display_order, created_at, updated_at) 
                  VALUES ('$title', '$description', '$buttonText', '$buttonLink', '$image', $displayOrder, NOW(), NOW())";
        
        return mysqli_query($this->db->con, $query);
    }

    // Update an existing carousel slide
    public function updateCarouselSlide($id, $title, $description, $buttonText, $buttonLink, $image, $displayOrder) {
        $id = (int)$id;
        $title = mysqli_real_escape_string($this->db->con, $title);
        $description = mysqli_real_escape_string($this->db->con, $description);
        $buttonText = mysqli_real_escape_string($this->db->con, $buttonText);
        $buttonLink = mysqli_real_escape_string($this->db->con, $buttonLink);
        $displayOrder = (int)$displayOrder;
        
        $imageClause = "";
        if (!empty($image)) {
            $image = mysqli_real_escape_string($this->db->con, $image);
            $imageClause = ", image_url = '$image'";
        }
        
        $query = "UPDATE carousel_slides 
                  SET title = '$title', description = '$description', 
                      button_text = '$buttonText', button_link = '$buttonLink', 
                      display_order = $displayOrder, updated_at = NOW()
                      $imageClause
                  WHERE id = $id";
        
        return mysqli_query($this->db->con, $query);
    }

    // Delete a carousel slide
    public function deleteCarouselSlide($id) {
        $id = (int)$id;
        $query = "UPDATE carousel_slides SET deleted = TRUE, updated_at = NOW() WHERE id = $id";
        return mysqli_query($this->db->con, $query);
    }

    // Begin a database transaction
    public function beginTransaction() {
        // Disable autocommit
        mysqli_autocommit($this->db->con, false);
    }
    
    // Commit a database transaction
    public function commit() {
        if (mysqli_commit($this->db->con)) {
            mysqli_autocommit($this->db->con, true);
            return true;
        }
        return false;
    }
    
    // Rollback a database transaction
    public function rollback() {
        if (mysqli_rollback($this->db->con)) {
            mysqli_autocommit($this->db->con, true);
            return true;
        }
        return false;
    }
} 