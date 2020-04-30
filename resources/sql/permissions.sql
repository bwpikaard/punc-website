CREATE TABLE `permissions` (
    `module` varchar(5) NOT NULL,
    `id` int(11) NOT NULL,
    `description` varchar(255) NOT NULL,
    PRIMARY KEY (`module`, `id`)
);

INSERT INTO `permissions` (`module`, `id`, `description`) VALUES
('USER', 1, 'Access Users'),
('USER', 2, 'Create Users'),
('USER', 3, 'Update Users'),
('USER', 4, 'Delete Users'),
('USER', 5, 'Reset Passwords'),

('POST', 1, 'Create Post'),
('POST', 2, 'Update Post'),
('POST', 3, 'Delete Post');