CREATE TABLE IF NOT EXISTS `configuration` (
    `key` varchar(50) NOT NULL,
    `value` varchar(5000) NOT NULL,
    PRIMARY KEY (`key`)
);