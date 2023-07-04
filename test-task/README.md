For this test task I created the docker container
which creating database and server for application.

For deploy you need to have installed docker and run 
``docker-compose up --build``
inside the project root folder.
After building the container you can go inside it by command
``docker compose exec app bash``
Creating the environment possible by only 2 commands
``composer install``
``php artisan migrate && php artisan db:seed``
After this you will have working application with test data.

For authorization I created the endpoint:
``POST /api/tokens/create/{id}``
Where {id} - user ID from database.
In the response you will get bearer auth token.
All Users contain some events, so you are free to choose anyone.

For running tests you don't need any test.env, because I used ``DatabaseTransactions`` 
trait to avoid any changes in real database. 
If you haven't installed aliases for PHPUnit or configured run in you IDE
you can just run 
``vendor/bin/phpunit``
inside the docker container.


Also, was not specified if user can get info about events belongs to another users,
so I made it possible but left the commented code which can limit the queries inside the EventRepository.
