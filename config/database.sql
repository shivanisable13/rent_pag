CREATE DATABASE pg_rental;
USE pg_rental;

CREATE TABLE users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100),
    email VARCHAR(100),
    password VARCHAR(255),
    role ENUM('user','admin') DEFAULT 'user'
);

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
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE bookings (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT,
    property_id INT,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

INSERT INTO users(name,email,password,role)
VALUES('Admin','admin@gmail.com',MD5('admin123'),'admin');