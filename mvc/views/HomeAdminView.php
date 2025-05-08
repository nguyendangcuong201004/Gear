<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Quản Lý Trang Chủ - GearBK Admin</title>

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css">
    <!-- Admin CSS -->
    <link rel="stylesheet" href="public/css/admin.css">
    <!-- Summernote Editor -->
    <link href="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote-lite.min.css" rel="stylesheet">
    <!-- SweetAlert2 -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">
    <!-- Responsive styles -->
    <link rel="stylesheet" href="/Gear/public/css/adminListUser.css">

    <style>
        @media (max-width: 767.98px) {
            .card-header {
                padding: 0.75rem;
            }
            .card-body {
                padding: 1rem;
            }
            .btn {
                font-size: 0.875rem;
                padding: 0.375rem 0.75rem;
            }
            .table {
                font-size: 0.875rem;
            }
            .nav-tabs .nav-link {
                padding: 0.5rem 0.75rem;
                font-size: 0.875rem;
            }
            .form-label {
                font-size: 0.875rem;
                margin-bottom: 0.25rem;
            }
            .h2 {
                font-size: 1.5rem;
            }
            .accordion-button {
                padding: 0.75rem;
                font-size: 0.875rem;
            }
            .summernote-container {
                min-height: 200px;
            }
            .modal-dialog {
                margin: 0.5rem;
            }
        }
        
        /* General responsive improvements */
        .table-responsive {
            overflow-x: auto;
        }
        .img-preview {
            max-width: 100%;
            height: auto;
        }
        .action-buttons {
            display: flex;
            flex-wrap: wrap;
            gap: 0.5rem;
        }
        .note-toolbar {
            flex-wrap: wrap;
        }

        /* Fix sidebar and content layout */
        .main-container {
            display: flex;
            min-height: 100vh;
        }
        .content {
            flex: 1;
            margin-left: 250px;
            min-height: 100vh;
        }
        @media (max-width: 768px) {
            .sidebar {
                width: 100%;
                position: fixed;
                display: none;
            }
            .content {
                margin-left: 0;
                width: 100%;
            }
        }
    </style>

</head>

<body>
    <div class="header">
        <h1>ADMIN</h1>
        <div class="buttons">
            <button class="source-btn" onclick="location.href='/Gear/AdminController/dashboard'">Nguyen Dang Cuong</button>
            <button class="logout-btn" onclick="location.href='/Gear/AuthController/logout'">Đăng xuất</button>
        </div>
    </div>
    <div class="main-container">
        <div class="sidebar position-fixed" style="padding: unset;">
            <ul>
                <li><a href="#">Tổng quan</a></li>
                <li><a href="/Gear/AdminProductController/list">Sản phẩm</a></li>
                <li><a href="/Gear/AdminOrderController/list">Đơn hàng</a></li>
                <li><a href="#">Nhóm quyền</a></li>
                <li><a href="#">Phân quyền</a></li>
                <li><a href="/Gear/AdminUserController/list">Tài khoản</a></li>
                <li><a href="/Gear/HomeAdminController">Quản lý trang chủ</a></li>
                <li><a href="/Gear/ContactAdminController">Quản lý liên hệ</a></li>
            </ul>
        </div>
        <div class="content">

        <!-- Main Content -->
        <div class="main-content flex-grow-1">
            <div class="container-fluid p-3 p-md-4">
                <div class="row mb-4">
                    <div class="col-12">
                        <div class="d-flex flex-wrap justify-content-between align-items-center">
                            <h2 class="m-0">Quản Lý Trang Chủ</h2>
                        </div>
                    </div>
                </div>

                <!-- Alert Messages -->
                <?php if (isset($_SESSION['success_message'])): ?>
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    <?php echo $_SESSION['success_message']; unset($_SESSION['success_message']); ?>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
                <?php endif; ?>

                <?php if (isset($_SESSION['error_message'])): ?>
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <?php echo $_SESSION['error_message']; unset($_SESSION['error_message']); ?>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
                <?php endif; ?>

                <!-- Tabs for different section management -->
                <ul class="nav nav-tabs mb-4 flex-nowrap overflow-auto" id="adminTabs" role="tablist">
                    <li class="nav-item" role="presentation">
                        <button class="nav-link active" id="general-tab" data-bs-toggle="tab" data-bs-target="#general-content" type="button" role="tab" aria-controls="general-content" aria-selected="true">
                            <i class="fas fa-cog me-2 text-danger"></i><span class="d-none d-sm-inline text-dark">Thông tin chung</span><span class="d-inline d-sm-none">Chung</span>
                        </button>
                    </li>
                    <li class="nav-item" role="presentation">
                        <button class="nav-link" id="carousel-tab" data-bs-toggle="tab" data-bs-target="#carousel-content" type="button" role="tab" aria-controls="carousel-content" aria-selected="false">
                            <i class="fas fa-images me-2 text-danger"></i><span class="d-none d-sm-inline text-dark">Quản lý Carousel</span><span class="d-inline d-sm-none">Carousel</span>
                        </button>
                    </li>
                    <li class="nav-item" role="presentation">
                        <button class="nav-link" id="about-tab" data-bs-toggle="tab" data-bs-target="#about-content" type="button" role="tab" aria-controls="about-content" aria-selected="false">
                            <i class="fas fa-info-circle me-2 text-danger"></i><span class="d-none d-sm-inline text-dark">Phần Giới Thiệu</span><span class="d-inline d-sm-none">Giới Thiệu</span>
                        </button>
                    </li>
                </ul>

                <div class="tab-content" id="adminTabContent">
                    <!-- General Settings Tab -->
                    <div class="tab-pane fade show active" id="general-content" role="tabpanel" aria-labelledby="general-tab">
                        <div class="card">
                            <div class="card-header bg-danger text-white">
                                <h5 class="mb-0">Thông Tin Chung</h5>
                            </div>
                            <div class="card-body">
                                <form action="/Gear/HomeAdminController/updateSettings" method="POST" enctype="multipart/form-data" class="ajax-form">
                                    <div class="row mb-3">
                                        <div class="col-12 col-md-6 mb-3 mb-md-0">
                                            <label class="form-label">Tên công ty</label>
                                            <input type="text" class="form-control" name="company_name" value="<?php echo isset($data['settings']['company_name']) ? htmlspecialchars($data['settings']['company_name']) : 'GearBK'; ?>">
                                        </div>
                                        <div class="col-12 col-md-6">
                                            <label class="form-label">Logo</label>
                                            <div class="input-group mb-3">
                                                <input type="file" class="form-control" name="logo" accept="image/*">
                                                <label class="input-group-text">Tải lên</label>
                                            </div>
                                            <?php if (isset($data['settings']['logo']) && !empty($data['settings']['logo'])): ?>
                                            <div class="mt-2">
                                                <img src="public/images/logos/<?php echo htmlspecialchars($data['settings']['logo']); ?>" alt="Current Logo" class="img-thumbnail img-preview" style="max-height: 100px;">
                                            </div>
                                            <?php endif; ?>
                                        </div>
                                    </div>
                                    <div class="row mb-3">
                                        <div class="col-12 col-md-4 mb-3 mb-md-0">
                                            <label class="form-label">Số điện thoại</label>
                                            <input type="text" class="form-control" name="phone" value="<?php echo isset($data['settings']['phone']) ? htmlspecialchars($data['settings']['phone']) : ''; ?>">
                                        </div>
                                        <div class="col-12 col-md-4 mb-3 mb-md-0">
                                            <label class="form-label">Email</label>
                                            <input type="email" class="form-control" name="email" value="<?php echo isset($data['settings']['email']) ? htmlspecialchars($data['settings']['email']) : ''; ?>">
                                        </div>
                                        <div class="col-12 col-md-4">
                                            <label class="form-label">Địa chỉ</label>
                                            <input type="text" class="form-control" name="address" value="<?php echo isset($data['settings']['address']) ? htmlspecialchars($data['settings']['address']) : ''; ?>">
                                        </div>
                                    </div>

                                    <!-- Additional Settings Accordion -->
                                    <div class="accordion mb-3" id="settingsAccordion">
                                        <!-- Giờ làm việc -->
                                        <div class="accordion-item">
                                            <h2 class="accordion-header" id="headingHours">
                                                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseHours" aria-expanded="false" aria-controls="collapseHours">
                                                    <i class="fas fa-clock me-2"></i> Giờ làm việc
                                                </button>
                                            </h2>
                                            <div id="collapseHours" class="accordion-collapse collapse" aria-labelledby="headingHours" data-bs-parent="#settingsAccordion">
                                                <div class="accordion-body">
                                                    <div class="row g-2">
                                                        <div class="col-12 col-md-4 mb-2">
                                                            <div class="input-group input-group-sm">
                                                                <span class="input-group-text">Thứ 2-6</span>
                                                                <input type="text" class="form-control" name="hours_weekday" value="<?php echo isset($data['settings']['hours_weekday']) ? htmlspecialchars($data['settings']['hours_weekday']) : '8:00 - 21:00'; ?>">
                                                            </div>
                                                        </div>
                                                        <div class="col-12 col-md-4 mb-2">
                                                            <div class="input-group input-group-sm">
                                                                <span class="input-group-text">Thứ 7</span>
                                                                <input type="text" class="form-control" name="hours_saturday" value="<?php echo isset($data['settings']['hours_saturday']) ? htmlspecialchars($data['settings']['hours_saturday']) : '9:00 - 21:00'; ?>">
                                                            </div>
                                                        </div>
                                                        <div class="col-12 col-md-4 mb-2">
                                                            <div class="input-group input-group-sm">
                                                                <span class="input-group-text">CN</span>
                                                                <input type="text" class="form-control" name="hours_sunday" value="<?php echo isset($data['settings']['hours_sunday']) ? htmlspecialchars($data['settings']['hours_sunday']) : '10:00 - 20:00'; ?>">
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        
                                        <!-- Mạng xã hội -->
                                        <div class="accordion-item">
                                            <h2 class="accordion-header" id="headingSocial">
                                                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseSocial" aria-expanded="false" aria-controls="collapseSocial">
                                                    <i class="fas fa-share-alt me-2"></i> Liên kết mạng xã hội
                                                </button>
                                            </h2>
                                            <div id="collapseSocial" class="accordion-collapse collapse" aria-labelledby="headingSocial" data-bs-parent="#settingsAccordion">
                                                <div class="accordion-body">
                                                    <div class="row g-2">
                                                        <div class="col-12 col-md-6 mb-2">
                                                            <div class="input-group input-group-sm">
                                                                <span class="input-group-text"><i class="fab fa-facebook-f text-primary"></i></span>
                                                                <input type="url" class="form-control" name="facebook_url" placeholder="Facebook URL" value="<?php echo htmlspecialchars($data['settings']['facebook_url']); ?>">
                                                            </div>
                                                        </div>
                                                        <div class="col-12 col-md-6 mb-2">
                                                            <div class="input-group input-group-sm">
                                                                <span class="input-group-text"><i class="fab fa-twitter text-info"></i></span>
                                                                <input type="url" class="form-control" name="twitter_url" placeholder="Twitter URL" value="<?php echo htmlspecialchars($data['settings']['twitter_url']); ?>">
                                                            </div>
                                                        </div>
                                                        <div class="col-12 col-md-6 mb-2">
                                                            <div class="input-group input-group-sm">
                                                                <span class="input-group-text"><i class="fab fa-instagram text-danger"></i></span>
                                                                <input type="url" class="form-control" name="instagram_url" placeholder="Instagram URL" value="<?php echo htmlspecialchars($data['settings']['instagram_url']); ?>">
                                                            </div>
                                                        </div>
                                                        <div class="col-12 col-md-6 mb-2">
                                                            <div class="input-group input-group-sm">
                                                                <span class="input-group-text"><i class="fab fa-youtube text-danger"></i></span>
                                                                <input type="url" class="form-control" name="youtube_url" placeholder="YouTube URL" value="<?php echo htmlspecialchars($data['settings']['youtube_url']); ?>">
                                                            </div>
                                                        </div>
                                                        <div class="col-12 col-md-6 mb-2">
                                                            <div class="input-group input-group-sm">
                                                                <span class="input-group-text"><i class="fab fa-tiktok"></i></span>
                                                                <input type="url" class="form-control" name="tiktok_url" placeholder="TikTok URL" value="<?php echo htmlspecialchars($data['settings']['tiktok_url']); ?>">
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        
                                        <!-- Bản đồ Google Maps -->
                                        <div class="accordion-item">
                                            <h2 class="accordion-header" id="headingMap">
                                                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseMap" aria-expanded="false" aria-controls="collapseMap">
                                                    <i class="fas fa-map-marker-alt me-2"></i> Bản đồ Google Maps
                                                </button>
                                            </h2>
                                            <div id="collapseMap" class="accordion-collapse collapse" aria-labelledby="headingMap" data-bs-parent="#settingsAccordion">
                                                <div class="p-3">
                                                    <div class="input-group input-group-sm">
                                                        <span class="input-group-text"><i class="fab fa-google"></i></span>
                                                        <input type="url" class="form-control" name="map_embed_url" placeholder="Google Maps URL" value="<?php echo htmlspecialchars($data['settings']['map_embed_url']); ?>">
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="mb-3">
                                        <label class="form-label">Nội dung giới thiệu</label>
                                        <div class="summernote-container">
                                            <textarea id="about-text-editor" class="form-control summernote" name="about_text" rows="5"><?php echo isset($data['settings']['about_text']) ? $data['settings']['about_text'] : ''; ?></textarea>
                                        </div>
                                    </div>
                                    <div class="d-flex justify-content-end">
                                        <button type="submit" class="btn btn-danger">
                                            <i class="fas fa-save me-1"></i><span class="d-none d-sm-inline">Lưu thay đổi</span><span class="d-inline d-sm-none">Lưu</span>
                                        </button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>

                    <!-- Carousel Management Tab -->
                    <div class="tab-pane fade" id="carousel-content" role="tabpanel" aria-labelledby="carousel-tab">
                        <div class="card">
                            <div class="card-header d-flex flex-wrap justify-content-between align-items-center bg-danger text-white gap-2">
                                <h5 class="mb-0">Quản Lý Carousel</h5>
                                <button class="btn btn-light btn-sm" data-bs-toggle="modal" data-bs-target="#addSlideModal">
                                    <i class="fas fa-plus me-1"></i><span class="d-none d-sm-inline">Thêm slide mới</span><span class="d-inline d-sm-none">Thêm</span>
                                </button>
                            </div>
                            <div class="card-body">
                                <?php if (empty($data['slides'])): ?>
                                <div class="text-center py-4">
                                    <p>Chưa có slide nào. Hãy thêm slide mới.</p>
                                </div>
                                <?php else: ?>
                                <div class="table-responsive">
                                    <table class="table table-bordered table-striped">
                                        <thead>
                                            <tr>
                                                <th>Thứ tự</th>
                                                <th>Hình ảnh</th>
                                                <th class="d-none d-md-table-cell">Tiêu đề</th>
                                                <th class="d-none d-lg-table-cell">Mô tả</th>
                                                <th class="d-none d-md-table-cell">Text nút</th>
                                                <th class="d-none d-lg-table-cell">Link</th>
                                                <th>Thao tác</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php foreach ($data['slides'] as $slide): ?>
                                            <tr>
                                                <td><?php echo htmlspecialchars($slide['display_order']); ?></td>
                                                <td>
                                                    <img src="public/images/carousel/<?php echo htmlspecialchars($slide['image_url']); ?>" 
                                                        alt="Slide" class="img-thumbnail img-preview" 
                                                        style="max-height: 60px; max-width: 100px;">
                                                </td>
                                                <td class="d-none d-md-table-cell"><?php echo htmlspecialchars($slide['title']); ?></td>
                                                <td class="d-none d-lg-table-cell"><?php echo substr(htmlspecialchars($slide['description']), 0, 50) . (strlen($slide['description']) > 50 ? '...' : ''); ?></td>
                                                <td class="d-none d-md-table-cell"><?php echo htmlspecialchars($slide['button_text']); ?></td>
                                                <td class="d-none d-lg-table-cell"><?php echo htmlspecialchars($slide['button_link']); ?></td>
                                                <td>
                                                    <div class="d-flex flex-wrap gap-1">
                                                        <button class="btn btn-sm btn-primary edit-slide-btn" 
                                                                data-id="<?php echo $slide['id']; ?>"
                                                                data-title="<?php echo htmlspecialchars($slide['title']); ?>"
                                                                data-description="<?php echo htmlspecialchars($slide['description']); ?>"
                                                                data-button-text="<?php echo htmlspecialchars($slide['button_text']); ?>"
                                                                data-button-link="<?php echo htmlspecialchars($slide['button_link']); ?>"
                                                                data-display-order="<?php echo htmlspecialchars($slide['display_order']); ?>"
                                                                data-bs-toggle="modal" data-bs-target="#editSlideModal">
                                                            <i class="fas fa-edit"></i>
                                                        </button>
                                                        <button class="btn btn-sm btn-danger delete-slide-btn"
                                                                data-id="<?php echo $slide['id']; ?>"
                                                                data-bs-toggle="modal" data-bs-target="#deleteSlideModal">
                                                            <i class="fas fa-trash"></i>
                                                        </button>
                                                    </div>
                                                </td>
                                            </tr>
                                            <?php endforeach; ?>
                                        </tbody>
                                    </table>
                                </div>
                                <?php endif; ?>
                            </div>
                        </div>

                        <!-- Carousel Preview -->
                        <div class="card mt-4">
                            <div class="card-header bg-danger text-white">
                                <h5 class="mb-0">Xem trước Carousel</h5>
                            </div>
                            <div class="card-body">
                                <?php if (empty($data['slides'])): ?>
                                <div class="text-center py-4">
                                    <p>Chưa có slide nào để xem trước.</p>
                                </div>
                                <?php else: ?>
                                <div id="carouselPreview" class="carousel slide" data-bs-ride="carousel">
                                    <div class="carousel-indicators">
                                        <?php foreach ($data['slides'] as $index => $slide): ?>
                                        <button type="button" data-bs-target="#carouselPreview" data-bs-slide-to="<?php echo $index; ?>" 
                                                <?php echo ($index === 0) ? 'class="active" aria-current="true"' : ''; ?> 
                                                aria-label="Slide <?php echo $index + 1; ?>"></button>
                                        <?php endforeach; ?>
                                    </div>
                                    <div class="carousel-inner rounded shadow-sm overflow-hidden">
                                        <?php foreach ($data['slides'] as $index => $slide): ?>
                                        <div class="carousel-item <?php echo ($index === 0) ? 'active' : ''; ?>">
                                            <img src="public/images/carousel/<?php echo htmlspecialchars($slide['image_url']); ?>" 
                                                    class="d-block w-100" 
                                                    alt="<?php echo htmlspecialchars($slide['title']); ?>" 
                                                    style="height: 500px; object-fit: cover;">
                                            <div class="carousel-caption d-flex align-items-end justify-content-center pb-3 pb-md-5" 
                                                style="top: 0; left: 0; right: 0; bottom: 0; width: 100%; height: 100%; position: absolute; background: linear-gradient(to top, rgba(0,0,0,1), rgba(0,0,0,0) 50%);">
                                                <div>
                                                    <h3 class="fw-bold mb-2 mb-md-3 fs-5 fs-md-4"><?php echo htmlspecialchars($slide['title']); ?></h3>
                                                    <p class="mb-2 mb-md-3 d-none d-sm-block"><?php echo htmlspecialchars($slide['description']); ?></p>
                                                    <a href="<?php echo htmlspecialchars($slide['button_link']); ?>" class="btn btn-light rounded-pill px-3 px-md-4 py-1 py-md-2 fw-bold btn-sm">
                                                        <?php echo htmlspecialchars($slide['button_text']); ?>
                                                    </a>
                                                </div>
                                            </div>
                                        </div>
                                        <?php endforeach; ?>
                                    </div>
                                    <button class="carousel-control-prev" type="button" data-bs-target="#carouselPreview" data-bs-slide="prev">
                                        <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                                        <span class="visually-hidden">Previous</span>
                                    </button>
                                    <button class="carousel-control-next" type="button" data-bs-target="#carouselPreview" data-bs-slide="next">
                                        <span class="carousel-control-next-icon" aria-hidden="true"></span>
                                        <span class="visually-hidden">Next</span>
                                    </button>
                                </div>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>

                    <!-- About Section Tab -->
                    <div class="tab-pane fade" id="about-content" role="tabpanel" aria-labelledby="about-tab">
                        <div class="card">
                            <div class="card-header bg-danger text-white">
                                <h5 class="mb-0">Phần Giới Thiệu</h5>
                            </div>
                            <div class="card-body">
                                <form action="/Gear/HomeAdminController/updateSettings" method="POST" enctype="multipart/form-data" class="ajax-form">
                                    <!-- Hidden field to pass company_name value -->
                                    <input type="hidden" name="company_name" value="<?php echo isset($data['settings']['company_name']) ? htmlspecialchars($data['settings']['company_name']) : 'GearBK'; ?>">
                                    
                                    <div class="mb-3">
                                        <label class="form-label">Tiêu đề phần Giới Thiệu</label>
                                        <input type="text" class="form-control" name="about_title" value="<?php echo isset($data['settings']['about_title']) ? htmlspecialchars($data['settings']['about_title']) : 'Về Chúng Tôi'; ?>">
                                    </div>
                                    
                                    <div class="mb-3">
                                        <label class="form-label">Hình ảnh chính phần Giới Thiệu</label>
                                        <div class="input-group mb-3">
                                            <input type="file" class="form-control" name="about_image" accept="image/*">
                                            <label class="input-group-text">Tải lên</label>
                                        </div>
                                        <?php if (isset($data['settings']['about_image']) && !empty($data['settings']['about_image'])): ?>
                                        <div class="mt-2">
                                            <img src="public/images/about/<?php echo htmlspecialchars($data['settings']['about_image']); ?>" alt="About Image" class="img-thumbnail img-preview" style="max-height: 200px;">
                                        </div>
                                        <?php endif; ?>
                                    </div>
                                    
                                    <div class="mb-3">
                                        <label class="form-label">Nội dung chính</label>
                                        <div class="summernote-container">
                                            <textarea id="about-content-editor" class="form-control summernote" name="about_content" rows="5"><?php echo isset($data['settings']['about_content']) ? $data['settings']['about_content'] : ''; ?></textarea>
                                        </div>
                                    </div>
                                    
                                    <div class="accordion mb-4" id="aboutAccordion">
                                        <!-- Company History Section -->
                                        <div class="accordion-item">
                                            <h2 class="accordion-header" id="headingHistory">
                                                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseHistory" aria-expanded="false" aria-controls="collapseHistory">
                                                    <i class="fas fa-history me-2"></i> Lịch sử công ty
                                                </button>
                                            </h2>
                                            <div id="collapseHistory" class="accordion-collapse collapse" aria-labelledby="headingHistory" data-bs-parent="#aboutAccordion">
                                                <div class="accordion-body">
                                                    <div class="mb-3">
                                                        <label class="form-label">Tiêu đề lịch sử</label>
                                                        <input type="text" class="form-control" name="about_history_title" value="<?php echo isset($data['settings']['about_history_title']) ? htmlspecialchars($data['settings']['about_history_title']) : 'Lịch Sử Hình Thành'; ?>">
                                                    </div>
                                                    <div class="mb-3">
                                                        <label class="form-label">Nội dung lịch sử</label>
                                                        <div class="summernote-container">
                                                            <textarea class="form-control summernote" name="about_history_content" rows="4"><?php echo isset($data['settings']['about_history_content']) ? $data['settings']['about_history_content'] : ''; ?></textarea>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        
                                        <!-- Mission & Vision Section -->
                                        <div class="accordion-item">
                                            <h2 class="accordion-header" id="headingMission">
                                                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseMission" aria-expanded="false" aria-controls="collapseMission">
                                                    <i class="fas fa-bullseye me-2"></i> Sứ mệnh & Tầm nhìn
                                                </button>
                                            </h2>
                                            <div id="collapseMission" class="accordion-collapse collapse" aria-labelledby="headingMission" data-bs-parent="#aboutAccordion">
                                                <div class="accordion-body">
                                                    <div class="mb-3">
                                                        <label class="form-label">Tiêu đề sứ mệnh</label>
                                                        <input type="text" class="form-control" name="about_mission_title" value="<?php echo isset($data['settings']['about_mission_title']) ? htmlspecialchars($data['settings']['about_mission_title']) : 'Sứ Mệnh Của Chúng Tôi'; ?>">
                                                    </div>
                                                    <div class="mb-3">
                                                        <label class="form-label">Nội dung sứ mệnh</label>
                                                        <div class="summernote-container">
                                                            <textarea class="form-control summernote" name="about_mission_content" rows="3"><?php echo isset($data['settings']['about_mission_content']) ? $data['settings']['about_mission_content'] : ''; ?></textarea>
                                                        </div>
                                                    </div>
                                                    <div class="mb-3">
                                                        <label class="form-label">Tiêu đề tầm nhìn</label>
                                                        <input type="text" class="form-control" name="about_vision_title" value="<?php echo isset($data['settings']['about_vision_title']) ? htmlspecialchars($data['settings']['about_vision_title']) : 'Tầm Nhìn'; ?>">
                                                    </div>
                                                    <div class="mb-3">
                                                        <label class="form-label">Nội dung tầm nhìn</label>
                                                        <div class="summernote-container">
                                                            <textarea class="form-control summernote" name="about_vision_content" rows="3"><?php echo isset($data['settings']['about_vision_content']) ? $data['settings']['about_vision_content'] : ''; ?></textarea>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        
                                        <!-- Values Section -->
                                        <div class="accordion-item">
                                            <h2 class="accordion-header" id="headingValues">
                                                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseValues" aria-expanded="false" aria-controls="collapseValues">
                                                    <i class="fas fa-gem me-2"></i> Giá trị cốt lõi
                                                </button>
                                            </h2>
                                            <div id="collapseValues" class="accordion-collapse collapse" aria-labelledby="headingValues" data-bs-parent="#aboutAccordion">
                                                <div class="accordion-body">
                                                    <div class="mb-3">
                                                        <label class="form-label">Tiêu đề giá trị cốt lõi</label>
                                                        <input type="text" class="form-control" name="about_values_title" value="<?php echo isset($data['settings']['about_values_title']) ? htmlspecialchars($data['settings']['about_values_title']) : 'Giá Trị Cốt Lõi'; ?>">
                                                    </div>
                                                    <div class="mb-3">
                                                        <label class="form-label">Nội dung giá trị cốt lõi</label>
                                                        <div class="summernote-container">
                                                            <textarea class="form-control summernote" name="about_values_content" rows="4"><?php echo isset($data['settings']['about_values_content']) ? $data['settings']['about_values_content'] : ''; ?></textarea>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        
                                        <!-- Achievements Section -->
                                        <div class="accordion-item">
                                            <h2 class="accordion-header" id="headingAchievements">
                                                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseAchievements" aria-expanded="false" aria-controls="collapseAchievements">
                                                    <i class="fas fa-trophy me-2"></i> Thành tựu & Giải thưởng
                                                </button>
                                            </h2>
                                            <div id="collapseAchievements" class="accordion-collapse collapse" aria-labelledby="headingAchievements" data-bs-parent="#aboutAccordion">
                                                <div class="accordion-body">
                                                    <div class="mb-3">
                                                        <label class="form-label">Tiêu đề thành tựu</label>
                                                        <input type="text" class="form-control" name="about_achievements_title" value="<?php echo isset($data['settings']['about_achievements_title']) ? htmlspecialchars($data['settings']['about_achievements_title']) : 'Thành Tựu & Giải Thưởng'; ?>">
                                                    </div>
                                                    <div class="mb-3">
                                                        <label class="form-label">Nội dung thành tựu</label>
                                                        <div class="summernote-container">
                                                            <textarea class="form-control summernote" name="about_achievements_content" rows="4"><?php echo isset($data['settings']['about_achievements_content']) ? $data['settings']['about_achievements_content'] : ''; ?></textarea>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    
                                    <div class="d-flex justify-content-end">
                                        <button type="submit" class="btn btn-danger">
                                            <i class="fas fa-save me-1"></i><span class="d-none d-sm-inline">Lưu thay đổi</span><span class="d-inline d-sm-none">Lưu</span>
                                        </button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Add Slide Modal -->
    <div class="modal fade" id="addSlideModal" tabindex="-1" aria-labelledby="addSlideModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-scrollable modal-lg">
            <div class="modal-content">
                <div class="modal-header bg-danger text-white">
                    <h5 class="modal-title" id="addSlideModalLabel">Thêm Slide Mới</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form action="/Gear/HomeAdminController/addCarouselSlide" method="POST" enctype="multipart/form-data" class="ajax-form">
                    <div class="modal-body">
                        <div class="mb-3">
                            <label class="form-label">Tiêu đề</label>
                            <input type="text" class="form-control" name="title" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Mô tả</label>
                            <textarea class="form-control" name="description" rows="3"></textarea>
                        </div>
                        <div class="row mb-3">
                            <div class="col-12 col-md-6 mb-3 mb-md-0">
                                <label class="form-label">Text nút</label>
                                <input type="text" class="form-control" name="button_text" value="Mua Ngay">
                            </div>
                            <div class="col-12 col-md-6">
                                <label class="form-label">Link nút</label>
                                <input type="text" class="form-control" name="button_link" value="#featured-products">
                            </div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-12 col-md-6 mb-3 mb-md-0">
                                <label class="form-label">Thứ tự hiển thị</label>
                                <input type="number" class="form-control" name="display_order" value="1" min="1">
                            </div>
                            <div class="col-12 col-md-6">
                                <label class="form-label">Hình ảnh slide</label>
                                <input type="file" class="form-control" name="image" accept="image/*" required>
                                <small class="form-text text-muted">Khuyến nghị kích thước: 1920 x 800 pixels</small>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer flex-wrap gap-2">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Đóng</button>
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-plus me-1"></i> Thêm slide
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Edit Slide Modal -->
    <div class="modal fade" id="editSlideModal" tabindex="-1" aria-labelledby="editSlideModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-scrollable modal-lg">
            <div class="modal-content">
                <div class="modal-header bg-danger text-white">
                    <h5 class="modal-title" id="editSlideModalLabel">Chỉnh Sửa Slide</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form action="/Gear/HomeAdminController/updateCarouselSlide" method="POST" enctype="multipart/form-data" class="ajax-form">
                    <input type="hidden" name="id" id="edit-slide-id">
                    <div class="modal-body">
                        <div class="mb-3">
                            <label class="form-label">Tiêu đề</label>
                            <input type="text" class="form-control" name="title" id="edit-slide-title" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Mô tả</label>
                            <textarea class="form-control" name="description" id="edit-slide-description" rows="3"></textarea>
                        </div>
                        <div class="row mb-3">
                            <div class="col-12 col-md-6 mb-3 mb-md-0">
                                <label class="form-label">Text nút</label>
                                <input type="text" class="form-control" name="button_text" id="edit-slide-button-text">
                            </div>
                            <div class="col-12 col-md-6">
                                <label class="form-label">Link nút</label>
                                <input type="text" class="form-control" name="button_link" id="edit-slide-button-link">
                            </div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-12 col-md-6 mb-3 mb-md-0">
                                <label class="form-label">Thứ tự hiển thị</label>
                                <input type="number" class="form-control" name="display_order" id="edit-slide-display-order" min="1">
                            </div>
                            <div class="col-12 col-md-6">
                                <label class="form-label">Hình ảnh slide mới (để trống nếu không thay đổi)</label>
                                <input type="file" class="form-control" name="image" accept="image/*">
                                <small class="form-text text-muted">Khuyến nghị kích thước: 1920 x 800 pixels</small>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer flex-wrap gap-2">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Đóng</button>
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-save me-1"></i> Lưu thay đổi
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Delete Slide Confirmation Modal -->
    <div class="modal fade" id="deleteSlideModal" tabindex="-1" aria-labelledby="deleteSlideModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header bg-danger text-white">
                    <h5 class="modal-title" id="deleteSlideModalLabel">Xác Nhận Xóa</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <p>Bạn có chắc chắn muốn xóa slide này không? Hành động này không thể hoàn tác.</p>
                </div>
                <div class="modal-footer flex-wrap gap-2">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Hủy</button>
                    <form action="/Gear/HomeAdminController/deleteCarouselSlide" method="POST" class="ajax-form">
                        <input type="hidden" name="id" id="delete-slide-id">
                        <button type="submit" class="btn btn-danger">
                            <i class="fas fa-trash me-1"></i> Xóa
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- JavaScript Libraries -->
    <script src="https://cdn.jsdelivr.net/npm/jquery@3.6.0/dist/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote-lite.min.js"></script>
    <!-- SweetAlert2 -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.js"></script>

    <!-- Custom Script -->
    <script>
        $(document).ready(function() {
            // Tab persistence functionality
            // Set active tab based on localStorage if exists
            const activeTab = localStorage.getItem('activeAdminTab');
            if (activeTab) {
                // Activate tab from localStorage
                $(`.nav-link[data-bs-target="${activeTab}"]`).tab('show');
            }
            
            // Save active tab selection when clicked
            $('.nav-link[data-bs-toggle="tab"]').on('shown.bs.tab', function (e) {
                const targetTab = $(e.target).data('bs-target');
                localStorage.setItem('activeAdminTab', targetTab);
            });
            
            // Handle window resize
            let resizeTimer;
            $(window).resize(function() {
                clearTimeout(resizeTimer);
                resizeTimer = setTimeout(function() {
                    adjustSummernoteForMobile();
                }, 250);
            });
            
            // Initialize Summernote editors with responsive options
            function initSummernote() {
                $('.summernote').each(function() {
                    let options = {
                        placeholder: 'Nhập nội dung...',
                        tabsize: 2,
                        height: 200,
                        callbacks: {
                            onBlur: function() {
                                // Update the textarea value when editor loses focus
                                var content = $(this).summernote('code');
                                $(this).val(content);
                            }
                        }
                    };
                    
                    // Reduce toolbar options on small screens
                    if (window.innerWidth < 768) {
                        options.toolbar = [
                            ['style', ['bold', 'italic', 'underline']],
                            ['para', ['ul', 'ol']],
                            ['view', ['fullscreen']]
                        ];
                        options.height = 150;
                    } else {
                        options.toolbar = [
                            ['style', ['style']],
                            ['font', ['bold', 'underline', 'clear']],
                            ['color', ['color']],
                            ['para', ['ul', 'ol', 'paragraph']],
                            ['table', ['table']],
                            ['insert', ['link']],
                            ['view', ['fullscreen', 'codeview', 'help']]
                        ];
                    }
                    
                    // Initialize or destroy/reinitialize
                    if ($(this).data('summernote')) {
                        $(this).summernote('destroy');
                    }
                    $(this).summernote(options);
                });
            }
            
            // Adjust Summernote for mobile devices
            function adjustSummernoteForMobile() {
                initSummernote();
            }
            
            // Initialize Summernote
            initSummernote();

            // Handle form submissions with AJAX - only target ajax-form class
            $('.ajax-form').submit(function(e) {
                e.preventDefault(); // Prevent default form submission
                
                const form = $(this);
                const url = form.attr('action');
                
                // Make sure Summernote content is updated in the textarea
                $('.summernote').each(function() {
                    var content = $(this).summernote('code');
                    $(this).val(content);
                });
                
                const formData = new FormData(this);
                
                // Show loading indicator
                const submitBtn = form.find('button[type="submit"]');
                const originalBtnText = submitBtn.html();
                submitBtn.html('<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span> Đang xử lý...');
                submitBtn.prop('disabled', true);
                
                $.ajax({
                    url: url,
                    type: 'POST',
                    data: formData,
                    processData: false,
                    contentType: false,
                    dataType: 'text', // Change to text to handle any response type
                    success: function(response) {
                        console.log("Response received:", response);
                        
                        // Reset button state
                        submitBtn.html(originalBtnText);
                        submitBtn.prop('disabled', false);
                        
                        // Try to parse as JSON
                        let jsonResponse;
                        let successStatus = true;
                        let message = "Thao tác thành công!";
                        
                        try {
                            // Try to parse the response as JSON
                            if (response.trim().startsWith('{')) {
                                jsonResponse = JSON.parse(response);
                                successStatus = jsonResponse.success;
                                message = jsonResponse.message || message;
                            } else if (response.trim().startsWith('<')) {
                                // HTML response means success (form would have redirected on error)
                                console.log("HTML response received, treating as success");
                                successStatus = true;
                                
                                // Show success alert using SweetAlert
                                Swal.fire({
                                    title: 'Thành công!',
                                    text: 'Thao tác đã được lưu thành công',
                                    icon: 'success',
                                    timer: 2000,
                                    timerProgressBar: true,
                                    showConfirmButton: false
                                });
                                
                                // Reload the page after success
                                setTimeout(function() {
                                    location.reload();
                                }, 2000);
                                return;
                            }
                        } catch (e) {
                            console.warn("Could not parse response as JSON:", e);
                            // Show the raw response in a success message anyway
                            // The operation likely succeeded since we're in the success callback
                        }
                        
                        if (successStatus) {
                            // Show success alert using SweetAlert
                            Swal.fire({
                                title: 'Thành công!',
                                text: message,
                                icon: 'success',
                                timer: 2000,
                                timerProgressBar: true,
                                showConfirmButton: false
                            });
                            
                            // Close modal if it's in a modal
                            if (form.closest('.modal').length) {
                                form.closest('.modal').modal('hide');
                            }
                            
                            // Reload the page after success
                            setTimeout(function() {
                                location.reload();
                            }, 2000);
                        } else {
                            // Show error alert using SweetAlert
                            Swal.fire({
                                title: 'Lỗi!',
                                text: message,
                                icon: 'error',
                                confirmButtonText: 'Đóng'
                            });
                        }
                    },
                    error: function(xhr, status, error) {
                        console.error("AJAX Error:", status, error);
                        console.error("Response:", xhr.responseText);
                        
                        // Reset button state
                        submitBtn.html(originalBtnText);
                        submitBtn.prop('disabled', false);
                        
                        // Show error alert using SweetAlert
                        Swal.fire({
                            title: 'Lỗi!',
                            text: `Có lỗi xảy ra! Vui lòng thử lại. (${status}: ${error})`,
                            icon: 'error',
                            confirmButtonText: 'Đóng'
                        });
                        
                        // If we got a response, try to handle it anyway
                        if (xhr.responseText && xhr.responseText.trim().length > 0) {
                            if (xhr.responseText.trim().startsWith('<')) {
                                // HTML response means the form submission needs to go to a different page
                                // This might be a redirect or the server returning a complete page
                                console.log("HTML response in error handler, reloading page");
                                setTimeout(function() {
                                    location.reload();
                                }, 1500);
                            }
                        }
                    }
                });
            });

            // Handle edit slide button click
            $('.edit-slide-btn').click(function() {
                const id = $(this).data('id');
                const title = $(this).data('title');
                const description = $(this).data('description');
                const buttonText = $(this).data('button-text');
                const buttonLink = $(this).data('button-link');
                const displayOrder = $(this).data('display-order');

                $('#edit-slide-id').val(id);
                $('#edit-slide-title').val(title);
                $('#edit-slide-description').val(description);
                $('#edit-slide-button-text').val(buttonText);
                $('#edit-slide-button-link').val(buttonLink);
                $('#edit-slide-display-order').val(displayOrder);
            });

            // Handle delete slide button click
            $('.delete-slide-btn').click(function() {
                const id = $(this).data('id');
                $('#delete-slide-id').val(id);
            });
        });
    </script>
</body>

</html> 