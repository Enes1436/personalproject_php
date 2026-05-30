CREATE DATABASE IF NOT EXISTS rentacar CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
USE rentacar;

CREATE TABLE cars (
    id INT AUTO_INCREMENT PRIMARY KEY,
    brand VARCHAR(80) NOT NULL,
    model VARCHAR(80) NOT NULL,
    year INT NOT NULL,
    transmission ENUM('Manual','Automatik') NOT NULL DEFAULT 'Manual',
    fuel ENUM('Benzine','Naft','Hybrid','Elektrik') NOT NULL DEFAULT 'Benzine',
    seats INT NOT NULL DEFAULT 5,
    price_per_day DECIMAL(8,2) NOT NULL,
    image VARCHAR(255) DEFAULT NULL,
    description TEXT,
    available TINYINT(1) NOT NULL DEFAULT 1,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB;

CREATE TABLE bookings (
    id INT AUTO_INCREMENT PRIMARY KEY,
    car_id INT NOT NULL,
    full_name VARCHAR(120) NOT NULL,
    email VARCHAR(120) NOT NULL,
    phone VARCHAR(30) NOT NULL,
    start_date DATE NOT NULL,
    end_date DATE NOT NULL,
    total_price DECIMAL(10,2) NOT NULL,
    status ENUM('Ne pritje','Konfirmuar','Anulluar') DEFAULT 'Ne pritje',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (car_id) REFERENCES cars(id) ON DELETE CASCADE
) ENGINE=InnoDB;

CREATE TABLE admins (
    id INT AUTO_INCREMENT PRIMARY KEY,
    email VARCHAR(120) UNIQUE NOT NULL,
    password VARCHAR(255) NOT NULL,
    name VARCHAR(80) NOT NULL
) ENGINE=InnoDB;

-- Admin default: admin@rentacar.al / admin123
INSERT INTO admins (email, password, name) VALUES
('admin@rentacar.al', '$2y$10$Q8q5K2nQ4VxX5xWZ8yJ1Y.7vYfZcK9LJ1mD3Lk5n7Hb8X9.dZqV6e', 'Admin');

INSERT INTO cars (brand, model, year, transmission, fuel, seats, price_per_day, description) VALUES
('Volkswagen', 'Golf 7', 2019, 'Manual', 'Naft', 5, 35.00, 'Komod dhe ekonomik per qytet.'),
('BMW', 'Seria 3', 2021, 'Automatik', 'Naft', 5, 75.00, 'Luksoz dhe i fuqishëm.'),
('Mercedes-Benz', 'C-Class', 2022, 'Automatik', 'Benzine', 5, 90.00, 'Elegant dhe komod.'),
('Toyota', 'Yaris', 2020, 'Manual', 'Benzine', 5, 28.00, 'Ideal për qytet, konsum të ulët.'),
('Audi', 'Q5', 2021, 'Automatik', 'Naft', 5, 110.00, 'SUV i fuqishëm për familje.'),
('Fiat', '500', 2019, 'Manual', 'Benzine', 4, 25.00, 'Kompakt dhe i thjeshtë për parkim.'),
('Nissan', 'Qashqai', 2022, 'Automatik', 'Naft', 5, 88.00, 'SUV familjar me hapësirë të bollshme.'),
('Skoda', 'Octavia', 2021, 'Manual', 'Benzine', 5, 48.00, 'Sedan komod dhe ekonomik për udhëtime.'),
('Hyundai', 'Tucson', 2023, 'Automatik', 'Hybrid', 5, 95.00, 'SUV modern me konsum të ulët.'),
('Ford', 'Focus', 2020, 'Manual', 'Benzine', 5, 38.00, 'Sportiv dhe ideal për qytet.');
