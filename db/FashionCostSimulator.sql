-- Drop existing database if it exists
DROP DATABASE IF EXISTS FashionCostSimulator;

-- Create new database
CREATE DATABASE FashionCostSimulator;

-- Use the database
USE FashionCostSimulator;

-- Users Table
CREATE TABLE users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    fname VARCHAR(100) NOT NULL,
    lname VARCHAR(100) NOT NULL,
    email VARCHAR(150) UNIQUE NOT NULL,
    password VARCHAR(255) NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

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
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

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
    unit_cost DECIMAL(10, 2) GENERATED ALWAYS AS ((fabric_cost + delivery_cost + printing_cost + sewing_cost + packaging_cost) / number_of_units) STORED,
    markup_percentage DECIMAL(5, 2) NOT NULL,
    projected_revenue DECIMAL(10, 2) GENERATED ALWAYS AS (unit_cost * number_of_units * (1 + (markup_percentage / 100))) STORED,
    break_even_cost DECIMAL(10, 2) GENERATED ALWAYS AS (unit_cost * number_of_units) STORED,
    projected_profit DECIMAL(10, 2) GENERATED ALWAYS AS (projected_revenue - break_even_cost) STORED,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (collection_id) REFERENCES collections(collection_id) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

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
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Triggers to update collection financials and summary
DELIMITER //

-- Trigger for INSERT
CREATE TRIGGER update_collection_financials_insert 
AFTER INSERT ON products
FOR EACH ROW BEGIN
    -- Update collection financials
    UPDATE collections c SET 
        total_cost = (
            SELECT COALESCE(SUM(fabric_cost + delivery_cost + sewing_cost + printing_cost + packaging_cost), 0)
            FROM products
            WHERE collection_id = NEW.collection_id
        ),
        total_break_even = (
            SELECT COALESCE(SUM(break_even_cost), 0)
            FROM products
            WHERE collection_id = NEW.collection_id
        ),
        projected_revenue = (
            SELECT COALESCE(SUM(projected_revenue), 0)
            FROM products
            WHERE collection_id = NEW.collection_id
        ),
        projected_profit = (
            SELECT COALESCE(SUM(projected_profit), 0)
            FROM products
            WHERE collection_id = NEW.collection_id
        )
    WHERE collection_id = NEW.collection_id;

    -- Update or Insert collection summary
    INSERT INTO collection_summary (
        collection_id, 
        total_cost, 
        total_break_even, 
        projected_revenue, 
        projected_profit
    ) 
    SELECT 
        collection_id,
        total_cost,
        total_break_even,
        projected_revenue,
        projected_profit
    FROM collections
    WHERE collection_id = NEW.collection_id
    ON DUPLICATE KEY UPDATE 
        total_cost = VALUES(total_cost),
        total_break_even = VALUES(total_break_even),
        projected_revenue = VALUES(projected_revenue),
        projected_profit = VALUES(projected_profit);
END;//

-- Trigger for UPDATE
CREATE TRIGGER update_collection_financials_update
AFTER UPDATE ON products
FOR EACH ROW BEGIN
    -- Update collection financials
    UPDATE collections c SET 
        total_cost = (
            SELECT COALESCE(SUM(fabric_cost + delivery_cost + sewing_cost + printing_cost + packaging_cost), 0)
            FROM products
            WHERE collection_id = NEW.collection_id
        ),
        total_break_even = (
            SELECT COALESCE(SUM(break_even_cost), 0)
            FROM products
            WHERE collection_id = NEW.collection_id
        ),
        projected_revenue = (
            SELECT COALESCE(SUM(projected_revenue), 0)
            FROM products
            WHERE collection_id = NEW.collection_id
        ),
        projected_profit = (
            SELECT COALESCE(SUM(projected_profit), 0)
            FROM products
            WHERE collection_id = NEW.collection_id
        )
    WHERE collection_id = NEW.collection_id;

    -- Update collection summary
    INSERT INTO collection_summary (
        collection_id, 
        total_cost, 
        total_break_even, 
        projected_revenue, 
        projected_profit
    ) 
    SELECT 
        collection_id,
        total_cost,
        total_break_even,
        projected_revenue,
        projected_profit
    FROM collections
    WHERE collection_id = NEW.collection_id
    ON DUPLICATE KEY UPDATE 
        total_cost = VALUES(total_cost),
        total_break_even = VALUES(total_break_even),
        projected_revenue = VALUES(projected_revenue),
        projected_profit = VALUES(projected_profit);
END;//

-- Trigger for DELETE
CREATE TRIGGER update_collection_financials_delete
AFTER DELETE ON products
FOR EACH ROW BEGIN
    -- Update collection financials
    UPDATE collections c SET 
        total_cost = (
            SELECT COALESCE(SUM(fabric_cost + delivery_cost + sewing_cost + printing_cost + packaging_cost), 0)
            FROM products
            WHERE collection_id = OLD.collection_id
        ),
        total_break_even = (
            SELECT COALESCE(SUM(break_even_cost), 0)
            FROM products
            WHERE collection_id = OLD.collection_id
        ),
        projected_revenue = (
            SELECT COALESCE(SUM(projected_revenue), 0)
            FROM products
            WHERE collection_id = OLD.collection_id
        ),
        projected_profit = (
            SELECT COALESCE(SUM(projected_profit), 0)
            FROM products
            WHERE collection_id = OLD.collection_id
        )
    WHERE collection_id = OLD.collection_id;

    -- Update collection summary
    INSERT INTO collection_summary (
        collection_id, 
        total_cost, 
        total_break_even, 
        projected_revenue, 
        projected_profit
    ) 
    SELECT 
        collection_id,
        total_cost,
        total_break_even,
        projected_revenue,
        projected_profit
    FROM collections
    WHERE collection_id = OLD.collection_id
    ON DUPLICATE KEY UPDATE 
        total_cost = VALUES(total_cost),
        total_break_even = VALUES(total_break_even),
        projected_revenue = VALUES(projected_revenue),
        projected_profit = VALUES(projected_profit);
END;//

DELIMITER ;

-- Indexes for performance optimization
CREATE INDEX idx_user_id ON users(id);
CREATE INDEX idx_collection_user_id ON collections(user_id);
CREATE INDEX idx_product_collection_id ON products(collection_id);
CREATE UNIQUE INDEX idx_collection_summary ON collection_summary(collection_id);