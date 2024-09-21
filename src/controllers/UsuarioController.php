<?php
namespace src\controllers;

use \core\Controller;
use \src\Config;
use src\models\Usuario;

class UsuarioController extends Controller {

    public function index() {
        $this->render('usuario', ['base' => Config::BASE_DIR]);
    }

    public function cadastro(){

        $nome = $_POST["nome"];
        $login = $_POST["login"];
        $senha = $_POST["senha"];
        //$idfilial = $_POST["idfilial"];
        $idgrupo = $_POST["idgrupo"];

        $cad = new Usuario();
        $ret = $cad->cadastro($nome, $login, $senha, $idgrupo); 
        // $hashedPassword = password_hash($password, PASSWORD_DEFAULT);  criptografar a senha 
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


    public function getusuarios(){
        $list = new Usuario();
        $ret = $list->getusuarios();
        
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

}