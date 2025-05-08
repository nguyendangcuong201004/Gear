<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo isset($data['settings']['company_name']) ? htmlspecialchars($data['settings']['company_name']) : 'GearBK Store'; ?></title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css"
        integrity="sha512-Evv84Mr4kqVGRNSgIGL/F/aIDqQb7xQ2vcrdIwxfjThSH8CSR7PBEakCr51Ck+w+/U6swU2Im1vVX0SVk9ABhg=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="/Gear/public/css/style.css">
    <link rel="stylesheet" href="/Gear/public/css/home.css">
    <style>
        /* Styles for login/logout buttons */
        .inner-user a, .inner-logout a {
            color: inherit;
            text-decoration: none;
            transition: color 0.3s ease;
        }
        .inner-user a:hover, .inner-logout a:hover {
            color: #e74c3c;
        }
        .inner-logout {
            margin-left: 15px;
        }
    </style>
</head>

<body class="bg-light">
    <header>
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <div class="inner-content">
                        <?php if (isset($data['settings']['logo']) && !empty($data['settings']['logo'])
                                && isset($data['settings']['company_name']) && !empty($data['settings']['company_name'])): ?>
                        <a class="inner-logo text-decoration-none text-dark" href="">
                            <img src="./public/images/logos/<?php echo htmlspecialchars($data['settings']['logo']); ?>" alt="GearBK Logo">
                            <span><?php echo htmlspecialchars($data['settings']['company_name']); ?></span>
                        </a>
                        <?php endif; ?>
                        <div class="inner-menu">
                            <ul>
                                <li>
                                    <a href="/Gear">HOME</a>
                                </li>
                                <li>
                                    <a href="/Gear/AboutController/index">ABOUT</a>
                                </li>
                                <li>
                                    <a href="/Gear/ProductController/list">SHOP</a>
                                </li>
                                <li>
                                    <a href="/Gear/ContactController">CONTACT</a>
                                </li>
                                <li>
                                    <a href="/Gear/BlogController/list">BLOG</a>
                                </li>
                                <li>
                                    <a href="/Gear/QAController/list">Q&A</a>
                                </li>
                            </ul>
                        </div>
                        <div class="d-flex">
                            <div class="inner-shop"><i class="fa-solid fa-bag-shopping"></i></div>
                            <?php if(isset($_COOKIE['access_token'])): ?>
                                <div class="inner-user mx-3">
                                    <a href="/Gear/AuthController/profile" title="Thông tin cá nhân" style="color: inherit; text-decoration: none;">
                                        <i class="fa-solid fa-user"></i>
                                    </a>
                                </div>
                                <div class="inner-logout">
                                    <a href="/Gear/AuthController/logout" title="Đăng xuất" style="color: inherit; text-decoration: none;">
                                        <i class="fa-solid fa-sign-out-alt"></i> Đăng xuất
                                    </a>
                                </div>
                            <?php else: ?>
                                <div class="inner-user">
                                    <a href="/Gear/AuthController/login" title="Đăng nhập" style="color: inherit; text-decoration: none;">
                                        <i class="fa-solid fa-user"></i>
                                    </a>
                                </div>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </header>

    <!-- Search Section -->
    <div class="container py-4">
        <div class="row justify-content-center">
            <div class="col-md-8 col-lg-6">
                <div class="search-wrapper bg-white rounded-4 shadow-sm p-3">
                    <form onsubmit="handleSearch(event)" class="search-form">
                        <div class="input-group">
                            <span class="input-group-text bg-white border-end-0">
                                <i class="fas fa-search text-muted"></i>
                            </span>
                            <input type="text" 
                                   class="form-control border-start-0 ps-0 search-input" 
                                   id="searchInput" 
                                   placeholder="Tìm kiếm sản phẩm..." 
                                   aria-label="Search">
                            <button class="btn btn-danger rounded-end-pill px-4 search-btn" type="submit">
                                Tìm kiếm
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Carousel and Categories Section -->
    <div class="container-fluid pt-3">
        <div class="row g-3">
            <!-- Mobile Categories Dropdown -->
            <div class="col-12 d-md-none mb-3">
                <div class="dropdown">
                    <button class="btn btn-danger w-100 d-flex justify-content-between align-items-center" type="button" 
                            data-bs-toggle="dropdown" aria-expanded="false">
                        <span>Danh Mục Sản Phẩm</span>
                        <i class="fas fa-chevron-down"></i>
                    </button>
                    <ul class="dropdown-menu w-100">
                        <?php foreach ($data['categories'] as $category): ?>
                        <li>
                            <a class="dropdown-item py-2" href="#category-container-<?php echo $category['id']; ?>">
                                <i class="<?php echo htmlspecialchars($category['icon_class']); ?> me-2"></i>
                                <?php echo htmlspecialchars($category['title']); ?>
                            </a>
                        </li>
                        <?php endforeach; ?>
                    </ul>
                </div>
            </div>
            
            <!-- Desktop Categories Sidebar -->
            <div class="col-lg-2 col-md-3 d-none d-md-block">
                <div class="card shadow-sm h-auto sticky-top" style="top: 15px; z-index: 10;">
                    <div class="card-header bg-danger text-white">
                        <h5 class="mb-0 fs-5">Danh Mục Sản Phẩm</h5>
                    </div>
                    <div class="list-group list-group-flush">
                        <?php foreach ($data['categories'] as $category): ?>
                        <a href="#category-container-<?php echo $category['id']; ?>" class="list-group-item list-group-item-action d-flex align-items-center py-3">
                            <i class="<?php echo htmlspecialchars($category['icon_class']); ?> me-2"></i>
                            <?php echo htmlspecialchars($category['title']); ?>
                        </a>
                        <?php endforeach; ?>
                    </div>
                </div>
            </div>
            
            <div class="col-lg-10 col-md-9 col-12">
                <div id="mainCarousel" class="carousel slide" data-bs-ride="carousel">
                    <!-- Carousel indicators -->
                    <div class="carousel-indicators">
                        <?php 
                        if (!empty($data['slides'])) {
                            foreach ($data['slides'] as $index => $slide) : 
                        ?>
                            <button type="button" data-bs-target="#mainCarousel" data-bs-slide-to="<?php echo $index; ?>" 
                                    <?php echo ($index === 0) ? 'class="active" aria-current="true"' : ''; ?> 
                                    aria-label="Slide <?php echo $index + 1; ?>"></button>
                        <?php 
                            endforeach;
                        } else { 
                        ?>
                            <button type="button" data-bs-target="#mainCarousel" data-bs-slide-to="0" class="active" aria-current="true" aria-label="Slide 1"></button>
                        <?php } ?>
                    </div>
                    
                    <!-- Carousel items -->
                    <div class="carousel-inner rounded shadow-sm overflow-hidden">
                        <?php 
                        if (!empty($data['slides'])) {
                            foreach ($data['slides'] as $index => $slide) : 
                        ?>
                            <div class="carousel-item <?php echo ($index === 0) ? 'active' : ''; ?>">
                                <img src="./public/images/carousel/<?php echo htmlspecialchars($slide['image_url']); ?>" 
                                        class="d-block w-100" 
                                        alt="<?php echo htmlspecialchars($slide['title']); ?>" 
                                        style="height: 500px; object-fit: cover;">
                                <div class="carousel-caption d-flex align-items-end justify-content-center pb-5" 
                                    style="top: 0; left: 0; right: 0; bottom: 0; width: 100%; height: 500px; position: absolute; background: linear-gradient(to top, rgba(0,0,0,1), rgba(0,0,0,0) 70%);">
                                    <div>
                                        <h2 class="fw-bold mb-2 mb-md-3 fs-4 fs-md-3 fs-lg-2"><?php echo htmlspecialchars($slide['title']); ?></h2>
                                        <?php if (!empty($slide['description'])) : ?>
                                            <p class="mb-2 mb-md-3 d-none d-sm-block"><?php echo htmlspecialchars($slide['description']); ?></p>
                                        <?php endif; ?>
                                        <a href="<?php echo htmlspecialchars($slide['button_link']); ?>" 
                                           class="btn btn-light rounded-pill px-3 px-md-4 py-1 py-md-2 fw-bold btn-sm btn-md-lg">
                                            <?php echo htmlspecialchars($slide['button_text']); ?>
                                        </a>
                                    </div>
                                </div>
                            </div>
                        <?php 
                            endforeach;
                        } else { 
                        ?>
                            <div class="carousel-item active">
                                <img src="public/images/default-slide.jpg" 
                                        class="d-block w-100" alt="GearBK" 
                                        style="height: 500px; object-fit: cover;">
                                <div class="carousel-caption d-flex align-items-end justify-content-center pb-5" style="top: 0; left: 0; right: 0; bottom: 0; width: 100%; height: 500px; position: absolute; background: linear-gradient(to top, rgba(0,0,0,1), rgba(0,0,0,0) 50%);">
                                    <div>
                                        <h2 class="fw-bold mb-2 mb-md-3 fs-4 fs-md-3 fs-lg-2">Chào mừng đến với GearBK</h2>
                                        <a href="#featured-products" class="btn btn-light rounded-pill px-3 px-md-4 py-1 py-md-2 fw-bold btn-sm btn-md-lg">Khám Phá</a>
                                    </div>
                                </div>
                            </div>
                        <?php } ?>
                    </div>
                    
                    <!-- Carousel controls -->
                    <button class="carousel-control-prev" type="button" data-bs-target="#mainCarousel" data-bs-slide="prev">
                        <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                        <span class="visually-hidden">Previous</span>
                    </button>
                    <button class="carousel-control-next" type="button" data-bs-target="#mainCarousel" data-bs-slide="next">
                        <span class="carousel-control-next-icon" aria-hidden="true"></span>
                        <span class="visually-hidden">Next</span>
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- Featured Products Section -->
    <div class="container pt-4 pt-md-5">
        <div class="row" id="featured-products">
            <div class="col-md-6 mb-3 mb-md-4">
                <h2 class="fw-bold mb-0 fs-3 fs-md-2">Sản Phẩm Nổi Bật</h2>
                <p class="text-muted mb-0 d-none d-sm-block">Khám phá thiết bị gaming mới nhất</p>
            </div>
            <div class="col-md-6 d-flex justify-content-md-end align-items-center mb-3 mb-md-4">
                <a href="#" class="btn btn-outline-danger rounded-pill">Xem thêm <i class="fas fa-arrow-right ms-1"></i></a>
            </div>
        </div>
        
        <!-- Mobile version: Scrollable cards without arrows -->
        <div class="d-md-none">
            <div class="row flex-nowrap overflow-auto pb-3 hide-scrollbar mx-0" id="featured-products-mobile">
                <?php foreach ($data['featuredProducts'] as $product): ?>
                <div class="col-9 col-sm-6 pe-3">
                    <div class="card shadow-sm h-100 product-card">
                        <a href="/Gear/ProductController/detail/slug=<?php echo htmlspecialchars($product['slug']); ?>" class="card-body p-3 text-decoration-none d-flex flex-column h-100">
                            <?php if(isset($product['discount']) && $product['discount'] > 0): ?>
                                <div class="discount-badge position-absolute top-0 end-0 bg-danger text-white fw-bold p-2 rounded m-2">
                                    -<?php echo $product['discount']; ?>%
                                </div>
                            <?php endif; ?>
                            <div class="card-img-wrapper mb-3 text-center bg-white p-2 rounded">
                                <img src="public/images/products/<?php echo htmlspecialchars($product['images']); ?>" 
                                        class="card-img-top" 
                                        alt="<?php echo htmlspecialchars($product['name']); ?>"
                                        onerror="this.onerror=null; this.src='public/images/default-product.jpg';"
                                        style="height: 150px; object-fit: contain;">
                            </div>
                            <h5 class="card-title fw-bold text-dark mb-2 fs-6" style="display: -webkit-box; -webkit-line-clamp: 2; -webkit-box-orient: vertical; overflow: hidden; text-overflow: ellipsis; min-height: 38px;">
                                <?php echo htmlspecialchars($product['name']); ?>
                            </h5>
                            <div class="mt-auto">
                                <span class="text-danger mb-2 d-block fs-5">
                                    <?php if(isset($product['discount']) && $product['discount'] > 0): ?>                                                
                                        <div>
                                            <del class="text-muted me-2 small"><?php echo number_format($product['price'], 0, ',', '.'); ?>₫</del>
                                        </div>
                                        <strong><?php echo number_format($product['price'] * (100 - $product['discount']) / 100, 0, ',', '.'); ?>₫</strong>
                                    <?php else: ?>
                                        <strong><?php echo number_format($product['price'], 0, ',', '.'); ?>₫</strong>
                                    <?php endif; ?>
                                </span>
                                <button class="btn btn-danger rounded-pill w-100 add-to-cart-btn btn-sm">
                                    <i class="fas fa-shopping-cart me-1"></i>Thêm vào giỏ
                                </button>
                            </div>
                        </a>
                    </div>
                </div>
                <?php endforeach; ?>
            </div>
        </div>
        
        <!-- Desktop version: Cards with navigation arrows -->
        <div class="position-relative d-none d-md-block">
            <div class="navigation-buttons position-absolute top-50 start-0 translate-middle-y z-3">
                <button class="btn btn-danger rounded-circle prev-btn me-2 shadow text-danger"
                    onclick="scrollCards('featured-products-container', 'left')">
                    <i class="fas fa-chevron-left"></i>
                </button>
            </div>
            <div class="navigation-buttons position-absolute top-50 end-0 translate-middle-y z-3">
                <button class="btn btn-danger rounded-circle next-btn shadow text-danger"
                    onclick="scrollCards('featured-products-container', 'right')">
                    <i class="fas fa-chevron-right"></i>
                </button>
            </div>
            <div class="row flex-nowrap overflow-hidden mx-auto" id="featured-products-container">
                <?php foreach ($data['featuredProducts'] as $product): ?>
                <div class="col-lg-3 col-md-4 col-sm-6 mb-4">
                    <div class="card shadow-sm h-100 product-card">
                        <a href="/Gear/ProductController/detail/slug=<?php echo htmlspecialchars($product['slug']); ?>" class="card-body p-3 text-decoration-none d-flex flex-column h-100">
                            <?php if(isset($product['discount']) && $product['discount'] > 0): ?>
                                <div class="discount-badge position-absolute top-0 end-0 bg-danger text-white fw-bold p-2 rounded m-2">
                                    -<?php echo $product['discount']; ?>%
                                </div>
                            <?php endif; ?>
                            <div class="card-img-wrapper mb-3 text-center bg-white p-2 rounded">
                                <img src="public/images/products/<?php echo htmlspecialchars($product['images']); ?>" 
                                        class="card-img-top" 
                                        alt="<?php echo htmlspecialchars($product['name']); ?>"
                                        onerror="this.onerror=null; this.src='public/images/default-product.jpg';"
                                        style="height: 180px; object-fit: contain;">
                            </div>
                            <h5 class="card-title fw-bold text-dark mb-2" style="display: -webkit-box; -webkit-line-clamp: 2; -webkit-box-orient: vertical; overflow: hidden; text-overflow: ellipsis; min-height: 48px;">
                                <?php echo htmlspecialchars($product['name']); ?>
                            </h5>
                            <div class="mt-auto">
                                <span class="h5 text-danger mb-3 d-block">
                                    <?php if(isset($product['discount']) && $product['discount'] > 0): ?>                                                
                                        <div>
                                            <del class="text-muted me-2 small"><?php echo number_format($product['price'], 0, ',', '.'); ?>₫</del>
                                        </div>
                                        <strong><?php echo number_format($product['price'] * (100 - $product['discount']) / 100, 0, ',', '.'); ?>₫</strong>
                                    <?php else: ?>
                                        <strong><?php echo number_format($product['price'], 0, ',', '.'); ?>₫</strong>
                                    <?php endif; ?>
                                </span>
                                <button class="btn btn-danger rounded-pill w-100 add-to-cart-btn">
                                    <i class="fas fa-shopping-cart me-2"></i>Thêm vào giỏ
                                </button>
                            </div>
                        </a>
                    </div>
                </div>
                <?php endforeach; ?>
            </div>
        </div>
    </div>
    
    <!-- Category Products Sections -->
    <div class="container pt-4 pt-md-5">
        <?php foreach ($data['categories'] as $index => $category): ?>
            <div class="row" id="category-<?php echo $category['id']; ?>">
                <div class="col-md-6 mb-3 mb-md-4">
                    <h2 class="fw-bold mb-0 fs-3 fs-md-2"><?php echo htmlspecialchars($category['name']); ?></h2>
                    <div class="border-bottom border-danger mt-2 mb-2" style="width: 50px; border-width: 3px !important;"></div>
                </div>
                <div class="col-md-6 d-flex justify-content-md-end align-items-center mb-3 mb-md-4">
                    <a href="/home/category/<?php echo $category['id']; ?>" class="btn btn-outline-danger rounded-pill">Xem thêm <i class="fas fa-arrow-right ms-1"></i></a>
                </div>
            </div>
            
            <!-- Mobile version: Scrollable cards without arrows -->
            <div class="d-md-none">
                <div class="row flex-nowrap overflow-auto pb-3 hide-scrollbar mx-0" id="category-mobile-<?php echo $category['id']; ?>">
                    <?php 
                    // Use products specific to this category
                    $categoryProducts = isset($data['categoryProducts'][$category['id']]) ? 
                        $data['categoryProducts'][$category['id']] : [];
                    
                    if (empty($categoryProducts)) {
                        echo '<div class="col-12 text-center py-4"><p>No products in this category yet.</p></div>';
                    } else {
                        foreach ($categoryProducts as $product): 
                    ?>
                        <div class="col-9 col-sm-6 pe-3">
                            <div class="card shadow-sm h-100 product-card">
                                <a href="/Gear/ProductController/detail/slug=<?php echo htmlspecialchars($product['slug']); ?>" class="card-body p-3 text-decoration-none d-flex flex-column h-100">
                                    <?php if(isset($product['discount']) && $product['discount'] > 0): ?>
                                        <div class="discount-badge position-absolute top-0 end-0 bg-danger text-white fw-bold p-2 rounded m-2">
                                            -<?php echo $product['discount']; ?>%
                                        </div>
                                    <?php endif; ?>
                                    <div class="card-img-wrapper mb-3 text-center bg-white p-2 rounded">
                                        <img src="public/images/products/<?php echo htmlspecialchars($product['images']); ?>" 
                                             class="card-img-top" 
                                             alt="<?php echo htmlspecialchars($product['name']); ?>"
                                             onerror="this.onerror=null; this.src='public/images/default-product.jpg';"
                                             style="height: 150px; object-fit: contain;">
                                    </div>
                                    <h5 class="card-title fw-bold text-dark mb-2 fs-6" style="display: -webkit-box; -webkit-line-clamp: 2; -webkit-box-orient: vertical; overflow: hidden; text-overflow: ellipsis; min-height: 38px;">
                                        <?php echo htmlspecialchars($product['name']); ?>
                                    </h5>
                                    <div class="mt-auto">
                                        <span class="text-danger mb-2 d-block fs-5">
                                            <?php if(isset($product['discount']) && $product['discount'] > 0): ?>
                                                <div>
                                                    <del class="text-muted me-2 small"><?php echo number_format($product['price'], 0, ',', '.'); ?>₫</del>
                                                </div>
                                                <strong><?php echo number_format($product['price'] * (100 - $product['discount']) / 100, 0, ',', '.'); ?>₫</strong>
                                            <?php else: ?>
                                                <strong><?php echo number_format($product['price'], 0, ',', '.'); ?>₫</strong>
                                            <?php endif; ?>
                                        </span>
                                        <button class="btn btn-danger rounded-pill w-100 add-to-cart-btn btn-sm">
                                            <i class="fas fa-shopping-cart me-1"></i>Thêm vào giỏ
                                        </button>
                                    </div>
                                </a>
                            </div>
                        </div>
                    <?php 
                        endforeach; 
                    }
                    ?>
                </div>
            </div>
            
            <!-- Desktop version: Cards with navigation arrows -->
            <div class="position-relative mb-5 d-none d-md-block">
                <div class="navigation-buttons position-absolute top-50 start-0 translate-middle-y z-3">
                    <button class="btn btn-danger rounded-circle prev-btn shadow text-danger"
                        onclick="scrollCards('category-container-<?php echo $category['id']; ?>', 'left')">
                        <i class="fas fa-chevron-left"></i>
                    </button>
                </div>
                <div class="navigation-buttons position-absolute top-50 end-0 translate-middle-y z-3">
                    <button class="btn btn-danger rounded-circle next-btn shadow text-danger"
                        onclick="scrollCards('category-container-<?php echo $category['id']; ?>', 'right')">
                        <i class="fas fa-chevron-right"></i>
                    </button>
                </div>
                <div class="row flex-nowrap overflow-hidden mx-auto" id="category-container-<?php echo $category['id']; ?>">
                    <?php 
                    // Use products specific to this category
                    $categoryProducts = isset($data['categoryProducts'][$category['id']]) ? 
                        $data['categoryProducts'][$category['id']] : [];
                    
                    if (empty($categoryProducts)) {
                        echo '<div class="col-12 text-center py-4"><p>No products in this category yet.</p></div>';
                    } else {
                        foreach ($categoryProducts as $product): 
                    ?>
                        <div class="col-lg-3 col-md-4 col-sm-6 mb-4">
                            <div class="card shadow-sm h-100 product-card">
                                <a href="/Gear/ProductController/detail/slug=<?php echo htmlspecialchars($product['slug']); ?>" class="card-body p-3 text-decoration-none d-flex flex-column h-100">
                                    <?php if(isset($product['discount']) && $product['discount'] > 0): ?>
                                        <div class="discount-badge position-absolute top-0 end-0 bg-danger text-white fw-bold p-2 rounded m-2">
                                            -<?php echo $product['discount']; ?>%
                                        </div>
                                    <?php endif; ?>
                                    <div class="card-img-wrapper mb-3 text-center bg-white p-2 rounded">
                                        <img src="public/images/products/<?php echo htmlspecialchars($product['images']); ?>" 
                                             class="card-img-top" 
                                             alt="<?php echo htmlspecialchars($product['name']); ?>"
                                             onerror="this.onerror=null; this.src='public/images/default-product.jpg';"
                                             style="height: 180px; object-fit: contain;">
                                    </div>
                                    <h5 class="card-title fw-bold text-dark mb-2" style="display: -webkit-box; -webkit-line-clamp: 2; -webkit-box-orient: vertical; overflow: hidden; text-overflow: ellipsis; min-height: 48px;">
                                        <?php echo htmlspecialchars($product['name']); ?>
                                    </h5>
                                    <div class="mt-auto">
                                        <span class="h5 text-danger mb-3 d-block">
                                            <?php if(isset($product['discount']) && $product['discount'] > 0): ?>
                                                <div>
                                                    <del class="text-muted me-2 small"><?php echo number_format($product['price'], 0, ',', '.'); ?>₫</del>
                                                </div>
                                                <strong><?php echo number_format($product['price'] * (100 - $product['discount']) / 100, 0, ',', '.'); ?>₫</strong>
                                            <?php else: ?>
                                                <strong><?php echo number_format($product['price'], 0, ',', '.'); ?>₫</strong>
                                            <?php endif; ?>
                                        </span>
                                        <button class="btn btn-danger rounded-pill w-100 add-to-cart-btn">
                                            <i class="fas fa-shopping-cart me-2"></i>Thêm vào giỏ
                                        </button>
                                    </div>
                                </a>
                            </div>
                        </div>
                    <?php 
                        endforeach; 
                    }
                    ?>
                </div>
            </div>
        <?php endforeach; ?>
        
    <!-- About Section -->
    <div class="container py-4 py-md-5 mb-4 mb-md-5">
        <div class="row mb-4 justify-content-center">
            <div class="col-md-10 col-lg-8 text-center">
                <h2 class="fw-bold mb-2 fs-3 fs-md-2"><?php echo htmlspecialchars($data['settings']['about_title']); ?></h2>
                <div class="position-relative mx-auto">
                    <div class="border-bottom border-danger mx-auto" style="width: 50px; border-width: 3px !important;"></div>
                    <div class="position-absolute start-50 translate-middle-x" style="width: 10px; height: 10px; background-color: #dc3545; border-radius: 50%; bottom: -5px;"></div>
                </div>
                <div class="text-muted mt-3 mt-md-4 px-2 px-md-0">
                    <?php echo $data['settings']['about_text']; ?>
                </div>
            </div>
        </div>

        <!-- Main About Content -->
        <div class="row justify-content-center mb-4 mb-md-5">
            <div class="col-lg-10 col-md-12">
                <div class="card shadow-lg border-0 overflow-hidden">
                    <div class="card-body p-0">
                        <?php if (isset($data['settings']['about_content']) && !empty($data['settings']['about_content'])): ?>
                            <div class="row g-0">
                                <?php if (isset($data['settings']['about_image']) && !empty($data['settings']['about_image'])): ?>
                                <div class="col-md-5 position-relative">
                                    <div class="h-100" style="background: linear-gradient(rgba(220, 53, 69, 0.8), rgba(220, 53, 69, 0.4)), url('public/images/about/<?php echo htmlspecialchars($data['settings']['about_image']); ?>'); background-size: cover; background-position: center; min-height: 200px; @media (min-width: 768px) { min-height: 300px; }"></div>
                                    <div class="position-absolute top-50 start-50 translate-middle text-white text-center p-3 p-md-4">
                                        <h3 class="fw-bold mb-2 mb-md-3 fs-4 fs-md-3"><?php echo htmlspecialchars($data['settings']['company_name']); ?></h3>
                                        <p class="mb-0 fw-light small">Est. 2015</p>
                                    </div>
                                </div>
                                <div class="col-md-7">
                                <?php else: ?>
                                <div class="col-12">
                                <?php endif; ?>
                                    <div class="about-content p-3 p-md-4 p-lg-5">
                                        <?php echo $data['settings']['about_content']; ?>
                                    </div>
                                </div>
                            </div>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>

        <!-- Additional About Sections -->
        <?php if (
            (isset($data['settings']['about_history_content']) && !empty($data['settings']['about_history_content'])) || 
            (isset($data['settings']['about_mission_content']) && !empty($data['settings']['about_mission_content'])) || 
            (isset($data['settings']['about_vision_content']) && !empty($data['settings']['about_vision_content'])) || 
            (isset($data['settings']['about_values_content']) && !empty($data['settings']['about_values_content'])) || 
            (isset($data['settings']['about_achievements_content']) && !empty($data['settings']['about_achievements_content']))
        ): ?>
        <div class="row mt-4 mt-md-5 g-3 g-md-4 justify-content-center">
            <!-- History Section -->
            <?php if (isset($data['settings']['about_history_content']) && !empty($data['settings']['about_history_content'])): ?>
            <div class="col-md-6 col-lg-6">
                <div class="card shadow-sm h-100 border-0 hover-lift transition-300">
                    <div class="card-body p-3 p-md-4">
                        <div class="d-flex align-items-center mb-2 mb-md-3">
                            <div class="icon-bg bg-danger p-2 p-md-3 rounded-circle text-white me-2 me-md-3 d-flex align-items-center justify-content-center" style="width: 40px; height: 40px; @media (min-width: 768px) { width: 50px; height: 50px; }">
                                <i class="fas fa-history"></i>
                            </div>
                            <h4 class="fw-bold mb-0 fs-5 fs-md-4"><?php echo htmlspecialchars($data['settings']['about_history_title']); ?></h4>
                        </div>
                        <div class="about-history-content ms-2 ms-md-4 ps-2 ps-md-3 border-start border-danger">
                            <?php echo $data['settings']['about_history_content']; ?>
                        </div>
                    </div>
                </div>
            </div>
            <?php endif; ?>

            <!-- Mission Section -->
            <?php if (isset($data['settings']['about_mission_content']) && !empty($data['settings']['about_mission_content'])): ?>
            <div class="col-md-6 col-lg-6">
                <div class="card shadow-sm h-100 border-0 hover-lift transition-300">
                    <div class="card-body p-3 p-md-4">
                        <div class="d-flex align-items-center mb-2 mb-md-3">
                            <div class="icon-bg bg-danger p-2 p-md-3 rounded-circle text-white me-2 me-md-3 d-flex align-items-center justify-content-center" style="width: 40px; height: 40px; @media (min-width: 768px) { width: 50px; height: 50px; }">
                                <i class="fas fa-bullseye"></i>
                            </div>
                            <h4 class="fw-bold mb-0 fs-5 fs-md-4"><?php echo htmlspecialchars($data['settings']['about_mission_title']); ?></h4>
                        </div>
                        <div class="about-mission-content ms-2 ms-md-4 ps-2 ps-md-3 border-start border-danger">
                            <?php echo $data['settings']['about_mission_content']; ?>
                        </div>
                    </div>
                </div>
            </div>
            <?php endif; ?>
            
            <!-- Vision Section -->
            <?php if (isset($data['settings']['about_vision_content']) && !empty($data['settings']['about_vision_content'])): ?>
            <div class="col-md-6 col-lg-6">
                <div class="card shadow-sm h-100 border-0 hover-lift transition-300">
                    <div class="card-body p-3 p-md-4">
                        <div class="d-flex align-items-center mb-2 mb-md-3">
                            <div class="icon-bg bg-danger p-2 p-md-3 rounded-circle text-white me-2 me-md-3 d-flex align-items-center justify-content-center" style="width: 40px; height: 40px; @media (min-width: 768px) { width: 50px; height: 50px; }">
                                <i class="fas fa-eye"></i>
                            </div>
                            <h4 class="fw-bold mb-0 fs-5 fs-md-4"><?php echo htmlspecialchars($data['settings']['about_vision_title']); ?></h4>
                        </div>
                        <div class="about-vision-content ms-2 ms-md-4 ps-2 ps-md-3 border-start border-danger">
                            <?php echo $data['settings']['about_vision_content']; ?>
                        </div>
                    </div>
                </div>
            </div>
            <?php endif; ?>

            <!-- Values Section -->
            <?php if (isset($data['settings']['about_values_content']) && !empty($data['settings']['about_values_content'])): ?>
            <div class="col-md-6 col-lg-6">
                <div class="card shadow-sm h-100 border-0 hover-lift transition-300">
                    <div class="card-body p-3 p-md-4">
                        <div class="d-flex align-items-center mb-2 mb-md-3">
                            <div class="icon-bg bg-danger p-2 p-md-3 rounded-circle text-white me-2 me-md-3 d-flex align-items-center justify-content-center" style="width: 40px; height: 40px; @media (min-width: 768px) { width: 50px; height: 50px; }">
                                <i class="fas fa-gem"></i>
                            </div>
                            <h4 class="fw-bold mb-0 fs-5 fs-md-4"><?php echo htmlspecialchars($data['settings']['about_values_title']); ?></h4>
                        </div>
                        <div class="about-values-content ms-2 ms-md-4 ps-2 ps-md-3 border-start border-danger">
                            <?php echo $data['settings']['about_values_content']; ?>
                        </div>
                    </div>
                </div>
            </div>
            <?php endif; ?>

            <!-- Achievements Section -->
            <?php if (isset($data['settings']['about_achievements_content']) && !empty($data['settings']['about_achievements_content'])): ?>
            <div class="col-md-6 col-lg-6">
                <div class="card shadow-sm h-100 border-0 hover-lift transition-300">
                    <div class="card-body p-3 p-md-4">
                        <div class="d-flex align-items-center mb-2 mb-md-3">
                            <div class="icon-bg bg-danger p-2 p-md-3 rounded-circle text-white me-2 me-md-3 d-flex align-items-center justify-content-center" style="width: 40px; height: 40px; @media (min-width: 768px) { width: 50px; height: 50px; }">
                                <i class="fas fa-trophy"></i>
                            </div>
                            <h4 class="fw-bold mb-0 fs-5 fs-md-4"><?php echo htmlspecialchars($data['settings']['about_achievements_title']); ?></h4>
                        </div>
                        <div class="about-achievements-content ms-2 ms-md-4 ps-2 ps-md-3 border-start border-danger">
                            <?php echo $data['settings']['about_achievements_content']; ?>
                        </div>
                    </div>
                </div>
            </div>
            <?php endif; ?>
        </div>
        <?php endif; ?>
    </div>

    <!-- Contact Section -->
    <div class="container mb-4 mb-md-5 py-4">
        <div class="row mb-3 mb-md-4 justify-content-center">
            <div class="col-md-8 text-center">
                <h2 class="fw-bold mb-2 fs-3 fs-md-2">Liên hệ với chúng tôi</h2>
                <div class="border-bottom border-danger mx-auto mt-2 mb-3 mb-md-4" style="width: 50px; border-width: 3px !important;"></div>
            </div>
        </div>
        <div class="row justify-content-center">
            <div class="col-lg-8 col-md-10">
                <div class="card shadow-lg border-0">
                    <div class="card-body p-3 p-md-4 text-center bg-white">
                        <h5 class="fw-bold mb-2 mb-md-3 text-danger">Chúng Tôi Luôn Mang Đến Trải Nghiệm Tốt Nhất</h5>
                        <p class="text-muted mb-3 mb-md-4 px-2 px-md-4">GearBK luôn nỗ lực không ngừng để mang đến cho quý khách những sản phẩm chất lượng với dịch vụ tận tâm.</p>
                        <div class="row g-3 mb-3 mb-md-4 justify-content-center">
                            <div class="col-4">
                                <i class="fas fa-headset text-danger my-2 my-md-3 fs-3"></i>
                                <p class="fw-bold mb-0 small small-md-normal">Hỗ trợ 24/7</p>
                            </div>
                            <div class="col-4">
                                <i class="fas fa-truck text-danger my-2 my-md-3 fs-3"></i>
                                <p class="fw-bold mb-0 small small-md-normal">Giao hàng nhanh</p>
                            </div>
                            <div class="col-4">
                                <i class="fas fa-shield-alt text-danger my-2 my-md-3 fs-3"></i>
                                <p class="fw-bold mb-0 small small-md-normal">Bảo hành tốt</p>
                            </div>
                        </div>
                        <a href="/Gear/ContactController" class="btn btn-danger rounded-pill px-4 py-2 fw-bold">Liên Hệ Ngay</a>
                    </div>
                </div>
            </div>
        </div>
    </div>

        
    <footer>
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-4">
                    <div class="inner-menu">
                        <ul>
                            <li>
                                <a href="/Gear">Home</a>
                            </li>
                            <li>
                                <a href="/Gear/AboutController/index">About</a>
                            </li>
                            <li>
                                <a href="/Gear/ProductController/list">Shop</a>
                            </li>
                            <li>
                                <a href="/Gear/ContactController">Contact</a>
                            </li>
                            <li>
                                <a href="/Gear/BlogController/list">Blog</a>
                            </li>
                            <li>
                                <a href="/Gear/QAController/list">Q&A</a>
                            </li>
                        </ul>
                    </div>
                </div>
                <div class="col-4">
                    <div class="inner-name">
                        GEARBK STORE
                    </div>
                </div>
                <div class="col-4">
                    <div class="inner-conpyright">
                        Copyright © 2025 GearBK Store
                    </div>
                </div>
            </div>
        </div>
    </footer>

    </body>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        function scrollCards(containerId, direction) {
            const container = document.getElementById(containerId);
            if (!container) {
                console.error('Container not found:', containerId);
                return;
            }
            
            const scrollAmount = container.clientWidth / 2;
            if (direction === 'left') {
                container.scrollBy({ left: -scrollAmount, behavior: 'smooth' });
            } else {
                container.scrollBy({ left: scrollAmount, behavior: 'smooth' });
            }
        }
        
        function handleSearch(event) {
            event.preventDefault();
            const searchValue = document.getElementById('searchInput').value;
            window.location.href = '/Gear/ProductController/list/search=' + searchValue;
        }
        
        // Add custom styles for responsiveness
        document.addEventListener('DOMContentLoaded', function() {
            // Add custom style tag
            const style = document.createElement('style');
            style.textContent = `
                /* Hide scrollbar for mobile scrolling containers */
                .hide-scrollbar {
                    -ms-overflow-style: none;  /* IE and Edge */
                    scrollbar-width: none;  /* Firefox */
                }
                .hide-scrollbar::-webkit-scrollbar {
                    display: none;  /* Chrome, Safari and Opera */
                }
                
                /* Responsive font sizes */
                @media (max-width: 576px) {
                    .small-md-normal {
                        font-size: 0.8rem;
                    }
                }
                
                /* Product card hover effect */
                .product-card {
                    transition: transform 0.3s ease, box-shadow 0.3s ease;
                }
                .product-card:hover {
                    transform: translateY(-5px);
                    box-shadow: 0 10px 20px rgba(0,0,0,0.1) !important;
                }
                
                /* Navigation button hover effects */
                .prev-btn, .next-btn {
                    background-color: white !important;
                    width: 40px;
                    height: 40px;
                    display: flex;
                    align-items: center;
                    justify-content: center;
                    transition: all 0.3s ease;
                }
                .prev-btn:hover, .next-btn:hover {
                    background-color: #dc3545 !important;
                    color: white !important;
                }
                
                /* Hover lift effect for cards */
                .hover-lift {
                    transition: transform 0.3s ease;
                }
                .hover-lift:hover {
                    transform: translateY(-5px);
                }
                
                /* Transition timing */
                .transition-300 {
                    transition: all 0.3s ease;
                }
                
                /* Ensure images maintain aspect ratio */
                .card-img-top {
                    transition: transform 0.3s ease;
                }
                .card-img-wrapper:hover .card-img-top {
                    transform: scale(1.05);
                }
            `;
            document.head.appendChild(style);
        });
    </script>

</html>