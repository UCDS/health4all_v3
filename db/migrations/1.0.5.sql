#New user function for creating access to Health4All end user documentation
INSERT INTO `user_function` (`user_function_id`, `user_function`, `user_function_display`, `description`) VALUES (NULL, 'documentation', 'End User Documentation', 'To add, edit and view end user documentation including documents and videos');

#Create table for end user documentation resources
CREATE TABLE `documentation` (
 `id` int(11) NOT NULL AUTO_INCREMENT,
 `keyword` varchar(50) NOT NULL,
 `topic` text NOT NULL,
 `document_link` varchar(200) NOT NULL,
 `document_date` date NOT NULL,
 `document_created_by` int(11) NOT NULL,
 `video_link` varchar(500) NOT NULL,
 `video_date` date NOT NULL,
 `video_created_by` int(11) NOT NULL,
 `status` tinyint(4) NOT NULL,
 `insert_datetime` datetime NOT NULL,
 `insert_by_staff_id` int(11) NOT NULL,
 `update_datetime` datetime NOT NULL,
 `update_by_staff_id` int(11) NOT NULL,
 `note` text NOT NULL,
 PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1
