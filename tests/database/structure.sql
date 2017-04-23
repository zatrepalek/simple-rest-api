CREATE TABLE `users` (
  `id` int(11) NOT NULL AUTO_INCREMENT PRIMARY KEY,
  `name` varchar(250) NOT NULL,
  `email` varchar(250) NOT NULL,
  `phone` int(9) NOT NULL
) ENGINE='InnoDB' COLLATE 'utf8_general_ci';
