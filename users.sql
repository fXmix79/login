-- Create a database
CREATE DATABASE users_db
character set utf8mb4 collate utf8mb4_general_ci;

-- Use the created database
USE users_db;

-- Create a users table
CREATE TABLE users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(50) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL
);

-- Insert some sample data
INSERT INTO users (username, password) VALUES
('user1', '$2y$10$67XG5HuZdNlJCQDhcg1Nouw.MDshJ/jz9Q45TIuqI8A6XyNmRWQLm'), -- password: password123
('user2', '$2y$10$ShJNVoTu3d0gcCXeQMnu7OxNoBoD2INnI4YTX9dIRCLzneVYjsxom'); -- password: mysecurepassword

select * from users;