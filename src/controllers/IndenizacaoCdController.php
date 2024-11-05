<?php
namespace src\controllers;

use \core\Controller;
use \src\Config;
use src\models\IndenizacaoCd;

class IndenizacaoCdController extends Controller {

    public function index() {
        $this->render('indenizacao-cd', ['base' => Config::BASE_DIR]);        
    }

    public function getTransportadora() {
        $agn = new IndenizacaoCd();
        $ret = $agn->getTransportadora();
      
       if ($ret['sucesso'] == false) {
            echo json_encode(array([
                "success" => false,
                "ret" => $ret['result']
           ]));
           die;
       }else{
           echo json_encode(array([
               "success" => true,
               "ret" => $ret['result']
           ]));
           die;
        }
    }

    public function getNegocio() {
        $agn = new IndenizacaoCd();
        $ret = $agn->getNegocio();
      
       if ($ret['sucesso'] == false) {
            echo json_encode(array([
                "success" => false,
                "ret" => $ret['result']
           ]));
           die;
       }else{
           echo json_encode(array([
               "success" => true,
               "ret" => $ret['result']
           ]));
           die;
        }
    }

    public function solicitar() {

        $dados = [];

        $dados['numero_nota'] = $_POST['numero_nota'];
        $dados['numero_nota2'] = $_POST['numero_nota2'];
        $dados['idnegocio'] = $_POST['idnegocio'];
        $dados['tipo_indenizacao'] = $_POST['tipo_indenizacao'];
        $dados['idtransportadora'] = $_POST['idfilial'];
        $dados['anexo'] = $_POST['anexo'];
        $dados['data'] = $_POST['data'];
        $dados['observacao'] = $_POST['observacao'];
        $dados['idcd'] = $_SESSION['idfilial'];


        $agn = new IndenizacaoCd();
        $ret = $agn->solicitar($dados);

        if ($ret['sucesso'] == false) {
            echo json_encode(array([
                "success" => false,
                "ret" => $ret['result']
           ]));
           die;
        }else{
           echo json_encode(array([
               "success" => true,
               "ret" => $ret['result']
           ]));
           die;
        }
    }

    public function getindenizacao (){
        $cad = new IndenizacaoCd();
        $ret = $cad->getindenizacao();

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


}