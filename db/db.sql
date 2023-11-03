CREATE DATABASE db_chatonline DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_bin;
USE db_chatonline;

CREATE TABLE `user` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `username` VARCHAR(20) NULL,
  `name` VARCHAR(50) NULL,
  `pwd` LONGTEXT NULL,
  PRIMARY KEY (`id`)
);

CREATE TABLE `friend_request` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `id_user_sender` INT NULL,
  `id_user_receiver` INT NULL,
  PRIMARY KEY (`id`),
  FOREIGN KEY (`id_user_sender`) REFERENCES `user`(`id`),
  FOREIGN KEY (`id_user_receiver`) REFERENCES `user`(`id`)
);

CREATE TABLE `friend_ship` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `id_user1` INT NULL,
  `id_user2` INT NULL,
  PRIMARY KEY (`id`),
  FOREIGN KEY (`id_user1`) REFERENCES `user`(`id`),
  FOREIGN KEY (`id_user2`) REFERENCES `user`(`id`)
);

CREATE TABLE `message` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `content` LONGTEXT NULL,
  `date` DATETIME DEFAULT CURRENT_TIMESTAMP,
  `id_friendship` INT NULL,
  `id_user_sender` INT NULL,
  PRIMARY KEY (`id`),
  FOREIGN KEY (`id_friendship`) REFERENCES `friend_ship`(`id`),
  FOREIGN KEY (`id_user_sender`) REFERENCES `user`(`id`)
);
