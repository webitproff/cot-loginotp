<?php
/* ====================
[BEGIN_COT_EXT]
Hooks=users.auth.check
[END_COT_EXT]
==================== */

/**
 * Login OTP (2FA) plugin for CMF Cotonti Siena v.0.9.26, PHP v.8.4+, MySQL v.8.0
 * Filename: loginotp.users.auth.check.php
 * Purpose: Intercepts the standard login process, checks credentials, 
 *          generates a one-time password (OTP), stores it in the DB, 
 *          sends it by e-mail and redirects the user to the OTP entry page.
 * Date=2025-10-26
 * @package loginotp
 * @version 1.1.3
 * @author webitproff
 * @copyright Copyright (c) webitproff 2025
 * @license BSD
 */

defined('COT_CODE') or die('Wrong URL');                     // Защита от прямого доступа — если файл вызван не через ядро, умрём.

require_once cot_incfile('loginotp', 'plug');                // Подключаем функции плагина (loginotp_is_enabled(), loginotp_generate_code() и т.д.).
Cot::$db->registerTable('loginotp');                         // Регистрируем таблицу cot_loginotp, чтобы Cotonti знал её префикс.

// Если 2FA отключена в настройках — пропускаем всё, пусть ядро логинит как обычно.
if (!loginotp_is_enabled()) return;

// Если в POST нет логина или пароля — ничего не делаем, ядро само покажет ошибку.
if (empty($_POST['rusername']) || empty($_POST['rpassword'])) return;

// Импортируем данные из формы, чистим их и ограничиваем длину.
$rusername = cot_import('rusername', 'P', 'TXT', 100);        // Логин/почта пользователя.
$rpassword = cot_import('rpassword', 'P', 'TXT', 32);        // Пароль (введённый пользователем).
$rremember = cot_import('rremember', 'P', 'BOL');            // Флажок «Запомнить меня».

// Определяем, по какому полю искать: по email (если разрешено) или по имени.
$loginParam = !Cot::$cfg['useremailduplicate'] && cot_check_email($rusername) ? 'user_email' : 'user_name';

// Ищем пользователя в таблице cot_users.
$sql = Cot::$db->query(
    "SELECT user_id, user_passsalt, user_passfunc, user_password, user_email 
     FROM " . Cot::$db->users . " 
     WHERE $loginParam=?", 
    $rusername
);

// Если по email не нашли, а в настройках разрешено — пробуем как имя.
if ($sql->rowCount() == 0 && $loginParam === 'user_email') {
    $sql = Cot::$db->query(
        "SELECT user_id, user_passsalt, user_passfunc, user_password, user_email 
         FROM " . Cot::$db->users . " 
         WHERE user_name=?", 
        $rusername
    );
}

// Если пользователь не найден — выходим, ядро само покажет ошибку «неверный логин».
if ($sql->rowCount() !== 1) return;

// Получаем данные пользователя.
$user = $sql->fetch();

// Проверяем пароль: хэшируем введённый с солью и функцией, сравниваем с хранимым.
$mdpass = cot_hash($rpassword, $user['user_passsalt'], $user['user_passfunc']);
if ($mdpass !== $user['user_password']) return;               // Неверный пароль — выходим, ядро покажет ошибку.

// Генерируем случайный 5-значный OTP.
$otp = loginotp_generate_code();

// Берём время жизни OTP из настроек плагина (в секундах).
$ttl = (int) Cot::$cfg['plugin']['loginotp']['otp_lifetime'];

// Вычисляем время истечения.
$expires = Cot::$sys['now'] + $ttl;

// Удаляем старый OTP для этого пользователя (если был).
Cot::$db->delete(Cot::$db->loginotp, 'otp_user_id = ?', [$user['user_id']]);

// Сохраняем новый OTP в базе.
Cot::$db->insert(Cot::$db->loginotp, [
    'otp_user_id' => $user['user_id'],      // ID пользователя.
    'otp_code'    => $otp,                  // Сам код.
    'otp_expires' => $expires,              // Время, когда код умрёт.
    'otp_remember'=> $rremember ? 1 : 0     // Запомнить ли сессию после успешного OTP.
]);

// Отправляем OTP на e-mail пользователя.
cot_mail(
    $user['user_email'],                                 // Кому.
    Cot::$L['loginotp_email_subject'],                   // Тема письма.
    sprintf(Cot::$L['loginotp_email_body'], $otp, (int)($ttl/60)) // Тело: код + сколько минут действует.
);

// Получаем параметр redirect из формы (куда пользователь хотел попасть после логина).
$redirect = cot_import('redirect', 'P', 'TXT');

// Формируем параметр для URL: если redirect есть — кодируем в base64 и добавляем.
$redirect_param = $redirect ? '&redirect=' . base64_encode($redirect) : '';

// Делаем редирект на страницу ввода OTP, передаём ID пользователя и (опционально) redirect.
cot_redirect(cot_url('plug', "e=loginotp&user={$user['user_id']}$redirect_param", '', true));