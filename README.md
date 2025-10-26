# Login OTP (2FA) — Email-Based Two-Factor Authentication


[![License](https://img.shields.io/badge/license-BSD-blue.svg)](https://github.com/webitproff/loginotp/blob/main/LICENSE)
[![Version](https://img.shields.io/badge/version-1.1.3-green.svg)](https://github.com/webitproff/loginotp/releases)
[![Cotonti Compatibility](https://img.shields.io/badge/Cotonti_Siena-0.9.26-orange.svg)](https://www.cotonti.com/)
[![PHP](https://img.shields.io/badge/PHP-8.4-blueviolet.svg)](https://www.php.net/releases/8_4_0.php)
[![MySQL](https://img.shields.io/badge/MySQL-8.0-blue.svg)](https://www.mysql.com/)

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

# Плагин Login OTP (2FA) для Cotonti Siena

[![License](https://img.shields.io/badge/license-BSD-blue.svg)](https://github.com/webitproff/loginotp/blob/main/LICENSE)
[![Version](https://img.shields.io/badge/version-1.1.3-green.svg)](https://github.com/webitproff/loginotp/releases)
[![Cotonti Compatibility](https://img.shields.io/badge/Cotonti_Siena-0.9.26-orange.svg)](https://www.cotonti.com/)
[![PHP](https://img.shields.io/badge/PHP-8.4-blueviolet.svg)](https://www.php.net/releases/8_4_0.php)
[![MySQL](https://img.shields.io/badge/MySQL-8.0-blue.svg)](https://www.mysql.com/)




## Описание

Плагин **Login OTP (2FA)** добавляет двухфакторную аутентификацию (2FA) для системы управления контентом **Cotonti Siena v.0.9.26**. После ввода логина и пароля пользователю отправляется одноразовый 5-значный код (OTP) на электронную почту. Код необходимо ввести на специальной странице для завершения авторизации. Это повышает безопасность входа, защищая от несанкционированного доступа, даже если пароль пользователя был скомпрометирован.

Плагин полностью интегрируется с ядром Cotonti, поддерживает локализацию (английский, русский, украинский) и имеет адаптивный интерфейс на основе Bootstrap 5 и Bootstrap Icons.

## Основные возможности

- Генерация одноразового 5-значного кода (OTP) для входа.
- Отправка кода на email пользователя.
- Настраиваемый срок действия кода (по умолчанию 5 минут).
- Поддержка опции «Запомнить меня» для сохранения сессии.
- Адаптивный интерфейс страницы ввода кода с валидацией.
- Логирование успешных и неуспешных попыток ввода OTP.
- Многоязычная поддержка: английский, русский, украинский.
- Интеграция с настройками Cotonti (включение/выключение 2FA, настройка времени жизни кода).

## Требования

- **CMF Cotonti Siena:** v.0.9.26
- **PHP:** 8.4 или выше
- **MySQL:** 8.0 или выше
- Настроенный почтовый сервер для отправки email (через функцию `cot_mail()`).

## Структура плагина

Плагин имеет следующую структуру файлов:
```
plugins/
└── loginotp/
├── loginotp.setup.php
├── loginotp.install.sql
├── loginotp.uninstall.sql
├── loginotp.users.login.check.php
├── loginotp.php
├── inc/
│   ├── loginotp.functions.php
├── lang/
│   ├── loginotp.en.lang.php
│   ├── loginotp.ru.lang.php
│   ├── loginotp.ua.lang.php
├── tpl/
│   ├── loginotp.tpl

```


### Описание файлов

| Файл                              | Описание                                                                 |
|-----------------------------------|--------------------------------------------------------------------------|
| `loginotp.setup.php`             | Регистрирует метаданные плагина в админ-панели Cotonti. Содержит конфигурацию плагина (включение 2FA, время жизни кода). |
| `loginotp.install.sql`           | SQL-скрипт для создания таблицы `cot_loginotp`, в которой хранятся OTP-коды, их срок действия и пользовательские данные. |
| `loginotp.uninstall.sql`         | SQL-скрипт для удаления таблицы `cot_loginotp` при деинсталляции плагина. |
| `loginotp.users.login.check.php` | Перехватывает процесс авторизации (хуки `users.auth.check`). Проверяет логин/пароль, генерирует OTP, сохраняет его в базе и отправляет на email. Редиректирует на страницу ввода кода. |
| `loginotp.php`                   | Обрабатывает страницу ввода OTP (хуки `standalone`). Проверяет введённый код, авторизует пользователя при успехе или показывает ошибку при неудаче. |
| `inc/loginotp.functions.php`     | Содержит основные функции плагина: инициализация, проверка активности 2FA, генерация OTP-кода. |
| `lang/loginotp.en.lang.php`      | Локализация на английском языке.                                          |
| `lang/loginotp.ru.lang.php`      | Локализация на русском языке.                                            |
| `lang/loginotp.ua.lang.php`      | Локализация на украинском языке.                                         |
| `tpl/loginotp.tpl`               | Шаблон страницы ввода OTP. Содержит HTML-форму с Bootstrap-стилями, валидацией и иконками. |

## Установка

1. Скачайте плагин из [репозитория](https://github.com/webitproff/cot-loginotp).
2. Распакуйте архив и скопируйте папку `loginotp` в директорию `plugins/` вашего сайта на Cotonti.
3. Перейдите в админ-панель Cotonti: **Администрирование → Расширения → Установить новые**.
4. Найдите плагин **Login OTP (2FA)** и нажмите **Установить**. Скрипт `loginotp.install.sql` автоматически создаст таблицу `cot_loginotp`.
5. Настройте плагин в разделе **Администрирование → Расширения → Login OTP → Конфигурация**:
   - **otp_enabled**: Включить/выключить 2FA (1 = включено, 0 = выключено).
   - **otp_lifetime**: Время жизни OTP-кода в секундах (300, 600, 900 секунд).
6. Отправка email функция `cot_mail()`.

## Использование

1. Пользователь вводит логин (или email, если разрешено) и пароль на стандартной странице входа Cotonti.
2. Если логин и пароль верны, плагин генерирует 5-значный OTP-код, сохраняет его в базе и отправляет на email пользователя.
3. Пользователь перенаправляется на страницу ввода кода (`plug.php?e=loginotp`).
4. На странице ввода кода пользователь вводит полученный OTP. Форма проверяет:
   - Код должен быть 5-значным числом.
   - Код не должен быть просрочен (срок действия указан в настройках).
5. При правильном коде пользователь авторизуется и перенаправляется на целевую страницу (или главную). При неверном коде показывается ошибка, и пользователь может попробовать снова.

## Логирование

Плагин записывает в лог Cotonti (**Администрирование → Логи**) следующие события:
- **Успешная авторизация:** `OTP SUCCESS: user_id=X`
- **Неуспешная попытка:** `OTP FAIL: user_id=X, code=Y`

## Локализация

Плагин поддерживает три языка:
- **Английский** (`loginotp.en.lang.php`)
- **Русский** (`loginotp.ru.lang.php`)
- **Украинский** (`loginotp.ua.lang.php`)

Языковые файлы содержат все сообщения, отображаемые пользователю: заголовки, подсказки, ошибки и текст email. Язык определяется настройками Cotonti.

## Шаблон (loginotp.tpl)

Шаблон `loginotp.tpl` использует Bootstrap 5 для стилизации и включает:
- Адаптивную форму ввода кода с автоматической фокусировкой на поле.
- Валидацию на стороне клиента (JavaScript): проверка на 5-значное число.
- Иконки Bootstrap Icons для уведомлений (информация/ошибка).
- Стилизованную кнопку отправки с эффектом ховера.
- Подсказку о сроке действия кода (5 минут) (от фонаря пока, нужно заводить из `$valSome = (int) Cot::$cfg['plugin']['loginotp']['otp_lifetime'];`).

## Конфигурация

Настройки плагина доступны в админ-панели:
- **otp_enabled**: Радиокнопка для включения/выключения 2FA (по умолчанию выключено).
- **otp_lifetime**: Выпадающий список для выбора времени жизни кода (300, 600, 900 секунд; по умолчанию 600 секунд).

## Деинсталляция

1. Перейдите в **Администрирование → Расширения → Login OTP → Удалить**.
2. Скрипт `loginotp.uninstall.sql` автоматически удалит таблицу `cot_loginotp`.
3. Удалите папку `plugins/loginotp` с сервера.

## Лицензия

Плагин распространяется под лицензией **BSD**. Подробности в файле `loginotp.setup.php`.  
Copyright © 2025 webitproff. Все права защищены.

## Контакты и поддержка

**Автор:** webitproff  
**GitHub:** [github.com/webitproff](https://github.com/webitproff)  
Для вопросов, предложений или сообщений об ошибках создавайте issue в [репозитории](https://github.com/webitproff/cot-loginotp/issues).

**Версия:** 1.1.3 | **Дата:** 2025-10-26 | **Лицензия:** BSD  
[Репозиторий на GitHub](https://github.com/webitproff/cot-loginotp)


Лицензия
BSD License
Copyright (c) webitproff 2025
