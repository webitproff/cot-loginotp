<?php
/**
 * Login OTP (2FA) plugin for CMF Cotonti Siena v.0.9.26, PHP v.8.4+, MySQL v.8.0
 * Filename: loginotp.en.lang.php
 * Purpose: Full localization (English)
 * Date=2025-10-26
 * @package loginotp
 * @version 1.1.3
 * @author webitproff
 * @copyright Copyright (c) webitproff 2025
 * @license BSD
 */

defined('COT_CODE') or die('Wrong URL');

$L['loginotp_title']           = 'Two-Factor Authentication';
$L['loginotp_enter_code']      = 'Enter the code sent to your email';
$L['loginotp_code_label']      = 'Verification Code';
$L['loginotp_submit']          = 'Confirm';
$L['loginotp_wrong_code']      = 'Invalid or expired code';
$L['loginotp_expired_code']    = 'Code has expired or not found';
$L['loginotp_email_subject']   = 'Your verification code';
$L['loginotp_email_body']      = "Your login code: %s\n\nThe code is valid for %d minutes.";
$L['loginotp_hint']            = 'Enter the 5-digit code from the email';
$L['loginotp_invalid_code']    = 'Enter a valid 5-digit code';
$L['loginotp_lifetime']        = 'Code is valid for <strong>5 minutes</strong>';