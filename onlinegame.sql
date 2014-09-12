-- phpMyAdmin SQL Dump
-- version 4.1.6
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: Aug 31, 2014 at 03:05 PM
-- Server version: 5.6.16
-- PHP Version: 5.5.9

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `onlinegame`
--

-- --------------------------------------------------------

--
-- Table structure for table `admins`
--

CREATE TABLE IF NOT EXISTS `admins` (
  `id` int(2) NOT NULL AUTO_INCREMENT,
  `username` varchar(50) NOT NULL,
  `email` varchar(150) NOT NULL,
  `password` varchar(50) NOT NULL,
  `user_type` enum('1','2') NOT NULL DEFAULT '2',
  `created_date` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `modified_date` datetime NOT NULL,
  `last_login` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=3 ;

--
-- Dumping data for table `admins`
--

INSERT INTO `admins` (`id`, `username`, `email`, `password`, `user_type`, `created_date`, `modified_date`, `last_login`) VALUES
(1, 'binaya', 'binaya@gmail.com', 'b8bcabd14cae29b361e42b3d88f13593', '1', '2014-08-31 13:15:01', '0000-00-00 00:00:00', '2014-08-31 16:22:21'),
(2, 'ajit', 'ajit@gmail.com', '96e7db63cb94a44aabfec7d755eb8f68', '2', '2014-08-31 13:15:01', '0000-00-00 00:00:00', '0000-00-00 00:00:00');

-- --------------------------------------------------------

--
-- Table structure for table `cms_pages`
--

CREATE TABLE IF NOT EXISTS `cms_pages` (
  `id` int(6) NOT NULL AUTO_INCREMENT,
  `title` varchar(100) NOT NULL,
  `page_title` varchar(255) NOT NULL,
  `description` text NOT NULL,
  `created_date` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `created_by` int(11) NOT NULL,
  `modified_date` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `countries`
--

CREATE TABLE IF NOT EXISTS `countries` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `country_name` varchar(50) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=242 ;

--
-- Dumping data for table `countries`
--

INSERT INTO `countries` (`id`, `country_name`) VALUES
(1, 'Afghanistan'),
(2, 'Albania'),
(3, 'Algeria'),
(4, 'American Samoa'),
(5, 'Andorra'),
(6, 'Angola'),
(7, 'Anguilla'),
(8, 'Antarctica'),
(9, 'Antigua And Barbuda'),
(10, 'Argentina'),
(11, 'Armenia'),
(12, 'Aruba'),
(13, 'Australia'),
(14, 'Austria'),
(15, 'Azerbaijan'),
(16, 'Bahamas'),
(17, 'Bahrain'),
(18, 'Bangladesh'),
(19, 'Barbados'),
(20, 'Belarus'),
(21, 'Belgium'),
(22, 'Belize'),
(23, 'Benin'),
(24, 'Bermuda'),
(25, 'Bhutan'),
(26, 'Bolivia'),
(27, 'Bosnia And Herzegovina'),
(28, 'Botswana'),
(29, 'Bouvet Island'),
(30, 'Brazil'),
(31, 'British Indian Ocean Territory'),
(32, 'Brunei Darussalam'),
(33, 'Bulgaria'),
(34, 'Burkina Faso'),
(35, 'Burundi'),
(36, 'Cambodia'),
(37, 'Cameroon'),
(38, 'Canada'),
(39, 'Cape Verde'),
(40, 'Cayman Islands'),
(41, 'Central African Republic'),
(42, 'Chad'),
(43, 'Chile'),
(44, 'China'),
(45, 'Christmas Island'),
(46, 'Cocos (keeling) Islands'),
(47, 'Colombia'),
(48, 'Comoros'),
(49, 'Congo'),
(50, 'Congo, The Democratic Republic Of The'),
(51, 'Cook Islands'),
(52, 'Costa Rica'),
(53, 'Cote D''ivoire'),
(54, 'Croatia'),
(55, 'Cuba'),
(56, 'Cyprus'),
(57, 'Czech Republic'),
(58, 'Denmark'),
(59, 'Djibouti'),
(60, 'Dominica'),
(61, 'Dominican Republic'),
(62, 'East Timor'),
(63, 'Ecuador'),
(64, 'Egypt'),
(65, 'El Salvador'),
(66, 'Equatorial Guinea'),
(67, 'Eritrea'),
(68, 'Estonia'),
(69, 'Ethiopia'),
(70, 'Falkland Islands (malvinas)'),
(71, 'Faroe Islands'),
(72, 'Fiji'),
(73, 'Finland'),
(74, 'France'),
(75, 'French Guiana'),
(76, 'French Polynesia'),
(77, 'French Southern Territories'),
(78, 'Gabon'),
(79, 'Gambia'),
(80, 'Georgia'),
(81, 'Germany'),
(82, 'Ghana'),
(83, 'Gibraltar'),
(84, 'Greece'),
(85, 'Greenland'),
(86, 'Grenada'),
(87, 'Guadeloupe'),
(88, 'Guam'),
(89, 'Guatemala'),
(90, 'Guinea'),
(91, 'Guinea-bissau'),
(92, 'Guyana'),
(93, 'Haiti'),
(94, 'Heard Island And Mcdonald Islands'),
(95, 'Holy See (vatican City State)'),
(96, 'Honduras'),
(97, 'Hong Kong'),
(98, 'Hungary'),
(99, 'Iceland'),
(100, 'India'),
(101, 'Indonesia'),
(102, 'Iran, Islamic Republic Of'),
(103, 'Iraq'),
(104, 'Ireland'),
(105, 'Israel'),
(106, 'Italy'),
(107, 'Jamaica'),
(108, 'Japan'),
(109, 'Jordan'),
(110, 'Kazakstan'),
(111, 'Kenya'),
(112, 'Kiribati'),
(113, 'Korea, Democratic People''s Republic Of'),
(114, 'Korea, Republic Of'),
(115, 'Kosovo'),
(116, 'Kuwait'),
(117, 'Kyrgyzstan'),
(118, 'Lao People''s Democratic Republic'),
(119, 'Latvia'),
(120, 'Lebanon'),
(121, 'Lesotho'),
(122, 'Liberia'),
(123, 'Libyan Arab Jamahiriya'),
(124, 'Liechtenstein'),
(125, 'Lithuania'),
(126, 'Luxembourg'),
(127, 'Macau'),
(128, 'Macedonia, The Former Yugoslav Republic Of'),
(129, 'Madagascar'),
(130, 'Malawi'),
(131, 'Malaysia'),
(132, 'Maldives'),
(133, 'Mali'),
(134, 'Malta'),
(135, 'Marshall Islands'),
(136, 'Martinique'),
(137, 'Mauritania'),
(138, 'Mauritius'),
(139, 'Mayotte'),
(140, 'Mexico'),
(141, 'Micronesia, Federated States Of'),
(142, 'Moldova, Republic Of'),
(143, 'Monaco'),
(144, 'Mongolia'),
(145, 'Montserrat'),
(146, 'Montenegro'),
(147, 'Morocco'),
(148, 'Mozambique'),
(149, 'Myanmar'),
(150, 'Namibia'),
(151, 'Nauru'),
(152, 'Nepal'),
(153, 'Netherlands'),
(154, 'Netherlands Antilles'),
(155, 'New Caledonia'),
(156, 'New Zealand'),
(157, 'Nicaragua'),
(158, 'Niger'),
(159, 'Nigeria'),
(160, 'Niue'),
(161, 'Norfolk Island'),
(162, 'Northern Mariana Islands'),
(163, 'Norway'),
(164, 'Oman'),
(165, 'Pakistan'),
(166, 'Palau'),
(167, 'Palestinian Territory, Occupied'),
(168, 'Panama'),
(169, 'Papua New Guinea'),
(170, 'Paraguay'),
(171, 'Peru'),
(172, 'Philippines'),
(173, 'Pitcairn'),
(174, 'Poland'),
(175, 'Portugal'),
(176, 'Puerto Rico'),
(177, 'Qatar'),
(178, 'Reunion'),
(179, 'Romania'),
(180, 'Russian Federation'),
(181, 'Rwanda'),
(182, 'Saint Helena'),
(183, 'Saint Kitts And Nevis'),
(184, 'Saint Lucia'),
(185, 'Saint Pierre And Miquelon'),
(186, 'Saint Vincent And The Grenadines'),
(187, 'Samoa'),
(188, 'San Marino'),
(189, 'Sao Tome And Principe'),
(190, 'Saudi Arabia'),
(191, 'Senegal'),
(192, 'Serbia'),
(193, 'Seychelles'),
(194, 'Sierra Leone'),
(195, 'Singapore'),
(196, 'Slovakia'),
(197, 'Slovenia'),
(198, 'Solomon Islands'),
(199, 'Somalia'),
(200, 'South Africa'),
(201, 'South Georgia And The South Sandwich Islands'),
(202, 'Spain'),
(203, 'Sri Lanka'),
(204, 'Sudan'),
(205, 'Suriname'),
(206, 'Svalbard And Jan Mayen'),
(207, 'Swaziland'),
(208, 'Sweden'),
(209, 'Switzerland'),
(210, 'Syrian Arab Republic'),
(211, 'Taiwan, Province Of China'),
(212, 'Tajikistan'),
(213, 'Tanzania, United Republic Of'),
(214, 'Thailand'),
(215, 'Togo'),
(216, 'Tokelau'),
(217, 'Tonga'),
(218, 'Trinidad And Tobago'),
(219, 'Tunisia'),
(220, 'Turkey'),
(221, 'Turkmenistan'),
(222, 'Turks And Caicos Islands'),
(223, 'Tuvalu'),
(224, 'Uganda'),
(225, 'Ukraine'),
(226, 'United Arab Emirates'),
(227, 'United Kingdom'),
(228, 'United States'),
(229, 'United States Minor Outlying Islands'),
(230, 'Uruguay'),
(231, 'Uzbekistan'),
(232, 'Vanuatu'),
(233, 'Venezuela'),
(234, 'Viet Nam'),
(235, 'Virgin Islands, British'),
(236, 'Virgin Islands, U.s.'),
(237, 'Wallis And Futuna'),
(238, 'Western Sahara'),
(239, 'Yemen'),
(240, 'Zambia'),
(241, 'Zimbabwe');

-- --------------------------------------------------------

--
-- Table structure for table `email_templates`
--

CREATE TABLE IF NOT EXISTS `email_templates` (
  `id` int(6) NOT NULL AUTO_INCREMENT,
  `title` varchar(100) NOT NULL,
  `subject` varchar(255) NOT NULL,
  `allowed_vars` varchar(255) NOT NULL,
  `email_from` varchar(150) NOT NULL,
  `description` text NOT NULL,
  `created_date` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `created_by` int(11) NOT NULL,
  `modified_date` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=39 ;

--
-- Dumping data for table `email_templates`
--

INSERT INTO `email_templates` (`id`, `title`, `subject`, `allowed_vars`, `email_from`, `description`, `created_date`, `created_by`, `modified_date`) VALUES
(1, 'Success Register Message', 'Activation Link', '{name},{last_name},{activation_code}', 'no-reply@tambark.com', '<p><strong>Hello:</strong>{name},{last_name}</p>\r\n<p>Thank you for joining Tambark.com. &nbsp;Below is your activation link. Please click to activate your account.&nbsp;</p>\r\n<p>{activation_code}</p>\r\n<p>Thank you again for joining us.&nbsp;</p>\r\n<p>Regards</p>\r\n<p>Tambark Support Team</p>', '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00'),
(2, 'Successfull User Registration to Admin', 'Successfull Registration ', '{name},{last name}', 'no-reply@tambark.com', ' <p>Hello Admin,</p>\r\n<p>A New student {name} {last_name} is registered with Tambark</p>\r\n<p>With Best Regards</p>\r\n<p><b>Tambark Team</b></p>', '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00'),
(3, 'Password to Admin', 'Password to Admin', '{password}', 'no-reply@tambark.com', '<p>Hello Admin&nbsp;</p>\r\n<p><strong>Your password is :</strong>&nbsp; {password}</p>\r\n<p>Tambark Team</p>', '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00'),
(4, 'Contact Us', 'Contact Us', '{first_name},{last_name}', 'no-reply@tambark.com', '<p>Hello {first_name}&nbsp;{last_name}</p>\r\n<p>Thank you for you note. We will get back to you shortly.</p>\r\n<p>Thank you using Tambark.com.</p>\r\n<p>Tambark Support Team</p>', '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00'),
(5, 'Password to Member', 'Password to Member', '{first_name},{last_name},{password}', 'no-reply@tambark.com', '<p><strong>Hello</strong> {first_name} {last_name}</p>\r\n<p><strong>Your password is :</strong>&nbsp; {password}</p>\r\n<p>Thank you for using Tambark.com</p>\r\n<p>Regards</p>\r\n<p>Tambark Support Team</p>', '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00'),
(6, 'Success Register Message', 'Activation Link', '{name},{last_name},{activation_code}', 'no-reply@tambark.com', '<p>Hello {name} {last_name},</p>\r\n<p>&nbsp;</p>\r\n<p>You have Successfully register with Tambark. Please click on the following link to activate your account..</p>\r\n<p>&nbsp;</p>\r\n<p>{activation_code}</p>\r\n<p>With Best Regards,</p>\r\n<p>Tambark Team</p>', '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00'),
(7, 'Success Register Message', 'Registration', '{name},{last_name},{email},{password}', 'no-reply@tambark.com', '<p>Hello {name} {last_name},</p>\r\n<p>&nbsp;</p>\r\n<p>You have Successfully register with Tambark.</p>\r\n<p>Your UserName:&nbsp;{email}</p>\r\n<p>Your Password:&nbsp;{password}</p>\r\n<p>Please keep your credentials safely.&nbsp;</p>\r\n<p><br />\r\nAnd thank you for registering with Tambark.com</p>\r\n<p>With Best Regards,</p>\r\n<p>Tambark Team</p>', '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00'),
(19, 'Send Invitation', 'Join This Site', '{name},{site_url},{inviter_name},{description}', 'no-reply@tambark.com', '<p>Hello {name},</p>\r\n<p>&nbsp;</p>\r\n<p>Message: {description}</p>\r\n<p>{inviter_name} has send invitation to join this site. Please click on the following link to join this site..</p>\r\n<p>{site_url}</p>\r\n<p>With Best Regards,</p>\r\n<p>Tambark Support Team</p>', '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00'),
(23, 'Request For Event', 'Request For Class', '{teacher_name},{student_fname},{student_lname},{event_title}', 'no-reply@tambark.com', '<p>Hello {teacher_name},</p>\r\n<p>A student {student_fname} {student_lname} is requested for the class{event_title}.</p>\r\n<p>The request can be found in the &quot;Approval Request&quot; section of your dashboard. Click to view and accept or reject.</p>\r\n<p>With Best Regards</p>\r\n<p><b>Tambark Team</b></p>', '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00'),
(24, 'Event Request Accepted', 'Event Request Accepted', '{student_name},{teacher_fname},{teacher_lname},{event_title}', 'no-reply@tambark.com', '<p>Hello {student_name},</p>\n<p>Your request has been accepted by {teacher_fname} {teacher_lname} for the event {event_title}.</p>\n<p>With Best Regards</p>\n<p><b>Tambark Team</b></p>', '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00'),
(25, 'Event Request Rejected', 'Event Request Rejected', '{student_name},{teacher_fname},{teacher_lname},{event_title},{reason},{message}', 'no-reply@tambark.com', '<p>Hello {student_name},</p>\r\n<p>Reason {reason}</p>\r\n<p>Your request has been rejected by {teacher_fname} {teacher_lname} for the event {event_title}.</p>\r\n<p>{message}</p>\r\n<p>With Best Regards</p>\r\n<p><b>Tambark Team</b></p>', '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00'),
(26, 'Student Removed', 'Removed From Instructor List', '{student_name},{teacher_fname},{teacher_lname},{event_title}', 'no-reply@tambark.com', '<p>Hello {student_name},</p>\r\n<p>You are being removed from the list of {teacher_fname} {teacher_lname} for the event {event_title}.</p>\r\n<p>If you think is an error, please write to us at Support at tambark.com, or go to tambark.com can contact support.&nbsp;</p>\r\n<p>With Best Regards</p>\r\n<p><b>Tambark Team</b></p>', '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00'),
(27, 'Contact Message', 'Contact Message', '{teacher_name},{student_fname},{student_lname},{student_id},{event_title},{student_email}', 'no-reply@tambark.com', ' <p>Hello {teacher_name},</p>\r\n<p>A student {student_fname} {student_lname} is trying to contact you for the event {event_title}.</p>\r\n<p>Student Id : {student_id}</p>\r\n<p>Student Email : {student_email}</p>\r\n\r\n<p>With Best Regards</p>\r\n<p><b>Tambark Team</b></p>', '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00'),
(28, 'Contact Admin', 'Contact Admin', '{first_name},{last_name},{subject},{message}', 'no-reply@tambark.com', '<p>Hello Admin,</p>\r\n<p>Instructor, <b>{first_name} {last_name}</b> is trying to contact you. </p>\r\n<p><b>Subject: </b>{subject}</p>\r\n<p><b>Message: </b>{message}</p>\r\n\r\n<p>Thanks & regards</p>\r\n<p>Tambark Team</p>', '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00'),
(29, 'Class Amendment by Instructor', 'Class Amendment by Instructor', '{name},{class}', 'no-reply@tambark.com', '<p>Dear : {name}</p>\r\n<p>Your class {class} has been changed by your insturctor. Please login to see the class changes.</p>\r\n<p>Thanks</p>\r\n<p>Regards:</p>\r\n<p>Tambark Support Team</p>\r\n<p>&nbsp;</p>', '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00'),
(30, 'Admin Profile changed', 'Admin Profile changed', '{user_name},{new_email}', 'no-reply@tambark.com', '<p>Hello Admin Your</p>\r\n<p><strong>Username is ::</strong> {user_name}</p>\r\n<p><strong>Email is ::</strong>&nbsp; {new_email} .</p>', '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00'),
(31, 'Notification', 'You have recieved a message', '{first_name},{last_name}', 'no-reply@tambark.com', '<p>Hello {first_name}&nbsp;{last_name}</p>\r\n<P>You have recieved a message check your Tambark.com account</p>\r\n\r\nRegards\r\n<P>Tambark Team</pa>', '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00'),
(32, 'Assignment Notification', 'Assignment Notification', '{s_f_name},{s_l_name},{t_f_name},{t_l_name}', 'no-reply@tambark.com', '<p>&nbsp;Hello {s_f_name} {s_l_name},</p>\r\n<p>&nbsp;</p>\r\n<p>Instructor ({t_f_name} {t_l_name}) assigned you a new Assignment.<strong> Please login into your tambark account for more details. Check your Assignment Notification against your registered class. Click to open, and review</strong>.&nbsp;</p>\r\n<p>With Regards,</p>\r\n<p>Tambark Support Team</p>', '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00'),
(33, 'Send Invitation', 'Tambark Class Invitation', '{event_name},{t_f_name},{t_l_name},{email},{link},{invite_code},{message}', 'no-reply@tambark.com', '<p>&nbsp;Hello Dear,</p>\r\n<p>&nbsp;</p>\r\n<p>Instructor ({t_f_name} {t_l_name}) send you a invitation to join class {event_name}. Please Click on below link to proceed further.</p>\r\n<p>click here:&nbsp;{link}</p>\r\n<p>Invite Code:&nbsp;<span style="text-decoration:none;color:#00aeef">{invite_code}</span></p>\r\n<p>Instuctor Message:</p>\r\n<p>{message}</p>\r\n<p>With Regards,</p>\r\n<p>Tambark Team</p>', '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00'),
(34, 'Send Class Request Invitation', 'Send Class Request Invitation', '{link},{message}', 'no-reply@tambark.com', '<p>Hello Dear,</p>\r\n<p>Instructor has sent you a link for his class. Following is the message from Instructor</p>\r\n<p>Message : {message}</p>\r\n<p>Link : {link}</p>\r\n<p>With Best Regards,</p>\r\n<p>Tambark Team</p>', '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00'),
(35, 'Send Class Invitation for Exist student', 'Tambark Class Invitation', '{event_name},{t_f_name},{t_l_name},{email},{link},{message}', 'no-reply@tambark.com', '<p>&nbsp;Hello Dear,</p>\r\n<p>&nbsp;</p>\r\n<p>Instructor ({t_f_name} {t_l_name}) send you a invitation to join class {event_name}. Please Click on below link to proceed further</p>\r\n<p>click here:&nbsp;{link}</p>\r\n<p>Instuctor Message:</p>\r\n<p>{message}</p>\r\n<p>With Regards,</p>\r\n<p>Tambark Team</p>', '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00'),
(36, 'New Member Registered Successfully', 'Tambark Registration', '{user_name},{user_type},', 'no-reply@tambark.com', '<p>&nbsp;Hello Admin,</p>\n<p>&nbsp;</p>\n<p> ({user_name}) has registered as a {user_type}.</p>\n<p>With Regards,</p>\n<p>Tambark Team</p>', '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00'),
(37, 'New Member Registered Successfully for Android App', 'Tambark Registration(Android App)', '{user_name}', 'no-reply@tambark.com', '<p>&nbsp;Hello {user_name},</p>\r\n<p>&nbsp;</p>\r\n<p> You have successfully registred with tambark.</p>\r\n<p>With Regards,</p>\r\n<p>Tambark Team</p>', '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00'),
(38, 'New Member Registered Successfully for Android App(Mail For Admin)', 'Tambark Registration(Admin)', '{user_name},{user_type},', 'no-reply@tambark.com', '<p>&nbsp;Hello Admin,</p>\n<p>&nbsp;</p>\n<p> ({user_name}) has registered as a {user_type}.</p>\n<p>With Regards,</p>\n<p>Tambark Team</p>', '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00');

-- --------------------------------------------------------

--
-- Table structure for table `games`
--

CREATE TABLE IF NOT EXISTS `games` (
  `id` int(11) NOT NULL,
  `name` varchar(260) NOT NULL,
  `image` varchar(260) NOT NULL,
  `file` varchar(260) NOT NULL,
  `code` text NOT NULL,
  `description` text NOT NULL,
  `instruction` text NOT NULL,
  `tag` varchar(500) NOT NULL,
  `series` varchar(500) NOT NULL,
  `size` varchar(260) NOT NULL,
  `category_id` varchar(500) NOT NULL,
  `created_date` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `created_by` int(11) NOT NULL,
  `modified_date` datetime NOT NULL,
  `modified_by` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `game_categories`
--

CREATE TABLE IF NOT EXISTS `game_categories` (
  `id` int(11) NOT NULL,
  `name` varchar(260) NOT NULL,
  `active` enum('1','0') NOT NULL DEFAULT '0',
  `created_date` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `modified_date` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `pages`
--

CREATE TABLE IF NOT EXISTS `pages` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `tag_id` int(11) NOT NULL,
  `name` varchar(260) NOT NULL,
  `title` varchar(260) NOT NULL,
  `description` text NOT NULL,
  `keywords` text NOT NULL,
  `tracking_code` text NOT NULL,
  `type` enum('popular','new') NOT NULL DEFAULT 'new',
  `created_date` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `modified_date` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `tags`
--

CREATE TABLE IF NOT EXISTS `tags` (
  `id` int(11) NOT NULL,
  `name` varchar(200) NOT NULL,
  `active` enum('yes','no') NOT NULL DEFAULT 'yes',
  `created_date` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `modified_date` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE IF NOT EXISTS `users` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `first_name` varchar(100) NOT NULL,
  `last_name` varchar(100) NOT NULL,
  `email` varchar(150) NOT NULL,
  `password` varchar(100) NOT NULL,
  `phone` varchar(30) NOT NULL,
  `profile_image` varchar(100) NOT NULL,
  `street` varchar(255) NOT NULL,
  `city` varchar(100) NOT NULL,
  `zipcode` varchar(25) NOT NULL,
  `state` varchar(250) NOT NULL,
  `country` varchar(5) NOT NULL,
  `f_id` varchar(255) DEFAULT NULL,
  `t_id` varchar(255) DEFAULT NULL,
  `g_id` varchar(255) DEFAULT NULL,
  `url` varchar(255) DEFAULT NULL,
  `additional_information` text NOT NULL,
  `activation_code` varchar(255) NOT NULL,
  `status` int(1) NOT NULL DEFAULT '1',
  `created_date` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `modified_date` datetime NOT NULL,
  `last_login` varchar(30) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
