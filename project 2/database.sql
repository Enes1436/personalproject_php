-- Rent A Car Database Schema
-- Import this in phpMyAdmin or run via mysql CLI

CREATE DATABASE IF NOT EXISTS rentacar1 CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
USE rentacar1;

-- Admin users
CREATE TABLE IF NOT EXISTS users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL,
    email VARCHAR(150) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL,
    role ENUM('admin','client') DEFAULT 'client',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB;

-- Cars catalogue
CREATE TABLE IF NOT EXISTS cars (
    id INT AUTO_INCREMENT PRIMARY KEY,
    brand VARCHAR(80) NOT NULL,
    model VARCHAR(80) NOT NULL,
    year INT NOT NULL,
    category VARCHAR(50) NOT NULL,
    transmission ENUM('Manual','Automatic') DEFAULT 'Manual',
    fuel VARCHAR(30) DEFAULT 'Petrol',
    seats INT DEFAULT 5,
    price_per_day DECIMAL(10,2) NOT NULL,
    image VARCHAR(255) DEFAULT NULL,
    description TEXT,
    available TINYINT(1) DEFAULT 1,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB;

-- Bookings
CREATE TABLE IF NOT EXISTS bookings (
    id INT AUTO_INCREMENT PRIMARY KEY,
    car_id INT NOT NULL,
    full_name VARCHAR(150) NOT NULL,
    email VARCHAR(150) NOT NULL,
    phone VARCHAR(30) NOT NULL,
    pickup_date DATE NOT NULL,
    return_date DATE NOT NULL,
    total_price DECIMAL(10,2) NOT NULL,
    status ENUM('pending','confirmed','cancelled','completed') DEFAULT 'pending',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (car_id) REFERENCES cars(id) ON DELETE CASCADE
) ENGINE=InnoDB;

-- Default admin: email=admin@rent.com  password=admin123
INSERT INTO users (name, email, password, role) VALUES
('Administrator','admin@rent.com','$2y$10$e0Mz5cQ8b2zZi8O2H1n9ZuBqYy0sQz0bF4mQpV3dXk6mC7Zk9YvQK','admin');

-- Sample cars
INSERT INTO cars (brand, model, year, category, transmission, fuel, seats, price_per_day, image, description) VALUES
('Tesla','Model 3',2023,'Electric','Automatic','Electric',5,89.00,'tesla.jpg','Modern electric sedan with autopilot and premium interior.'),
('BMW','X5',2022,'SUV','Automatic','Diesel',7,120.00,'bmw.jpg','Powerful luxury SUV perfect for family trips.'),
('Mercedes','C-Class',2023,'Sedan','Automatic','Petrol',5,99.00,'mercedes.jpg','Elegant business sedan with premium comfort.'),
('Toyota','Corolla',2022,'Economy','Manual','Petrol',5,39.00,'toyota.jpg','Reliable and fuel-efficient compact car.'),
('Audi','A4',2023,'Sedan','Automatic','Petrol',5,95.00,'audi.jpg','Sporty and refined German engineering.'),
('Range Rover','Sport',2022,'SUV','Automatic','Diesel',5,180.00,'range.jpg','Premium SUV with off-road capability and luxury.');