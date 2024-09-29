<?php
use core\Router;

$router = new Router();

// login - falto pagina de cadastro
$router->get('/', 'LoginController@index');
$router->post('/logar', 'LoginController@logar');
$router->get('/deslogar', 'LoginController@deslogar');

//inicio
$router->get('/inicio', 'InicioController@index');

// dashboard
$router->get('/dashboard', 'DashboardController@index');

//transportadoras
$router->get('/transportadoras', 'TransportadoraController@index');
$router->get('/gettransportadoras', 'TransportadoraController@getTransportadora');


$router->post('/cadtransportadoras', 'TransportadoraController@cadastro');
$router->get('/updatesituacaotransportadora', 'TransportadoraController@updateSituacaoTransportadora');
$router->get('/editartransportadora', 'TransportadoraController@editar');

// Centro de distribuição
$router->get('/centro-distribuicao','CentroDistribuicaoController@index');
$router->get('/getcentro-distribuicao', 'CentroDistribuicaoController@getCentroDistribuicao');


$router->post('/cadcentro-distribuicao','CentroDistribuicaoController@cadastro');
$router->get('/editarcentro-distribuicao', 'CentroDistribuicaoController@editar');
$router->get('/updatesituacaocentro-distribuicao', 'CentroDistribuicaoController@updatesituacaoCd');

// cadastro usuario
$router->get('/usuario', 'UsuarioController@index');
$router->post('/cadusuario', 'UsuarioController@cadastro');
$router->get('/getusuarios', 'UsuarioController@getusuarios');


$router->get('/editarusuario', 'UsuarioController@editar');
$router->get('/getfilialporgrupo', 'UsuarioController@getFilialPorGrupo');

// Acompanhamento
$router->get('/solicitacao-cd', 'SolicitacaoController@index');