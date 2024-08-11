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




// REVO (de "Return" e "Voltar")
// DEVO (de "Devolução")

// AGN (de "Agenda")