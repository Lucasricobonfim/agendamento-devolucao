<?php
namespace src\controllers;

use \core\Controller;
use \src\Config;
use src\models\IndenizacaoFinanceiro;

class IndenizacaoFinanceiroController extends Controller {

    public function index() {
        $this->render('indenizacao-financeiro', ['base' => Config::BASE_DIR]);        
    }

    public function getindenizacao (){
        $dados = [];
        $cad = new IndenizacaoFinanceiro();
        $dados['idtransportadora'] = $_SESSION['idfilial'];
        //$dados['idsituacao'] = $_GET['idsituacao'];
        $ret = $cad->getindenizacao($dados);

        if($ret['sucesso'] == true){
            echo json_encode(array([
                "success" => true,
                "ret" => $ret['result']
            ]));
            die;
        }else{
            echo json_encode(array([
                "success" => false,
                "ret" => $ret['result']
            ]));
            die;
        }
    }

    public function updateindenizacao(){
        $dados = $_POST;

        $slt = new IndenizacaoFinanceiro();
        $ret = $slt->updateindenizacao($dados);

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