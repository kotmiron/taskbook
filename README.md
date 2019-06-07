# Taskbook Приложение-задачник
-----------

### База данных

Используется PostgreSQL.

### Дополнительные бандлы:

white-october/pagerfanta-bundle
hautelook/alice-bundle

### Создание таблиц

bin/console doctrine:schema:update --force

### Наполнение фейковым содержимым из фикстур

php bin/console hautelook:fixtures:load

### Административная часть

- Username: `admin`
- Password: `123`
