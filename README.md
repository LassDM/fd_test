## Тестовый сайт по реализации API.

Даны два списка. Список автомобилей и список пользователей.  
C помощью laravel сделать api для управления списком использования автомобилей пользователями.
В один момент времени 1 пользователь может управлять только одним автомобилем. В один момент времени 1 автомобилем может управлять только 1 пользователь.  
Код разместить на https://github.com/  
Подготовить документацию в https://editor.swagger.io/  
Обязательно наличие тестов.  
## Запуск проекта

1. Накатываем файлы из гита на чистый laravel
2. Запускаем в отдельном терминале встроенный сервер <php artisan serve>
3. Подключаемся к своей любимой БД и выполняем <php artisan migrate --seed>
