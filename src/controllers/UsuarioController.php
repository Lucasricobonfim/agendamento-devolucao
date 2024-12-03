<?php
namespace src\controllers;

use \core\Controller;
use \src\Config;
use src\models\Usuario;

class UsuarioController extends Controller {
    
    public function __construct(){
        if (!isset($_SESSION['token']) || $_SESSION['idgrupo'] != 1) {
            header("Location: " . Config::BASE_DIR . '/');
            exit();
        }
    }

    public function index() {
        $this->render('usuario', ['base' => Config::BASE_DIR]);
    }

    public function cadastro(){

        $dados = [];
        $dados['nome'] = $_POST["nome"];
        $dados['login'] = $_POST["login"];
        $dados['senha'] = $_POST["senha"];
        $dados['idfilial'] = $_POST["idfilial"];
        $dados['idgrupo'] = $_POST["idgrupo"];


        $cad = new Usuario();
        $hashedSenha = md5($dados['senha']); 
        // $hashedSenha = password_hash($dados['senha'], PASSWORD_DEFAULT);  
        $dados['senha'] = $hashedSenha;
        
        $ret = $cad->cadastro($dados); 
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


    public function editar() {

        $dados = [];

        $dados['idfilial'] = $_GET['idfilial'];
        $dados['idgrupo'] = $_GET['idgrupo'];
        $dados['idusuario'] = $_GET['idusuario'];
        $dados['login'] = $_GET['login'];
        $dados['nome'] = $_GET['nome'];

        if(!empty($_GET['senha'])){
            
            $hashedSenha = md5($_GET['senha']); 
            $dados['senha'] =  $hashedSenha;
        }

        $editar = new Usuario();
        $result = $editar->editar($dados);

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

    public function getFilialPorGrupo(){

        $idgrupo['idgrupo'] = $_GET['idgrupo'];
        $get = new Usuario();
        $ret = $get->getFilialPorGrupo($idgrupo);

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


    public function updateSituacaoUsuario() {
        $id = $_GET['id'];
        $idsituacao = $_GET['idsituacao'];

        $cad = new Usuario();
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

    public function verificaLogin() {
        
        $dados =[];
        $dados['login'] = $_GET['login'];

        $cad = new Usuario();
        $ret = $cad->verificaLogin($dados);

        
        if (!$ret['sucesso']) {
            echo json_encode(array([
                "success" => false,
                "ret" => $ret['result']
           ]));
           die;
       }
       else{
           echo json_encode(array([
               "success" => true,
               "ret" => $ret['result']
           ]));
           die;
       }
        
    }

}
