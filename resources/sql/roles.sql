CREATE TABLE `roles` (
    `role_id` int(11) NOT NULL AUTO_INCREMENT,
    `role_name` varchar(255) NOT NULL,
    PRIMARY KEY (`role_id`)
);

INSERT INTO `roles` (`role_id`, `role_name`) VALUES
(2, 'Administrator'),
(1, 'User');