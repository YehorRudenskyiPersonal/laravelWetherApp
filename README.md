# Laravel wether app

Мікросервіс, щогодини зберігає температуру по одному місту (вказується в env).
Використовується https://openweathermap.org/api

## Table of Contents

- [Запуск](#installation)
- [Використання](#usage)

## Запуск

Аби запустити проект:

1. Скопіюйте репозіторій git remote add origin https://github.com/YehorRudenskyiPersonal/laravelWetherApp.git
Також це ключ для розшифровки .env. Тільки нікому не кажіть - 3UVsEgGVK36XN82KKeyLFMhvosbZN1aF
Відчувається жахливо, але це тестова апка, тому залишу його тут

2. Запустіть докер та виконайте команди:

    ```bash
    docker-compose build && docker-compose up
    ```

## Використання

У мікросервісу є 2 основні функціонали: збирання даних кожну годину та виведення історії температур.
Тож по списку:

### Збирання даних за api
Відбувається кожну годину, починає працювати разом з програмою.
Також було додано консольну команду  
```bash
php artisan get:temperature --city={your_city}
```
За допомогою цієї команди можна позапланово додати запис для обраного міста, або для міста з .env (якщо не вказати параметр).

### Виведення історії температур
Є 3 варіанти отримання історії температур. Так мікросервіс зможе взаємодіяти з більшою кількістю можливих отримувачів.
Обов'язково треба вказувати x-token в хедерах.

1. Звичайне api
    Реалізація завдання напряму. 
    Роут: http://localhost:8080/api/temperatures/info/
    GET параметри: day, city
    Якщо вказати один з них, виведення відбудеться згідно вказаного параметру, якщо не вказати жодного - виведе цілий список
2. SOAP api

    Реалізація SOAP api, віддає xml. Також зроблено роути для кожної потреби:

    http://localhost:8080/api/soap/temperatures/date/{date} - виведення за датою, формат {date} Y-m-d.

    http://localhost:8080/api/soap/temperatures/city/{city} - виведення за містом, {city} - строка з великими та малими літерами.

    http://localhost:8080/api/soap/temperatures/info/{date}/{city} - виведення за датою та містом, формат {date} Y-m-d, {city} - строка з великими та малими літерами.

    http://localhost:8080/api/soap/temperatures/info - виведення цілого списку.

3. GraphQL api
    Реалізація GraphQL api. Запити:

    Повний список:
    ```graphql
    query TemperatureListQuery {
        temperatureListQuery {
            id
            city
            temperature
            full_data
            created_at
        }
    }
    ```
    За містом:
    ```graphql
    query TemperatureByCity {
        temperatureByCity(city: "{some_city}") {
            id
            city
            temperature
            full_data
            created_at
        }
    }
    ```
    За датою:
    ```graphql
    query TemperatureByCity {
        temperatureByCity(city: "{Y-m-d date}") {
            id
            city
            temperature
            full_data
            created_at
        }
    }
    ```
    За містом і датою:
    ```graphql
    query TemperatureByCityAndDate {
        temperatureByCityAndDate(city: "{some_city}", date: "{Y-m-d date}") {
            id
            city
            temperature
            full_data
            created_at
        }
    }
    ```

