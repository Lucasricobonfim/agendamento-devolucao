<?php
namespace src\controllers;

use \core\Controller;
use \src\Config;
use src\models\Replica;

class ReplicaController extends Controller {
    public function __construct() {
        // Verifica se o usuário está autenticado e pertence aos grupos 1, 4 ou 5
        if (!isset($_SESSION['token']) || !in_array($_SESSION['idgrupo'], [1, 4, 5])) {
            header("Location: " . Config::BASE_DIR . '/deslogar');
            exit();
        }
    }
    public function index() {
        $this->render('replica', ['base' => Config::BASE_DIR]);
    }

    public function getreplica(){
        // Obtém o id da filial da sessão e o id da situação da requisição
        $dados['idtransportadora'] = $_SESSION['idfilial'];
        $dados['idsituacao'] = $_GET['idsituacao'];
        // Define o idnegocio com base na idfilial
        if ($_SESSION['idfilial'] == 52) {
            $dados['idnegocio'] = 52;
        } elseif ($_SESSION['idfilial'] == 53) {
            $dados['idnegocio'] = 53;
        } else {
            $dados['idnegocio'] = $_SESSION['idfilial'];
        }
        $cad = new Replica();
        $ret = $cad->getreplica($dados);

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

    public function updatereplica(){
        $dados = $_POST;
        $slt = new Replica();
        $ret = $slt->updatereplica($dados);

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