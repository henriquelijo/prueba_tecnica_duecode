CREATE TABLE IF NOT EXISTS `users` (
  `id` VARCHAR(23) NOT NULL,
  `firstName` VARCHAR(255) NOT NULL,
  `lastName` VARCHAR(255) NOT NULL,
  `email` VARCHAR(255) NOT NULL,
  `password` VARCHAR(255) NOT NULL,
  `date_created` DATETIME NOT NULL,
  `date_updated` DATETIME DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `email` (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;


CREATE TABLE IF NOT EXISTS `teams` (
  `id` INT AUTO_INCREMENT PRIMARY KEY,
  `name` VARCHAR(255) NOT NULL,
  `city` VARCHAR(255),
  `sport` VARCHAR(255) NOT NULL,
  `description` TEXT NOT NULL,
  `date_fundation` DATE,
  `date_created` DATETIME NOT NULL,
  `date_updated` DATETIME DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;


CREATE TABLE IF NOT EXISTS `players` (
  `id` INT AUTO_INCREMENT PRIMARY KEY,
  `name` VARCHAR(23) NOT NULL,
  `team_id` INT NOT NULL,
  `number` VARCHAR(255) NOT NULL,
  `description` TEXT DEFAULT NULL,
  `date_created` DATETIME NOT NULL,
  `date_updated` DATETIME DEFAULT NULL, 
  FOREIGN KEY (`team_id`) REFERENCES `teams`(`id`) ON DELETE RESTRICT ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

ALTER TABLE `players`
ADD COLUMN `captain` BOOLEAN DEFAULT FALSE;
