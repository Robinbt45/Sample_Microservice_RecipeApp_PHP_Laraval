# Recipe Service 

It is a micro-service for a recipe app, The moto behind this service is to help front-end or mobile apps to interact with end-user and update their recipe in proper format with ingredients and all steps to be followed.

## Installation Process 

* System Requirement: Apache2, PHP (7.2.x or higher), MySQL (5.x or higher), composer
* Create a new database ( I am using `recipe_service`) you can use of your choice
* Go to root directory of project
* Now change `.env` file as per your database details
* Execute below command in terminal
* `composer update`
* `php artisan db:wipe`
* `php artisan migrate`
* `php artisan passport:install --force`
* `php artisan serve`

The server is running on localhost:8000 / 127.0.0.1:8000


## How to use
* Step 1: POST /api/login
    *  BODY: `{
             	"email":"master@chef.com",
             	"password":"test@123$"
             }`
    * P.S. default username is `master@chef.com` and password is `test@123$`
    * in the response you will get `data.token` in json
* Step 2: call API {GET/POST/PUT/DELETE} /api/recipe.... 

    * Headers: 
        * Content-Type: application/json
        * Accept: application/json
        * Authorization: Bearer <token>
     
## Available APIs

* POST /api/register - Create new Account
* POST /api/login - Login using Account

* POST /api/recipe - Create new Recipe
* GET /api/recipe/{recipeId} - Get a Recipe by Id
* GET /api/recipe - Get all Recipes
* PUT /api/recipe/{recipeId} - Update a Recipe
* DELETE /api/recipe/{id} - Remove a Recipe

* POST /api/recipe/{recipeId}/ingredient - Create new Ingredient
* GET /api/recipe/{recipeId}/ingredient/{ingredientId} - Get an Ingredient by Id
* GET /api/recipe/{recipeId}/ingredient - Get all Ingredients by Recipe Id
* PUT /api/recipe/{recipeId}/ingredient/{ingredientId} - Update an Ingredient
* DELETE /api/recipe/{recipeId}/ingredient/{ingredientId} - Remove an Ingredient

* POST /api/recipe/{recipeId}/step - Create new Step
* GET /api/recipe/{recipeId}/step/{stepId} - Get a Step by Id
* GET /api/recipe/{recipeId}/step/ - Get all Steps by Recipe Id
* PUT /api/recipe/{recipeId}/step/{stepId} - Update a Step
* DELETE /api/recipe/{recipeId}/step/{stepId} - Remove a Step


## Testing

For executing test case create new test database and update .env.testing

`
$ vendor/bin/phpunit
`

PHPUnit 8.3.5 by Sebastian Bergmann and contributors.

....................                                              20 / 20 (100%)

Time: 6.75 seconds, Memory: 32.00 MB

OK (20 tests, 33 assertions)


## Build via

Laravel framework which is an open-source software licensed under the [MIT license](https://opensource.org/licenses/MIT).
