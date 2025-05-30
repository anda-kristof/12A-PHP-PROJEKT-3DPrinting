
CREATE DATABASE IF NOT EXISTS `12a_3dprinting` DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci;
USE `12a_3dprinting`;



CREATE TABLE `users` (
  `user_id` INT(11) NOT NULL AUTO_INCREMENT,
  `username` VARCHAR(50) NOT NULL,
  `password` VARCHAR(255) NOT NULL,
  `email` VARCHAR(100) NOT NULL,
  PRIMARY KEY (`user_id`),
  UNIQUE KEY `username` (`username`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

CREATE TABLE `materials` (
  `material_id` INT(11) NOT NULL AUTO_INCREMENT,
  `name` VARCHAR(255) NOT NULL,
  `color` VARCHAR(255) NOT NULL,
  `density` FLOAT NOT NULL,         -- g/mm^3
  `img` VARCHAR(155) NOT NULL,
  PRIMARY KEY (`material_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

CREATE TABLE `models` (
  `model_id` INT(11) NOT NULL AUTO_INCREMENT,
  `user_id` INT(11) NOT NULL,
  `name` VARCHAR(100) NOT NULL,
  `volume_mm` FLOAT NOT NULL,
  `max_size_mm` FLOAT NOT NULL,
  `description` TEXT NOT NULL,
  `img` VARCHAR(255) NOT NULL,
  `recommended_material` VARCHAR(255) NOT NULL,
  PRIMARY KEY (`model_id`),
  KEY `user_id` (`user_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

CREATE TABLE `printer_types` (
  `printer_type_id` INT(11) NOT NULL AUTO_INCREMENT,
  `printer_type_name` VARCHAR(255) NOT NULL,
  `printing_speed` FLOAT NOT NULL COMMENT 'mm^3/s',
  `plate_length` FLOAT NOT NULL,
  `plate_height` FLOAT NOT NULL,
  `plate_width` FLOAT NOT NULL,
  `compatible_materials` VARCHAR(255) NOT NULL,
  `img` VARCHAR(255) NOT NULL,
  PRIMARY KEY (`printer_type_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

CREATE TABLE `printers` (
  `printer_id` INT(11) NOT NULL AUTO_INCREMENT,
  `printer_type_id` INT(11) NOT NULL,
  `printer_name` VARCHAR(255) NOT NULL,
  `status` VARCHAR(255) NOT NULL,
  `job_id` INT(11) NOT NULL,
  PRIMARY KEY (`printer_id`),
  KEY `printer_type_id` (`printer_type_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

CREATE TABLE `filaments` (
  `filament_id` INT(11) NOT NULL AUTO_INCREMENT,
  `material_id` INT(11) NOT NULL,
  `filament_grams` FLOAT NOT NULL,
  PRIMARY KEY (`filament_id`),
  KEY `material_id` (`material_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

CREATE TABLE `jobs` (
  `job_id` INT(11) NOT NULL AUTO_INCREMENT,
  `user_id` INT(11) NOT NULL,
  `printer_id` INT(11) NOT NULL,
  `filament_id` INT(11) NOT NULL,
  `starts_time` DATETIME NOT NULL,
  `print_time` TIME NOT NULL,
  `status` VARCHAR(255) NOT NULL,
  `grams` FLOAT NOT NULL,
  `model_id` INT(11) NOT NULL,
  PRIMARY KEY (`job_id`),
  KEY `user_id` (`user_id`),
  KEY `printer_id` (`printer_id`),
  KEY `filament_id` (`filament_id`),
  KEY `model_id` (`model_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;



ALTER TABLE `models`
  ADD CONSTRAINT `models_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`);

ALTER TABLE `printers`
  ADD CONSTRAINT `printers_ibfk_1` FOREIGN KEY (`printer_type_id`) REFERENCES `printer_types` (`printer_type_id`);

ALTER TABLE `filaments`
  ADD CONSTRAINT `filaments_ibfk_1` FOREIGN KEY (`material_id`) REFERENCES `materials` (`material_id`);

ALTER TABLE `jobs`
  ADD CONSTRAINT `jobs_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`),
  ADD CONSTRAINT `jobs_ibfk_2` FOREIGN KEY (`printer_id`) REFERENCES `printers` (`printer_id`),
  ADD CONSTRAINT `jobs_ibfk_3` FOREIGN KEY (`filament_id`) REFERENCES `filaments` (`filament_id`),
  ADD CONSTRAINT `jobs_ibfk_4` FOREIGN KEY (`model_id`) REFERENCES `models` (`model_id`);

