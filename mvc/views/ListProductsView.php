<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Shop - GearBK Store</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css"
        integrity="sha384-xOolHFLEh07PJGoPkLv1IbcEPTNtaed2xpHsD9ESMhqIYd0nLMwNLD69Npy4HI+N" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css"
        integrity="sha512-Evv84Mr4kqVGRNSgIGL/F/aIDqQb7xQ2vcrdIwxfjThSH8CSR7PBEakCr51Ck+w+/U6swU2Im1vVX0SVk9ABhg=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="/public/css/product.css">
    <link rel="stylesheet" href="/public/css/style.css">
</head>

<body>
    <header>
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <div class="inner-content">
                        <a href="/ProductController/list">
                            <div class="inner-logo" style="color: #000;">
                                <img src="/public/images/LogoGearBK.webp" alt="">
                                <span>GearBK</span>
                            </div>
                        </a>
                        <div class="inner-menu">
                            <ul>
                                <li>
                                    <a href="/Gear">HOME</a>
                                </li>
                                <li>
                                    <a href="/Gear/AboutController/index">ABOUT</a>
                                </li>
                                <li>
                                    <a href="/Gear/shop">SHOP</a>
                                </li>
                                <li>
                                    <a href="/Gear/contact">CONTACT</a>
                                </li>
                                <li>
                                    <a href="/Gear/BlogController/list">BLOG</a>
                                </li>
                                <li>
                                    <a href="/Gear/QAController/list">Q&A</a>
                                </li>
                            </ul>
                        </div>
                        <a href="/OrderController/home" style="color: #000;"><div class="inner-shop"><i class="fa-solid fa-bag-shopping"></i></div></a>
                        <div class="inner-user"><i class="fa-solid fa-user"></i></div>
                    </div>
                </div>
            </div>
        </div>
    </header>

    <div class="banner">
        <img src="/public/images/Banner-demo.jpg" alt="">
    </div>

    <div class="main">
        <div class="container">
            <div class="row">
                <div class="col-3">
                    <div class="inner-filter inner-left">
                    <div class="inner-price">
                        <div class="inner-title">Lọc giá</div>
                            <div>
                                <label><input type="radio" name="price" value="1"> Tất cả</label><br>
                                <label><input type="radio" name="price" value="2"> Dưới 500,000₫</label><br>
                                <label><input type="radio" name="price" value="3"> 500,000₫ - 5,000,000₫</label><br>
                                <label><input type="radio" name="price" value="4"> 5,000,000₫ - 15,000,000₫</label><br>
                                <label><input type="radio" name="price" value="5"> 15,000,000₫ - 30,000,000₫</label><br>
                                <label><input type="radio" name="price" value="6"> Trên 30,000,000₫</label>
                            </div>
                        </div>
                    </div>
                    <script>
                        document.addEventListener('DOMContentLoaded', function(){
                        // parse segments
                        let path = window.location.pathname.split('?')[0],
                            segs = path.split('/').filter(Boolean),
                            currentSearch = '', currentSort = '', currentPrice = '1';

                        segs.forEach(s=>{
                            if (s.startsWith('search='))      currentSearch = s.split('=')[1];
                            if (s.startsWith('sortfilter='))  currentSort   = s.split('=')[1];
                            if (s.startsWith('pricefilter=')) currentPrice   = s.split('=')[1];
                        });

                        // highlight price radio
                        document.querySelectorAll('input[name="price"]').forEach(r=>{
                            if (r.value === currentPrice) {
                            r.checked = true;
                            }
                            r.addEventListener('change', function(){
                            // build lại URL
                            let base = path
                                .replace(/\/search=[^\/]+/,'')
                                .replace(/\/sortfilter=[^\/]+/,'')
                                .replace(/\/pricefilter=[^\/]+/,'');
                            if (currentSearch)    base += '/search='     + currentSearch;
                            if (currentSort)      base += '/sortfilter=' + currentSort;
                            base += '/pricefilter=' + this.value;
                            window.location.href = base;
                            });
                        });

                        // (Giữ nguyên phần JS search & sort như trước...)
                        });
                    </script>
                </div>
                <div class="col-9 inner-right">
                    <!-- 1) Search form (giữ nguyên slugify của bạn) -->
                    <form id="search-form" class="inner-search-form">
                    <div class="input-group mb-3">
                        <input 
                        type="text" 
                        id="search-input"
                        class="form-control"
                        placeholder="Khám phá sản phẩm tại GearBK"
                        value=""
                        >
                        <div class="input-group-append">
                        <button class="btn btn-outline-secondary" type="submit">
                            <i class="fa-solid fa-magnifying-glass"></i>
                        </button>
                        </div>
                    </div>
                    </form>

                    <!-- 2) Sort buttons: thêm data-sort để JS dễ truy cập -->
                    <div class="inner-sort btn-group" role="group">
                    <button type="button" class="btn btn-light" data-sort="price-asc">Giá tăng dần</button>
                    <button type="button" class="btn btn-light" data-sort="price-desc">Giá giảm dần</button>
                    <button type="button" class="btn btn-light" data-sort="az">A-Z</button>
                    <button type="button" class="btn btn-light" data-sort="za">Z-A</button>
                    </div>

                    <!-- 3) JS xử lý cả 3 việc: prefill, highlight, redirect on click -->
                    <script>
                    document.addEventListener('DOMContentLoaded', function(){
                    // 3.1: parse segments từ URL
                    let path = window.location.pathname.split('?')[0];
                    let segments = path.split('/').filter(Boolean); // ["ProductController","list",...]
                    let currentSearch = '';
                    let currentSort   = '';

                    segments.forEach(seg => {
                        if (seg.startsWith('search=')) {
                        currentSearch = decodeURIComponent(seg.split('=')[1]);
                        }
                        if (seg.startsWith('sortfilter=')) {
                        currentSort = decodeURIComponent(seg.split('=')[1]);
                        }
                    });

                    // 3.2: Prefill ô search
                    let input = document.getElementById('search-input');
                    if (input && currentSearch) {
                        input.value = currentSearch;
                    }

                    // 3.3: Highlight nút sort active
                    document.querySelectorAll('.inner-sort [data-sort]').forEach(btn => {
                        if (btn.dataset.sort === currentSort) {
                        btn.classList.remove('btn-light');
                        btn.classList.add('btn-danger');
                        } else {
                        btn.classList.remove('btn-danger');
                        btn.classList.add('btn-light');
                        }
                    });

                    // 3.4: Bind sự kiện submit form search (giữ nguyên slugify và redirect)
                    document.getElementById('search-form').addEventListener('submit', function(e){
                        e.preventDefault();
                        // slugify như bạn đã có
                        var term = input.value.trim();
                        var slug = makeSlug(term);
                        // dọn path cũ: bỏ segment /search=... và /sortfilter=...
                        var base = path
                        .replace(/\/search=[^\/]+/g, '')
                        .replace(/\/sortfilter=[^\/]+/g, '');
                        // giữ lại sort nếu đã có
                        if (currentSort) {
                        base += '/sortfilter=' + encodeURIComponent(currentSort);
                        }
                        // thêm search mới (nếu có)
                        if (slug) {
                        base += '/search=' + encodeURIComponent(slug);
                        }
                        window.location.href = base;
                    });

                    // 3.5: Bind click lên các nút sort
                    document.querySelectorAll('.inner-sort [data-sort]').forEach(btn => {
                        btn.addEventListener('click', function(){
                        var sortKey = btn.dataset.sort;
                        // dọn path cũ y hệt trên
                        var base = path
                            .replace(/\/search=[^\/]+/g, '')
                            .replace(/\/sortfilter=[^\/]+/g, '');
                        // nếu có search hiện tại, giữ lại
                        if (currentSearch) {
                            base += '/search=' + encodeURIComponent(currentSearch);
                        }
                        // thêm sort mới
                        base += '/sortfilter=' + encodeURIComponent(sortKey);
                        window.location.href = base;
                        });
                    });
                    });

                    // Hàm makeSlug như bạn đã định nghĩa ở trên
                    function makeSlug(str) {
                    return str
                        .normalize('NFD').replace(/[\u0300-\u036f]/g, '')
                        .replace(/đ/g, 'd').replace(/Đ/g, 'D')
                        .toLowerCase().replace(/[^\w\s-]/g, '')
                        .replace(/\s+/g, '-').replace(/-+/g, '-')
                        .replace(/^-+|-+$/g, '');
                    }
                    </script>
                    <div class="inner-product-list">
                        <div class="row">
                            <?php if (mysqli_num_rows($data["listProducts"]) > 0): ?>
                                <?php while ($row = mysqli_fetch_assoc($data["listProducts"])): ?>
                                    <div class="col-4">
                                        <a href="/ProductController/detail/slug=<?= $row['slug'] ?>">
                                            <div class="inner-item">
                                                <img src="<?= $row['images'] ?>" alt="">
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
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
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
    <script src="../../public/js/script.js"></script>
</body>

</html>