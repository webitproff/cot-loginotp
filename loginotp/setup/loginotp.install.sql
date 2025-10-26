-- loginotp.install.sql

CREATE TABLE IF NOT EXISTS `cot_loginotp` (
    `otp_id` INT(11) NOT NULL AUTO_INCREMENT,
    `otp_user_id` INT(11) NOT NULL,
    `otp_code` VARCHAR(5) NOT NULL DEFAULT '',
    `otp_expires` INT(11) NOT NULL DEFAULT 0,
    `otp_remember` TINYINT(1) NOT NULL DEFAULT 0,
    PRIMARY KEY (`otp_id`),
    KEY `otp_user_id` (`otp_user_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
