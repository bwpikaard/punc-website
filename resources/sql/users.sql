CREATE TABLE IF NOT EXISTS `users` (
    `id` int(11) NOT NULL AUTO_INCREMENT,
    `username` varchar(50) NOT NULL,
    `email` varchar(50) NOT NULL,
    `displayname` varchar(50) NOT NULL,
    `password` varchar(100) NOT NULL,
    `administrator` tinyint(1) NOT NULL,
    `created` datetime NOT NULL,
    PRIMARY KEY (`id`)
);