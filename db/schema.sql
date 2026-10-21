-- Finance Tracker schema (MySQL 8).
-- Column names match the queries in api/*.php.
-- No DROP statements: this file is also run by hand against production.

CREATE TABLE users (
  id            INT AUTO_INCREMENT PRIMARY KEY,
  first_name    VARCHAR(100) NOT NULL,
  last_name     VARCHAR(100) NOT NULL,
  email         VARCHAR(255) NOT NULL UNIQUE,
  password_hash VARCHAR(255) NOT NULL,
  created_at    TIMESTAMP DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE finance (
  id         INT AUTO_INCREMENT PRIMARY KEY,
  user_id    INT NOT NULL,
  title      VARCHAR(255) NOT NULL,
  amount     DECIMAL(10,2) NOT NULL,
  date       DATE NOT NULL,
  category   ENUM('food','bills','entertainment','others') NOT NULL,
  notes      TEXT NULL,
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  CONSTRAINT fk_finance_user FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE,
  CONSTRAINT chk_finance_amount CHECK (amount > 0),
  INDEX idx_finance_user_date (user_id, date)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
