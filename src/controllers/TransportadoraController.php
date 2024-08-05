<?php
namespace src\controllers;

use \core\Controller;
use \src\Config;

class TransportadoraController extends Controller {

    public function index() {
        $this->render('transportadoras', ['base' => Config::BASE_DIR]);
    }

    public function cadastro(){
        $nome = $_POST["nome"];
        $cnpj_cpf = $_POST["cnpj_cpf"];
        $email = $_POST["email"];
        $telefone = $_POST["telefone"];

        
        

        /*chamar model para realizar o cadastro, depois pegar o resultado e retornar sucesso ou false para o javascript*/

        // if ($result == false) {
        //     echo json_encode(array([
        //         "success" => false,
        //         "result" => $result
        //     ]));
        //     die;
        // }else{
        //     echo json_encode(array([
        //         "success" => true,
        //         "result" => $result
        //     ]));
        //     die;
        // }
        
    }

}