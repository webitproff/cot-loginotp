# Login OTP (2FA) — Email-Based Two-Factor Authentication

**Plugin for CMF Cotonti Siena**  
**Version:** `1.1.3`  
**Date:** `2025-10-26`  
**Author:** `webitproff`  
**License:** `BSD`

---

## Description

**Login OTP** is a **reliable and simple 2FA plugin** that adds a **second login step** using a **one-time password (OTP)** sent to the **user's email**.

> **No Google Authenticator, no SMS, no extra dependencies.**  
> Only **email + 5-digit code**.

---

## Features

| Feature | Status |
|--------|--------|
| Two-factor authentication | Done |
| OTP via email | Done |
| Configurable OTP lifetime | Done |
| Remember device (remember me) | Done |
| Full localization (ru, en, uk) | Done |
| Bootstrap 5.3 — stylish form | Done |
| Secure redirect (base64 + URL validation) | Done |
| Logging of logins/errors | Done |
| Cleanup table after use | Done |

---

## Installation

1. Unpack the archive into the folder:  
   `plugins/loginotp/`
2. Go to **Admin → Plugins → Login OTP → Install**
3. Enable the plugin: **Enabled**
4. Configure options (optional):  
   **Admin → Plugins → Login OTP → Settings**

---

## Default Settings

| Parameter | Value |
|---------|--------|
| `otp_lifetime` | `300` (5 minutes) |
| `otp_length` | `5` digits |
| `enabled` | `1` (enabled) |

---

## How it Works

1. User enters **username + password**  
2. If the password is correct → **OTP is generated**  
3. The code is **sent via email**  
4. User is redirected to `plug?e=loginotp`  
5. User enters the **5-digit code**  
6. If the code is correct → **login successful**  
7. If the code is incorrect → **error + retry**

> **Table `cot_loginotp` is temporary.**  
> Entry lives **5 minutes** and **is deleted upon login**.

---

## File Structure

```
plugins/loginotp/
├── loginotp.php                     ← Main standalone hooks
├── loginotp.users.auth.check.php    ← Login interception
├── loginotp.functions.php           ← OTP generation
├── lang/
│   ├── loginotp.ru.lang.php         ← Russian
│   ├── loginotp.en.lang.php         ← English
│   └── loginotp.uk.lang.php         ← Ukrainian
└── tpl/
    └── loginotp.tpl                 ← Template (Bootstrap 5.3)
```

---

## Security

- **base64 + filter_var** — protects redirect URLs from tampering  
- **cot_import()** — validates all input data  
- **Parameterized SQL queries** — protects from injection  
- **OTP deleted after use**  
- **Login attempts logged**

---

## Localization

Supports **3 languages**:

- **Russian** — `loginotp.ru.lang.php`  
- **English** — `loginotp.en.lang.php`  
- **Ukrainian** — `loginotp.uk.lang.php`

> Cotonti automatically selects language based on `$usr['lang']`

---

## Support

- Cotonti Siena v.0.9.26+  
- PHP 8.4+  
- MySQL 8.0+  

---

## License

BSD License  
Copyright (c) webitproff 2025


___

# Login OTP (2FA) — Двухфакторная аутентификация по email

**Плагин для CMF Cotonti Siena**  
**Версия:** `1.1.3`  
**Дата:** `2025-10-26`  
**Автор:** `webitproff`  
**Лицензия:** `BSD`  

---

## Описание

**Login OTP** — это **надёжный и простой 2FA-плагин**, который добавляет **второй этап входа** через **одноразовый код (OTP)**, отправляемый на **email пользователя**.

> **Без Google Authenticator, без SMS, без лишних зависимостей.**  
> Только **email + 5-значный код**.

---

## Возможности

| Функция | Статус |
|--------|--------|
| Двухфакторная аутентификация | Done |
| Код по email | Done |
| Время жизни OTP — настраиваемое | Done |
| Запомнить устройство (remember me) | Done |
| Полная локализация (ru, en, uk) | Done |
| Bootstrap 5.3 — красивая форма | Done |
| Безопасный редирект (base64 + валидация URL) | Done |
| Логирование входов/ошибок | Done |
| Очистка таблицы после использования | Done |

---

## Установка

1. Распакуй архив в папку:
plugins/loginotp/
text2. Зайди в **Админку → Плагины → Login OTP → Установить**

3. Включи плагин: **Включён**

4. Настрой параметры (по желанию):  
**Админка → Плагины → Login OTP → Настройки**

---

## Настройки (по умолчанию)

| Параметр | Значение |
|---------|--------|
| `otp_lifetime` | `300` (5 минут) |
| `otp_length` | `5` цифр |
| `enabled` | `1` (включён) |

---

## Как работает

1. Пользователь вводит **логин + пароль**
2. Если пароль верный → **генерируется OTP**
3. Код **отправляется на email**
4. Пользователь переходит на `plug?e=loginotp`
5. Вводит **5-значный код**
6. Код верный → **вход**
7. Код неверный → **ошибка + повтор**

> **Таблица `cot_loginotp` — временная.**  
> Запись живёт **5 минут** и **удаляется при входе**.

---

## Структура файлов
```
plugins/loginotp/
├── loginotp.php                     ← Основной standalone-хуки
├── loginotp.users.auth.check.php    ← Перехват логина
├── loginotp.functions.php           ← Генерация кода
├── lang/
│   ├── loginotp.ru.lang.php         ← Русский
│   ├── loginotp.en.lang.php         ← English
│   └── loginotp.uk.lang.php         ← Українська
└── tpl/
└── loginotp.tpl                 ← Шаблон (Bootstrap 5.3)
```
---

## Безопасность

- **base64 + filter_var** — защита от подмены редиректа
- **cot_import()** — валидация всех входных данных
- **SQL-запросы с параметрами** — защита от инъекций
- **Код удаляется после использования**
- **Логирование попыток**

---

## Локализация

Поддерживаются **3 языка**:

- **Русский** — `loginotp.ru.lang.php`
- **English** — `loginotp.en.lang.php`
- **Українська** — `loginotp.uk.lang.php`

> Cotonti автоматически выбирает язык по `$usr['lang']`

---



Поддержка

Cotonti Siena v.0.9.26+
PHP 8.4+
MySQL 8.0+


Лицензия
BSD License
Copyright (c) webitproff 2025
