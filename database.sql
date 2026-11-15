CREATE DATABASE IF NOT EXISTS dry_season_planner
  CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
USE dry_season_planner;

CREATE TABLE IF NOT EXISTS farmers (
  id INT AUTO_INCREMENT PRIMARY KEY,
  full_name VARCHAR(120) NOT NULL,
  phone VARCHAR(30) NOT NULL,
  location VARCHAR(120) NOT NULL,
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE IF NOT EXISTS herds (
  id INT AUTO_INCREMENT PRIMARY KEY,
  farmer_id INT NOT NULL,
  lactating_cows INT NOT NULL DEFAULT 0,
  dry_cows INT NOT NULL DEFAULT 0,
  heifers INT NOT NULL DEFAULT 0,
  calves INT NOT NULL DEFAULT 0,
  updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  CONSTRAINT fk_herd_farmer FOREIGN KEY (farmer_id) REFERENCES farmers(id) ON DELETE CASCADE,
  UNIQUE KEY uq_herd_farmer (farmer_id)
);

CREATE TABLE IF NOT EXISTS silage_inventory (
  id INT AUTO_INCREMENT PRIMARY KEY,
  farmer_id INT NOT NULL,
  entry_type ENUM('made','fed','adjustment') NOT NULL,
  quantity_kg DECIMAL(12,2) NOT NULL,
  entry_date DATE NOT NULL,
  notes VARCHAR(255) DEFAULT '',
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  CONSTRAINT fk_inventory_farmer FOREIGN KEY (farmer_id) REFERENCES farmers(id) ON DELETE CASCADE
);

INSERT INTO farmers (full_name, phone, location)
SELECT 'Demo Farmer', '0700000000', 'Kampala'
WHERE NOT EXISTS (SELECT 1 FROM farmers WHERE full_name = 'Demo Farmer' AND phone = '0700000000');

INSERT INTO herds (farmer_id, lactating_cows, dry_cows, heifers, calves)
SELECT id, 8, 2, 3, 2 FROM farmers
WHERE full_name = 'Demo Farmer' AND phone = '0700000000'
AND NOT EXISTS (SELECT 1 FROM herds h WHERE h.farmer_id = farmers.id);
