-- Demo data: one user and three months of transactions.
-- Dates are relative to the current month so the dashboard and charts
-- never go stale. Demo login: demo@example.com / Demo-Pass-2026
-- (public on purpose; it only works once login.php uses password_verify).

INSERT INTO users (first_name, last_name, email, password_hash)
VALUES ('Demo', 'User', 'demo@example.com',
        '$2b$10$omxyeVIexDSlNBj.r4odvuiZQH9TczGn7ghlx760eubZwAAqURcZK');

SET @demo_id = LAST_INSERT_ID();

-- First day of this month and the two before it.
SET @m0 = CAST(DATE_FORMAT(CURDATE(), '%Y-%m-01') AS DATE);
SET @m1 = @m0 - INTERVAL 1 MONTH;
SET @m2 = @m0 - INTERVAL 2 MONTH;

INSERT INTO finance (user_id, title, amount, date, category, notes) VALUES
-- Two months ago
(@demo_id, 'Rent',                 1450.00, @m2 + INTERVAL 0 DAY,  'bills',         'Monthly rent'),
(@demo_id, 'Groceries',              96.40, @m2 + INTERVAL 2 DAY,  'food',          NULL),
(@demo_id, 'Phone plan',             45.00, @m2 + INTERVAL 4 DAY,  'bills',         NULL),
(@demo_id, 'Cinema',                 32.00, @m2 + INTERVAL 6 DAY,  'entertainment', 'Friday night'),
(@demo_id, 'Coffee',                  5.50, @m2 + INTERVAL 8 DAY,  'food',          NULL),
(@demo_id, 'Groceries',             112.75, @m2 + INTERVAL 10 DAY, 'food',          NULL),
(@demo_id, 'Gym membership',         60.00, @m2 + INTERVAL 12 DAY, 'others',        NULL),
(@demo_id, 'Concert tickets',       145.00, @m2 + INTERVAL 15 DAY, 'entertainment', NULL),
(@demo_id, 'Dinner out',             68.20, @m2 + INTERVAL 18 DAY, 'food',          'Birthday dinner'),
(@demo_id, 'Electricity',           188.30, @m2 + INTERVAL 21 DAY, 'bills',         'Quarterly bill'),
(@demo_id, 'Haircut',                35.00, @m2 + INTERVAL 24 DAY, 'others',        NULL),
(@demo_id, 'Groceries',              89.10, @m2 + INTERVAL 26 DAY, 'food',          NULL),

-- Last month
(@demo_id, 'Rent',                 1450.00, @m1 + INTERVAL 0 DAY,  'bills',         'Monthly rent'),
(@demo_id, 'Groceries',             104.60, @m1 + INTERVAL 3 DAY,  'food',          NULL),
(@demo_id, 'Phone plan',             45.00, @m1 + INTERVAL 4 DAY,  'bills',         NULL),
(@demo_id, 'Streaming subscription', 18.99, @m1 + INTERVAL 5 DAY,  'entertainment', NULL),
(@demo_id, 'Lunch',                  16.80, @m1 + INTERVAL 7 DAY,  'food',          NULL),
(@demo_id, 'Textbook',               89.95, @m1 + INTERVAL 9 DAY,  'others',        'Second-hand'),
(@demo_id, 'Groceries',              93.25, @m1 + INTERVAL 11 DAY, 'food',          NULL),
(@demo_id, 'Gym membership',         60.00, @m1 + INTERVAL 12 DAY, 'others',        NULL),
(@demo_id, 'Internet',               75.00, @m1 + INTERVAL 14 DAY, 'bills',         NULL),
(@demo_id, 'Bowling',                28.00, @m1 + INTERVAL 17 DAY, 'entertainment', NULL),
(@demo_id, 'Takeaway',               42.50, @m1 + INTERVAL 20 DAY, 'food',          NULL),
(@demo_id, 'Video game',             79.00, @m1 + INTERVAL 23 DAY, 'entertainment', NULL),
(@demo_id, 'Groceries',             118.40, @m1 + INTERVAL 25 DAY, 'food',          NULL),

-- This month (capped at today so nothing is in the future)
(@demo_id, 'Rent',                 1450.00, @m0,                                     'bills',         'Monthly rent'),
(@demo_id, 'Groceries',              87.30, LEAST(@m0 + INTERVAL 2 DAY,  CURDATE()), 'food',          NULL),
(@demo_id, 'Phone plan',             45.00, LEAST(@m0 + INTERVAL 4 DAY,  CURDATE()), 'bills',         NULL),
(@demo_id, 'Streaming subscription', 18.99, LEAST(@m0 + INTERVAL 5 DAY,  CURDATE()), 'entertainment', NULL),
(@demo_id, 'Coffee',                  6.00, LEAST(@m0 + INTERVAL 7 DAY,  CURDATE()), 'food',          NULL),
(@demo_id, 'Gym membership',         60.00, LEAST(@m0 + INTERVAL 12 DAY, CURDATE()), 'others',        NULL),
(@demo_id, 'Groceries',             101.15, LEAST(@m0 + INTERVAL 13 DAY, CURDATE()), 'food',          NULL),
(@demo_id, 'Museum entry',           25.00, LEAST(@m0 + INTERVAL 16 DAY, CURDATE()), 'entertainment', NULL),
(@demo_id, 'Pharmacy',               23.40, LEAST(@m0 + INTERVAL 19 DAY, CURDATE()), 'others',        NULL),
(@demo_id, 'Groceries',              76.85, CURDATE(),                               'food',          NULL);
