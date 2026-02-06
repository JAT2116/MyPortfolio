CREATE DATABASE IF NOT EXISTS `database`;
USE `database`;

--
-- Table structure for table `users`
--
CREATE TABLE `users` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `username` (`username`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `users`
--
-- You should change this default password in a real application by creating a proper hash.
-- The fallback password is 'Admin'
INSERT INTO `users` (`id`, `username`, `password`) VALUES
(1, 'Admin', '$2y$10$I/hP.N9/pE55B5/aL9.gA.LpB.Xl4jL9V8tZ3.aN8mZ3.aN8mZ3.a');

--
-- Table structure for table `projects`
--
CREATE TABLE `projects` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(100) NOT NULL,
  `description` text NOT NULL,
  `image_path` varchar(255) NOT NULL,
  `category` varchar(50) NOT NULL,
  `project_link` varchar(255) DEFAULT '#',
  `document_path` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Table structure for table `site_info`
--
CREATE TABLE `site_info` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `info_key` varchar(50) NOT NULL,
  `info_value` text NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `info_key` (`info_key`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `site_info`
--
INSERT INTO `site_info` (`id`, `info_key`, `info_value`) VALUES
(1, 'email', 'jehieltuan12345@sample.com'),
(2, 'facebook', 'Jehiel Tuan'),
(3, 'about_me', 'I''m Jehiel Tuan, a student programmer and developer passionate about building real-world solutions through code. I’m constantly exploring new technologies and sharpening my skills to grow into a well-rounded software developer.'),
(4, 'service_web_desc', 'As a web designer, I bring ideas to life through clean, creative, and user-focused designs that blend function with visual appeal.'),
(5, 'service_student_desc', 'As a computer science student is a constant cycle of coding, debugging, caffeine, and the occasional existential crisis over semicolons.'),
(6, 'service_dev_desc', 'As a software developer is a blend of solving complex problems, writing and rewriting code, and endlessly learning to keep up with ever-evolving technology.'),
(7, 'service_fullstack_desc', 'As a frontend and backend developer means juggling user experience and server logic, turning ideas into seamless interfaces while ensuring everything runs smoothly behind the scenes.'),
(8, 'home_intro', 'Motivated computer science student and aspiring programmer with a solid foundation in software development and a passion for learning new technologies. Seeking an opportunity to contribute to real-world projects while gaining hands-on experience and growing as a developer.');