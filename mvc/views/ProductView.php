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
    <link rel="stylesheet" href="/Gear/public/css/product.css">
    <link rel="stylesheet" href="/Gear/public/css/style.css">
    <link rel="stylesheet" href="/Gear/public/css/product_detail.css">
</head>


<body>
    <header>
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <div class="inner-content">
                        <div class="inner-logo">
                            
                            <a class="text-decoration-none text-dark" href="/Gear">
                                <div class="inner-logo" style="color: #000;">
                                    <img src="/Gear/public/images/logos/<?php echo $data['settings']['logo']; ?>" alt="<?php echo $data['settings']['company_name']; ?>">
                                    <span><?php echo $data['settings']['company_name']; ?></span>
                                </div>
                            </a>
                        </div>
                        <div class="inner-menu">
    <ul>
        <li><a href="/Gear">HOME</a></li>
        <li><a href="/Gear/AboutController/index">ABOUT</a></li>
        <li><a href="/Gear/ProductController/list">SHOP</a></li>
        <li><a href="/Gear/ContactController">CONTACT</a></li>
        <li><a href="/Gear/BlogController/list">NEWS</a></li>
        <?php if (isset($_COOKIE['user_role']) && $_COOKIE['user_role'] === 'admin'): ?>
            <li><a href="/Gear/AdminProductController/list">ADMIN</a></li>
        <?php endif; ?>
    </ul>
</div>

                        <a href="/Gear/OrderController/home" style="color: #000;">
                            <div class="inner-shop"><i class="fa-solid fa-bag-shopping"></i></div>
                        </a>
                        <div class="inner-user"><i class="fa-solid fa-user"></i></div>
                    </div>
                </div>
            </div>
        </div>
    </header>

    <div class="container d-flex">
        <!-- Left Section: Promotional Banner -->
        <div class="left-section">
            <img src="<?php echo isset($data["detailProduct"]["images"]) && !empty($data["detailProduct"]["images"]) ? 
                     '/Gear/public/images/products/' . htmlspecialchars($data["detailProduct"]["images"]) : 
                     '/Gear/public/images/default-product.jpg'; ?>" 
                 alt="<?= htmlspecialchars($data["detailProduct"]["name"]) ?>" 
                 width="500px" 
                 height="550px"
                 onerror="this.onerror=null; this.src='/Gear/public/images/default-product.jpg';"
                 style="object-fit: contain;">
        </div>

        <!-- Right Section: Product Details -->
        <div class="right-section">
            <h1><?= $data["detailProduct"]["name"] ?></h1>
            <p class="product-code">78131 | Lượt xem: 1 | Thể loại: PC</p>
            <div class="price-section">
                <span class="current-price">
                    <?=
                    number_format(
                        (int) (
                            $data["detailProduct"]["price"]
                            - $data["detailProduct"]["price"] * $data["detailProduct"]["discount"] / 100
                        ),
                        0,
                        ',',
                        '.'
                    )
                    ?> đ
                </span>
                <span class="original-price">
                    <?= number_format(
                        $data["detailProduct"]["price"],
                        0,
                        ',',
                        '.'
                    )
                    ?> đ
                </span>
            </div>

            <form id="add-to-cart-form"
                action="/Gear/ProductController/addToCart"
                method="POST"
                class="d-flex flex-column">

                <!-- 1) Quantity Selector -->
                <div class="quantity-selector d-flex align-items-center mb-3">
                    <button type="button" id="qty-decrease" class="btn btn-outline-secondary">–</button>
                    <input
                    type="number"
                    name="quantity"
                    id="qty-input"
                    value="1"
                    min="1"
                    class="form-control mx-2 text-center"
                    style="width: 80px;"
                    >
                    <button type="button" id="qty-increase" class="btn btn-outline-secondary">+</button>
                </div>

                <!-- 2) Hidden để gửi slug -->
                <input
                    type="hidden"
                    name="slug"
                    value="<?= htmlspecialchars($data['detailProduct']['slug']) ?>"
                >

                <!-- 3) Submit Button -->
                <button type="submit"
                        class="btn btn-danger add-to-cart align-self-start">
                    THÊM VÀO GIỎ
                </button>
            </form>

            <script>
                // JS để tăng/giảm số lượng
                document.getElementById('qty-decrease').addEventListener('click', () => {
                const inp = document.getElementById('qty-input');
                let v = parseInt(inp.value, 10);
                if (v > 1) inp.value = v - 1;
                });
                document.getElementById('qty-increase').addEventListener('click', () => {
                const inp = document.getElementById('qty-input');
                inp.value = parseInt(inp.value, 10) + 1;
                });
            </script>

            <!-- Additional Offers -->

            <!-- Product Description Section -->
        </div>
    </div>

    <div class="container">
        <div class="product-description">
            <h2>Mô tả sản phẩm</h2>
            <h3><?= $data["detailProduct"]["name"] ?></h3>
            <p><?= nl2br($data["detailProduct"]['description']) ?></p>
            <!-- <p>Hiệu năng ấn tượng với CPU Intel Core i3 12100F cung cấp sức mạnh đủ tốt cho làm việc và chơi game.</p>
            <p>Thiết kế từ chất liệu kính, có sẵn fan LED RGB.</p>
            <p>Vỏ case cứng cáp, sang trọng, tạo sự chắc chắn và thẩm mỹ cho bộ PC của bạn.</p>
            <p>Bộ nguồn Bộ Tản Nhiệt CPU Deepcool AG400 ARGB công suất vừa đủ, ổn định điện năng cho hệ thống PC.</p>
            <p>Mainboard Gigabyte H610M H V3 DDR4 đảm bảo cung cấp một nguồn năng lượng cao, ổn định và mạnh mẽ.</p>
            <p>Card đồ họa Gigabyte RTX 3050 Windforce OC V2 6GB đáp ứng tốt các tác vụ thiết kế đồ họa, các tựa game một cách mượt mà.</p>
            <p><strong>Giá bán: 11,590,000₫</strong></p>

            <h3>CPU Intel Core i3 12100F</h3>
            <p>Intel Core i3 12100F sở hữu 4 nhân 8 luồng, mang đến hiệu suất mạnh mẽ cho các tác vụ văn phòng, chơi game và giải trí đa phương tiện. Với TDP cơ bản 58W và công suất Turbo tối đa lên đến 89W, CPU này đảm bảo hoạt động ổn định, tiết kiệm điện năng mà vẫn duy trì hiệu năng ấn tượng.</p>
            <p>Bộ vi xử lý này được trang bị bộ nhớ cache 12MB và hỗ trợ dung lượng RAM tối đa 128GB, giúp đảm bảo khả năng xử lý tốt trên các hệ thống từ phổ thông đến trung cấp. Do không có nhân đồ họa tích hợp, i3 12100F đặc biệt phù hợp khi sử dụng với card đồ họa rời, mang lại trải nghiệm gaming mượt mà và tối ưu chi phí.</p>
            <p>Với xung nhịp tối đa lên đến 4.3GHz, i3 12100F duy trì hiệu năng ổn định ngay cả trong các tác vụ nặng. Hỗ trợ PCIe 5.0 giúp tăng tốc độ truyền dữ liệu, cải thiện khả năng mở rộng phần cứng. Ngoài ra, công nghệ Intel SpeedStep giúp tối ưu điện năng tiêu thụ, phù hợp cho những hệ thống cần sự cân bằng giữa hiệu suất và tiết kiệm năng lượng.</p>

            <h3>Mainboard Gigabyte H610M H V3 DDR4</h3>
            <p>Gigabyte H610M H V3 DDR4 hỗ trợ CPU Intel Core thế hệ 14/13/12 trên socket LGA1700, đi kèm 2 khe RAM DDR4 tối đa 64GB, giúp tối ưu hiệu suất. Trang bị 1 khe M.2 PCIe 3.0 x4, 4 cổng SATA 6Gb/s, cùng HDMI, D-Sub, USB 3.2 Gen 1 và LAN Gigabit, đảm bảo kết nối nhanh và ổn định. Với thiết kế Micro-ATX nhỏ gọn, đây là lựa chọn lý tưởng cho PC gaming giá rẻ và hệ thống làm việc bền bỉ.</p>

            <h3>Card đồ họa Gigabyte RTX 3050 Windforce OC V2 6GB – Hiệu năng ổn định cho game thủ và nhà sáng tạo</h3>
            <p>Card màn hình GIGABYTE GeForce RTX 3050 WINDFORCE OC 6G mang đến sức mạnh đồ họa vượt trội nhờ công nghệ NVIDIA Ampere kiến trúc hiện đại. Sản phẩm hoàn hảo cho game thủ và người dùng chuyên nghiệp muốn tận hưởng hiệu năng mượt mà và độ chính xác màu vượt trội.</p>
            <p>Card được trang bị hệ thống làm mát WINDFORCE 2X với hai quạt 90mm quay ngược chiều giúp tối ưu luồng không khí và giảm nhiệt độ hiệu quả. Tản nhiệt kết hợp với các ống dẫn nhiệt bằng đồng trực tiếp và tấm nền bảo vệ giúp bảo vệ toàn diện.</p>
            <p>Sản phẩm hỗ trợ nhiều cổng kết nối tiên tiến bao gồm HDMI 2.1 và DisplayPort 1.4a, tương thích với nhiều màn hình độ phân giải cao và tốc độ quét nhanh. Công nghệ NVIDIA DLSS nâng cao hiệu suất, mang lại trải nghiệm chơi game mượt mà, chi tiết hơn.</p>

            <h3>SSD TeamGroup CX2 256GB Sata III 2.5 inch</h3>
            <p>Tốc độ đọc/ghi tối đa của SSD TeamGroup CX2 256GB Sata III 2.5 inch lên đến tối đa 540/490MB/s, nhanh hơn gấp 4 lần so với HDD. Nó có thể giảm độ trễ hoạt động khi chơi game và tải phần mềm, mang đến cho nhân viên máy tính và game thủ trải nghiệm chơi game tốt nhất và mượt mà nhất cũng như hiệu suất tốc độ cực cao mà không có bất kỳ độ trễ nào ngay cả khi tải phần mềm và trò chơi chỉnh sửa đoạn phim hay đồ họa nặng.</p>

            <h3>Ram PC TeamGroup T-Force Vulcan Z Gray 8GB DDR4-3200</h3>
            <p>Ram PC TeamGroup T-Force Vulcan Z Gray 8GB DDR4-3200 gây ấn tượng cho người nhìn nhờ thiết kế bắt mắt với họa tiết bên ngoài có hình dáng giống đôi cánh đang bay, đồng nhất với hình ảnh logo, toát lên sự mạnh mẽ, cá tính. Kết hợp với sắc đỏ rực rỡ, kiến tạo nên dàn PC hiện đại và nổi bật tạo cảm hứng làm việc hay chơi game thú vị.</p>

            <h3>Nguồn Deepcool PF550 550W 80 Plus</h3>
            <p>Nguồn Deepcool PF550 550W 80 Plus White cung cấp hiệu suất điện năng an toàn và ổn định với hiệu suất Tiêu chuẩn 80 PLUS đáng tin cậy và giá cả phải chăng.</p>

            <h3>Case Xigmatek View II 3F ATX Black</h3>
            <p>Case Xigmatek View II 3F ATX Black với thiết kế hiện đại, hỗ trợ lắp đặt linh kiện dễ dàng, phù hợp cho các dàn PC gaming.</p>

            <h3>Bảng thông số kỹ thuật</h3>
            <table>
                <tr>
                    <th>Thành phần</th>
                    <th>Thông số</th>
                </tr>
                <tr>
                    <td>CPU</td>
                    <td>CPU Intel Core i3 12100F</td>
                </tr>
                <tr>
                    <td>Mainboard</td>
                    <td>Mainboard Gigabyte H610M H V3 DDR4</td>
                </tr>
                <tr>
                    <td>RAM</td>
                    <td>Ram PC TeamGroup T-Force Vulcan Z Gray 8GB (Bảo hành 36 tháng)</td>
                </tr>
                <tr>
                    <td>VGA</td>
                    <td>Gigabyte RTX 3050 Windforce OC V2 6GB</td>
                </tr>
                <tr>
                    <td>SSD</td>
                    <td>SSD TeamGroup CX2 256GB Sata III 2.5 inch</td>
                </tr>
                <tr>
                    <td>Case</td>
                    <td>Case máy tính Xigmatek View II 3F ATX Black – (Bảo hành 12 tháng)</td>
                </tr>
                <tr>
                    <td>Nguồn</td>
                    <td>Nguồn Deepcool PF550 550W 80 Plus</td>
                </tr>
            </table> -->
        </div>
    </div>


    <footer>
        <div class="container">
            <div class="row justify-content-center">
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