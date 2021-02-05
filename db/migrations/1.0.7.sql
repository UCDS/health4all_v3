INSERT INTO `defaults` (`default_id`, `default_tilte`, `default_description`, `default_type`, `default_unit`, `lower_range`, `upper_range`, `value`) VALUES ('uc_url', 'UC URL', 'Link to UC website', 'Text', NULL, NULL, NULL, 'http://yousee.one/'); 

INSERT INTO `defaults` (`default_id`, `default_tilte`, `default_description`, `default_type`, `default_unit`, `lower_range`, `upper_range`, `value`) VALUES ('app_helpline', 'Application Helpline', 'Helpline number for application users', 'Text', NULL, NULL, NULL, '040-4917-1149'); 

INSERT INTO `defaults` (`default_id`, `default_tilte`, `default_description`, `default_type`, `default_unit`, `lower_range`, `upper_range`, `value`) VALUES ('pdoc_max_size', 'Patient Document Maximum Size', 'File size limit for Patient Documents to be uploaded. The maximum size (in kilobytes) that the file can be. Set to zero for no limit. Note: Most PHP installations have their own limit, as specified in the php.ini file. Usually 2 MB (or 2048 KB) by default.', 'Numeric', 'KB', '', '', '2048'); 

INSERT INTO `defaults` (`default_id`, `default_tilte`, `default_description`, `default_type`, `default_unit`, `lower_range`, `upper_range`, `value`) VALUES ('pdoc_max_width', 'Patient Document Image Maximum Width', 'Image width limit for Patient Documents to be uploaded. The minimum width (in pixels) that the image can be. Set to zero for no limit.', 'Numeric', 'Pixel', '', '', '1024');  

INSERT INTO `defaults` (`default_id`, `default_tilte`, `default_description`, `default_type`, `default_unit`, `lower_range`, `upper_range`, `value`) VALUES ('pdoc_max_height', 'Patient Document Image Maximum Height', 'Image height limit for Patient Documents to be uploaded. The maximum height (in pixels) that the image can be. Set to zero for no limit.', 'Numeric', 'Pixel', '', '', '768');

INSERT INTO `defaults` (`default_id`, `default_tilte`, `default_description`, `default_type`, `default_unit`, `lower_range`, `upper_range`, `value`) VALUES ('pdoc_allowed_types', 'Patient Document files types', 'Patient Document files types allowed for upload. The mime types corresponding to the types of files you allow to be uploaded. Usually the file extension can be used as the mime type. Can be either an array or a pipe-separated string.', 'Text', 'File Type', '', '', 'gif|jpg|png|pdf'); 

INSERT INTO `defaults` (`default_id`, `default_tilte`, `default_description`, `default_type`, `default_unit`, `lower_range`, `upper_range`, `value`) VALUES ('pdoc_remove_spaces', 'Remove spaces in Patient Document file name', 'If set to TRUE, any spaces in the file name will be converted to underscores. This is recommended.', 'Text', '', '', '', 'TRUE'); 

INSERT INTO `defaults` (`default_id`, `default_tilte`, `default_description`, `default_type`, `default_unit`, `lower_range`, `upper_range`, `value`) VALUES ('pdoc_overwrite', 'Overwrite feature for document upload', 'If set to true, if a file with the same name as the one you are uploading exists, it will be overwritten. If set to false, a number will be appended to the filename if another with the same name exists.', 'Text', '', '', '', 'TRUE'); 
INSERT INTO `user_function` (`user_function_id`, `user_function`, `user_function_display`, `description`) VALUES (NULL, 'patient_document_upload', 'Patient Document Upload', 'Patient external reports scanned and uploaded'); 
ALTER TABLE `user_function_link` ADD `remove` TINYINT(1) NOT NULL AFTER `view`;


#Table structure for table `patient_document_upload`
CREATE TABLE `patient_document_upload` (
  `id` int(11) NOT NULL,
  `patient_id` int(11) NOT NULL,
  `document_date` date NOT NULL,
  `document_type_id` int(11) NOT NULL,
  `note` text NOT NULL,
  `document_link` varchar(200) NOT NULL,
  `insert_datetime` datetime NOT NULL,
  `insert_by_staff_id` int(11) NOT NULL,
  `update_datetime` datetime NOT NULL,
  `update_by_staff_id` int(11) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COMMENT='Patient external reports scanned and uploaded';

#Indexes for table `patient_document_upload`
ALTER TABLE `patient_document_upload`
  ADD PRIMARY KEY (`id`);

# AUTO_INCREMENT for table `patient_document_upload`
ALTER TABLE `patient_document_upload`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;


#Table structure for table `patient_document_type`
CREATE TABLE `patient_document_type` (
  `document_type_id` int(11) NOT NULL,
  `document_type` varchar(50) NOT NULL,
  `note` text NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COMMENT='Type of Patient external reports scanned and uploaded';

#Dumping data for table `patient_document_type`
INSERT INTO `patient_document_type` (`document_type_id`, `document_type`, `note`) VALUES
(1, 'Consultation Summary', ''),
(2, 'Discharge Summary', ''),
(3, 'Lab Report', ''),
(4, 'CT Report', ''),
(5, 'MRI Report', ''),
(6, 'Ultrasound Report', ''),
(7, '2D Echo Report', '');

#Indexes for table `patient_document_type`
ALTER TABLE `patient_document_type`
  ADD PRIMARY KEY (`document_type_id`);

#AUTO_INCREMENT for table `patient_document_type`
ALTER TABLE `patient_document_type`
  MODIFY `document_type_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

#Table structure for table `removed_patient_document_upload`
CREATE TABLE `removed_patient_document_upload` (
  `id` int(11) NOT NULL,
  `patient_id` int(11) NOT NULL,
  `document_date` date NOT NULL,
  `document_type_id` int(11) NOT NULL,
  `note` text NOT NULL,
  `document_link` varchar(200) NOT NULL,
  `insert_datetime` datetime NOT NULL,
  `insert_by_staff_id` int(11) NOT NULL,
  `update_datetime` datetime NOT NULL,
  `update_by_staff_id` int(11) NOT NULL,
  `removed_datetime` datetime NOT NULL,
  `removed_by_staff_id` int(11) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COMMENT='Deletion history of Patient external reports scanned';

#Indexes for table `removed_patient_document_upload`
ALTER TABLE `removed_patient_document_upload`
  ADD PRIMARY KEY (`id`);

#AUTO_INCREMENT for table `removed_patient_document_upload`
ALTER TABLE `removed_patient_document_upload`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

CREATE TABLE `language` ( 
  `language_id` INT NOT NULL AUTO_INCREMENT, 
  `language` VARCHAR(50) NOT NULL ,  
  PRIMARY KEY (`language_id`)
);
INSERT INTO `language` (`language_id`, `language`) VALUES (1, 'Telugu'); 
INSERT INTO `language` (`language_id`, `language`) VALUES (2, 'English'); 
INSERT INTO `language` (`language_id`, `language`) VALUES (3, 'Hindi'); 
INSERT INTO `language` (`language_id`, `language`) VALUES (4, 'Bengali'); 
INSERT INTO `language` (`language_id`, `language`) VALUES (5, 'Odiya'); 
INSERT INTO `language` (`language_id`, `language`) VALUES (6, 'Kannada'); 
INSERT INTO `language` (`language_id`, `language`) VALUES (7, 'Tamil'); 
INSERT INTO `language` (`language_id`, `language`) VALUES (8, 'Malayalam'); 

ALTER TABLE `helpline_call`
 ADD COLUMN `language_id` INT;


INSERT INTO `defaults` (`default_id`, `default_tilte`, `default_description`, `default_type`, `default_unit`, `lower_range`, `upper_range`, `value`) VALUES ('pagination', 'Pagination', 'Default number of rows to be loaded for reports', 'Numeric', NULL, '50', '200', '50');
