CREATE DATABASE inventaris_db;
USE inventaris_db;

CREATE TABLE categories (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL
);

CREATE TABLE suppliers (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL,
    phone VARCHAR(20)
);

CREATE TABLE product (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(150) NOT NULL,
    category_id INT NOT NULL,
    supplier_id INT NOT NULL,
    price DECIMAL(12,2) NOT NULL,
    stock INT NOT NULL DEFAULT 0,
    FOREIGN KEY (category_id) REFERENCES categories (id),
    FOREIGN KEY (supplier_id) REFERENCES suppliers (id)
);

-- Seed Data (Minimal 5 data per tabel)
INSERT INTO categories (name) VALUES 
('Laptop'), ('Aksesoris'), ('Display'), ('Penyimpanan'), ('Jaringan');

INSERT INTO suppliers (name, phone) VALUES 
('PT Asus Indo', '081111111'), ('PT Peripheral', '082222222'), 
('PT Layar Bening', '083333333'), ('PT Cepat Simpan', '084444444'), ('PT Jaring Kuat', '085555555');

INSERT INTO product (name, category_id, supplier_id, price, stock) VALUES 
('Asus VivoBook A416JA', 1, 1, 7500000, 10),
('Mouse Logitech G', 2, 2, 450000, 20),
('Monitor AOC 24 Inch', 3, 3, 2100000, 15),
('SSD Samsung 1TB', 4, 4, 1500000, 30),
('Router TP-Link', 5, 5, 300000, 25);