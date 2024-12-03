<?php
namespace src\controllers;

use \core\Controller;
use \src\Config;
use src\models\Solicitacoes;

class SolicitacoesController extends Controller {

    public function __construct(){
        if ( !isset($_SESSION['token']) || $_SESSION['idgrupo'] == 2     )  {
            header("Location: " . Config::BASE_DIR . '/');
            exit();
        }
    }


    public function index() {
        $idgrupo = $_SESSION['idgrupo']; // Obtém o grupo do usuário logado
        // print_r($_SESSION);
        // exit;
        $this->render('solicitacoes', [
            'base' => Config::BASE_DIR,
            'idgrupo' => $idgrupo // Envia o idgrupo para a View
        ]);
    }

    public function getsolicitacoes() {
        $dados = [];
        $list = new Solicitacoes();  
        
        $dados['idsituacao'] = $_GET['idsituacao'];
        $ret = $list->getsolicitacoes($dados);

    
        
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
      
    }

    public function updateSolicitacao(){
        $dados = $_POST;
        $slt = new Solicitacoes();
        $ret = $slt->updatesolicitacao($dados);

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