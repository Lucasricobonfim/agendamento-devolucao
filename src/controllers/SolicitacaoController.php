<?php
namespace src\controllers;

use \core\Controller;
use \src\Config;
use src\models\Solicitacao;

class SolicitacaoController extends Controller {

    public function index() {
        $this->render('solicitacao-cd', ['base' => Config::BASE_DIR]);
    }

}