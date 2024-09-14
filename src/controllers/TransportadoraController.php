<?php
namespace src\controllers;

use \core\Controller;
use \src\Config;
use src\models\Transportadora;

class TransportadoraController extends Controller {

    public function index() {

        $cad = new Transportadora();
        $result = $cad->getTransportadoras();
        $this->render('transportadoras', ['base' => Config::BASE_DIR, 'dados' =>  json_encode($result)]);
    }

    public function cadastro(){
        $nome = $_POST["nome"];
        $cnpj_cpf = $_POST["cnpj_cpf"];
        $email = $_POST["email"];
        $telefone = $_POST["telefone"];
        $cad = new Transportadora();
        $existe =  $cad->verificarCpf_cnpj($cnpj_cpf);

        if($existe[0]['existecpf'] == 1){
            echo json_encode(array([
                    "success" => false,
                    "result" => $existe
                ]));
            die;
        }

        $result = $cad->cadastro($nome, $cnpj_cpf, $email, $telefone);

         if ($result == false) {
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

    public function updateSituacaoTransportadora() {
        $id = $_GET['id'];
        $idsituacao = $_GET['idsituacao'];

        $cad = new Transportadora();
        $result = $cad->updateSituacao($id, $idsituacao);

        if (!$result) {
            
            echo json_encode(array([
                "success" => false,
                "result" => $result
           ]));
           die;
       }
       else{
           echo json_encode(array([
               "success" => true,
               "result" => $result
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

        if (!$result) {
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