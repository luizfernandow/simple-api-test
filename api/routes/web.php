<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It is a breeze. Simply tell Lumen the URIs it should respond to
| and give it the Closure to call when that URI is requested.
|
*/

use Illuminate\Support\Facades\Artisan;

$router->get('/', function () use ($router) {
    return $router->app->version();
});

$router->post('/reset', function () use ($router) {
    Artisan::call('migrate:refresh');
    return 'OK';
});

$router->get('/balance', 'AccountController@balance');

$router->post('/event', 'AccountController@event');
