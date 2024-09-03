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
        $status = $_POST["status"];

        $cad = new Transportadora();

        $existe =  $cad->verificarCpf_cnpj($cnpj_cpf);
        // print_r($existe);
        // die;

        if($existe[0]['existecpf'] == 1){
            echo json_encode(array([
                    "success" => false,
                    "result" => $existe
                ]));
            die;
        }


        $result = $cad->cadastro($nome, $cnpj_cpf, $email, $telefone, $status);
    
        // print_r($result);die;
        /*chamar model para realizar o cadastro, depois pegar o resultado e retornar sucesso ou false para o javascript*/

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

    public function deletar() {

        $id = $_GET['id'];

        $cad = new Transportadora();
        $result = $cad->deletar($id);

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

    public function editar() {

        $id = $_GET['id'];

        $cad = new Transportadora();
        // $result = $cad->deletar($id);

    //     if (!$result) {
    //         echo json_encode(array([
    //             "success" => false,
    //             "result" => $result
    //        ]));
    //        die;
    //    }else{
    //        echo json_encode(array([
    //            "success" => true,
    //            "result" => $result
    //        ]));
    //        die;
    //    }
        
    }

}