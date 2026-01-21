# WordPress Docker Project

## Быстрый старт

```bash
docker-compose up -d
```

**Доступ:**
- WordPress: http://localhost:8080
- phpMyAdmin: http://localhost:8081

## База данных

**MySQL:**
- База: `rostest_wordpress`
- Пользователь: `rostest_user`
- Пароль: `rostest_password`
- Хост: `db`

**phpMyAdmin:**
- Пользователь: `root`
- Пароль: `rostest_rootpassword`

## Структура

```
wordpress/
├── themes/rostest_theme/    # Кастомная тема
└── plugins/                 # Локальные плагины
```

**Файлы темы:**
- `functions.php` - регистрация меню, стилей, скриптов
- `index.php` - главная страница
- `single.php` - шаблон записи
- `page.php` - шаблон страницы
- `header.php`, `footer.php` - шапка и подвал

## Команды

```bash
docker-compose down              # Остановить
docker-compose restart           # Перезапустить
docker-compose logs -f wordpress # Логи
docker-compose down -v           # Удалить все данные
```
