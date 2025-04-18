<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Shop - GearBK Store</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css"
        integrity="sha384-xOolHFLEh07PJGoPkLv1IbcEPTNtaed2xpHsD9ESMhqIYd0nLMwNLD69Npy4HI+N" crossorigin="anonymous">
    <link rel="stylesheet" href="../public/css/product.css">
    <link rel="stylesheet" href="../public/css/style.css">
    <link rel="stylesheet"
      href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css"
      integrity="sha512-Evv84Mr4kqVGRNSgIGL/F/aIDqQb7xQ2vcrdIwxfjThSH8CSR7PBEakCr51Ck+w+/U6swU2Im1vVX0SVk9ABhg=="
      crossorigin="anonymous"
      referrerpolicy="no-referrer" />

</head>

<body>
    <header>
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <div class="inner-content">
                        <div class="inner-logo">
                            <img src="../../public/images/LogoGearBK.webp" alt="">
                            <span>GearBK</span>
                        </div>
                        <div class="inner-menu">
                            <ul>
                                <li>
                                    <a href="">HOME</a>
                                </li>
                                <li>
                                    <a href="">ABOUT</a>
                                </li>
                                <li>
                                    <a href="">SHOP</a>
                                </li>
                                <li>
                                    <a href="">CONTACT</a>
                                </li>
                                <li>
                                    <a href="">NEWS</a>
                                </li>
                                <li><a href="<?= base_url('AuthController/logout') ?>">ĐĂNG XUẤT</a></li>

                            </ul>
                        </div>
                        <div class="inner-shop"><i class="fa-solid fa-shopping-bag"></i></div>
<div class="inner-user"><i class="fa-solid fa-user"></i></div>
                    </div>
                </div>
            </div>
        </div>
    </header>

    <div class="banner">
        <img src="../../public/images/Banner-demo.jpg" alt="">
    </div>

    <div class="main">
        <div class="container">
            <div class="row">
                <div class="col-3">
                    <div class="inner-filter inner-left">
                        <div class="inner-brand">
                            <form action="#" form-check-brand>
                                <div class="inner-title">Thương hiệu</div>
                                <div class="row">
                                    <div class="col-6"><input type="checkbox" id="all" name="all" value="all">
                                        <label for="all">Tất cả</label>
                                    </div>
                                    <div class="col-6">
                                        <input type="checkbox" id="Xgear" name="Xgear" value="xgear">
                                        <label for="Xgear">Xgear</label> <br>
                                    </div>
                                    <div class="col-6">
                                        <input type="checkbox" id="Gigabye" name="Gigabye" value="gigabye">
                                        <label for="Gigabye">Gigabye</label>
                                    </div>
                                    <div class="col-6">
                                        <input type="checkbox" id="MSI" name="MSI" value="msi">
                                        <label for="MSI">MSI</label> <br>
                                    </div>
                                    <div class="col-6">
                                        <input type="checkbox" id="Asus" name="Asus" value="asus">
                                        <label for="Asus">Asus</label>
                                    </div>
                                </div>
                            </form>
                        </div>

                        <div class="inner-price">
                            <form action="#" form-check-price>
                                <div class="inner-title">Lọc giá</div>
                                <div class="row">
                                    <div class="col-12"><input type="checkbox" id="all" name="all" value="all">
                                        <label for="all">Tất cả</label>
                                    </div>
                                    <div class="col-12">
                                        <input type="checkbox" id="duoi-500" name="duoi-500" value="duoi-500">
                                        <label for="duoi-500">Dưới 500,000₫</label> <br>
                                    </div>
                                    <div class="col-12">
                                        <input type="checkbox" id="500-5000" name="500-5000" value="500-5000">
                                        <label for="500-5000">500,000₫ - 5,000,000₫</label>
                                    </div>
                                    <div class="col-12">
                                        <input type="checkbox" id="5000-15000" name="5000-15000" value="5000-15000">
                                        <label for="5000-15000">5,000,000₫ - 15,000,000₫</label> <br>
                                    </div>
                                    <div class="col-12">
                                        <input type="checkbox" id="15000-30000" name="15000-30000" value="15000-30000">
                                        <label for="15000-30000">15,000,000₫ - 30,000,000₫</label>
                                    </div>
                                    <div class="col-12">
                                        <input type="checkbox" id="tren-30000" name="tren-30000" value="tren-30000">
                                        <label for="tren-30000">Trên 30,000,000₫</label>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
                <div class="col-9 inner-right">
                    <div class="inner-search">
                        <input type="text" placeholder="Khám phá sản phẩm tại GearBK"> <i class="fa-solid fa-magnifying-glass"></i>
                    </div>
                    <div class="inner-sort">
                        <button type="button" class="btn btn-danger">Nổi bật</button>
                        <button type="button" class="btn btn-light">Giá tăng dần</button>
                        <button type="button" class="btn btn-light">Giá giảm dần</button>
                        <button type="button" class="btn btn-light">A-Z</button>
                        <button type="button" class="btn btn-light">Z-A</button>
                        <button type="button" class="btn btn-light">Mới nhất</button>
                        <button type="button" class="btn btn-light">Bán chạy</button>
                    </div>
                    <div class="inner-product-list">
                        <div class="row">
                        <?php if (mysqli_num_rows($data["listProducts"]) > 0): ?>
                            <?php while ($row = mysqli_fetch_assoc($data["listProducts"])): ?>
                                <div class="col-4">
                                    <a href="detail.php?slug=<?= $row['slug'] ?>">
                                        <div class="inner-item">
                                            <img src="../../public/images/<?= $row['images'] ?>" alt="">
                                            <div class="inner-title"><?= $row['name'] ?></div>
                                            <span class="inner-new-price"><?= number_format($row['price']) ?>₫</span>
                                            <?php if ($row['discount'] > 0): ?>
                                                <span class="inner-old-price">
                                                    <?= number_format($row['price'] * 100 / (100 - $row['discount'])) ?>₫
                                                </span>
                                            <?php endif; ?>
                                            <div class="inner-more-info">
                                                <div class="inner-preview">
                                                    <img src="images/Chip.webp" alt="">
                                                    <div class="inner-text">Intel Core i3-12100F</div>
                                                </div>
                                                <div class="inner-preview">
                                                    <img src="images/RTX.webp" alt="">
                                                    <div class="inner-text">RTX 3050</div>
                                                </div>
                                            </div>
                                        </div>
                                    </a>
                                </div>
                            <?php endwhile; ?>
                        <?php endif; ?>
              
    <footer>
        <div class="container">
            <div class="row">
                <div class="col-4">
                    <div class="inner-menu">
                        <ul>
                            <li>
                                <a href="">Home</a>
                            </li>
                            <li>
                                <a href="">About</a>
                            </li>
                            <li>
                                <a href="">Shop</a>
                            </li>
                            <li>
                                <a href="">Contact</a>
                            </li>
                            <li>
                                <a href="">News</a>
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

    <script src="https://cdn.jsdelivr.net/npm/jquery@3.5.1/dist/jquery.slim.min.js"
        integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj"
        crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-Fy6S3B9q64WdZWQUiU+q4/2Lc9npb8tCaSX9FK7E8HnRr0Jz8D6OP9dO5Vg3Q9ct"
        crossorigin="anonymous"></script>
</body>

</html>