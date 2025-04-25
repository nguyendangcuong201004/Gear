<?php
class HomeModel {
    private $db;

    public function __construct() {
        $this->db = new Database();
    }

    // Get featured products
    public function getFeaturedProducts() {
        $query = "SELECT p.*, c.title as category_name 
                FROM products p 
                JOIN products_categories pc ON p.id = pc.product_id 
                JOIN categories c ON pc.category_id = c.id 
                WHERE p.deleted = FALSE AND p.status = 'active'
                ORDER BY p.created_at DESC
                LIMIT 10";
                
        $result = mysqli_query($this->db->con, $query);
        $products = [];
        
        if ($result) {
            while ($row = mysqli_fetch_assoc($result)) {
                $row['images'] = $this->getFirstImageUrl($row['images']);
                $products[] = $row;
            }
        }
        
        return $products;
    }

    // Get products by category
    public function getProductsByCategory($categoryId) {
        $categoryId = mysqli_real_escape_string($this->db->con, $categoryId);
        
        $query = "SELECT p.*, c.title as category_name 
                FROM products p 
                JOIN products_categories pc ON p.id = pc.product_id 
                JOIN categories c ON pc.category_id = c.id 
                WHERE pc.category_id = '$categoryId' AND p.deleted = FALSE
                ORDER BY p.created_at DESC
                LIMIT 10";
                
        $result = mysqli_query($this->db->con, $query);
        $products = [];
        
        if ($result) {
            while ($row = mysqli_fetch_assoc($result)) {
                $row['images'] = $this->getFirstImageUrl($row['images']);
                $products[] = $row;
            }
        }
        
        return $products;
    }

    // Helper function to extract the first image URL from images data
    private function getFirstImageUrl($imagesData) {
        // Try to decode as JSON first
        $decoded = json_decode($imagesData, true);
        
        if (is_array($decoded) && !empty($decoded)) {
            // If it's a JSON array, get the first element
            return $decoded[0];
        } elseif (is_string($imagesData) && !empty($imagesData)) {
            // If it's a string but not valid JSON, it might be a direct URL or comma-separated list
            if (strpos($imagesData, ',') !== false) {
                // If it's comma-separated, get the first one
                $images = explode(',', $imagesData);
                return trim($images[0]);
            }
            // Return as is if it appears to be a direct URL
            return $imagesData;
        }
        
        // Fallback to a default image
        return 'images/default-product.jpg';
    }

    // Get all categories
    public function getAllCategories() {
        $query = "SELECT * FROM categories WHERE deleted = FALSE";
        $result = mysqli_query($this->db->con, $query);
        $categories = [];
        
        if ($result) {
            while ($row = mysqli_fetch_assoc($result)) {
                // Map category titles to default icon classes
                $iconMap = [
                    'Laptops' => 'fas fa-laptop',
                    'Desktops' => 'fas fa-desktop',
                    'Monitors' => 'fas fa-tv',
                    'Keyboards' => 'fas fa-keyboard',
                    'Mice' => 'fas fa-mouse',
                    'Headsets' => 'fas fa-headphones',
                    'Accessories' => 'fas fa-gamepad',
                    'Components' => 'fas fa-microchip'
                ];
                
                $row['icon_class'] = isset($iconMap[$row['title']]) ? $iconMap[$row['title']] : 'fas fa-tags';
                $row['name'] = $row['title']; // Add name field based on title for compatibility
                $categories[] = $row;
            }
        }
        
        return $categories;
    }

    public function getCategoryCount() {
        $query = "SELECT COUNT(*) as count FROM categories WHERE deleted = FALSE";
        $result = mysqli_query($this->db->con, $query);
        
        if ($result) {
            $row = mysqli_fetch_assoc($result);
            return $row['count'];
        }
        
        return 0;
    }
    
    public function getCategoryName($categoryId) {
        $categoryId = mysqli_real_escape_string($this->db->con, $categoryId);
        
        $query = "SELECT title FROM categories WHERE id = '$categoryId' AND deleted = FALSE";
        $result = mysqli_query($this->db->con, $query);
        
        if ($result && mysqli_num_rows($result) > 0) {
            $row = mysqli_fetch_assoc($result);
            return $row['title'];
        }
        
        return null;
    }
} 