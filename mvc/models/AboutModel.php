<?php
class AboutModel {
    private $conn;
    
    public function __construct() {
        // Kết nối database với MySQLi
        $host = 'localhost';
        $dbname = 'gear';
        $username = 'root';
        $password = '';
        
        $this->conn = new mysqli($host, $username, $password, $dbname);
        
        // Kiểm tra kết nối
        if ($this->conn->connect_error) {
            die("Connection failed: " . $this->conn->connect_error);
        }
    }
    
    // Hàm lấy nội dung đơn lẻ từ page_content
    public function getContent($section_name, $key) {
        $section_name = $this->conn->real_escape_string($section_name);
        $key = $this->conn->real_escape_string($key);
        
        $query = "
            SELECT pc.content 
            FROM page_content pc
            JOIN page_sections ps ON pc.section_id = ps.id
            WHERE ps.name = '$section_name' AND pc.`key` = '$key'
        ";
        
        $result = $this->conn->query($query);
        if ($result && $result->num_rows > 0) {
            $row = $result->fetch_assoc();
            return $row['content'];
        }
        return '';
    }
    
    // Lấy dữ liệu cho Our Story
    public function getOurStory() {
        return [
            'paragraph_1' => $this->getContent('our_story', 'paragraph_1'),
            'paragraph_2' => $this->getContent('our_story', 'paragraph_2'),
            'banner_image' => $this->getContent('our_story', 'banner_image')
        ];
    }
    
    // Lấy dữ liệu cho Mission & Values
    public function getMissionValues() {
        return [
            'quality_title' => $this->getContent('mission_values', 'quality_title'),
            'quality_item_1' => $this->getContent('mission_values', 'quality_item_1'),
            'quality_item_2' => $this->getContent('mission_values', 'quality_item_2'),
            'quality_item_3' => $this->getContent('mission_values', 'quality_item_3'),
            'satisfaction_title' => $this->getContent('mission_values', 'satisfaction_title'),
            'satisfaction_item_1' => $this->getContent('mission_values', 'satisfaction_item_1'),
            'satisfaction_item_2' => $this->getContent('mission_values', 'satisfaction_item_2'),
            'satisfaction_item_3' => $this->getContent('mission_values', 'satisfaction_item_3'),
            'innovation_title' => $this->getContent('mission_values', 'innovation_title'),
            'innovation_item_1' => $this->getContent('mission_values', 'innovation_item_1'),
            'innovation_item_2' => $this->getContent('mission_values', 'innovation_item_2'),
            'innovation_item_3' => $this->getContent('mission_values', 'innovation_item_3')
        ];
    }
    
    // Lấy dữ liệu cho Our Product Categories
    public function getProductCategories() {
        $query = "
            SELECT pc.* 
            FROM product_categories pc
            JOIN page_sections ps ON pc.section_id = ps.id
            WHERE ps.name = 'product_categories'
            ORDER BY pc.display_order ASC
        ";
        $result = $this->conn->query($query);
        $product_categories = [];
        if ($result && $result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $product_categories[] = $row;
            }
        }
        return $product_categories;
    }
    
    // Lấy dữ liệu cho Stats Section
    public function getStats() {
        $query = "
            SELECT s.* 
            FROM stats s
            JOIN page_sections ps ON s.section_id = ps.id
            WHERE ps.name = 'stats'
            ORDER BY s.display_order ASC
        ";
        $result = $this->conn->query($query);
        $stats = [];
        if ($result && $result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $stats[] = $row;
            }
        }
        return $stats;
    }
    
    // Lấy dữ liệu cho Our Journey
    public function getJourneyItems() {
        $query = "
            SELECT ji.* 
            FROM journey_items ji
            JOIN page_sections ps ON ji.section_id = ps.id
            WHERE ps.name = 'journey'
            ORDER BY ji.display_order ASC
        ";
        $result = $this->conn->query($query);
        $journey_items = [];
        if ($result && $result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $journey_items[] = $row;
            }
        }
        return $journey_items;
    }
    
    // Lấy dữ liệu cho Our Team
    public function getTeamMembers() {
        $query = "
            SELECT tm.* 
            FROM team_members tm
            JOIN page_sections ps ON tm.section_id = ps.id
            WHERE ps.name = 'team'
            ORDER BY tm.display_order ASC
        ";
        $result = $this->conn->query($query);
        $team_members = [];
        if ($result && $result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $team_members[] = $row;
            }
        }
        return $team_members;
    }
    
    // Lấy tất cả dữ liệu cho AboutView
    public function getAllAboutData() {
        return [
            'our_story' => $this->getOurStory(),
            'mission_values' => $this->getMissionValues(),
            'product_categories' => $this->getProductCategories(),
            'stats' => $this->getStats(),
            'journey_items' => $this->getJourneyItems(),
            'team_members' => $this->getTeamMembers()
        ];
    }
    
    public function __destruct() {
        // Đóng kết nối khi đối tượng bị hủy
        if ($this->conn) {
            $this->conn->close();
        }
    }
} 