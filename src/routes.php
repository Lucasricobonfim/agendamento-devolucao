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

$router->get('/updatesituacaousuario', 'UsuarioController@updateSituacaoUsuario');

$router->get('/editarusuario', 'UsuarioController@editar');
$router->get('/getfilialporgrupo', 'UsuarioController@getFilialPorGrupo');

// Solicitação Agendamento
$router->get('/agendamento', 'AgendamentoController@index');
$router->get('/getcentro-distribuicao-ativos', 'AgendamentoController@getCd');
$router->post('/solicitar-agendamento', 'AgendamentoController@solicitar');
$router->get('/agendamento-listar', 'AgendamentoController@listagem');

$router->get('/get-agendamento', 'AgendamentoController@getAgendamento');


//Pendente CD
$router->get('/solicitacoes', 'SolicitacoesController@index');
$router->get('/getsolicitacoes', 'SolicitacoesController@getsolicitacoes');
$router->post('/updatesolicitacao', 'SolicitacoesController@updateSolicitacao');

//Negocio
$router->get('/negocio', 'NegocioController@index');
$router->get('/getnegocio', 'NegocioController@getnegocio');

$router->post('/cadnegocio', 'NegocioController@cadastro');
$router->get('/editnegocio', 'NegocioController@editar');
$router->get('/updatesituacaonegocio', 'NegocioController@updatesituacaoNegocio');

// Indenização
$router->get('/indenizacao-cd', 'IndenizacaoCdController@index');
$router->post('/solicitar-indenizacao', 'IndenizacaoCdController@solicitar');

$router->get('/get-transportadora-ativos', 'IndenizacaoCdController@getTransportadora');
$router->get('/get-negocio-ativos', 'IndenizacaoCdController@getNegocio');
$router->get('/get-indenizacao-cd', 'IndenizacaoCdController@getindenizacao');

//Indenização - Transportadora
$router->get('/indenizacao-transportadora', 'IndenizacaoTransportadoraController@index');
$router->get('/getindenizacao-transportadora', 'IndenizacaoTransportadoraController@getindenizacao');
$router->post('/updateindenizacao-transportadora', 'IndenizacaoTransportadoraController@updateindenizacao');
