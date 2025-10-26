<?php
/* ====================
[BEGIN_COT_EXT]
Hooks=standalone
[END_COT_EXT]
==================== */

/**
 * Login OTP (2FA) plugin for CMF Cotonti Siena v.0.9.26, PHP v.8.4+, MySQL v.8.0
 * Filename: loginotp.php
 * Purpose: Handles the OTP (one-time password) input page. 
 *          Validates the code entered by the user, logs them in on success, 
 *          shows an error and redirects back on failure. Fully standalone.
 * Date=2025-10-26
 * @package loginotp
 * @version 1.1.3
 * @author webitproff
 * @copyright Copyright (c) webitproff 2025
 * @license BSD
 */

defined('COT_CODE') or die('Wrong URL');  
// — Защита от прямого запуска файла. Если не через ядро — пиздец, умираем.

require_once cot_incfile('loginotp', 'plug');  
// — Подключаем функции плагина: loginotp_is_enabled(), loginotp_generate_code() и т.д.

Cot::$db->registerTable('loginotp');  
// — Регистрируем таблицу cot_loginotp, чтобы Cotonti знал её префикс и не ебал мозги.

cot_langfile('loginotp', 'plug');  
// — Загружаем языковые переменные из loginotp.ru.lang.php — без этого $L пустой, и всё на английском.

list(Cot::$usr['auth'], Cot::$usr['grp']) = cot_auth('users', true);  
// — Проверяем права доступа к модулю users. true = полный доступ. Заполняем $usr['auth'] и $usr['grp'].

$t = new XTemplate(cot_tplfile('loginotp', 'plug'));  
// — Создаём объект шаблона. Ищем loginotp.tpl в папке плагина. Будем в него пихать переменные.

if (Cot::$usr['id'] > 0) {  
// — Если юзер уже залогинен (по кукам или сессии) — нахуй его отсюда.
    Cot::$db->delete(Cot::$db->loginotp, 'otp_user_id = ?', [Cot::$usr['id']]);  
    // — Удаляем его старый OTP, если был — нечего мусорить.
    cot_redirect(cot_url('index'));  
    // — Кидаем на главную. Нечего тут делать.
}

$otp_user_id = cot_import('user', 'G', 'INT');  
// — Берём ID пользователя из GET (пришёл с редиректа после логина). Чистим как INT.

$otp_code    = cot_import('code', 'P', 'TXT', 5);  
// — Берём введённый OTP из POST. Ограничиваем до 5 символов.

$redirect    = cot_import('redirect', 'G', 'TXT');  
// — Берём параметр redirect из GET (куда юзер хотел попасть после входа).

$error       = '';  
// — Переменная для ошибки. По умолчанию пустая — всё заебись.

if (isset($_SESSION['loginotp_error'])) {  
// — Проверяем, есть ли ошибка в сессии (мы её туда пихали при неверном коде).
    $error = $_SESSION['loginotp_error'];  
    // — Перекладываем в локальную переменную.
    unset($_SESSION['loginotp_error']);  
    // — Удаляем из сессии — чтобы не показывалась вечно.
}

$redirect_url = cot_url('index');  
// — По умолчанию редиректим на главную после успешного входа.
if (!empty($redirect)) {  
    // — Если передан redirect — пытаемся его расшифровать.
    $decoded = base64_decode($redirect, true);  
    // — Декодируем из base64.
    if ($decoded !== false && filter_var($decoded, FILTER_VALIDATE_URL)) {  
        // — Проверяем, что это валидный URL и не хуйня какая-то.
        $redirect_url = $decoded;  
        // — Если всё ок — используем его.
    }
}

if ($otp_user_id > 0 && !empty($otp_code)) {  
    // — Если юзер ввёл код и ID валидный — проверяем его в базе.
    $sql = Cot::$db->query(
        "SELECT u.*, o.otp_code, o.otp_expires, o.otp_remember 
         FROM " . Cot::$db->users . " u 
         LEFT JOIN " . Cot::$db->loginotp . " o ON o.otp_user_id = u.user_id 
         WHERE u.user_id = ? AND o.otp_code = ? AND o.otp_expires > ?", 
        [$otp_user_id, $otp_code, Cot::$sys['now']]
    );  
    // — Ищем совпадение: ID + код + код не просрочен.

    if ($sql->rowCount() === 1) {  
        // — НАШЛИ! Код верный.
        $user = $sql->fetch();  
        // — Получаем все данные юзера + otp_remember.

        Cot::$db->delete(Cot::$db->loginotp, 'otp_user_id = ?', [$otp_user_id]);  
        // — Удаляем использованный OTP — одноразовый, сука.

        $remember = !empty($user['otp_remember']);  
        // — Запомнить ли сессию? Берем из базы (поставили при генерации OTP).

        cot_user_authorize($user, $remember);  
        // — АВТОРИЗУЕМ юзера! Устанавливаем куки, сессию, $usr и т.д.

        cot_log("OTP SUCCESS: user_id={$user['user_id']}", 'users', 'otp', 'success');  
        // — Пишем в лог: всё заебись, вход успешен.

        cot_uriredir_apply(Cot::$cfg['redirbkonlogin']);  
        // — Применяем глобальный редирект после логина (если включён в настройках).

        cot_redirect($redirect_url);  
        // — Кидаем юзера туда, куда он хотел (или на главную).
    } else {  
        // — НЕВЕРНЫЙ ИЛИ ПРОСРОЧЕННЫЙ КОД.
        $_SESSION['loginotp_error'] = $L['loginotp_wrong_code'];  
        // — Запихиваем ошибку в сессию — покажем после редиректа.

        cot_log("OTP FAIL: user_id=$otp_user_id, code=$otp_code", 'users', 'otp', 'error');  
        // — Пишем в лог: кто-то обосрался.

        cot_redirect(cot_url('plug', "e=loginotp&user=$otp_user_id" . ($redirect ? "&redirect=$redirect" : ''), '', true));  
        // — Редиректим на эту же страницу, сохраняя user и redirect. Ошибка покажется.
    }
}

$t->assign([  
    // — Пихаем переменные в шаблон. Всё через $L — локализация.
    'LOGINOTP_TITLE'        => $L['loginotp_title'],         // Заголовок формы.
    'LOGINOTP_ENTER_CODE'   => $L['loginotp_enter_code'],    // Подсказка "введите код".
    'LOGINOTP_CODE_LABEL'   => $L['loginotp_code_label'],    // Лейбл поля.
    'LOGINOTP_SUBMIT'       => $L['loginotp_submit'],        // Текст кнопки.
    'LOGINOTP_ERROR'        => $error,                       // Ошибка (из сессии или пустая).
    'LOGINOTP_FORM_ACTION'  => cot_url('plug', "e=loginotp&user=$otp_user_id" . ($redirect ? "&redirect=$redirect" : ''), '', true),  
    // — URL формы — на эту же страницу, с параметрами.
    'LOGINOTP_USER_ID'      => $otp_user_id,                 // ID юзера (в hidden поле).
    'LOGINOTP_REDIRECT'     => $redirect,                    // redirect (если был).
    'LOGINOTP_HINT'         => $L['loginotp_hint'],          // Подсказка под полем.
    'LOGINOTP_INVALID_CODE' => $L['loginotp_invalid_code'],  // Текст валидации.
    'LOGINOTP_LIFETIME'     => $L['loginotp_lifetime']       // "Код действителен 5 минут".
]);

