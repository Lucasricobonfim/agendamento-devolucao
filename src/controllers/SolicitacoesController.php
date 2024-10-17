<?php
namespace src\controllers;

use \core\Controller;
use \src\Config;
use src\models\Solicitacoes; // Certifique-se de que esta classe está correta

class SolicitacoesController extends Controller {

    public function index() {
        $this->render('solicitacoes', ['base' => Config::BASE_DIR]);        
    }

    public function getsolicitacoes(){
        // Instancie a classe Solicitacoes, não Usuario
        $list = new Solicitacoes();  
        
        // Chame o método getsolicitacoes da classe Solicitacoes
        $ret = $list->getsolicitacoes();
        print_r($ret);
        
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
    }


}