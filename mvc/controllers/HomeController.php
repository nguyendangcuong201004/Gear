<?php
class HomeController extends Controller {
    private $homeModel;
    private $homeAdminModel;

    public function __construct() {
        $this->homeModel = $this->model("HomeModel");
        $this->homeAdminModel = $this->model("HomeAdminModel");
    }

    public function index() {
        $settings = $this->homeAdminModel->getSiteSettings();
        $slides = $this->homeAdminModel->getCarouselSlides();
        
        $featuredProducts = $this->homeModel->getFeaturedProducts();
        $categories = $this->homeModel->getAllCategories();
        
        // Get products for each category
        $categoryProducts = [];
        foreach ($categories as $category) {
            $categoryProducts[$category['id']] = $this->homeModel->getProductsByCategory($category['id']);
        }
        
        $this->view("HomeView", [
            "settings" => $settings,
            "slides" => $slides,
            "featuredProducts" => $featuredProducts,
            "categories" => $categories,
            "categoryProducts" => $categoryProducts
        ]);
    }

    public function category($categoryId = null) {
        if ($categoryId === null) {
            // Redirect to home if no category ID is provided
            header("Location: /HomeView");
            exit();
        }
        
        $settings = $this->homeAdminModel->getSiteSettings();
        
        $products = $this->homeModel->getProductsByCategory($categoryId);
        $categoryName = $this->homeModel->getCategoryName($categoryId);
        $categories = $this->homeModel->getAllCategories();
        
        $this->view("category", [
            "settings" => $settings,
            "products" => $products,
            "categoryName" => $categoryName,
            "categories" => $categories,
            "categoryId" => $categoryId
        ]);
    }
} 