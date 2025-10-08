CREATE DATABASE IF NOT EXISTS cibil_tracker;
USE cibil_tracker;

CREATE TABLE IF NOT EXISTS users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(50) UNIQUE NOT NULL,
    email VARCHAR(100) UNIQUE NOT NULL,
    password_hash VARCHAR(255) NOT NULL,
    role ENUM('user', 'admin') NOT NULL DEFAULT 'user',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

INSERT INTO users (username, email, password_hash, role) VALUES (
    'admin',
    'admin@example.com',
    '$2y$10$<hash>', -- Replace with hash of 'admin123'
    'admin'
);

CREATE TABLE IF NOT EXISTS score_history (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT NOT NULL,
    score INT NOT NULL,
    fetched_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE
);

CREATE TABLE IF NOT EXISTS tips (
    id INT AUTO_INCREMENT PRIMARY KEY,
    tip_text TEXT NOT NULL
);

INSERT INTO tips (tip_text) VALUES 
('Pay bills on time.'),
('Reduce credit utilization.'),
('Avoid new credit applications.');