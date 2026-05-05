CREATE DATABASE IF NOT EXISTS pg_rental;
USE pg_rental;

-- ================= USERS =================
CREATE TABLE users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100),
    email VARCHAR(100),
    password VARCHAR(255),
    role ENUM('user','admin') DEFAULT 'user'
);

-- ================= PROPERTIES =================
CREATE TABLE properties (
    id INT AUTO_INCREMENT PRIMARY KEY,
    title VARCHAR(200),
    address TEXT,
    price INT,
    type VARCHAR(10),
    sharing VARCHAR(20),
    image VARCHAR(255),
    owner_name VARCHAR(100),
    contact VARCHAR(20),
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,

    wifi VARCHAR(10),
    laundry VARCHAR(10),
    meals VARCHAR(10),
    gym VARCHAR(10),
    cleaning VARCHAR(10),
    security VARCHAR(10),

    description TEXT,
    capacity INT DEFAULT 1,
    owner_id INT,
    status VARCHAR(20) DEFAULT 'pending'
);

-- ================= BOOKINGS =================
CREATE TABLE bookings (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT,
    property_id INT,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,

    status VARCHAR(20),
    name VARCHAR(100),
    phone VARCHAR(10),
    message TEXT,

    notification TEXT,
    is_read INT DEFAULT 0,

    payment_status VARCHAR(20) DEFAULT 'pending',
    payment_id VARCHAR(100),
    amount INT DEFAULT 0,
    payment_method VARCHAR(50)
);

-- ================= NOTIFICATIONS =================
CREATE TABLE notifications (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT,
    message TEXT,
    is_read INT DEFAULT 0,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    booking_id INT
);

-- ================= PROPERTY IMAGES =================
CREATE TABLE property_images (
    id INT AUTO_INCREMENT PRIMARY KEY,
    property_id INT,
    image VARCHAR(255),
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (property_id) REFERENCES properties(id) ON DELETE CASCADE
);

-- ================= ADMIN USER =================
INSERT INTO users(name,email,password,role)
VALUES('Admin','admin@gmail.com',MD5('admin123'),'admin');
