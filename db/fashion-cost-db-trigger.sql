DELIMITER //

CREATE TRIGGER update_collection_totals_insert
AFTER INSERT ON products
FOR EACH ROW
BEGIN
    UPDATE collections 
    SET 
        total_costs = (
            SELECT SUM((fabric_cost + delivery_cost + printing_cost + packaging_cost) * number_of_units)
            FROM products
            WHERE collection_id = NEW.collection_id
        ),
        total_break_even = (
            SELECT SUM(break_even_point)
            FROM products
            WHERE collection_id = NEW.collection_id
        ),
        projected_revenue = (
            SELECT SUM(projected_revenue)
            FROM products
            WHERE collection_id = NEW.collection_id
        ),
        projected_profit = (
            SELECT SUM(projected_profit)
            FROM products
            WHERE collection_id = NEW.collection_id
        ),
        updated_at = CURRENT_TIMESTAMP
    WHERE collection_id = NEW.collection_id;
END //

CREATE TRIGGER update_collection_totals_update
AFTER UPDATE ON products
FOR EACH ROW
BEGIN
    UPDATE collections 
    SET 
        total_costs = (
            SELECT SUM((fabric_cost + delivery_cost + printing_cost + packaging_cost) * number_of_units)
            FROM products
            WHERE collection_id = NEW.collection_id
        ),
        total_break_even = (
            SELECT SUM(break_even_point)
            FROM products
            WHERE collection_id = NEW.collection_id
        ),
        projected_revenue = (
            SELECT SUM(projected_revenue)
            FROM products
            WHERE collection_id = NEW.collection_id
        ),
        projected_profit = (
            SELECT SUM(projected_profit)
            FROM products
            WHERE collection_id = NEW.collection_id
        ),
        updated_at = CURRENT_TIMESTAMP
    WHERE collection_id = NEW.collection_id;
END //

CREATE TRIGGER update_collection_totals_delete
AFTER DELETE ON products
FOR EACH ROW
BEGIN
    UPDATE collections 
    SET 
        total_costs = (
            SELECT SUM((fabric_cost + delivery_cost + printing_cost + packaging_cost) * number_of_units)
            FROM products
            WHERE collection_id = OLD.collection_id
        ),
        total_break_even = (
            SELECT SUM(break_even_point)
            FROM products
            WHERE collection_id = OLD.collection_id
        ),
        projected_revenue = (
            SELECT SUM(projected_revenue)
            FROM products
            WHERE collection_id = OLD.collection_id
        ),
        projected_profit = (
            SELECT SUM(projected_profit)
            FROM products
            WHERE collection_id = OLD.collection_id
        ),
        updated_at = CURRENT_TIMESTAMP
    WHERE collection_id = OLD.collection_id;
END //

DELIMITER ;
