CREATE TABLE `users` (
    `id` int(11) NOT NULL AUTO_INCREMENT,
    `type` tinyint(1) NOT NULL,
    `status` tinyint(1) NOT NULL,
    `role_id` int(11) NOT NULL,
    `username` varchar(50) NOT NULL,
    `password` varchar(128) NOT NULL,
    `firstname` varchar(50) NOT NULL,
    `lastname` varchar(50) NOT NULL,
    `email` varchar(50) NOT NULL,
    `website` varchar(200),
    `image` varchar(50),
    `institution` varchar(50),
    `institution_image` varchar(50),
    `expertise` text,
    `instrumentation` text,
    `biography` text,
    `created` datetime NOT NULL,
    PRIMARY KEY (`id`)
);

INSERT INTO `users` (`type`, `status`, `role_id`, `username`, `password`, `firstname`, `lastname`, `email`, `created`) VALUES
(1, 1, 2, 'bwpikaard', '$2y$10$leMaF/h/T19p90INXfvGKetN5Z1owKA76/OkTgfJJ/N.iOw.cdKs2', 'Bryan', 'Pikaard', 'bwpikaard@mail.roanoke.edu', '0019-09-09 10:52:10');