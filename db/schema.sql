-- Database: disaster_relief
-- Run this in phpMyAdmin or mysql client

CREATE DATABASE IF NOT EXISTS `disaster_relief` DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
USE `disaster_relief`;

-- Relief centers table
CREATE TABLE IF NOT EXISTS `centers` (
  `id` INT UNSIGNED NOT NULL AUTO_INCREMENT,
  `name` VARCHAR(120) NOT NULL,
  `type` ENUM('shelter','food','medical','water') NOT NULL,
  `latitude` DECIMAL(10,7) NOT NULL,
  `longitude` DECIMAL(10,7) NOT NULL,
  `address` VARCHAR(255) DEFAULT NULL,
  `phone` VARCHAR(40) DEFAULT NULL,
  `opening_hours` VARCHAR(120) DEFAULT NULL,
  `supplies` TEXT DEFAULT NULL,
  `updated_at` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  INDEX `idx_type` (`type`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Sample seed data
INSERT INTO `centers` (`name`,`type`,`latitude`,`longitude`,`address`,`phone`,`opening_hours`,`supplies`) VALUES
('City Hall Shelter','shelter',17.3850,78.4867,'123 Main St','1800-000-111','24/7','Blankets, beds'),
('Community Kitchen','food',17.4401,78.3489,'456 Market Rd','1800-000-222','10:00-20:00','Meals, water'),
('Relief Clinic','medical',17.4220,78.4570,'789 Health Ave','1800-000-333','09:00-18:00','First aid, meds');

