/*
	Table Creation For Web Programming Language
	Target: MySQL
*/

CREATE TABLE `USER`(
	`username` VARCHAR(64) NOT NULL,
	`password` VARCHAR(64) NOT NULL,
	`email` VARCHAR(64) NOT NULL,
	`first_name` VARCHAR(32),
	`last_name` VARCHAR(32),
	`gender` VARCHAR(6),
	`address` VARCHAR(255),
	`phone` VARCHAR(32),
	`token` VARCHAR(512),
	CONSTRAINT `user_pk` PRIMARY KEY (`username`)
);

CREATE TABLE `TEAM`(
	`team_id` INTEGER(10) NOT NULL CHECK(`team_id`>0),
	`name` VARCHAR(64) NOT NULL,
	CONSTRAINT `team_pk` PRIMARY KEY (`team_id`)
);

CREATE TABLE `NEWS`(
	`news_id` INTEGER(32) NOT NULL CHECK(`news_id`>0),
	`title` VARCHAR(128) NOT NULL,
	`content` VARCHAR(65536) NOT NULL,
	`date` DATETIME NOT NULL,
	CONSTRAINT `news_pk` PRIMARY KEY (`news_id`)
);

CREATE TABLE `ROASTER`(
	`player_id` INTEGER(32) NOT NULL CHECK(`player_id`>0),
	`first_name` VARCHAR(32) NOT NULL,
	`last_name` VARCHAR(32) NOT NULL,
	`gender` VARCHAR(6),
	`weight` DECIMAL(6,2),
	`height` DECIMAL(6,2),
	`born_date` DATETIME,
	`born_place` VARCHAR(255),
	`college` VARCHAR(128),
	`team_id` INTEGER(10) CHECK(`team_id`>0),
	CONSTRAINT `roaster_pk` PRIMARY KEY (`player_id`),
	CONSTRAINT `roaster_fk` FOREIGN KEY (`team_id`) REFERENCES `TEAM`(`team_id`)
);

CREATE TABLE `GAME`(
	`game_id` INTEGER(32) NOT NULL CHECK(`game_id`>0),
	`team1_id` INTEGER(10) NOT NULL CHECK(`team1_id`>0),
	`team2_id` INTEGER(10) NOT NULL CHECK(`team2_id`>0),
	`team1_score` INTEGER(5),
	`team2_score` INTEGER(5),
	`date` DATE,
	`time` TIME,
	`location` VARCHAR(255),
	CONSTRAINT `game_pk` PRIMARY KEY (`game_id`),
	CONSTRAINT `game_fk_1` FOREIGN KEY (`team1_id`) REFERENCES `TEAM`(`team_id`),
	CONSTRAINT `game_fk_2` FOREIGN KEY (`team2_id`) REFERENCES `TEAM`(`team_id`)
);

CREATE TABLE `COMMENT`(
	`news_id` INTEGER(32) NOT NULL CHECK(`news_id`>0),
	`comment_id` INTEGER(32) NOT NULL CHECK(`comment_id`>0),
	`content` VARCHAR(255) NOT NULL,
	`date` DATETIME,
	`username` VARCHAR(64) NOT NULL,
	CONSTRAINT `comment_pk` PRIMARY KEY (`news_id`,`comment_id`),
	CONSTRAINT `comment_fk` FOREIGN KEY (`news_id`) REFERENCES `NEWS`(`news_id`),
	CONSTRAINT `comment_fk_1` FOREIGN KEY (`username`) REFERENCES `USER`(`username`)
);

CREATE TABLE `SUBSCRIBE`(
	`username` VARCHAR(64) NOT NULL,
	`team_id` INTEGER(10) NOT NULL CHECK(`team_id`>0),
	CONSTRAINT `subscribe_pk` PRIMARY KEY (`username`,`team_id`),
	CONSTRAINT `subscribe_fk_1` FOREIGN KEY (`username`) REFERENCES `USER`(`username`),
	CONSTRAINT `subscribe_fk_2` FOREIGN KEY (`team_id`) REFERENCES `TEAM`(`team_id`)
);

CREATE TABLE `TEAM_IN_NEWS`(
	`news_id` INTEGER(32) NOT NULL CHECK(`news_id`>0),
	`team_id` INTEGER(10) NOT NULL CHECK(`team_id`>0),
	CONSTRAINT `tin_pk` PRIMARY KEY (`news_id`,`team_id`),
	CONSTRAINT `tin_fk_1` FOREIGN KEY (`news_id`) REFERENCES `NEWS`(`news_id`),
	CONSTRAINT `tin_fk_2` FOREIGN KEY (`team_id`) REFERENCES `TEAM`(`team_id`)
);

CREATE TABLE `PLAYER_IN_NEWS`(
	`news_id` INTEGER(32) NOT NULL CHECK(`news_id`>0),
	`player_id` INTEGER(32) NOT NULL CHECK(`player_id`>0),
	CONSTRAINT `pin_pk` PRIMARY KEY (`news_id`,`player_id`),
	CONSTRAINT `pin_fk_1` FOREIGN KEY (`news_id`) REFERENCES `NEWS`(`news_id`),
	CONSTRAINT `pin_fk_2` FOREIGN KEY (`player_id`) REFERENCES `ROASTER`(`player_id`)
);

