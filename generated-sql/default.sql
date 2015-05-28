
# This is a fix for InnoDB in MySQL >= 4.1.x
# It "suspends judgement" for fkey relationships until are tables are set.
SET FOREIGN_KEY_CHECKS = 0;

-- ---------------------------------------------------------------------
-- users
-- ---------------------------------------------------------------------

DROP TABLE IF EXISTS `users`;

CREATE TABLE `users`
(
    `id` INTEGER NOT NULL AUTO_INCREMENT,
    `name` VARCHAR(30) NOT NULL,
    `email` VARCHAR(38) NOT NULL,
    `password` VARCHAR(255) NOT NULL,
    `type` VARCHAR(12) NOT NULL,
    `birth` DATE NOT NULL,
    `country` VARCHAR(30) NOT NULL,
    PRIMARY KEY (`id`)
) ENGINE=InnoDB;

-- ---------------------------------------------------------------------
-- petitions
-- ---------------------------------------------------------------------

DROP TABLE IF EXISTS `petitions`;

CREATE TABLE `petitions`
(
    `id` INTEGER NOT NULL AUTO_INCREMENT,
    `title` VARCHAR(120) NOT NULL,
    `message` VARCHAR(800) NOT NULL,
    `state` VARCHAR(30) NOT NULL,
    `target` INTEGER NOT NULL,
    `signed` INTEGER NOT NULL,
    `userid` INTEGER NOT NULL,
    `category` VARCHAR(50) NOT NULL,
    PRIMARY KEY (`id`),
    INDEX `petitions_fi_2596c7` (`userid`),
    CONSTRAINT `petitions_fk_2596c7`
        FOREIGN KEY (`userid`)
        REFERENCES `users` (`id`)
) ENGINE=InnoDB;

-- ---------------------------------------------------------------------
-- comments
-- ---------------------------------------------------------------------

DROP TABLE IF EXISTS `comments`;

CREATE TABLE `comments`
(
    `id` INTEGER NOT NULL AUTO_INCREMENT,
    `message` VARCHAR(500) NOT NULL,
    `userid` INTEGER NOT NULL,
    `petid` INTEGER NOT NULL,
    PRIMARY KEY (`id`),
    INDEX `comments_fi_2596c7` (`userid`),
    INDEX `comments_fi_4c4abd` (`petid`),
    CONSTRAINT `comments_fk_2596c7`
        FOREIGN KEY (`userid`)
        REFERENCES `users` (`id`),
    CONSTRAINT `comments_fk_4c4abd`
        FOREIGN KEY (`petid`)
        REFERENCES `petitions` (`id`)
) ENGINE=InnoDB;

-- ---------------------------------------------------------------------
-- signatures
-- ---------------------------------------------------------------------

DROP TABLE IF EXISTS `signatures`;

CREATE TABLE `signatures`
(
    `id` INTEGER NOT NULL AUTO_INCREMENT,
    `signed` TINYINT(1),
    `userid` INTEGER NOT NULL,
    `petid` INTEGER NOT NULL,
    PRIMARY KEY (`id`),
    INDEX `signatures_fi_2596c7` (`userid`),
    INDEX `signatures_fi_4c4abd` (`petid`),
    CONSTRAINT `signatures_fk_2596c7`
        FOREIGN KEY (`userid`)
        REFERENCES `users` (`id`),
    CONSTRAINT `signatures_fk_4c4abd`
        FOREIGN KEY (`petid`)
        REFERENCES `petitions` (`id`)
) ENGINE=InnoDB;

# This restores the fkey checks, after having unset them earlier
SET FOREIGN_KEY_CHECKS = 1;
