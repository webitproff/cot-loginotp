<?php
/**
 * Login OTP (2FA) plugin for CMF Cotonti Siena v.0.9.26, PHP v.8.4+, MySQL v.8.0
 * Filename: loginotp.ru.lang.php
 * Purpose: Полная локализация
 * Date=2025-10-26
 * @package loginotp
 * @version 1.1.3
 * @author webitproff
 * @copyright Copyright (c) webitproff 2025
 * @license BSD
 */

defined('COT_CODE') or die('Wrong URL');

$L['loginotp_title']           = 'Двухэтапная аутентификация';
$L['loginotp_enter_code']      = 'Введите код, отправленный на вашу почту';
$L['loginotp_code_label']      = 'Код подтверждения';
$L['loginotp_submit']          = 'Подтвердить';
$L['loginotp_wrong_code']      = 'Неверный или просроченный код';
$L['loginotp_expired_code']    = 'Код просрочен или не найден';
$L['loginotp_email_subject']   = 'Ваш код подтверждения';
$L['loginotp_email_body']      = "Ваш код для входа: %s\n\nКод действителен %d минут.";
$L['loginotp_hint']            = 'Введите 5-значный код из письма';
$L['loginotp_invalid_code']    = 'Введите корректный код (5 цифр)';
$L['loginotp_lifetime']        = 'Код действителен <strong>5 минут</strong>';