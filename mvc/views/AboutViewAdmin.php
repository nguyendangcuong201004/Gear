<?php
// Include AboutAdminModel
require_once 'mvc/models/AboutAdminModel.php';
$aboutModel = new AboutAdminModel();

// Check if user is admin - Basic authentication
if (!isset($_COOKIE['user_role']) || $_COOKIE['user_role'] !== 'admin') {
    // Redirect to login page if not admin
    header("Location: /Gear/login");
    exit;
}

// Process form submissions
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['section'])) {
        $section = $_POST['section'];
        
        // Our Story section update
        if ($section === 'our_story') {
            $paragraph1 = $_POST['paragraph_1'];
            $paragraph2 = $_POST['paragraph_2'];
            $current_banner_image = isset($_POST['current_banner_image']) ? $_POST['current_banner_image'] : '';
            
            $message = $aboutModel->updateOurStory($paragraph1, $paragraph2, $current_banner_image, 
                (isset($_FILES['banner_image']) && $_FILES['banner_image']['error'] == 0) ? $_FILES['banner_image'] : null);
        }
        // Mission & Values section update
        else if ($section === 'mission_values') {
            $message = $aboutModel->updateMissionValues($_POST);
        }
        // Product Category Add
        else if ($section === 'product_category_add') {
            $title = $_POST['title'];
            $description = $_POST['description'];
            $display_order = $_POST['display_order'];
            
            $message = $aboutModel->addProductCategory($title, $description, $_FILES['image'], $display_order);
        }
        // Product Category Update
        else if ($section === 'product_category_update') {
            $id = $_POST['id'];
            $title = $_POST['title'];
            $description = $_POST['description'];
            $display_order = $_POST['display_order'];
            $current_image_url = $_POST['current_image_url'];
            
            $message = $aboutModel->updateProductCategory($id, $title, $description, $_FILES['image'], $current_image_url, $display_order);
        }
        // Stats Add
        else if ($section === 'stat_add') {
            $label = $_POST['label'];
            $number = $_POST['number'];
            $display_order = $_POST['display_order'];
            
            $message = $aboutModel->addStat($label, $number, $display_order);
        }
        // Stat Update
        else if ($section === 'stat_update') {
            $id = $_POST['id'];
            $label = $_POST['label'];
            $number = $_POST['number'];
            $display_order = $_POST['display_order'];
            
            $message = $aboutModel->updateStat($id, $label, $number, $display_order);
        }
        // Journey Add
        else if ($section === 'journey_add') {
            $year = $_POST['year'];
            $description = $_POST['description'];
            $display_order = $_POST['display_order'];
            
            $message = $aboutModel->addJourneyItem($year, $description, $display_order);
        }
        // Journey Update
        else if ($section === 'journey_update') {
            $id = $_POST['id'];
            $year = $_POST['year'];
            $description = $_POST['description'];
            $display_order = $_POST['display_order'];
            
            $message = $aboutModel->updateJourneyItem($id, $year, $description, $display_order);
        }
        // Team Member Add
        else if ($section === 'team_add') {
            $name = $_POST['name'];
            $role = $_POST['role'];
            $info = $_POST['info'];
            $display_order = $_POST['display_order'];
            
            $message = $aboutModel->addTeamMember($name, $role, $info, $_FILES['image'], $display_order);
        }
        // Team Member Update
        else if ($section === 'team_update') {
            $id = $_POST['id'];
            $name = $_POST['name'];
            $role = $_POST['role'];
            $info = $_POST['info'];
            $display_order = $_POST['display_order'];
            $current_image_url = $_POST['current_team_image_url'];
            
            $message = $aboutModel->updateTeamMember($id, $name, $role, $info, $_FILES['image'], $current_image_url, $display_order);
        }
        // Delete operations
        else if ($section === 'delete') {
            $id = $_POST['id'];
            $item_type = $_POST['item_type'];
            
            $message = $aboutModel->deleteItem($id, $item_type);
        }
    }
}

// Get data for each section to display in forms
$aboutData = $aboutModel->getAllAboutData();

// Our Story
$our_story_paragraph_1 = $aboutData['our_story']['paragraph_1'];
$our_story_paragraph_2 = $aboutData['our_story']['paragraph_2'];
$banner_image = $aboutData['our_story']['banner_image'];

// Mission & Values
$mission_quality_title = $aboutData['mission_values']['quality_title'];
$mission_quality_item_1 = $aboutData['mission_values']['quality_item_1'];
$mission_quality_item_2 = $aboutData['mission_values']['quality_item_2'];
$mission_quality_item_3 = $aboutData['mission_values']['quality_item_3'];
$mission_satisfaction_title = $aboutData['mission_values']['satisfaction_title'];
$mission_satisfaction_item_1 = $aboutData['mission_values']['satisfaction_item_1'];
$mission_satisfaction_item_2 = $aboutData['mission_values']['satisfaction_item_2'];
$mission_satisfaction_item_3 = $aboutData['mission_values']['satisfaction_item_3'];
$mission_innovation_title = $aboutData['mission_values']['innovation_title'];
$mission_innovation_item_1 = $aboutData['mission_values']['innovation_item_1'];
$mission_innovation_item_2 = $aboutData['mission_values']['innovation_item_2'];
$mission_innovation_item_3 = $aboutData['mission_values']['innovation_item_3'];

// Product Categories, Stats, Journey items, and Team Members
$product_categories = $aboutData['product_categories'];
$stats = $aboutData['stats'];
$journey_items = $aboutData['journey_items'];
$team_members = $aboutData['team_members'];
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>About Us Admin - GearBK Store</title>
  <!-- Bootstrap CSS -->
  <link
    rel="stylesheet"
    href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css"
    integrity="sha384-xOolHFLEh07PJGoPkLv1IbcEPTNtaed2xpHsD9ESMhqIYd0nLMwNLD69Npy4HI+N"
    crossorigin="anonymous"
  >
  <!-- Font Awesome -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css"
        integrity="sha512-iecdLmaskl7CVkqkXNQ/ZH/XLlvWZOJyj7Yy7tcenmpD1ypASozpmT/E0iPtmFIB46ZmdtAc9eNBvH0H/ZpiBw=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
  <!-- Animate.css for basic animations -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css" />
  <!-- Swiper for sliders -->
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@10/swiper-bundle.min.css" />
  <link rel="stylesheet" href="/Gear/public/css/blog.css">
  <link rel="stylesheet" href="/Gear/public/css/AboutView.css">
  <link rel="stylesheet" href="/Gear/public/css/AboutViewAdmin.css">
  
  <style>
    body {
      font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
      background-color: #f9f9f9;
      color: #333;
    }
    
    /* Add significant space between header and content */
    .admin-container {
      margin-top: 120px;
      padding-bottom: 50px;
    }
    
    /* Header styling to match AboutView */
    header {
      background-color: #343a40;
      position: fixed;
      top: 0;
      left: 0;
      right: 0;
      z-index: 1000;
      box-shadow: 0 2px 10px rgba(0,0,0,0.2);
    }
    
    .header-inner-content {
      display: flex;
      align-items: center;
      justify-content: space-between;
      padding: 15px 0;
    }
    
    .header-logo {
      display: flex;
      align-items: center;
    }
    
    .header-logo img {
      width: 50px;
      height: 50px;
      object-fit: cover;
      border-radius: 20%;
      margin-right: 10px;
    }
    
    .header-logo span {
      font-size: 22px;
      font-weight: 600;
      color: white;
    }
    
    .header-menu ul {
      display: flex;
      list-style: none;
      margin: 0;
      padding: 0;
    }
    
    .header-menu ul li {
      margin: 0 15px;
    }
    
    .header-menu ul li a {
      color: white;
      text-decoration: none;
      font-weight: 500;
      transition: all 0.3s ease;
    }
    
    .header-menu ul li a:hover {
      color: #dc3545;
    }
    
    .header-shop, .header-user {
      color: white;
      font-size: 20px;
      margin-left: 15px;
      cursor: pointer;
    }
    
    
  </style>
</head>
<body class="bg-light">
  <!-- Header -->
  <header>
    <div class="container">
      <div class="row">
        <div class="col-12">
          <div class="header-inner-content">
            <div class="header-logo">
              <img src="/Gear/public/images/LogoGearBK.webp" alt="Logo">
              <span>GearBK</span>
            </div>
            <div class="header-menu">
              <ul>
                <li><a href="/Gear">HOME</a></li>
                <li><a href="/Gear/AboutController/index">ABOUT</a></li>
                <li><a href="/Gear/ProductController/list">SHOP</a></li>
                <li><a href="/Gear/ContactController">CONTACT</a></li>
                <li><a href="/Gear/BlogController/list">BLOG</a></li>
                <li><a href="/Gear/QAController/list">Q&A</a></li>
                <?php if (isset($_COOKIE['user_role']) && $_COOKIE['user_role'] === 'admin'): ?>
            <li><a href="/Gear/AdminProductController/list">ADMIN</a></li>
        <?php endif; ?>
                <li><a href="/Gear/AuthController/logout">ĐĂNG XUẤT</a></li>
              </ul>
            </div>
            <div class="d-flex">
              <div class="header-shop"><i class="fa-solid fa-bag-shopping"></i></div>
              <div class="header-user"><i class="fa-solid fa-user"></i></div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </header>
  
  <!-- Admin Badge -->
  <div class="admin-badge">
    <i class="fas fa-user-shield"></i> Admin Mode
  </div>

  <div class="container admin-container">
    <!-- Alert Message Display -->
    <?php if (isset($message)): ?>
    <div class="alert alert-success alert-dismissible fade show" role="alert">
      <?= $message ?>
      <button type="button" class="close" data-dismiss="alert" aria-label="Close">
        <span aria-hidden="true">&times;</span>
      </button>
    </div>
    <?php endif; ?>
    
    <div class="row">
      <div class="col-md-3">
        <!-- Nav tabs -->
        <div class="admin-menu-container">
          <h3 class="mb-4 text-center" style="color: #dc3545;">About Page Administration</h3>
          
          <!-- <div class="mb-4">
            <div class="d-flex flex-column">
              <a href="/Gear/AboutController/index" class="btn btn-primary mb-2" target="_blank">
                <i class="fas fa-eye"></i> View Live Page
              </a>
              <a href="/Gear/AdminController/dashboard" class="btn btn-outline-danger mb-2">
                <i class="fas fa-tachometer-alt"></i> Admin Dashboard
              </a>
              <a href="/Gear" class="btn btn-outline-danger">
                <i class="fas fa-home"></i> Back to Website
              </a>
            </div>
          </div> -->
          
          <div class="section-divider"></div>
          
          <!-- Nav tabs with updated styling -->
          <div class="nav nav-pills flex-column" id="v-pills-tab" role="tablist" aria-orientation="vertical">
            <a class="nav-link active" id="v-pills-story-tab" data-toggle="pill" href="#v-pills-story" role="tab" aria-controls="v-pills-story" aria-selected="true" style="color: #dc3545; border: 1px solid #dc3545;">
              <i class="fas fa-history"></i> Our Story
            </a>
            <a class="nav-link" id="v-pills-mission-tab" data-toggle="pill" href="#v-pills-mission" role="tab" aria-controls="v-pills-mission" aria-selected="false" style="color: #dc3545; border: 1px solid #dc3545;">
              <i class="fas fa-bullseye"></i> Mission & Values
            </a>
            <a class="nav-link" id="v-pills-products-tab" data-toggle="pill" href="#v-pills-products" role="tab" aria-controls="v-pills-products" aria-selected="false" style="color: #dc3545; border: 1px solid #dc3545;">
              <i class="fas fa-boxes"></i> Product Categories
            </a>
            <a class="nav-link" id="v-pills-stats-tab" data-toggle="pill" href="#v-pills-stats" role="tab" aria-controls="v-pills-stats" aria-selected="false" style="color: #dc3545; border: 1px solid #dc3545;">
              <i class="fas fa-chart-pie"></i> Stats
            </a>
            <a class="nav-link" id="v-pills-journey-tab" data-toggle="pill" href="#v-pills-journey" role="tab" aria-controls="v-pills-journey" aria-selected="false" style="color: #dc3545; border: 1px solid #dc3545;">
              <i class="fas fa-road"></i> Journey
            </a>
            <a class="nav-link" id="v-pills-team-tab" data-toggle="pill" href="#v-pills-team" role="tab" aria-controls="v-pills-team" aria-selected="false" style="color: #dc3545; border: 1px solid #dc3545;">
              <i class="fas fa-users"></i> Team
            </a>
          </div>
        </div>
      </div>
      <div class="col-md-9">
        <!-- Tab content -->
        <div class="tab-content" id="v-pills-tabContent">
          <!-- Our Story Section -->
          <div class="tab-pane fade show active" id="v-pills-story" role="tabpanel" aria-labelledby="v-pills-story-tab">
            <div class="section-card">
              <div class="section-header">
                <h4 class="m-0"><i class="fas fa-history"></i> Our Story</h4>
              </div>
              <div class="section-body">
                <form method="POST" action="" enctype="multipart/form-data">
                  <input type="hidden" name="section" value="our_story">
                  
                  <div class="form-group">
                    <label for="paragraph_1"><strong>Paragraph 1</strong></label>
                    <textarea class="form-control" id="paragraph_1" name="paragraph_1" rows="4" required><?= htmlspecialchars($our_story_paragraph_1) ?></textarea>
                  </div>
                  
                  <div class="form-group">
                    <label for="paragraph_2"><strong>Paragraph 2</strong></label>
                    <textarea class="form-control" id="paragraph_2" name="paragraph_2" rows="4" required><?= htmlspecialchars($our_story_paragraph_2) ?></textarea>
                  </div>
                  
                  <div class="form-group">
                    <label for="banner_image"><strong>Banner Image</strong></label>
                    <input type="file" class="form-control-file" id="banner_image" name="banner_image" accept="image/*">
                    <small class="form-text text-muted">Để trống nếu không muốn thay đổi ảnh hiện tại</small>
                    
                    <?php if (!empty($banner_image)): ?>
                    <div class="mt-2">
                      <label>Current Image:</label>
                      <img src="<?= strpos($banner_image, 'http') === 0 ? $banner_image : '/Gear/' . ltrim($banner_image, '/') ?>" alt="Banner Image" class="img-thumbnail" style="max-height: 150px;">
                      <input type="hidden" name="current_banner_image" value="<?= htmlspecialchars($banner_image) ?>">
                    </div>
                    <?php endif; ?>
                  </div>
                  
                  <div class="text-right">
                    <button type="submit" class="btn btn-primary"><i class="fas fa-save"></i> Lưu thay đổi</button>
                  </div>
                </form>
              </div>
            </div>
          </div>
          
          <!-- Mission & Values Section -->
          <div class="tab-pane fade" id="v-pills-mission" role="tabpanel" aria-labelledby="v-pills-mission-tab">
            <div class="section-card">
              <div class="section-header">
                <h4 class="m-0"><i class="fas fa-bullseye"></i> Mission & Values</h4>
              </div>
              <div class="section-body">
                <form method="POST" action="">
                  <input type="hidden" name="section" value="mission_values">
                  
                  <h5 class="mb-3" style="color: #dc3545;">Quality</h5>
                  <div class="form-group">
                    <label for="quality_title"><strong>Quality Title</strong></label>
                    <input type="text" class="form-control" id="quality_title" name="quality_title" value="<?= htmlspecialchars($mission_quality_title) ?>" required>
                    <small class="form-text text-muted">Main title for the quality section</small>
                  </div>
                  
                  <div class="row">
                    <div class="col-md-4">
                      <div class="form-group">
                        <label for="quality_item_1"><strong>Quality Item 1</strong></label>
                        <input type="text" class="form-control" id="quality_item_1" name="quality_item_1" value="<?= htmlspecialchars($mission_quality_item_1) ?>" required>
                      </div>
                    </div>
                    <div class="col-md-4">
                      <div class="form-group">
                        <label for="quality_item_2"><strong>Quality Item 2</strong></label>
                        <input type="text" class="form-control" id="quality_item_2" name="quality_item_2" value="<?= htmlspecialchars($mission_quality_item_2) ?>" required>
                      </div>
                    </div>
                    <div class="col-md-4">
                      <div class="form-group">
                        <label for="quality_item_3"><strong>Quality Item 3</strong></label>
                        <input type="text" class="form-control" id="quality_item_3" name="quality_item_3" value="<?= htmlspecialchars($mission_quality_item_3) ?>" required>
                      </div>
                    </div>
                  </div>
                  
                  <hr class="section-divider">
                  
                  <h5 class="mb-3" style="color: #dc3545;">Customer Satisfaction</h5>
                  <div class="form-group">
                    <label for="satisfaction_title"><strong>Satisfaction Title</strong></label>
                    <input type="text" class="form-control" id="satisfaction_title" name="satisfaction_title" value="<?= htmlspecialchars($mission_satisfaction_title) ?>" required>
                    <small class="form-text text-muted">Main title for the satisfaction section</small>
                  </div>
                  
                  <div class="row">
                    <div class="col-md-4">
                      <div class="form-group">
                        <label for="satisfaction_item_1"><strong>Satisfaction Item 1</strong></label>
                        <input type="text" class="form-control" id="satisfaction_item_1" name="satisfaction_item_1" value="<?= htmlspecialchars($mission_satisfaction_item_1) ?>" required>
                      </div>
                    </div>
                    <div class="col-md-4">
                      <div class="form-group">
                        <label for="satisfaction_item_2"><strong>Satisfaction Item 2</strong></label>
                        <input type="text" class="form-control" id="satisfaction_item_2" name="satisfaction_item_2" value="<?= htmlspecialchars($mission_satisfaction_item_2) ?>" required>
                      </div>
                    </div>
                    <div class="col-md-4">
                      <div class="form-group">
                        <label for="satisfaction_item_3"><strong>Satisfaction Item 3</strong></label>
                        <input type="text" class="form-control" id="satisfaction_item_3" name="satisfaction_item_3" value="<?= htmlspecialchars($mission_satisfaction_item_3) ?>" required>
                      </div>
                    </div>
                  </div>
                  
                  <hr>
                  
                  <h5 class="mb-3" style="color: #dc3545;">Innovation</h5>
                  <div class="form-group">
                    <label for="innovation_title"><strong>Innovation Title</strong></label>
                    <input type="text" class="form-control" id="innovation_title" name="innovation_title" value="<?= htmlspecialchars($mission_innovation_title) ?>" required>
                    <small class="form-text text-muted">Main title for the innovation section</small>
                  </div>
                  
                  <div class="row">
                    <div class="col-md-4">
                      <div class="form-group">
                        <label for="innovation_item_1"><strong>Innovation Item 1</strong></label>
                        <input type="text" class="form-control" id="innovation_item_1" name="innovation_item_1" value="<?= htmlspecialchars($mission_innovation_item_1) ?>" required>
                      </div>
                    </div>
                    <div class="col-md-4">
                      <div class="form-group">
                        <label for="innovation_item_2"><strong>Innovation Item 2</strong></label>
                        <input type="text" class="form-control" id="innovation_item_2" name="innovation_item_2" value="<?= htmlspecialchars($mission_innovation_item_2) ?>" required>
                      </div>
                    </div>
                    <div class="col-md-4">
                      <div class="form-group">
                        <label for="innovation_item_3"><strong>Innovation Item 3</strong></label>
                        <input type="text" class="form-control" id="innovation_item_3" name="innovation_item_3" value="<?= htmlspecialchars($mission_innovation_item_3) ?>" required>
                      </div>
                    </div>
                  </div>
                  
                  <div class="text-right mt-4">
                    <button type="submit" class="btn btn-primary"><i class="fas fa-save"></i> Lưu thay đổi</button>
                  </div>
                </form>
              </div>
            </div>
          </div>
          
          <!-- Product Categories Section -->
          <div class="tab-pane fade" id="v-pills-products" role="tabpanel" aria-labelledby="v-pills-products-tab">
            <div class="section-card">
              <div class="section-header d-flex justify-content-between align-items-center">
                <h4 class="m-0"><i class="fas fa-boxes"></i> Product Categories</h4>
                <button type="button" class="btn btn-sm btn-light" data-toggle="modal" data-target="#addProductCategoryModal">
                  <i class="fas fa-plus"></i> Thêm mới
                </button>
              </div>
              <div class="section-body">
                <div class="table-responsive">
                  <table class="table table-bordered table-hover">
                    <thead>
                      <tr>
                        <th width="5%">ID</th>
                        <th width="15%">Image</th>
                        <th width="25%">Title</th>
                        <th width="35%">Description</th>
                        <th width="10%">Order</th>
                        <th width="10%">Actions</th>
                      </tr>
                    </thead>
                    <tbody>
                      <?php foreach ($product_categories as $category): ?>
                      <tr>
                        <td><?= $category['id'] ?></td>
                        <td>
                          <img src="<?= strpos($category['image_url'], 'http') === 0 ? $category['image_url'] : '/Gear/' . ltrim($category['image_url'], '/') ?>" alt="Category" class="img-thumbnail" style="max-height: 60px;">
                        </td>
                        <td><?= htmlspecialchars($category['title']) ?></td>
                        <td><?= htmlspecialchars(substr($category['description'], 0, 100)) ?>...</td>
                        <td><?= $category['display_order'] ?></td>
                        <td>
                          <button class="btn btn-sm btn-primary edit-category-btn" 
                                  data-id="<?= $category['id'] ?>" 
                                  data-title="<?= htmlspecialchars($category['title']) ?>" 
                                  data-description="<?= htmlspecialchars($category['description']) ?>" 
                                  data-image="<?= htmlspecialchars($category['image_url']) ?>" 
                                  data-order="<?= $category['display_order'] ?>">
                            <i class="fas fa-edit"></i>
                          </button>
                          <button class="btn btn-sm btn-danger delete-category-btn" data-id="<?= $category['id'] ?>">
                            <i class="fas fa-trash"></i>
                          </button>
                        </td>
                      </tr>
                      <?php endforeach; ?>
                    </tbody>
                  </table>
                </div>
              </div>
            </div>
          </div>
          
          <!-- Stats Section -->
          <div class="tab-pane fade" id="v-pills-stats" role="tabpanel" aria-labelledby="v-pills-stats-tab">
            <div class="section-card">
              <div class="section-header d-flex justify-content-between align-items-center">
                <h4 class="m-0"><i class="fas fa-chart-pie"></i> Stats</h4>
                <button type="button" class="btn btn-sm btn-light" data-toggle="modal" data-target="#addStatModal">
                  <i class="fas fa-plus"></i> Thêm mới
                </button>
              </div>
              <div class="section-body">
                
                <div class="table-responsive">
                  <table class="table table-bordered table-hover">
                    <thead>
                      <tr>
                        <th width="5%">ID</th>
                        <th width="30%">Label</th>
                        <th width="25%">Number</th>
                        <th width="10%">Order</th>
                        <th width="10%">Actions</th>
                      </tr>
                    </thead>
                    <tbody>
                      <?php foreach ($stats as $stat): ?>
                      <tr>
                        <td><?= $stat['id'] ?></td>
                        <td><?= htmlspecialchars($stat['label']) ?></td>
                        <td><?= $stat['number'] ?></td>
                        <td><?= $stat['display_order'] ?></td>
                        <td>
                          <button class="btn btn-sm btn-primary edit-stat-btn" 
                                  data-id="<?= $stat['id'] ?>" 
                                  data-label="<?= htmlspecialchars($stat['label']) ?>" 
                                  data-number="<?= $stat['number'] ?>" 
                                  data-order="<?= $stat['display_order'] ?>">
                            <i class="fas fa-edit"></i>
                          </button>
                          <button class="btn btn-sm btn-danger delete-stat-btn" data-id="<?= $stat['id'] ?>">
                            <i class="fas fa-trash"></i>
                          </button>
                        </td>
                      </tr>
                      <?php endforeach; ?>
                    </tbody>
                  </table>
                </div>
              </div>
            </div>
          </div>
          
          <!-- Journey Section -->
          <div class="tab-pane fade" id="v-pills-journey" role="tabpanel" aria-labelledby="v-pills-journey-tab">
            <div class="section-card">
              <div class="section-header d-flex justify-content-between align-items-center">
                <h4 class="m-0"><i class="fas fa-road"></i> Journey</h4>
                <button type="button" class="btn btn-sm btn-light" data-toggle="modal" data-target="#addJourneyModal">
                  <i class="fas fa-plus"></i> Thêm mới
                </button>
              </div>
              <div class="section-body">
                
                <div class="table-responsive">
                  <table class="table table-bordered table-hover">
                    <thead>
                      <tr>
                        <th width="5%">ID</th>
                        <th width="15%">Year</th>
                        <th width="60%">Description</th>
                        <th width="10%">Order</th>
                        <th width="10%">Actions</th>
                      </tr>
                    </thead>
                    <tbody>
                      <?php foreach ($journey_items as $item): ?>
                      <tr>
                        <td><?= $item['id'] ?></td>
                        <td><?= htmlspecialchars($item['year']) ?></td>
                        <td><?= htmlspecialchars(substr($item['description'], 0, 100)) ?>...</td>
                        <td><?= $item['display_order'] ?></td>
                        <td>
                          <button class="btn btn-sm btn-primary edit-journey-btn" 
                                  data-id="<?= $item['id'] ?>" 
                                  data-year="<?= htmlspecialchars($item['year']) ?>" 
                                  data-description="<?= htmlspecialchars($item['description']) ?>" 
                                  data-order="<?= $item['display_order'] ?>">
                            <i class="fas fa-edit"></i>
                          </button>
                          <button class="btn btn-sm btn-danger delete-journey-btn" data-id="<?= $item['id'] ?>">
                            <i class="fas fa-trash"></i>
                          </button>
                        </td>
                      </tr>
                      <?php endforeach; ?>
                    </tbody>
                  </table>
                </div>
              </div>
            </div>
          </div>
          
          <!-- Team Section -->
          <div class="tab-pane fade" id="v-pills-team" role="tabpanel" aria-labelledby="v-pills-team-tab">
            <div class="section-card">
              <div class="section-header d-flex justify-content-between align-items-center">
                <h4 class="m-0"><i class="fas fa-users"></i> Team</h4>
                <button type="button" class="btn btn-sm btn-light" data-toggle="modal" data-target="#addTeamMemberModal">
                  <i class="fas fa-plus"></i> Thêm mới
                </button>
              </div>
              <div class="section-body">
                
                <div class="table-responsive">
                  <table class="table table-bordered table-hover">
                    <thead>
                      <tr>
                        <th width="5%">ID</th>
                        <th width="15%">Image</th>
                        <th width="20%">Name</th>
                        <th width="15%">Role</th>
                        <th width="25%">Info</th>
                        <th width="10%">Order</th>
                        <th width="10%">Actions</th>
                      </tr>
                    </thead>
                    <tbody>
                      <?php foreach ($team_members as $member): ?>
                      <tr>
                        <td><?= $member['id'] ?></td>
                        <td>
                          <img src="<?= strpos($member['image_url'], 'http') === 0 ? $member['image_url'] : '/Gear/' . ltrim($member['image_url'], '/') ?>" alt="Team Member" class="img-thumbnail" style="max-height: 60px;">
                        </td>
                        <td><?= htmlspecialchars($member['name']) ?></td>
                        <td><?= htmlspecialchars($member['role']) ?></td>
                        <td><?= htmlspecialchars(substr($member['info'], 0, 50)) ?>...</td>
                        <td><?= $member['display_order'] ?></td>
                        <td>
                          <button class="btn btn-sm btn-primary edit-team-btn" 
                                  data-id="<?= $member['id'] ?>" 
                                  data-name="<?= htmlspecialchars($member['name']) ?>" 
                                  data-role="<?= htmlspecialchars($member['role']) ?>" 
                                  data-info="<?= htmlspecialchars($member['info']) ?>" 
                                  data-image="<?= htmlspecialchars($member['image_url']) ?>" 
                                  data-order="<?= $member['display_order'] ?>">
                            <i class="fas fa-edit"></i>
                          </button>
                          <button class="btn btn-sm btn-danger delete-team-btn" data-id="<?= $member['id'] ?>">
                            <i class="fas fa-trash"></i>
                          </button>
                        </td>
                      </tr>
                      <?php endforeach; ?>
                    </tbody>
                  </table>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
  
  <!-- Modals for adding/editing items -->
  
  <!-- Product Category Modals -->
  <div class="modal fade" id="addProductCategoryModal" tabindex="-1" aria-labelledby="addProductCategoryModalLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header bg-primary text-white">
          <h5 class="modal-title" id="addProductCategoryModalLabel">Add Product Category</h5>
          <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <form id="addProductCategoryForm" method="POST" action="" enctype="multipart/form-data">
          <div class="modal-body">
            <input type="hidden" name="section" value="product_category_add">
            <div class="form-group">
              <label for="category_title">Title</label>
              <input type="text" class="form-control" id="category_title" name="title" required>
            </div>
            <div class="form-group">
              <label for="category_description">Description</label>
              <textarea class="form-control" id="category_description" name="description" rows="3" required></textarea>
            </div>
            <div class="form-group">
              <label for="category_image">Upload Image</label>
              <input type="file" class="form-control-file" id="category_image" name="image" accept="image/*" required>
              <small class="form-text text-muted">Hãy chọn ảnh có kích thước phù hợp (tối đa 2MB)</small>
            </div>
            <div class="form-group">
              <label for="category_order">Display Order</label>
              <input type="number" class="form-control" id="category_order" name="display_order" min="1" required>
            </div>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
            <button type="submit" class="btn btn-primary">Add Category</button>
          </div>
        </form>
      </div>
    </div>
  </div>

  <div class="modal fade" id="editProductCategoryModal" tabindex="-1" aria-labelledby="editProductCategoryModalLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header bg-primary text-white">
          <h5 class="modal-title" id="editProductCategoryModalLabel">Edit Product Category</h5>
          <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <form id="editProductCategoryForm" method="POST" action="" enctype="multipart/form-data">
          <div class="modal-body">
            <input type="hidden" name="section" value="product_category_update">
            <input type="hidden" id="edit_category_id" name="id">
            <div class="form-group">
              <label for="edit_category_title">Title</label>
              <input type="text" class="form-control" id="edit_category_title" name="title" required>
            </div>
            <div class="form-group">
              <label for="edit_category_description">Description</label>
              <textarea class="form-control" id="edit_category_description" name="description" rows="3" required></textarea>
            </div>
            <div class="form-group">
              <label for="edit_category_image">Upload New Image</label>
              <input type="file" class="form-control-file" id="edit_category_image" name="image" accept="image/*">
              <small class="form-text text-muted">Để trống nếu không muốn thay đổi ảnh hiện tại</small>
              <div class="mt-2" id="current_category_image_container">
                <label>Current Image:</label>
                <img id="current_category_image" src="" alt="Current Image" class="img-thumbnail" style="max-height: 100px;">
                <input type="hidden" id="current_image_url" name="current_image_url">
              </div>
            </div>
            <div class="form-group">
              <label for="edit_category_order">Display Order</label>
              <input type="number" class="form-control" id="edit_category_order" name="display_order" min="1" required>
            </div>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
            <button type="submit" class="btn btn-primary">Save Changes</button>
          </div>
        </form>
      </div>
    </div>
  </div>

  <!-- Stats Modals -->
  <div class="modal fade" id="addStatModal" tabindex="-1" aria-labelledby="addStatModalLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header bg-primary text-white">
          <h5 class="modal-title" id="addStatModalLabel">Add Stat</h5>
          <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <form id="addStatForm" method="POST" action="">
          <div class="modal-body">
            <input type="hidden" name="section" value="stat_add">
            <div class="form-group">
              <label for="stat_label">Label</label>
              <input type="text" class="form-control" id="stat_label" name="label" required>
            </div>
            <div class="form-group">
              <label for="stat_number">Number</label>
              <input type="number" class="form-control" id="stat_number" name="number" min="1" required>
            </div>
            <div class="form-group">
              <label for="stat_order">Display Order</label>
              <input type="number" class="form-control" id="stat_order" name="display_order" min="1" required>
            </div>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
            <button type="submit" class="btn btn-primary">Add Stat</button>
          </div>
        </form>
      </div>
    </div>
  </div>

  <div class="modal fade" id="editStatModal" tabindex="-1" aria-labelledby="editStatModalLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header bg-primary text-white">
          <h5 class="modal-title" id="editStatModalLabel">Edit Stat</h5>
          <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <form id="editStatForm" method="POST" action="">
          <div class="modal-body">
            <input type="hidden" name="section" value="stat_update">
            <input type="hidden" id="edit_stat_id" name="id">
            <div class="form-group">
              <label for="edit_stat_label">Label</label>
              <input type="text" class="form-control" id="edit_stat_label" name="label" required>
            </div>
            <div class="form-group">
              <label for="edit_stat_number">Number</label>
              <input type="number" class="form-control" id="edit_stat_number" name="number" min="1" required>
            </div>
            <div class="form-group">
              <label for="edit_stat_order">Display Order</label>
              <input type="number" class="form-control" id="edit_stat_order" name="display_order" min="1" required>
            </div>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
            <button type="submit" class="btn btn-primary">Save Changes</button>
          </div>
        </form>
      </div>
    </div>
  </div>

  <!-- Journey Modals -->
  <div class="modal fade" id="addJourneyModal" tabindex="-1" aria-labelledby="addJourneyModalLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header bg-primary text-white">
          <h5 class="modal-title" id="addJourneyModalLabel">Add Journey Item</h5>
          <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <form id="addJourneyForm" method="POST" action="">
          <div class="modal-body">
            <input type="hidden" name="section" value="journey_add">
            <div class="form-group">
              <label for="journey_year">Year</label>
              <input type="text" class="form-control" id="journey_year" name="year" required>
            </div>
            <div class="form-group">
              <label for="journey_description">Description</label>
              <textarea class="form-control" id="journey_description" name="description" rows="3" required></textarea>
            </div>
            <div class="form-group">
              <label for="journey_order">Display Order</label>
              <input type="number" class="form-control" id="journey_order" name="display_order" min="1" required>
            </div>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
            <button type="submit" class="btn btn-primary">Add Journey Item</button>
          </div>
        </form>
      </div>
    </div>
  </div>

  <div class="modal fade" id="editJourneyModal" tabindex="-1" aria-labelledby="editJourneyModalLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header bg-primary text-white">
          <h5 class="modal-title" id="editJourneyModalLabel">Edit Journey Item</h5>
          <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <form id="editJourneyForm" method="POST" action="">
          <div class="modal-body">
            <input type="hidden" name="section" value="journey_update">
            <input type="hidden" id="edit_journey_id" name="id">
            <div class="form-group">
              <label for="edit_journey_year">Year</label>
              <input type="text" class="form-control" id="edit_journey_year" name="year" required>
            </div>
            <div class="form-group">
              <label for="edit_journey_description">Description</label>
              <textarea class="form-control" id="edit_journey_description" name="description" rows="3" required></textarea>
            </div>
            <div class="form-group">
              <label for="edit_journey_order">Display Order</label>
              <input type="number" class="form-control" id="edit_journey_order" name="display_order" min="1" required>
            </div>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
            <button type="submit" class="btn btn-primary">Save Changes</button>
          </div>
        </form>
      </div>
    </div>
  </div>

  <!-- Team Member Modals -->
  <div class="modal fade" id="addTeamMemberModal" tabindex="-1" aria-labelledby="addTeamMemberModalLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header bg-primary text-white">
          <h5 class="modal-title" id="addTeamMemberModalLabel">Add Team Member</h5>
          <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <form id="addTeamMemberForm" method="POST" action="" enctype="multipart/form-data">
          <div class="modal-body">
            <input type="hidden" name="section" value="team_add">
            <div class="form-group">
              <label for="team_name">Name</label>
              <input type="text" class="form-control" id="team_name" name="name" required>
            </div>
            <div class="form-group">
              <label for="team_role">Role</label>
              <input type="text" class="form-control" id="team_role" name="role" required>
            </div>
            <div class="form-group">
              <label for="team_info">Info</label>
              <textarea class="form-control" id="team_info" name="info" rows="3" required></textarea>
            </div>
            <div class="form-group">
              <label for="team_image">Upload Image</label>
              <input type="file" class="form-control-file" id="team_image" name="image" accept="image/*" required>
              <small class="form-text text-muted">Hãy chọn ảnh có kích thước phù hợp (tối đa 2MB)</small>
            </div>
            <div class="form-group">
              <label for="team_order">Display Order</label>
              <input type="number" class="form-control" id="team_order" name="display_order" min="1" required>
            </div>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
            <button type="submit" class="btn btn-primary">Add Team Member</button>
          </div>
        </form>
      </div>
    </div>
  </div>

  <div class="modal fade" id="editTeamMemberModal" tabindex="-1" aria-labelledby="editTeamMemberModalLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header bg-primary text-white">
          <h5 class="modal-title" id="editTeamMemberModalLabel">Edit Team Member</h5>
          <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <form id="editTeamMemberForm" method="POST" action="" enctype="multipart/form-data">
          <div class="modal-body">
            <input type="hidden" name="section" value="team_update">
            <input type="hidden" id="edit_team_id" name="id">
            <div class="form-group">
              <label for="edit_team_name">Name</label>
              <input type="text" class="form-control" id="edit_team_name" name="name" required>
            </div>
            <div class="form-group">
              <label for="edit_team_role">Role</label>
              <input type="text" class="form-control" id="edit_team_role" name="role" required>
            </div>
            <div class="form-group">
              <label for="edit_team_info">Info</label>
              <textarea class="form-control" id="edit_team_info" name="info" rows="3" required></textarea>
            </div>
            <div class="form-group">
              <label for="edit_team_image">Upload New Image</label>
              <input type="file" class="form-control-file" id="edit_team_image" name="image" accept="image/*">
              <small class="form-text text-muted">Để trống nếu không muốn thay đổi ảnh hiện tại</small>
              <div class="mt-2" id="current_team_image_container">
                <label>Current Image:</label>
                <img id="current_team_image" src="" alt="Current Image" class="img-thumbnail" style="max-height: 100px;">
                <input type="hidden" id="current_team_image_url" name="current_image_url">
              </div>
            </div>
            <div class="form-group">
              <label for="edit_team_order">Display Order</label>
              <input type="number" class="form-control" id="edit_team_order" name="display_order" min="1" required>
            </div>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
            <button type="submit" class="btn btn-primary">Save Changes</button>
          </div>
        </form>
      </div>
    </div>
  </div>

  <!-- Confirmation Modal for Deleting -->
  <div class="modal fade" id="deleteConfirmModal" tabindex="-1" aria-labelledby="deleteConfirmModalLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header bg-danger text-white">
          <h5 class="modal-title" id="deleteConfirmModalLabel">Confirm Delete</h5>
          <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          Are you sure you want to delete this item? This action cannot be undone.
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
          <form id="deleteForm" method="POST" action="">
            <input type="hidden" name="section" value="delete">
            <input type="hidden" id="delete_item_id" name="id">
            <input type="hidden" id="delete_item_type" name="item_type">
            <button type="submit" class="btn btn-danger">Delete</button>
          </form>
        </div>
      </div>
    </div>
  </div>

  <!-- Footer -->
  <!-- <div class="copyright-footer text-center py-3 mt-5">
    <div class="container">
      <p class="mb-0 text-white">© 2023 GearBK Admin Panel. All rights reserved.</p>
    </div>
  </div> -->

  <!-- JS libraries -->
  <script src="https://cdn.jsdelivr.net/npm/jquery@3.5.1/dist/jquery.slim.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.bundle.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/swiper@10/swiper-bundle.min.js"></script>
  <script>
    // JavaScript for handling modals and interactions
    document.addEventListener('DOMContentLoaded', function() {
      // Animation on page load
      const animateElements = document.querySelectorAll('.section-card');
      animateElements.forEach((el, index) => {
        el.classList.add('animate__animated', 'animate__fadeInUp');
        el.style.animationDelay = `${0.1 * index}s`;
      });
      
      // Product Category Edit Button
      const editCategoryButtons = document.querySelectorAll('.edit-category-btn');
      editCategoryButtons.forEach(button => {
        button.addEventListener('click', function() {
          const id = this.getAttribute('data-id');
          const title = this.getAttribute('data-title');
          const description = this.getAttribute('data-description');
          const image = this.getAttribute('data-image');
          const order = this.getAttribute('data-order');
          
          document.getElementById('edit_category_id').value = id;
          document.getElementById('edit_category_title').value = title;
          document.getElementById('edit_category_description').value = description;
          document.getElementById('current_image_url').value = image;
          document.getElementById('current_category_image').src = image.startsWith('http') ? image : '/Gear/' + image.replace(/^\/+/, '');
          document.getElementById('edit_category_order').value = order;
          
          $('#editProductCategoryModal').modal('show');
        });
      });
      
      // Product Category Delete Button
      const deleteCategoryButtons = document.querySelectorAll('.delete-category-btn');
      deleteCategoryButtons.forEach(button => {
        button.addEventListener('click', function() {
          const id = this.getAttribute('data-id');
          document.getElementById('delete_item_id').value = id;
          document.getElementById('delete_item_type').value = 'product_category';
          
          $('#deleteConfirmModal').modal('show');
        });
      });
      
      // Stats Edit Button
      const editStatButtons = document.querySelectorAll('.edit-stat-btn');
      editStatButtons.forEach(button => {
        button.addEventListener('click', function() {
          const id = this.getAttribute('data-id');
          const label = this.getAttribute('data-label');
          const number = this.getAttribute('data-number');
          const order = this.getAttribute('data-order');
          
          document.getElementById('edit_stat_id').value = id;
          document.getElementById('edit_stat_label').value = label;
          document.getElementById('edit_stat_number').value = number;
          document.getElementById('edit_stat_order').value = order;
          
          $('#editStatModal').modal('show');
        });
      });
      
      // Stats Delete Button
      const deleteStatButtons = document.querySelectorAll('.delete-stat-btn');
      deleteStatButtons.forEach(button => {
        button.addEventListener('click', function() {
          const id = this.getAttribute('data-id');
          document.getElementById('delete_item_id').value = id;
          document.getElementById('delete_item_type').value = 'stat';
          
          $('#deleteConfirmModal').modal('show');
        });
      });
      
      // Journey Edit Button
      const editJourneyButtons = document.querySelectorAll('.edit-journey-btn');
      editJourneyButtons.forEach(button => {
        button.addEventListener('click', function() {
          const id = this.getAttribute('data-id');
          const year = this.getAttribute('data-year');
          const description = this.getAttribute('data-description');
          const order = this.getAttribute('data-order');
          
          document.getElementById('edit_journey_id').value = id;
          document.getElementById('edit_journey_year').value = year;
          document.getElementById('edit_journey_description').value = description;
          document.getElementById('edit_journey_order').value = order;
          
          $('#editJourneyModal').modal('show');
        });
      });
      
      // Journey Delete Button
      const deleteJourneyButtons = document.querySelectorAll('.delete-journey-btn');
      deleteJourneyButtons.forEach(button => {
        button.addEventListener('click', function() {
          const id = this.getAttribute('data-id');
          document.getElementById('delete_item_id').value = id;
          document.getElementById('delete_item_type').value = 'journey';
          
          $('#deleteConfirmModal').modal('show');
        });
      });
      
      // Team Member Edit Button
      const editTeamButtons = document.querySelectorAll('.edit-team-btn');
      editTeamButtons.forEach(button => {
        button.addEventListener('click', function() {
          const id = this.getAttribute('data-id');
          const name = this.getAttribute('data-name');
          const role = this.getAttribute('data-role');
          const info = this.getAttribute('data-info');
          const image = this.getAttribute('data-image');
          const order = this.getAttribute('data-order');
          
          document.getElementById('edit_team_id').value = id;
          document.getElementById('edit_team_name').value = name;
          document.getElementById('edit_team_role').value = role;
          document.getElementById('edit_team_info').value = info;
          document.getElementById('current_team_image_url').value = image;
          document.getElementById('current_team_image').src = image.startsWith('http') ? image : '/Gear/' + image.replace(/^\/+/, '');
          document.getElementById('edit_team_order').value = order;
          
          $('#editTeamMemberModal').modal('show');
        });
      });
      
      // Team Member Delete Button
      const deleteTeamButtons = document.querySelectorAll('.delete-team-btn');
      deleteTeamButtons.forEach(button => {
        button.addEventListener('click', function() {
          const id = this.getAttribute('data-id');
          document.getElementById('delete_item_id').value = id;
          document.getElementById('delete_item_type').value = 'team';
          
          $('#deleteConfirmModal').modal('show');
        });
      });
    });
  </script>
</body>
</html> 