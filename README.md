## Yii geo track

Демо проект на Yii2 реализующий frontend и backend API.
Реализация задания описанного в документе `Тестовое задание PHP.pdf`

### Установка и запуск

Подготовлена кофигурация docker-compose. Для запуска приложения - в корневом каталоге проекта выполните:
```
docker-compose up
```
При удачном запуске web-итерфейс будет доступен локально на порту 80, а API доступно по адресам `localhost/front` и `localhost/back`.

### Тестирование

Для запуска автоматических тестов запустите контейнер и выполните комманду:
```
docker exec -it geo-track_web_1 vendor/bin/codecept run
```
***Примечание:***
Тесты используют "продакшн" БД и ожидают в ней определённые данные, которые заносятся миграциями. Еспи тесты не проходятся попробуйте сбросить БД и накатить миграции заново командой:
```
docker exec -it geo-track_web_1 yii migrate/fresh --interactive 0
```

### Хранимые данные

Система хранит следующие данные:

#### Список пользователей

Поле | Описание
-- | --
'guid' | Уникальный 128-ми битный идентификатор пользоватнля. Представлен шестнадцатиричным числом в строке длинной 32 символа
'telephone' | Номер телефона
'password' | Хэшированный пароль

#### Список координат для каждого ползователя

Поле | Описание
-- | --
'latitude' | Широта
'longitude' | Долгота
'time' | Временная метка

### API

Front API доступно по адресу `localhost/front`. API предоставляет следующие endpoints:

URL | описание
-- | --
POST /login | Логин пользователя по полям 'telephone'/'password'. Клиент должен сохранять cookies для поддержания сессии.
POST /insert-position | Добавление текущей координаты. Требуемые поля: 'longitude','latitude' - float, 'time' - ISO8601
GET /logout | Логаут и закрытие сессии

Back API доступно по адресу `localhost/back`. Никаких методов аутентификации не реализованно. API предоставляет следующие endpoints:

URL | описание
-- | --
GET /drop-sessions | Сброс всех активных сессий
DELETE /user/\<GUID\> | Удаление пользователя
GET /restore-user/\<GUID\> | Восстановление пользователя
GET /users | Получение списка ползователей. Дополнительно можно получить список последних трёх координат с каждым ползователем, добавив параметр 'expand=positions'
GET /user/\<GUID\>/last-position | Получение последней координаты пользователя с расстоянием до центра Екатеринбурга
GET /users/\<GUID\>/positions | Список координат ползователя
### Примечания

Использован базовый шаблон [Yii2](https://www.yiiframework.com/) и следующие проекты:
1. https://github.com/vishnubob/wait-for-it
