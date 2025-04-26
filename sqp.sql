CREATE TABLE products (
    id INT NOT NULL AUTO_INCREMENT,
    name VARCHAR(255) NOT NULL,                -- Tên sản phẩm
    code VARCHAR(20),                          -- Mã sản phẩm
    images LONGTEXT,                           -- Ảnh (có thể JSON chuỗi nhiều ảnh)
    price INT,                                 -- Giá bán
    discount INT,                              -- % giảm giá (nếu có)
    description LONGTEXT,                      -- Mô tả chi tiết
    specs LONGTEXT,                            -- Cấu hình / thông số kỹ thuật
    quantity INT,                              -- Số lượng tồn kho
    status VARCHAR(20),                        -- Trạng thái (còn hàng, ngừng KD,...)
    slug VARCHAR(255) NOT NULL,                -- Tên SEO (pc-gaming-x305)
    deleted BOOLEAN DEFAULT FALSE,             -- Xóa mềm
    deleted_at TIMESTAMP NULL,
    created_at TIMESTAMP NULL,
    updated_at TIMESTAMP NULL,
    PRIMARY KEY (id)
);


CREATE TABLE categories (
    id INT NOT NULL AUTO_INCREMENT,
    title VARCHAR(255) NOT NULL,               -- Tên danh mục
    image VARCHAR(500),                        -- Ảnh đại diện danh mục
    description LONGTEXT,                      -- Mô tả danh mục
    status VARCHAR(20),                        -- Trạng thái (active/inactive)
    slug VARCHAR(255) NOT NULL,                -- Đường dẫn SEO
    deleted BOOLEAN DEFAULT FALSE,             -- Xóa mềm
    deleted_at TIMESTAMP NULL,
    created_at TIMESTAMP NULL,
    updated_at TIMESTAMP NULL,
    PRIMARY KEY (id)
);



CREATE TABLE products_categories (
    product_id INT,
    category_id INT,
    PRIMARY KEY (product_id, category_id),
    FOREIGN KEY (product_id) REFERENCES products(id),
    FOREIGN KEY (category_id) REFERENCES categories(id)
);



CREATE TABLE orders (
    id INT NOT NULL AUTO_INCREMENT,
    code VARCHAR(10) NOT NULL,                -- Mã đơn hàng (vd: ORD12345)
    full_name VARCHAR(50) NOT NULL,           -- Tên người nhận
    phone VARCHAR(10) NOT NULL,               -- SĐT người nhận
    note VARCHAR(500),                        -- Ghi chú đơn hàng
    status VARCHAR(20),                       -- Trạng thái (pending, confirmed,...)
    deleted BOOLEAN DEFAULT FALSE,            -- Xóa mềm
    deleted_at TIMESTAMP NULL,
    created_at TIMESTAMP NULL,
    updated_at TIMESTAMP NULL,
    PRIMARY KEY (id)
);


CREATE TABLE orders_products (
    id INT NOT NULL AUTO_INCREMENT,
    order_id INT NOT NULL,                     -- Mã đơn hàng
    product_id INT NOT NULL,                   -- Mã sản phẩm
    quantity INT NOT NULL,                     -- Số lượng mua
    price INT NOT NULL,                        -- Giá tại thời điểm mua
    discount INT,                              -- Giảm giá (nếu có)
    PRIMARY KEY (id),
    FOREIGN KEY (order_id) REFERENCES orders(id),
    FOREIGN KEY (product_id) REFERENCES products(id)
);


-- categories
INSERT INTO categories (title, image, description, status, slug) VALUES ('PC Gaming', 'pc-gaming.jpg', 'Máy tính chơi game hiệu năng cao', 'active', 'pc-gaming');
INSERT INTO categories (title, image, description, status, slug) VALUES ('Laptop Văn Phòng', 'laptop-vanphong.jpg', 'Laptop mỏng nhẹ cho công việc', 'active', 'laptop-van-phong');
INSERT INTO categories (title, image, description, status, slug) VALUES ('Màn Hình', 'man-hinh.jpg', 'Màn hình Full HD, 2K, 4K', 'active', 'man-hinh');
INSERT INTO categories (title, image, description, status, slug) VALUES ('Phụ Kiện', 'phu-kien.jpg', 'Chuột, bàn phím, tai nghe...', 'active', 'phu-kien');
INSERT INTO categories (title, image, description, status, slug) VALUES ('Thiết Bị Mạng', 'network.jpg', 'Router, Switch, WiFi Mesh', 'active', 'thiet-bi-mang');

-- products
INSERT INTO products (name, code, images, price, discount, description, quantity, status, slug) VALUES ('PC Gaming X305', 'SP0001', 'pc-gaming-x305.jpg', 9361678, 5, 'Sản phẩm PC Gaming X305 phù hợp với nhu cầu sử dụng cá nhân hoặc doanh nghiệp.', 47, 'active', 'pc-gaming-x305');
INSERT INTO products (name, code, images, price, discount, description, quantity, status, slug) VALUES ('Laptop HP G3', 'SP0002', 'laptop-hp-g3.jpg', 17389795, 0, 'Sản phẩm Laptop HP G3 phù hợp với nhu cầu sử dụng cá nhân hoặc doanh nghiệp.', 36, 'active', 'laptop-hp-g3');
INSERT INTO products (name, code, images, price, discount, description, quantity, status, slug) VALUES ('Màn Hình LG 24inch', 'SP0003', 'màn-hình-lg-24inch.jpg', 8348463, 10, 'Sản phẩm Màn Hình LG 24inch phù hợp với nhu cầu sử dụng cá nhân hoặc doanh nghiệp.', 62, 'active', 'màn-hình-lg-24inch');
INSERT INTO products (name, code, images, price, discount, description, quantity, status, slug) VALUES ('Chuột Logitech G102', 'SP0004', 'chuột-logitech-g102.jpg', 11188129, 10, 'Sản phẩm Chuột Logitech G102 phù hợp với nhu cầu sử dụng cá nhân hoặc doanh nghiệp.', 66, 'active', 'chuột-logitech-g102');
INSERT INTO products (name, code, images, price, discount, description, quantity, status, slug) VALUES ('Router WiFi TP-Link', 'SP0005', 'router-wifi-tp-link.jpg', 11389895, 5, 'Sản phẩm Router WiFi TP-Link phù hợp với nhu cầu sử dụng cá nhân hoặc doanh nghiệp.', 75, 'active', 'router-wifi-tp-link');
INSERT INTO products (name, code, images, price, discount, description, quantity, status, slug) VALUES ('PC Gaming AMD', 'SP0006', 'pc-gaming-amd.jpg', 11893045, 10, 'Sản phẩm PC Gaming AMD phù hợp với nhu cầu sử dụng cá nhân hoặc doanh nghiệp.', 17, 'active', 'pc-gaming-amd');
INSERT INTO products (name, code, images, price, discount, description, quantity, status, slug) VALUES ('Laptop Asus Zenbook', 'SP0007', 'laptop-asus-zenbook.jpg', 18833524, 10, 'Sản phẩm Laptop Asus Zenbook phù hợp với nhu cầu sử dụng cá nhân hoặc doanh nghiệp.', 38, 'active', 'laptop-asus-zenbook');
INSERT INTO products (name, code, images, price, discount, description, quantity, status, slug) VALUES ('Màn hình Dell 27inch', 'SP0008', 'màn-hình-dell-27inch.jpg', 12032111, 10, 'Sản phẩm Màn hình Dell 27inch phù hợp với nhu cầu sử dụng cá nhân hoặc doanh nghiệp.', 99, 'active', 'màn-hình-dell-27inch');
INSERT INTO products (name, code, images, price, discount, description, quantity, status, slug) VALUES ('Bàn phím cơ Razer', 'SP0009', 'bàn-phím-cơ-razer.jpg', 7159294, 10, 'Sản phẩm Bàn phím cơ Razer phù hợp với nhu cầu sử dụng cá nhân hoặc doanh nghiệp.', 35, 'active', 'bàn-phím-cơ-razer');
INSERT INTO products (name, code, images, price, discount, description, quantity, status, slug) VALUES ('Switch 8 cổng', 'SP0010', 'switch-8-cổng.jpg', 7780563, 5, 'Sản phẩm Switch 8 cổng phù hợp với nhu cầu sử dụng cá nhân hoặc doanh nghiệp.', 20, 'active', 'switch-8-cổng');


INSERT INTO products_categories (product_id, category_id) VALUES (1, 1);
INSERT INTO products_categories (product_id, category_id) VALUES (2, 2);
INSERT INTO products_categories (product_id, category_id) VALUES (3, 3);
INSERT INTO products_categories (product_id, category_id) VALUES (4, 4);
INSERT INTO products_categories (product_id, category_id) VALUES (5, 5);
INSERT INTO products_categories (product_id, category_id) VALUES (6, 1);
INSERT INTO products_categories (product_id, category_id) VALUES (7, 2);
INSERT INTO products_categories (product_id, category_id) VALUES (8, 3);
INSERT INTO products_categories (product_id, category_id) VALUES (9, 4);
INSERT INTO products_categories (product_id, category_id) VALUES (10, 5);


-- orders
INSERT INTO orders (id, code, full_name, phone, note, status, deleted, deleted_at, created_at, updated_at) VALUES 
(1, 'ORD00001', 'Nguyễn Văn An', '0912345678', 'Giao hàng trong ngày', 'pending', FALSE, NULL, '2025-04-01 10:00:00', '2025-04-01 10:00:00'),
(2, 'ORD00002', 'Trần Thị Bình', '0987654321', '', 'confirmed', FALSE, NULL, '2025-04-02 14:30:00', '2025-04-02 15:00:00'),
(3, 'ORD00003', 'Lê Minh Châu', '0935123456', 'Gói cẩn thận', 'shipped', FALSE, NULL, '2025-04-03 09:15:00', '2025-04-03 10:00:00'),
(4, 'ORD00004', 'Phạm Quốc Duy', '0909123456', 'Giao vào buổi sáng', 'delivered', FALSE, NULL, '2025-04-04 11:00:00', '2025-04-05 08:00:00'),
(5, 'ORD00005', 'Hoàng Thị E', '0941234567', '', 'cancelled', FALSE, NULL, '2025-04-05 16:00:00', '2025-04-05 16:30:00'),
(6, 'ORD00006', 'Đặng Văn Phúc', '0978123456', 'Giao hàng nhanh', 'pending', FALSE, NULL, '2025-04-06 13:20:00', '2025-04-06 13:20:00'),
(7, 'ORD00007', 'Ngô Thị Giang', '0923456789', '', 'confirmed', FALSE, NULL, '2025-04-07 08:45:00', '2025-04-07 09:00:00'),
(8, 'ORD00008', 'Vũ Minh Hiếu', '0967891234', 'Gọi trước khi giao', 'shipped', FALSE, NULL, '2025-04-08 12:00:00', '2025-04-08 12:30:00'),
(9, 'ORD00009', 'Bùi Thị Kim', '0918765432', '', 'delivered', FALSE, NULL, '2025-04-09 15:00:00', '2025-04-10 09:00:00'),
(10, 'ORD00010', 'Lý Văn Long', '0936789123', 'Giao vào cuối tuần', 'pending', FALSE, NULL, '2025-04-10 17:00:00', '2025-04-10 17:00:00');

-- orders_products
INSERT INTO orders_products (order_id, product_id, quantity, price, discount) VALUES 
-- Order 1
(1, 1, 1, 9361678, 5),    -- PC Gaming X305
(1, 4, 2, 11188129, 10),  -- Chuột Logitech G102
-- Order 2
(2, 2, 1, 17389795, 0),   -- Laptop HP G3
-- Order 3
(3, 3, 1, 8348463, 10),   -- Màn Hình LG 24inch
(3, 5, 1, 11389895, 5),   -- Router WiFi TP-Link
(3, 9, 1, 7159294, 10),   -- Bàn phím cơ Razer
-- Order 4
(4, 6, 1, 11893045, 10),  -- PC Gaming AMD
-- Order 5
(5, 7, 1, 18833524, 10),  -- Laptop Asus Zenbook
(5, 8, 1, 12032111, 10),  -- Màn hình Dell 27inch
-- Order 6
(6, 1, 2, 9361678, 5),    -- PC Gaming X305
-- Order 7
(7, 2, 1, 17389795, 0),   -- Laptop HP G3
(7, 4, 1, 11188129, 10),  -- Chuột Logitech G102
-- Order 8
(8, 3, 1, 8348463, 10),   -- Màn Hình LG 24inch
(8, 10, 1, 7780563, 5),   -- Switch 8 cổng
-- Order 9
(9, 6, 1, 11893045, 10),  -- PC Gaming AMD
(9, 9, 1, 7159294, 10),   -- Bàn phím cơ Razer
-- Order 10
(10, 5, 1, 11389895, 5),  -- Router WiFi TP-Link
(10, 8, 1, 12032111, 10); -- Màn hình Dell 27inch
