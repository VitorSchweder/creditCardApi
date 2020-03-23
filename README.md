## How to setup this Application
Install the packages with this command in yout terminal: 
<pre>
composer install
</pre>

<p>
If you don't have PostgreSQL installed you have to install
</p>

<p>
Create database in PostgreSQL
</p>
    
<p>
Set connection with database in .env file, PORT = 5432
</p>

<p>
Set JWT_SECRET in .env file, example JWT_SECRET=081ZMlHGJ2nmw0R0rPZ7QTIGTCtvEm0m6csuJFRVWc
you can generate running the command: php artisan jwt:secret
</p>

## Users
<p>
Register Users: POST /register
</p>

<p>
Login Users: POST /login
</p>
    
## Users JWT
<p>
I used JWT so after register or login response is a token field that can be send in Authorization Header this way:

Field: Authorization Value: Bearer TOKEN

Token has validate of 60 minutes, but if needed you can change in config/jwt.php in "ttl"
</p>

## Security
<p>
All the requests are protected, so you have to register a user to access
</p>

## Endpoints - API

## Cards
<p>
Insert Cards: POST /cards
</p>

<p>
List Cards: GET /cards
</p>

<p>
Show Cards: GET /cards/{id}/show
</p>

<p>
Update Cards: PUT /cards/{id}/update
</p>

<p>
Delete Cards: DELETE /cards/{id}/delete
</p>

## Categories
<p>
List Categories: GET /categories
</p>
    
## Tests
<p>
To Run Tests you can use the command: ./vendor/bin/phpunit
The files are locate in tests/Unit
</p>
