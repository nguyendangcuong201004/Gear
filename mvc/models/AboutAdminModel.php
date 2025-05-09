<?php
class AboutAdminModel
{
    private $conn;

    // Constructor - connects to database
    public function __construct()
    {
        $host = 'localhost';
        $dbname = 'gear';
        $username = 'root';
        $password = '';

        $this->conn = new mysqli($host, $username, $password, $dbname);

        // Check connection
        if ($this->conn->connect_error) {
            die("Connection failed: " . $this->conn->connect_error);
        }
    }

    // Destructor - closes database connection
    public function __destruct()
    {
        if ($this->conn) {
            $this->conn->close();
        }
    }

    // Function to update content in database
    public function updateContent($section_name, $key, $content)
    {
        $section_name = $this->conn->real_escape_string($section_name);
        $key = $this->conn->real_escape_string($key);
        $content = $this->conn->real_escape_string($content);
        
        $query = "
            UPDATE page_content pc
            JOIN page_sections ps ON pc.section_id = ps.id
            SET pc.content = '$content'
            WHERE ps.name = '$section_name' AND pc.`key` = '$key'
        ";
        
        return $this->conn->query($query);
    }

    // Function to get content from database
    public function getContent($section_name, $key)
    {
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

    // Our Story section methods
    public function updateOurStory($paragraph1, $paragraph2, $current_banner_image, $new_banner_image = null)
    {
        $banner_image = $current_banner_image;
        $message = null;
        
        // Process banner image if uploaded
        if ($new_banner_image && $new_banner_image['error'] == 0) {
            $upload_dir = "public/uploads/about/";
            
            // Create directory if it doesn't exist
            if (!file_exists($upload_dir)) {
                mkdir($upload_dir, 0777, true);
            }
            
            // Create unique filename
            $file_name = time() . '_' . basename($new_banner_image['name']);
            $target_file = $upload_dir . $file_name;
            
            // Upload file
            if (move_uploaded_file($new_banner_image['tmp_name'], $target_file)) {
                // Delete old image if exists and not default
                if (!empty($banner_image) && file_exists($banner_image) && strpos($banner_image, 'public/uploads/about/') === 0) {
                    @unlink($banner_image);
                }
                $banner_image = $target_file;
            } else {
                $message = "Error uploading banner image. Other changes were saved.";
            }
        }
        
        $this->updateContent('our_story', 'paragraph_1', $paragraph1);
        $this->updateContent('our_story', 'paragraph_2', $paragraph2);
        $this->updateContent('our_story', 'banner_image', $banner_image);
        
        return isset($message) ? $message : "Our Story section updated successfully!";
    }

    // Mission & Values section methods
    public function updateMissionValues($data)
    {
        $this->updateContent('mission_values', 'quality_title', $data['quality_title']);
        $this->updateContent('mission_values', 'quality_item_1', $data['quality_item_1']);
        $this->updateContent('mission_values', 'quality_item_2', $data['quality_item_2']);
        $this->updateContent('mission_values', 'quality_item_3', $data['quality_item_3']);
        
        $this->updateContent('mission_values', 'satisfaction_title', $data['satisfaction_title']);
        $this->updateContent('mission_values', 'satisfaction_item_1', $data['satisfaction_item_1']);
        $this->updateContent('mission_values', 'satisfaction_item_2', $data['satisfaction_item_2']);
        $this->updateContent('mission_values', 'satisfaction_item_3', $data['satisfaction_item_3']);
        
        $this->updateContent('mission_values', 'innovation_title', $data['innovation_title']);
        $this->updateContent('mission_values', 'innovation_item_1', $data['innovation_item_1']);
        $this->updateContent('mission_values', 'innovation_item_2', $data['innovation_item_2']);
        $this->updateContent('mission_values', 'innovation_item_3', $data['innovation_item_3']);
        
        return "Mission & Values section updated successfully!";
    }

    // Product Category methods
    public function addProductCategory($title, $description, $image, $display_order)
    {
        // Get section_id for product_categories
        $query = "SELECT id FROM page_sections WHERE name = 'product_categories'";
        $result = $this->conn->query($query);
        
        if ($result && $result->num_rows > 0) {
            $row = $result->fetch_assoc();
            $section_id = $row['id'];
            
            // Upload image
            $upload_dir = "public/uploads/about/";
            if (!file_exists($upload_dir)) {
                mkdir($upload_dir, 0777, true);
            }
            $file_name = time() . '_' . basename($image['name']);
            $target_file = $upload_dir . $file_name;
            if (move_uploaded_file($image['tmp_name'], $target_file)) {
                $image_url = $target_file;
            } else {
                $image_url = '';
            }
            
            // Insert new category
            $query = "INSERT INTO product_categories (section_id, title, description, image_url, display_order) 
                      VALUES (?, ?, ?, ?, ?)";
            $stmt = $this->conn->prepare($query);
            $stmt->bind_param("isssi", $section_id, $title, $description, $image_url, $display_order);
            $stmt->execute();
            $stmt->close();
            
            return "Product Category added successfully!";
        }
        
        return "Error: Section not found";
    }

    public function updateProductCategory($id, $title, $description, $image, $current_image_url, $display_order)
    {
        // Upload image if provided
        $image_url = $current_image_url;
        
        if ($image && $image['error'] == 0) {
            $upload_dir = "public/uploads/about/";
            if (!file_exists($upload_dir)) {
                mkdir($upload_dir, 0777, true);
            }
            $file_name = time() . '_' . basename($image['name']);
            $target_file = $upload_dir . $file_name;
            if (move_uploaded_file($image['tmp_name'], $target_file)) {
                $image_url = $target_file;
            }
        }
        
        // Update category
        $query = "UPDATE product_categories 
                  SET title = ?, description = ?, image_url = ?, display_order = ?
                  WHERE id = ?";
        $stmt = $this->conn->prepare($query);
        $stmt->bind_param("sssii", $title, $description, $image_url, $display_order, $id);
        $stmt->execute();
        $stmt->close();
        
        return "Product Category updated successfully!";
    }

    // Stats methods
    public function addStat($label, $number, $display_order)
    {
        // Get section_id for stats
        $query = "SELECT id FROM page_sections WHERE name = 'stats'";
        $result = $this->conn->query($query);
        
        if ($result && $result->num_rows > 0) {
            $row = $result->fetch_assoc();
            $section_id = $row['id'];
            
            // Insert new stat
            $query = "INSERT INTO stats (section_id, label, number, display_order) 
                      VALUES (?, ?, ?, ?)";
            $stmt = $this->conn->prepare($query);
            $stmt->bind_param("isii", $section_id, $label, $number, $display_order);
            $stmt->execute();
            $stmt->close();
            
            return "Stat added successfully!";
        }
        
        return "Error: Section not found";
    }

    public function updateStat($id, $label, $number, $display_order)
    {
        // Update stat
        $query = "UPDATE stats 
                  SET label = ?, number = ?, display_order = ?
                  WHERE id = ?";
        $stmt = $this->conn->prepare($query);
        $stmt->bind_param("siii", $label, $number, $display_order, $id);
        $stmt->execute();
        $stmt->close();
        
        return "Stat updated successfully!";
    }

    // Journey methods
    public function addJourneyItem($year, $description, $display_order)
    {
        // Get section_id for journey
        $query = "SELECT id FROM page_sections WHERE name = 'journey'";
        $result = $this->conn->query($query);
        
        if ($result && $result->num_rows > 0) {
            $row = $result->fetch_assoc();
            $section_id = $row['id'];
            
            // Insert new journey item
            $query = "INSERT INTO journey_items (section_id, year, description, display_order) 
                      VALUES (?, ?, ?, ?)";
            $stmt = $this->conn->prepare($query);
            $stmt->bind_param("issi", $section_id, $year, $description, $display_order);
            $stmt->execute();
            $stmt->close();
            
            return "Journey item added successfully!";
        }
        
        return "Error: Section not found";
    }

    public function updateJourneyItem($id, $year, $description, $display_order)
    {
        // Update journey item
        $query = "UPDATE journey_items 
                  SET year = ?, description = ?, display_order = ?
                  WHERE id = ?";
        $stmt = $this->conn->prepare($query);
        $stmt->bind_param("ssii", $year, $description, $display_order, $id);
        $stmt->execute();
        $stmt->close();
        
        return "Journey item updated successfully!";
    }

    // Team Member methods
    public function addTeamMember($name, $role, $info, $image, $display_order)
    {
        // Get section_id for team
        $query = "SELECT id FROM page_sections WHERE name = 'team'";
        $result = $this->conn->query($query);
        
        if ($result && $result->num_rows > 0) {
            $row = $result->fetch_assoc();
            $section_id = $row['id'];
            
            // Upload image
            $upload_dir = "public/uploads/about/team/";
            if (!file_exists($upload_dir)) {
                mkdir($upload_dir, 0777, true);
            }
            $file_name = time() . '_' . basename($image['name']);
            $target_file = $upload_dir . $file_name;
            if (move_uploaded_file($image['tmp_name'], $target_file)) {
                $image_url = $target_file;
            } else {
                $image_url = '';
            }
            
            // Insert new team member
            $query = "INSERT INTO team_members (section_id, name, role, info, image_url, display_order) 
                      VALUES (?, ?, ?, ?, ?, ?)";
            $stmt = $this->conn->prepare($query);
            $stmt->bind_param("issssi", $section_id, $name, $role, $info, $image_url, $display_order);
            $stmt->execute();
            $stmt->close();
            
            return "Team member added successfully!";
        }
        
        return "Error: Section not found";
    }

    public function updateTeamMember($id, $name, $role, $info, $image, $current_image_url, $display_order)
    {
        // Upload image if provided
        $image_url = $current_image_url;
        
        if ($image && $image['error'] == 0) {
            $upload_dir = "public/uploads/about/team/";
            if (!file_exists($upload_dir)) {
                mkdir($upload_dir, 0777, true);
            }
            $file_name = time() . '_' . basename($image['name']);
            $target_file = $upload_dir . $file_name;
            if (move_uploaded_file($image['tmp_name'], $target_file)) {
                $image_url = $target_file;
            }
        }
        
        // Update team member
        $query = "UPDATE team_members 
                  SET name = ?, role = ?, info = ?, image_url = ?, display_order = ?
                  WHERE id = ?";
        $stmt = $this->conn->prepare($query);
        $stmt->bind_param("ssssii", $name, $role, $info, $image_url, $display_order, $id);
        $stmt->execute();
        $stmt->close();
        
        return "Team member updated successfully!";
    }

    // Delete operations
    public function deleteItem($id, $item_type)
    {
        if ($item_type === 'product_category') {
            $query = "DELETE FROM product_categories WHERE id = ?";
            $success_message = "Product category deleted successfully!";
        } else if ($item_type === 'stat') {
            $query = "DELETE FROM stats WHERE id = ?";
            $success_message = "Stat deleted successfully!";
        } else if ($item_type === 'journey') {
            $query = "DELETE FROM journey_items WHERE id = ?";
            $success_message = "Journey item deleted successfully!";
        } else if ($item_type === 'team') {
            $query = "DELETE FROM team_members WHERE id = ?";
            $success_message = "Team member deleted successfully!";
        } else {
            return "Invalid item type specified";
        }
        
        $stmt = $this->conn->prepare($query);
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $stmt->close();
        
        return $success_message;
    }

    // Get data for display in forms
    public function getOurStoryData()
    {
        $data = [];
        $data['paragraph_1'] = $this->getContent('our_story', 'paragraph_1');
        $data['paragraph_2'] = $this->getContent('our_story', 'paragraph_2');
        $data['banner_image'] = $this->getContent('our_story', 'banner_image');
        return $data;
    }

    public function getMissionValuesData()
    {
        $data = [];
        $data['quality_title'] = $this->getContent('mission_values', 'quality_title');
        $data['quality_item_1'] = $this->getContent('mission_values', 'quality_item_1');
        $data['quality_item_2'] = $this->getContent('mission_values', 'quality_item_2');
        $data['quality_item_3'] = $this->getContent('mission_values', 'quality_item_3');
        
        $data['satisfaction_title'] = $this->getContent('mission_values', 'satisfaction_title');
        $data['satisfaction_item_1'] = $this->getContent('mission_values', 'satisfaction_item_1');
        $data['satisfaction_item_2'] = $this->getContent('mission_values', 'satisfaction_item_2');
        $data['satisfaction_item_3'] = $this->getContent('mission_values', 'satisfaction_item_3');
        
        $data['innovation_title'] = $this->getContent('mission_values', 'innovation_title');
        $data['innovation_item_1'] = $this->getContent('mission_values', 'innovation_item_1');
        $data['innovation_item_2'] = $this->getContent('mission_values', 'innovation_item_2');
        $data['innovation_item_3'] = $this->getContent('mission_values', 'innovation_item_3');
        
        return $data;
    }

    public function getProductCategories()
    {
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

    public function getStats()
    {
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

    public function getJourneyItems()
    {
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

    public function getTeamMembers()
    {
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

    public function getAllAboutData()
    {
        $data = [];
        $data['our_story'] = $this->getOurStoryData();
        $data['mission_values'] = $this->getMissionValuesData();
        $data['product_categories'] = $this->getProductCategories();
        $data['stats'] = $this->getStats();
        $data['journey_items'] = $this->getJourneyItems();
        $data['team_members'] = $this->getTeamMembers();
        return $data;
    }
} 