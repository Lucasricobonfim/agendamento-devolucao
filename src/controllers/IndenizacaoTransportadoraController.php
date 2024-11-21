<?php
namespace src\controllers;

use \core\Controller;
use \src\Config;
use src\models\IndenizacaoTransportadora;

class IndenizacaoTransportadoraController extends Controller {
    public function __construct(){
        if (!isset($_SESSION['token']) || $_SESSION['idgrupo'] != 2) {
            header("Location: " . Config::BASE_DIR . '/');
            exit();
        }
    }
    public function index() {
        $this->render('indenizacao-transportadora', ['base' => Config::BASE_DIR]);
    }

    public function getindenizacao (){

        $cad = new IndenizacaoTransportadora();
        $dados['idcd'] = $_SESSION['idfilial'];
        $dados['idsituacao'] = $_GET['idsituacao'];
        $dados['idtransportadora'] = $_SESSION['idfilial'];
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
        $dados['cnpj'] = isset($_POST['cnpj']) ? $_POST['cnpj'] : 'null';
        $slt = new IndenizacaoTransportadora();
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