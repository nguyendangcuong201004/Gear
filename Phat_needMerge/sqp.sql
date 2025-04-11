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


CREATE TABLE users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(50) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE posts (
    id INT AUTO_INCREMENT PRIMARY KEY,
    title VARCHAR(255) NOT NULL,
    category VARCHAR(100) NOT NULL,
    image VARCHAR(255),
    content TEXT,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);
CREATE TABLE `comments` (
  `id` INT(11) NOT NULL AUTO_INCREMENT,
  `post_id` INT(11) NOT NULL,
  `name` VARCHAR(255) NOT NULL,
  `email` VARCHAR(255) NOT NULL,
  `comment` TEXT NOT NULL,
  `created_at` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `post_id` (`post_id`),
  CONSTRAINT `comments_ibfk_1` FOREIGN KEY (`post_id`) REFERENCES `posts` (`id`) 
    ON DELETE CASCADE 
    ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;



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



