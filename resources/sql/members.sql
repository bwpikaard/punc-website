CREATE TABLE IF NOT EXISTS `members` (
    `id` int(11) NOT NULL AUTO_INCREMENT,
    `name` varchar(50) NOT NULL,
    `email` varchar(50),
    `website` varchar(200),
    `image` varchar(50) NOT NULL,
    `institution` varchar(50) NOT NULL,
    `institution_image` varchar(50) NOT NULL,
    `expertise` varchar(300) NOT NULL,
    `instrumentation` varchar(1000) NOT NULL,
    `biography` varchar(5000),
    `approved` tinyint(1) NOT NULL,
    PRIMARY KEY (`id`)
);