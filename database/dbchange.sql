ALTER TABLE `contact_us` CHANGE `is_delete` `is_delete` CHAR(2) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL DEFAULT 'N';
ALTER TABLE `contact_us` ADD INDEX(`is_delete`);
ALTER TABLE `contact_us` ADD INDEX(`is_status`);
ALTER TABLE `sai_download_setup` ADD `read_status` CHAR(2) NOT NULL DEFAULT 'U' COMMENT 'U - Unread, R - Read';
ALTER TABLE `si_gst_inquiry` ADD `read_status` CHAR(2) NOT NULL DEFAULT 'U' COMMENT 'U - Unread, R -Read';