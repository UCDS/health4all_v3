#Defaults settings for user documents file uploads
ALTER TABLE `defaults` CHANGE `value` `value` VARCHAR(50) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT NULL;

INSERT INTO `defaults` VALUES ('udoc_max_size', 'User Document Maximum Size', 'File size limit for User Documents to be uploaded. The maximum size (in kilobytes) that the file can be. Set to zero for no limit. Note: Most PHP installations have their own limit, as specified in the php.ini file. Usually 2 MB (or 2048 KB) by default.', 'Numeric', 'KB', '', '', '2048');

INSERT INTO `defaults` VALUES ('udoc_max_width', 'User Document Image Maximum Width', 'Image width limit for User Documents to be uploaded. The minimum width (in pixels) that the image can be. Set to zero for no limit.', 'Numeric', '', '', '', '1024');

INSERT INTO `defaults` VALUES ('udoc_max_height', 'User Document Image Maximum Height', 'Image height limit for User Documents to be uploaded. The maximum height (in pixels) that the image can be. Set to zero for no limit.', 'Numeric', '', '', '', '768');

INSERT INTO `defaults` VALUES ('udoc_allowed_types', 'User Document files types', 'User Document files types allowed for upload. The mime types corresponding to the types of files you allow to be uploaded. Usually the file extension can be used as the mime type. Can be either an array or a pipe-separated string.', 'Text', '', '', '', 'gif|jpg|png|pdf');

INSERT INTO `defaults` VALUES ('udoc_remove_spaces', 'Remove spaces in User Document file name', 'If set to TRUE, any spaces in the file name will be converted to underscores. This is recommended.', 'Text', '', '', '', 'TRUE');

INSERT INTO `defaults` VALUES ('udoc_overwrite', 'Overwrite feature for document upload', 'If set to true, if a file with the same name as the one you are uploading exists, it will be overwritten. If set to false, a number will be appended to the filename if another with the same name exists.', 'Text', '', '', '', 'TRUE');

UPDATE `defaults` SET `default_unit` = 'Pixel' WHERE `defaults`.`default_id` = 'ucdoc_max_width';

UPDATE `defaults` SET `default_unit` = 'Pixel' WHERE `defaults`.`default_id` = 'udoc_max_height';

UPDATE `defaults` SET `default_unit` = 'File Type' WHERE `defaults`.`default_id` = 'ucdoc_allowed_types';