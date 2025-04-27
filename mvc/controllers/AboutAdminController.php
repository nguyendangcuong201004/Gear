<?php
class AboutAdminController {
    private $conn;
    
    public function __construct() {
        // Database connection
        $host = 'localhost';
        $dbname = 'gear';
        $username = 'root';
        $password = '';
        
        $this->conn = new mysqli($host, $username, $password, $dbname);
        
        if ($this->conn->connect_error) {
            die("Connection failed: " . $this->conn->connect_error);
        }
        
        // Check if user is admin
        session_start();
        if (!isset($_SESSION['user_role']) || $_SESSION['user_role'] !== 'admin') {
            header("Location: /Gear/login");
            exit;
        }
    }
    
    public function index() {
        // Load the admin view
        require_once 'mvc/views/AboutViewAdmin.php';
    }
    
    // Content Update Methods
    
    // Product Categories
    public function addProductCategory() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $title = $this->conn->real_escape_string($_POST['title']);
            $description = $this->conn->real_escape_string($_POST['description']);
            $image_url = $this->conn->real_escape_string($_POST['image_url']);
            $display_order = (int)$_POST['display_order'];
            
            // Get section_id for product_categories
            $query = "SELECT id FROM page_sections WHERE name = 'product_categories'";
            $result = $this->conn->query($query);
            $row = $result->fetch_assoc();
            $section_id = $row['id'];
            
            $query = "INSERT INTO product_categories (section_id, title, description, image_url, display_order) 
                      VALUES ('$section_id', '$title', '$description', '$image_url', '$display_order')";
            
            if ($this->conn->query($query)) {
                header("Location: /Gear/AboutAdminController/index?status=success&message=Product category added successfully");
            } else {
                header("Location: /Gear/AboutAdminController/index?status=error&message=Failed to add product category");
            }
        }
    }
    
    public function updateProductCategory() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $id = (int)$_POST['id'];
            $title = $this->conn->real_escape_string($_POST['title']);
            $description = $this->conn->real_escape_string($_POST['description']);
            $image_url = $this->conn->real_escape_string($_POST['image_url']);
            $display_order = (int)$_POST['display_order'];
            
            $query = "UPDATE product_categories 
                      SET title = '$title', description = '$description', image_url = '$image_url', display_order = '$display_order' 
                      WHERE id = $id";
            
            if ($this->conn->query($query)) {
                header("Location: /Gear/AboutAdminController/index?status=success&message=Product category updated successfully");
            } else {
                header("Location: /Gear/AboutAdminController/index?status=error&message=Failed to update product category");
            }
        }
    }
    
    public function deleteProductCategory() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $id = (int)$_POST['id'];
            
            $query = "DELETE FROM product_categories WHERE id = $id";
            
            if ($this->conn->query($query)) {
                header("Location: /Gear/AboutAdminController/index?status=success&message=Product category deleted successfully");
            } else {
                header("Location: /Gear/AboutAdminController/index?status=error&message=Failed to delete product category");
            }
        }
    }
    
    // Stats
    public function addStat() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $label = $this->conn->real_escape_string($_POST['label']);
            $number = (int)$_POST['number'];
            $display_order = (int)$_POST['display_order'];
            
            // Get section_id for stats
            $query = "SELECT id FROM page_sections WHERE name = 'stats'";
            $result = $this->conn->query($query);
            $row = $result->fetch_assoc();
            $section_id = $row['id'];
            
            $query = "INSERT INTO stats (section_id, label, number, display_order) 
                      VALUES ('$section_id', '$label', '$number', '$display_order')";
            
            if ($this->conn->query($query)) {
                header("Location: /Gear/AboutAdminController/index?status=success&message=Stat added successfully");
            } else {
                header("Location: /Gear/AboutAdminController/index?status=error&message=Failed to add stat");
            }
        }
    }
    
    public function updateStat() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $id = (int)$_POST['id'];
            $label = $this->conn->real_escape_string($_POST['label']);
            $number = (int)$_POST['number'];
            $display_order = (int)$_POST['display_order'];
            
            $query = "UPDATE stats 
                      SET label = '$label', number = '$number', display_order = '$display_order' 
                      WHERE id = $id";
            
            if ($this->conn->query($query)) {
                header("Location: /Gear/AboutAdminController/index?status=success&message=Stat updated successfully");
            } else {
                header("Location: /Gear/AboutAdminController/index?status=error&message=Failed to update stat");
            }
        }
    }
    
    public function deleteStat() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $id = (int)$_POST['id'];
            
            $query = "DELETE FROM stats WHERE id = $id";
            
            if ($this->conn->query($query)) {
                header("Location: /Gear/AboutAdminController/index?status=success&message=Stat deleted successfully");
            } else {
                header("Location: /Gear/AboutAdminController/index?status=error&message=Failed to delete stat");
            }
        }
    }
    
    // Journey Items
    public function addJourney() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $year = $this->conn->real_escape_string($_POST['year']);
            $description = $this->conn->real_escape_string($_POST['description']);
            $display_order = (int)$_POST['display_order'];
            
            // Get section_id for journey
            $query = "SELECT id FROM page_sections WHERE name = 'journey'";
            $result = $this->conn->query($query);
            $row = $result->fetch_assoc();
            $section_id = $row['id'];
            
            $query = "INSERT INTO journey_items (section_id, year, description, display_order) 
                      VALUES ('$section_id', '$year', '$description', '$display_order')";
            
            if ($this->conn->query($query)) {
                header("Location: /Gear/AboutAdminController/index?status=success&message=Journey item added successfully");
            } else {
                header("Location: /Gear/AboutAdminController/index?status=error&message=Failed to add journey item");
            }
        }
    }
    
    public function updateJourney() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $id = (int)$_POST['id'];
            $year = $this->conn->real_escape_string($_POST['year']);
            $description = $this->conn->real_escape_string($_POST['description']);
            $display_order = (int)$_POST['display_order'];
            
            $query = "UPDATE journey_items 
                      SET year = '$year', description = '$description', display_order = '$display_order' 
                      WHERE id = $id";
            
            if ($this->conn->query($query)) {
                header("Location: /Gear/AboutAdminController/index?status=success&message=Journey item updated successfully");
            } else {
                header("Location: /Gear/AboutAdminController/index?status=error&message=Failed to update journey item");
            }
        }
    }
    
    public function deleteJourney() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $id = (int)$_POST['id'];
            
            $query = "DELETE FROM journey_items WHERE id = $id";
            
            if ($this->conn->query($query)) {
                header("Location: /Gear/AboutAdminController/index?status=success&message=Journey item deleted successfully");
            } else {
                header("Location: /Gear/AboutAdminController/index?status=error&message=Failed to delete journey item");
            }
        }
    }
    
    // Team Members
    public function addTeam() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $name = $this->conn->real_escape_string($_POST['name']);
            $role = $this->conn->real_escape_string($_POST['role']);
            $info = $this->conn->real_escape_string($_POST['info']);
            $image_url = $this->conn->real_escape_string($_POST['image_url']);
            $display_order = (int)$_POST['display_order'];
            
            // Get section_id for team
            $query = "SELECT id FROM page_sections WHERE name = 'team'";
            $result = $this->conn->query($query);
            $row = $result->fetch_assoc();
            $section_id = $row['id'];
            
            $query = "INSERT INTO team_members (section_id, name, role, info, image_url, display_order) 
                      VALUES ('$section_id', '$name', '$role', '$info', '$image_url', '$display_order')";
            
            if ($this->conn->query($query)) {
                header("Location: /Gear/AboutAdminController/index?status=success&message=Team member added successfully");
            } else {
                header("Location: /Gear/AboutAdminController/index?status=error&message=Failed to add team member");
            }
        }
    }
    
    public function updateTeam() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $id = (int)$_POST['id'];
            $name = $this->conn->real_escape_string($_POST['name']);
            $role = $this->conn->real_escape_string($_POST['role']);
            $info = $this->conn->real_escape_string($_POST['info']);
            $image_url = $this->conn->real_escape_string($_POST['image_url']);
            $display_order = (int)$_POST['display_order'];
            
            $query = "UPDATE team_members 
                      SET name = '$name', role = '$role', info = '$info', 
                          image_url = '$image_url', display_order = '$display_order' 
                      WHERE id = $id";
            
            if ($this->conn->query($query)) {
                header("Location: /Gear/AboutAdminController/index?status=success&message=Team member updated successfully");
            } else {
                header("Location: /Gear/AboutAdminController/index?status=error&message=Failed to update team member");
            }
        }
    }
    
    public function deleteTeam() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $id = (int)$_POST['id'];
            
            $query = "DELETE FROM team_members WHERE id = $id";
            
            if ($this->conn->query($query)) {
                header("Location: /Gear/AboutAdminController/index?status=success&message=Team member deleted successfully");
            } else {
                header("Location: /Gear/AboutAdminController/index?status=error&message=Failed to delete team member");
            }
        }
    }
} 