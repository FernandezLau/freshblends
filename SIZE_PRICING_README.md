# Size-Specific Pricing Feature

## Overview
This POS system now supports size-specific pricing for products. Each product can have different prices for different sizes (XS, S, M, L, XL, XXL), or fall back to the base price if size-specific prices are not set.

## Setup Instructions

### 1. Database Migration
Run the SQL queries in `DATABASE_MIGRATION.sql` to add the new columns to your products table:

```sql
ALTER TABLE products ADD COLUMN xs_price DECIMAL(10, 2) NULL;
ALTER TABLE products ADD COLUMN s_price DECIMAL(10, 2) NULL;
ALTER TABLE products ADD COLUMN m_price DECIMAL(10, 2) NULL;
ALTER TABLE products ADD COLUMN l_price DECIMAL(10, 2) NULL;
ALTER TABLE products ADD COLUMN xl_price DECIMAL(10, 2) NULL;
ALTER TABLE products ADD COLUMN xxl_price DECIMAL(10, 2) NULL;
```

### 2. Adding/Editing Products
When adding or editing a product, you'll now see:
- **Base Price**: The default price if no size-specific price is set
- **Size-Specific Prices**: Optional fields for XS, S, M, L, XL, XXL prices

Leave size-specific fields blank if you want to use the base price for all sizes.

### 3. How It Works
- **Product Add/Edit Forms**: Grid layout showing all size price fields (2 columns)
- **Cart Display**: Shows the correct price based on the selected size
- **Receipt Printing**: Uses size-specific prices for calculations

## Pricing Logic
When a customer adds a product to cart with a specific size:
1. System checks if size-specific price exists (e.g., m_price for size M)
2. If yes, uses that price
3. If no, falls back to the base price

## Example
Product: "T-Shirt" with base price ₱85.00
- XS: ₱79.00
- S: ₱82.00
- M: (not set) → uses ₱85.00
- L: ₱88.00
- XL: ₱91.00
- XXL: ₱95.00

## Database Columns Added
- `xs_price` - Price for XS size (DECIMAL, nullable)
- `s_price` - Price for S size (DECIMAL, nullable)
- `m_price` - Price for M size (DECIMAL, nullable)
- `l_price` - Price for L size (DECIMAL, nullable)
- `xl_price` - Price for XL size (DECIMAL, nullable)
- `xxl_price` - Price for XXL size (DECIMAL, nullable)
