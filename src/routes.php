<?php
use core\Router;

$router = new Router();

// login - falto pagina de cadastro
$router->get('/', 'LoginController@index');

$router->post('/logar', 'LoginController@logar');

$router->get('/deslogar', 'LoginController@deslogar');

//inicio
$router->get('/inicio', 'InicioController@index');
$router->get('/getsituacao', 'InicioController@getSituacao');

$router->get('/get-transportadora-dash', 'InicioController@getTransportadoraDash');
$router->get('/get=cd-dash', 'InicioController@getCdDash');
$router->get('/get-dashboard', 'InicioController@getDashBoard');
$router->get('/get-dashboard-qtd', 'InicioController@getTotalSolicitaces');


$router->get('/verifica/filial/inativa', 'InicioController@verificaInativa');

$router->get('/verifica/agendamento/pendente', 'InicioController@verificaAgendamentoPendente');

// dashboard
$router->get('/dashboard', 'DashboardController@index');

//transportadoras
$router->get('/transportadoras', 'TransportadoraController@index');
$router->get('/gettransportadoras', 'TransportadoraController@getTransportadora');


$router->post('/cadtransportadoras', 'TransportadoraController@cadastro'); // PAGINA NAO ENCONTRADA
$router->get('/updatesituacaotransportadora', 'TransportadoraController@updateSituacaoTransportadora');
$router->get('/editartransportadora', 'TransportadoraController@editar');

// Centro de distribuição
$router->get('/centro-distribuicao','CentroDistribuicaoController@index');
$router->get('/getcentro-distribuicao', 'CentroDistribuicaoController@getCentroDistribuicao');


$router->post('/cadcentro-distribuicao','CentroDistribuicaoController@cadastro'); // PAGINA NAO ENCONTRADA
$router->get('/editarcentro-distribuicao', 'CentroDistribuicaoController@editar');
$router->get('/updatesituacaocentro-distribuicao', 'CentroDistribuicaoController@updatesituacaoCd');

// cadastro usuario
$router->get('/usuario', 'UsuarioController@index');// PAGINA NAO ENCONTRADA
$router->post('/cadusuario', 'UsuarioController@cadastro');// PAGINA NAO ENCONTRADA
$router->get('/getusuarios', 'UsuarioController@getusuarios');

$router->get('/updatesituacaousuario', 'UsuarioController@updateSituacaoUsuario');

$router->get('/editarusuario', 'UsuarioController@editar');
$router->get('/getfilialporgrupo', 'UsuarioController@getFilialPorGrupo');

$router->get('/verifica/existe/login', 'UsuarioController@verificaLogin');


// Solicitação Agendamento
$router->get('/agendamento', 'AgendamentoController@index');
$router->get('/getcentro-distribuicao-ativos', 'AgendamentoController@getCd');
$router->post('/solicitar-agendamento', 'AgendamentoController@solicitar'); // PAGINA NAO ENCONTRADA
$router->get('/agendamento-listar', 'AgendamentoController@listagem');

$router->get('/get-agendamento', 'AgendamentoController@getAgendamento');

$router->post('/reagendar', 'AgendamentoController@reagendar'); // PAGINA NAO ENCONTRADA


//Pendente CD
$router->get('/solicitacoes', 'SolicitacoesController@index');
$router->get('/getsolicitacoes', 'SolicitacoesController@getsolicitacoes');
$router->post('/updatesolicitacao', 'SolicitacoesController@updateSolicitacao'); // PAGINA NAO ENCONTRADA


