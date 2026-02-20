-- Add size-specific price columns to products table
-- Run this SQL query in your database to add the new columns

    ALTER TABLE products ADD COLUMN xs_price DECIMAL(10, 2) NULL;
    ALTER TABLE products ADD COLUMN s_price DECIMAL(10, 2) NULL;
    ALTER TABLE products ADD COLUMN m_price DECIMAL(10, 2) NULL;
    ALTER TABLE products ADD COLUMN l_price DECIMAL(10, 2) NULL;
    ALTER TABLE products ADD COLUMN xl_price DECIMAL(10, 2) NULL;
    ALTER TABLE products ADD COLUMN xxl_price DECIMAL(10, 2) NULL;

-- Example: Set specific prices for a product (product ID = 1)
-- UPDATE products 
-- SET xs_price = 79.00, s_price = 82.00, m_price = 85.00, l_price = 88.00, xl_price = 91.00, xxl_price = 95.00
-- WHERE id = 1;

-- To verify the changes:
-- SELECT * FROM products;
