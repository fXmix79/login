-- Create a database
CREATE DATABASE example_db;

-- Use the created database
USE example_db;

-- Create a users table
CREATE TABLE users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(50) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL
);

-- Insert some sample data
INSERT INTO users (username, password) VALUES
('user1', '$2y$10$EIXuQoL6ZnS2Rx1hFxeEUu9U7CNc7x3IhCeihwWXcXG4a3LS0VOWG'), -- password: password123
('user2', '$2y$10$e9Lw4.vMdOaJzCPlpRQSSOnJkK9oN0O7eOBF6F3UgNuwlCpq6OgyC'); -- password: mysecurepassword
