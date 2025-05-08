<?php
require_once "./mvc/models/HomeAdminModel.php";

class AboutController extends Controller {
    private $homeAdminModel;

    public function __construct() {
        $this->homeAdminModel = new HomeAdminModel();
    }

    public function index() {
        // Get site settings
        $settings = $this->homeAdminModel->getSiteSettings();

        // Kiểm tra người dùng dựa trên cookie thay vì session
        if (isset($_COOKIE['user_role']) && $_COOKIE['user_role'] === 'admin') {
            // If admin, render the admin view
            $this->view("AboutViewAdmin", ['settings' => $settings]);
        } else {
            // If not admin, render the regular view
            $this->view("AboutView", ['settings' => $settings]);
        }
    }
    
    public function list() {
        // Redirect to index method
        $this->index();
    }
}