<?php
namespace src\controllers;

use \core\Controller;
use \src\Config;
use src\models\Solicitacoes;

class SolicitacoesController extends Controller {

    public function index() {
        $this->render('solicitacoes', ['base' => Config::BASE_DIR]);        
    }

    public function getsolicitacoes() {
        $list = new Solicitacoes();  
        $ret = $list->getsolicitacoes();
    
        // Retorne em JSON corretamente
        if ($ret['sucesso'] == false) {
            echo json_encode(array([
                "success" => false,
                "ret" => $ret['result']
           ]));
           die;
        } else {
            echo json_encode(array([
                "success" => true,
                "ret" => $ret['result']
            ]));
            die;
        }
        die; // Não esqueça do die para interromper a execução após enviar a resposta
    }
}