CREATE TABLE IF NOT EXISTS `posts` (
    `id` int(11) NOT NULL AUTO_INCREMENT,
    `published` tinyint(1) NOT NULL, 
    `author` int(11) NOT NULL,
    `title` varchar(100) NOT NULL,
    `content` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
    `created` datetime NOT NULL,
    `modified` datetime,
    PRIMARY KEY (`id`)
);