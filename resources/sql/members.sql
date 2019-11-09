CREATE TABLE IF NOT EXISTS `members` (
    `id` int(11) NOT NULL AUTO_INCREMENT,
    `name` varchar(50) NOT NULL,
    `website` varchar(200),
    `image` varchar(50) NOT NULL,
    `institution` varchar(50) NOT NULL,
    `institution_image` varchar(50) NOT NULL,
    `expertise` varchar(100) NOT NULL,
    `instrumentation` varchar(1000) NOT NULL,
    `biography` varchar(5000),
    PRIMARY KEY (`id`)
);