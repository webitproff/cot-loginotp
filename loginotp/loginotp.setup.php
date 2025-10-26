<?php
/* ====================
[BEGIN_COT_EXT]
Code=loginotp
Name=Login OTP (2FA)
Category=auth-security
Description=Two-factor authentication via one-time 5-digit code sent by email
Version=1.1.3
Date=2025-10-26
Author=webitproff
Copyright=Copyright (c) webitproff 2025 | https://github.com/webitproff
Notes=BSD License
SQL=loginotp.install.sql
UninstallSQL=loginotp.uninstall.sql
Auth_guests=R
Lock_guests=W12345A
Auth_members=RW
Lock_members=12345
Hooks=users.login.check,standalone
[END_COT_EXT]

[BEGIN_COT_EXT_CONFIG]
otp_enabled=01:radio:0:1:Enable 2FA
otp_lifetime=02:select:300,600,900:600:OTP code lifetime (seconds)
[END_COT_EXT_CONFIG]
==================== */

defined('COT_CODE') or die('Wrong URL');

/**
 * Login OTP (2FA) plugin for CMF Cotonti Siena v.0.9.26, PHP v.8.4+, MySQL v.8.0
 * Filename: loginotp.setup.php
 * Purpose: Registers metadata of the Login OTP (2FA) plugin in the Cotonti admin panel.
 * Date=2025-10-26
 * @package loginotp
 * @version 1.1.3
 * @author webitproff
 * @copyright Copyright (c) webitproff 2025 | https://github.com/webitproff
 * @license BSD
 */
