-- Drop existing database if it exists
DROP DATABASE IF EXISTS FashionCostSimulator;

-- Create a new database
CREATE DATABASE FashionCostSimulator;

-- Use the database
USE FashionCostSimulator;

-- Updated Users Table
CREATE TABLE users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    fname VARCHAR(100) NOT NULL,
    lname VARCHAR(100) NOT NULL,
    email VARCHAR(150) UNIQUE NOT NULL,
    password VARCHAR(255) NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Collections Table
CREATE TABLE collections (
    collection_id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT NOT NULL,
    collection_name VARCHAR(100) NOT NULL,
    total_cost DECIMAL(10, 2) DEFAULT 0,
    total_break_even DECIMAL(10, 2) DEFAULT 0,
    projected_revenue DECIMAL(10, 2) DEFAULT 0,
    projected_profit DECIMAL(10, 2) DEFAULT 0,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE
);

-- Products Table
CREATE TABLE products (
    product_id INT AUTO_INCREMENT PRIMARY KEY,
    collection_id INT NOT NULL,
    product_name VARCHAR(100) NOT NULL,
    fabric_cost DECIMAL(10, 2) NOT NULL,
    delivery_cost DECIMAL(10, 2) NOT NULL,
    sewing_cost DECIMAL(10,2) NOT NULL,
    printing_cost DECIMAL(10, 2) NOT NULL,
    packaging_cost DECIMAL(10, 2) NOT NULL,
    number_of_units INT NOT NULL,
    unit_cost DECIMAL(10, 2) GENERATED ALWAYS AS ((fabric_cost + delivery_cost + printing_cost + sewing_cost+ packaging_cost) / number_of_units) STORED,
    markup_percentage DECIMAL(5, 2) NOT NULL,
    projected_revenue DECIMAL(10, 2) GENERATED ALWAYS AS (unit_cost * number_of_units * (1 + (markup_percentage / 100))) STORED,
    break_even_cost DECIMAL(10, 2) GENERATED ALWAYS AS (unit_cost * number_of_units) STORED,
    projected_profit DECIMAL(10, 2) GENERATED ALWAYS AS (projected_revenue - break_even_cost) STORED,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (collection_id) REFERENCES collections(collection_id) ON DELETE CASCADE
);

-- Collection Summary Table
CREATE TABLE collection_summary (
    summary_id INT AUTO_INCREMENT PRIMARY KEY,
    collection_id INT NOT NULL,
    total_cost DECIMAL(10, 2) NOT NULL,
    total_break_even DECIMAL(10, 2) NOT NULL,
    projected_revenue DECIMAL(10, 2) NOT NULL,
    projected_profit DECIMAL(10, 2) NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (collection_id) REFERENCES collections(collection_id) ON DELETE CASCADE
);
