<?php
/**
 * Login OTP (2FA) plugin for CMF Cotonti Siena v.0.9.26, PHP v.8.4+, MySQL v.8.0
 * Filename: loginotp.functions.php
 * Purpose: 
 * Date=2025-10-26
 * @package loginotp
 * @version 1.1.3
 * @author webitproff
 * @copyright Copyright (c) webitproff 2025
 * @license BSD
 */ 

defined('COT_CODE') or die("Wrong URL.");

require_once cot_langfile('loginotp', 'plug');

/**
 * Инициализация плагина
 */
function loginotp_init() {
    Cot::$db->registerTable('loginotp');
}

/**
 * Проверка активности 2FA
 */
function loginotp_is_enabled() {
    return !empty(Cot::$cfg['plugin']['loginotp']['otp_enabled']);
}

/**
 * Генерация одноразового кода
 */
function loginotp_generate_code() {
    return sprintf("%05d", mt_rand(10000, 99999));
}
