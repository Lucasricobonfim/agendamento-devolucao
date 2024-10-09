<?php
namespace src\controllers;

use \core\Controller;
use \src\Config;
use src\models\Transportadora;

class TransportadoraController extends Controller {

    public function index() {

        if($_SESSION['idgrupo'] == 1){
            $this->render('transportadoras', ['base' => Config::BASE_DIR]);
        }else{
            $this->render('404');
        }
    }

    public function getTransportadora (){
        $cad = new Transportadora();
        $ret = $cad->getTransportadoras();

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

    public function cadastro(){
        $nome = $_POST["nome"];
        $cnpj_cpf = $_POST["cnpj_cpf"];
        $email = $_POST["email"];
        $telefone = $_POST["telefone"];
        $cad = new Transportadora();
        $existe =  $cad->verificarCpf_cnpj($cnpj_cpf);

        // print_r($existe);die;
        if($existe['result'][0]['existecpf'] == 1){
            echo json_encode(array([
                    "success" => false,
                    "ret" => $existe
                ]));
            die;
        }

        $ret = $cad->cadastro($nome, $cnpj_cpf, $email, $telefone);

        if ($ret['sucesso'] == true) {
            echo json_encode(array([
                "success" => true,
                "ret" => $ret
            ]));
            die;
        }else{
            echo json_encode(array([
                "success" => false,
                "ret" => $ret
            ]));
            die;
        }   
    }

    public function updateSituacaoTransportadora() {
        $id = $_GET['id'];
        $idsituacao = $_GET['idsituacao'];

        $cad = new Transportadora();
        $ret = $cad->updateSituacao($id, $idsituacao);

        
        if (!$ret['sucesso']) {
            echo json_encode(array([
                "success" => false,
                "ret" => $ret
           ]));
           die;
       }
       else{
           echo json_encode(array([
               "success" => true,
               "ret" => $ret
           ]));
           die;
       }
        
    }

    public function editar() {


        
        $idfilial = $_GET['idfilial'];
        $nome = $_GET['nome'];
        $cnpj_cpf = $_GET['cnpj_cpf'];
        $email = $_GET['email'];
        $telefone = $_GET['telefone'];

        $editar = new Transportadora();
        $result = $editar->editar($idfilial, $nome, $cnpj_cpf, $email, $telefone);

        if (!$result['sucesso']) {
            echo json_encode(array([
                "success" => false,
                "result" => $result
           ]));
           die;
       }else{
           echo json_encode(array([
               "success" => true,
               "result" => $result
           ]));
           die;
       }
        
    }

}