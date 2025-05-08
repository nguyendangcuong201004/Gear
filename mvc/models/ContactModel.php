<?php
class ContactModel {
    private $db;

    public function __construct() {
        $this->db = new Database();
    }

    
    // Lưu tin nhắn liên hệ mới
    public function saveContactMessage($name, $email, $subject, $phone, $message, $newsletter) {
        // Đảm bảo bảng đã được tạo
        
        
        // Chuẩn bị dữ liệu
        $name = mysqli_real_escape_string($this->db->con, $name);
        $email = mysqli_real_escape_string($this->db->con, $email);
        $subject = mysqli_real_escape_string($this->db->con, $subject);
        $phone = mysqli_real_escape_string($this->db->con, $phone);
        $message = mysqli_real_escape_string($this->db->con, $message);
        $newsletter = (int)$newsletter;
        
        // Chèn dữ liệu
        $query = "INSERT INTO contact_messages (name, email, subject, phone, message, newsletter) 
                  VALUES ('$name', '$email', '$subject', '$phone', '$message', $newsletter)";
        
        $result = mysqli_query($this->db->con, $query);
        
        return $result;
    }
} 