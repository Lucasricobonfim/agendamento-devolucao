<?php
use core\Router;

$router = new Router();

// login - falto pagina de cadastro
$router->get('/', 'LoginController@index');
$router->post('/logar', 'LoginController@logar');
$router->get('/deslogar', 'LoginController@deslogar');


//
$router->get('/dashboard', 'DashboardController@index');
//transportadoras
$router->get('/transportadoras', 'TransportadoraController@index');
$router->post('/cadtransportadoras', 'TransportadoraController@cadastro');