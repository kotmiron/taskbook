#Taskbook Приложение-задачник
-----------

1) База данных
Используется PostgreSQL.

2) Дополнительные бандлы:
    white-october/pagerfanta-bundle
    hautelook/alice-bundle

3) Создание таблиц
    bin/console doctrine:schema:update --force

4) Наполнение фейковым содержимым из фикстур
    php bin/console hautelook:fixtures:load

5) Административная часть

    Логин:  admin
    Пароль: 123
