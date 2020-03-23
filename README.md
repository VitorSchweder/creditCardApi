## How to setup this Application

1 - If you don't have PostgreSQL installed you have to install
2 - Create database in PostgreSQL
3 - Set connection with database in .env file, PORT = 5432
4 - Set JWT_SECRET in .env file, example JWT_SECRET=081ZMlHGJ2nmw0R0rPZ7QTIGTCtvEm0m6csuJFRVWc
you can generate running the command: php artisan jwt:secret

## Users
Register Users: POST /register
Login Users: POST /login

## Users JWT
I used JWT so after register or login response is a token field that can be send in Authorization Header this way:

Field: Authorization Value: Bearer TOKEN

Token has validate of 60 minutes, but if needed you can change in config/jwt.php in "ttl"

## Security
All the requests are protected, so you have to register a user to access

## Endpoints - API

## Cards
Insert Cards: POST /cards
List Cards: GET /cards
Show Cards: GET /cards/{id}/show
Update Cards: PUT /cards/{id}/update
Delete Cards: DELETE /cards/{id}/delete

## Categories
List Categories: GET /categories

1 - Silver
2 - Gold
3 - Platinum
4 - Black

## Tests
To Run Tests you can use the command: ./vendor/bin/phpunit
The files are locate in tests/Unit
