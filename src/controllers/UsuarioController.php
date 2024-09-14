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
        $result = $cad->cadastro($nome, $login, $senha, $idgrupo); 

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


    public function getusuarios(){
        $list = new Usuario();
        $result = $list->getusuarios();
        
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

}