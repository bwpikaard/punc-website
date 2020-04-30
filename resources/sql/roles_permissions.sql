CREATE TABLE `roles_permissions` (
    `role_id` int(11) NOT NULL,
    `permission_module` varchar(5) NOT NULL,
    `permission_id` int(11) NOT NULL,
    PRIMARY KEY (`role_id`, `permission_module`, `permission_id`)
);

INSERT INTO `roles_permissions` (`role_id`, `permission_module`, `permission_id`) VALUES
(2, 'USER', 1),
(2, 'USER', 2),
(2, 'USER', 3),
(2, 'USER', 4),
(2, 'USER', 5),
(2, 'POST', 1),
(2, 'POST', 2),
(2, 'POST', 3);