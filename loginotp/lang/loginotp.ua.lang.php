<?php
/**
 * Login OTP (2FA) plugin for CMF Cotonti Siena v.0.9.26, PHP v.8.4+, MySQL v.8.0
 * Filename: loginotp.uk.lang.php
 * Purpose: Повна локалізація (українська)
 * Date=2025-10-26
 * @package loginotp
 * @version 1.1.3
 * @author webitproff
 * @copyright Copyright (c) webitproff 2025
 * @license BSD
 */

defined('COT_CODE') or die('Wrong URL');

$L['loginotp_title']           = 'Двофакторна аутентифікація';
$L['loginotp_enter_code']      = 'Введіть код, надісланий на вашу пошту';
$L['loginotp_code_label']      = 'Код підтвердження';
$L['loginotp_submit']          = 'Підтвердити';
$L['loginotp_wrong_code']      = 'Невірний або прострочений код';
$L['loginotp_expired_code']    = 'Код прострочений або не знайдений';
$L['loginotp_email_subject']   = 'Ваш код підтвердження';
$L['loginotp_email_body']      = "Ваш код для входу: %s\n\nКод дійсний %d хвилин.";
$L['loginotp_hint']            = 'Введіть 5-значний код з листа';
$L['loginotp_invalid_code']    = 'Введіть коректний код (5 цифр)';
$L['loginotp_lifetime']        = 'Код дійсний <strong>5 хвилин</strong>';