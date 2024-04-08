<?php
use core\Router;

$router = new Router();

$router->get('/', 'LoginController@index');
$router->post('/logar', 'LoginController@logar');
$router->get('/home', 'HomeController@index');