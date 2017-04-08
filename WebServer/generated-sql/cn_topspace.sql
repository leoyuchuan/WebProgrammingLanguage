
# This is a fix for InnoDB in MySQL >= 4.1.x
# It "suspends judgement" for fkey relationships until are tables are set.
SET FOREIGN_KEY_CHECKS = 0;

-- ---------------------------------------------------------------------
-- COMMENT
-- ---------------------------------------------------------------------

DROP TABLE IF EXISTS `COMMENT`;

CREATE TABLE `COMMENT`
(
    `news_id` INTEGER(32) NOT NULL,
    `comment_id` INTEGER(32) NOT NULL,
    `content` VARCHAR(255) NOT NULL,
    `date` DATETIME,
    `username` VARCHAR(64) NOT NULL,
    PRIMARY KEY (`news_id`,`comment_id`),
    INDEX `comment_fk_1` (`username`)
) ENGINE=MyISAM;

-- ---------------------------------------------------------------------
-- GAME
-- ---------------------------------------------------------------------

DROP TABLE IF EXISTS `GAME`;

CREATE TABLE `GAME`
(
    `game_id` INTEGER(32) NOT NULL,
    `team1_id` INTEGER(10) NOT NULL,
    `team2_id` INTEGER(10) NOT NULL,
    `team1_score` INTEGER(5),
    `team2_score` INTEGER(5),
    `date` DATE,
    `time` TIME,
    `location` VARCHAR(255),
    PRIMARY KEY (`game_id`),
    INDEX `game_fk_1` (`team1_id`),
    INDEX `game_fk_2` (`team2_id`)
) ENGINE=MyISAM;

-- ---------------------------------------------------------------------
-- NEWS
-- ---------------------------------------------------------------------

DROP TABLE IF EXISTS `NEWS`;

CREATE TABLE `NEWS`
(
    `news_id` INTEGER(32) NOT NULL,
    `title` VARCHAR(128) NOT NULL,
    `content` TEXT NOT NULL,
    `date` DATETIME NOT NULL,
    PRIMARY KEY (`news_id`)
) ENGINE=MyISAM;

-- ---------------------------------------------------------------------
-- PLAYER_IN_NEWS
-- ---------------------------------------------------------------------

DROP TABLE IF EXISTS `PLAYER_IN_NEWS`;

CREATE TABLE `PLAYER_IN_NEWS`
(
    `news_id` INTEGER(32) NOT NULL,
    `player_id` INTEGER(32) NOT NULL,
    PRIMARY KEY (`news_id`,`player_id`),
    INDEX `pin_fk_2` (`player_id`)
) ENGINE=MyISAM;

-- ---------------------------------------------------------------------
-- ROASTER
-- ---------------------------------------------------------------------

DROP TABLE IF EXISTS `ROASTER`;

CREATE TABLE `ROASTER`
(
    `player_id` INTEGER(32) NOT NULL,
    `first_name` VARCHAR(32) NOT NULL,
    `last_name` VARCHAR(32) NOT NULL,
    `gender` VARCHAR(6),
    `weight` DECIMAL(6,2),
    `height` DECIMAL(6,2),
    `born_date` DATETIME,
    `born_place` VARCHAR(255),
    `college` VARCHAR(128),
    `team_id` INTEGER(10),
    PRIMARY KEY (`player_id`),
    INDEX `roaster_fk` (`team_id`)
) ENGINE=MyISAM;

-- ---------------------------------------------------------------------
-- SUBSCRIBE
-- ---------------------------------------------------------------------

DROP TABLE IF EXISTS `SUBSCRIBE`;

CREATE TABLE `SUBSCRIBE`
(
    `username` VARCHAR(64) NOT NULL,
    `team_id` INTEGER(10) NOT NULL,
    PRIMARY KEY (`username`,`team_id`),
    INDEX `subscribe_fk_2` (`team_id`)
) ENGINE=MyISAM;

-- ---------------------------------------------------------------------
-- TEAM
-- ---------------------------------------------------------------------

DROP TABLE IF EXISTS `TEAM`;

CREATE TABLE `TEAM`
(
    `team_id` INTEGER(10) NOT NULL,
    `name` VARCHAR(64) NOT NULL,
    PRIMARY KEY (`team_id`)
) ENGINE=MyISAM;

-- ---------------------------------------------------------------------
-- TEAM_IN_NEWS
-- ---------------------------------------------------------------------

DROP TABLE IF EXISTS `TEAM_IN_NEWS`;

CREATE TABLE `TEAM_IN_NEWS`
(
    `news_id` INTEGER(32) NOT NULL,
    `team_id` INTEGER(10) NOT NULL,
    PRIMARY KEY (`news_id`,`team_id`),
    INDEX `tin_fk_2` (`team_id`)
) ENGINE=MyISAM;

-- ---------------------------------------------------------------------
-- USER
-- ---------------------------------------------------------------------

DROP TABLE IF EXISTS `USER`;

CREATE TABLE `USER`
(
    `username` VARCHAR(64) NOT NULL,
    `password` VARCHAR(64) NOT NULL,
    `email` VARCHAR(64) NOT NULL,
    `first_name` VARCHAR(32),
    `last_name` VARCHAR(32),
    `gender` VARCHAR(6),
    `address` VARCHAR(255),
    `phone` VARCHAR(32),
    `token` VARCHAR(512),
    PRIMARY KEY (`username`)
) ENGINE=MyISAM;

# This restores the fkey checks, after having unset them earlier
SET FOREIGN_KEY_CHECKS = 1;
