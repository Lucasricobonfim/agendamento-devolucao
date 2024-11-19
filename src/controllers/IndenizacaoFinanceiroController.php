<?php
namespace src\controllers;

use \core\Controller;
use \src\Config;
use src\models\IndenizacaoFinanceiro;

class IndenizacaoFinanceiroController extends Controller {
    public function __construct(){
        if (!isset($_SESSION['token'])) {
            header("Location: " . Config::BASE_DIR . '/');
            exit();
        }
    }
    public function index() {
        if($_SESSION['idgrupo'] == 1 || $_SESSION['idgrupo'] == 6 || $_SESSION['idgrupo'] == 7){
            $this->render('indenizacao-financeiro', ['base' => Config::BASE_DIR]);
        }
        else{
            $this->render('404');
        }        
    }

    public function getindenizacao (){
        $cad = new IndenizacaoFinanceiro();
        $dados['idtransportadora'] = $_SESSION['idfilial'];
        $dados['idsituacao'] = $_GET['idsituacao'];
        $dados['idnegocio'] = ($_SESSION['idfilial'] == 55) ? 52 : (($_SESSION['idfilial'] == 54) ? 53 : $_SESSION['idfilial']);
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