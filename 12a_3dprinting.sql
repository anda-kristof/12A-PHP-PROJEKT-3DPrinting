DROP DATABASE IF EXISTS `12a_3dprinting`;
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
  `density` FLOAT NOT NULL,
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
  `user_id` INT(11) NOT NULL,
  `printer_name` VARCHAR(255) NOT NULL,
  `status` VARCHAR(255) NOT NULL,
  `job_id` INT(11) NOT NULL,
  PRIMARY KEY (`printer_id`),
  KEY `printer_type_id` (`printer_type_id`),
  KEY `user_id` (`user_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

CREATE TABLE `filaments` (
  `filament_id` INT(11) NOT NULL AUTO_INCREMENT,
  `material_id` INT(11) NOT NULL,
  `user_id` INT(11) NOT NULL,
  `filament_grams` FLOAT NOT NULL,
  PRIMARY KEY (`filament_id`),
  KEY `material_id` (`material_id`),
  KEY `user_id` (`user_id`)
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
  ADD CONSTRAINT `printers_ibfk_1` FOREIGN KEY (`printer_type_id`) REFERENCES `printer_types` (`printer_type_id`),
  ADD CONSTRAINT `printers_ibfk_2` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`);

ALTER TABLE `filaments`
  ADD CONSTRAINT `filaments_ibfk_1` FOREIGN KEY (`material_id`) REFERENCES `materials` (`material_id`),
  ADD CONSTRAINT `filaments_ibfk_2` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`);

ALTER TABLE `jobs`
  ADD CONSTRAINT `jobs_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`),
  ADD CONSTRAINT `jobs_ibfk_2` FOREIGN KEY (`printer_id`) REFERENCES `printers` (`printer_id`),
  ADD CONSTRAINT `jobs_ibfk_3` FOREIGN KEY (`filament_id`) REFERENCES `filaments` (`filament_id`),
  ADD CONSTRAINT `jobs_ibfk_4` FOREIGN KEY (`model_id`) REFERENCES `models` (`model_id`);

INSERT INTO users (username, password, email) VALUES
  ('alice', 'hashpass1', 'alice@example.com'),
  ('bob', 'hashpass2', 'bob@example.com'),
  ('carol', 'hashpass3', 'carol@example.com');

INSERT INTO materials (name, color, density, img) VALUES
  ('PLA', 'white', 1.24, 'pla_white.png'),
  ('ABS', 'black', 1.04, 'abs_black.png'),
  ('PETG', 'blue', 1.27, 'petg_blue.png'),
  ('TPU', 'red', 1.21, 'tpu_red.png'),
  ('Nylon', 'grey', 1.15, 'nylon_grey.png');

INSERT INTO models (user_id, name, volume_mm, max_size_mm, description, img, recommended_material) VALUES
  (1, 'Chess Pawn', 1200, 45, 'A simple chess pawn.', 'pawn.png', 'PLA'),
  (2, 'Phone Stand', 3000, 100, 'Desk phone stand.', 'stand.png', 'PETG'),
  (1, 'Keychain', 350, 30, 'Small keychain with logo.', 'keychain.png', 'ABS'),
  (3, 'Spool Holder', 2400, 120, 'Filament spool holder.', 'spoolholder.png', 'PETG'),
  (2, 'Flexible Toy', 800, 55, 'A toy made from flexible TPU.', 'flexitoy.png', 'TPU');

INSERT INTO printer_types (printer_type_name, printing_speed, plate_length, plate_height, plate_width, compatible_materials, img) VALUES
  ('Prusa i3', 15.0, 250, 210, 210, 'PLA,ABS,PETG', 'prusa.png'),
  ('Ender 3', 10.0, 220, 250, 220, 'PLA,ABS', 'ender3.png'),
  ('Anycubic Mega', 12.0, 210, 210, 205, 'PLA,PETG,TPU', 'anycubic.png');

INSERT INTO printers (printer_type_id, user_id, printer_name, status, job_id) VALUES
  (1, 1, 'Prusa #1', 'idle', 0),
  (2, 2, 'Ender #1', 'printing', 0),
  (3, 3, 'Mega #1', 'idle', 0);

-- Filaments - now with user_id
INSERT INTO filaments (material_id, user_id, filament_grams) VALUES
  (1, 1, 500),   -- Alice's PLA
  (2, 1, 200),   -- Alice's ABS
  (3, 2, 1000),  -- Bob's PETG
  (1, 2, 150),   -- Bob's PLA
  (4, 2, 120),   -- Bob's TPU
  (5, 3, 300),   -- Carol's Nylon
  (3, 3, 250),   -- Carol's PETG
  (4, 3, 90);    -- Carol's TPU

INSERT INTO jobs (user_id, printer_id, filament_id, starts_time, print_time, status, grams, model_id) VALUES
  (1, 1, 1, '2025-05-30 10:00:00', '01:30:00', 'finished', 25, 1),
  (2, 2, 3, '2025-05-29 15:00:00', '02:00:00', 'printing', 50, 2),
  (1, 1, 2, '2025-05-28 12:00:00', '00:45:00', 'queued', 10, 3),
  (3, 3, 7, '2025-05-27 11:20:00', '02:20:00', 'finished', 60, 4),
  (2, 2, 5, '2025-05-27 17:00:00', '00:55:00', 'queued', 30, 5),
  (3, 3, 6, '2025-05-26 09:00:00', '01:15:00', 'finished', 40, 4),
  (3, 3, 8, '2025-05-25 13:00:00', '01:00:00', 'printing', 12, 5);