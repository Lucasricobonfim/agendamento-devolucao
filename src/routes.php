<?php
use core\Router;

$router = new Router();

// login - falto pagina de cadastro
$router->get('/', 'LoginController@index');
$router->post('/logar', 'LoginController@logar');
$router->get('/deslogar', 'LoginController@deslogar');


// dashboard
$router->get('/dashboard', 'DashboardController@index');

//transportadoras
$router->get('/transportadoras', 'TransportadoraController@index');
$router->post('/cadtransportadoras', 'TransportadoraController@cadastro');
$router->get('/updatesituacaotransportadora', 'TransportadoraController@updateSituacaoTransportadora');
$router->get('/editartransportadora', 'TransportadoraController@editar');

// cadastro usuario
$router->get('/usuario', 'UsuarioController@index');
$router->post('/cadusuario', 'UsuarioController@cadastro');
$router->get('/getusuarios', 'UsuarioController@getusuarios');
