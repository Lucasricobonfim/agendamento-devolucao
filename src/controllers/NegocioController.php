<?php
namespace src\controllers;

use \core\Controller;
use \src\Config;
use src\models\Negocio;

class NegocioController extends Controller{
    public function __construct() {
        // Verifica se o usuário está autenticado e se pertence ao grupo 4 ou 5
        if (!isset($_SESSION['token'])) {
            header("Location: " . Config::BASE_DIR . '/');
            exit();
        }
    }

    public function index() {
        if($_SESSION['idgrupo'] == 1){
            $this->render('negocio', ['base' => Config::BASE_DIR]);
        }
        else{
            $this->render('404');
        }        
    }

    public function cadastro() {
        $nome = $_POST["nome"];
        $email = $_POST["email"];
        $idtipofilial = $_POST["idtipofilial"];
        $telefone = $_POST["telefone"];

        $cad = new Negocio(); // chamando a model aq
        $ret = $cad->cadastro($nome, $email, $idtipofilial, $telefone );// Armazenando os dados do sql da model na variavel ret
        //verificando se o retorno no ret é true ou falso, 
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

    public function getnegocio (){
        $cad = new Negocio();
        $ret = $cad->getnegocio();

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

    public function editar() {
        
        $idfilial = $_GET['idfilial'];
        $nome = $_GET["nome"];
        $email = $_GET["email"];
        $idtipofilial = $_GET["idtipofilial"];
        $telefone = $_GET["telefone"];

        $editar = new Negocio();
        $result = $editar->editar($idfilial, $nome, $email, $idtipofilial, $telefone);

        if($result['sucesso'] == true){
            echo json_encode(array([
                "success" => true,
                "ret" => $result['result']
            ]));
            die;
        }else{
            echo json_encode(array([
                "success" => false,
                "ret" => $result['result']
            ]));
            die;
        }
        
    }

    public function updatesituacaoNegocio() {
        $id = $_GET['id'];
        $idsituacao = $_GET['idsituacao'];

        $cad = new Negocio();
        $ret = $cad->updatesituacaoNegocio($id, $idsituacao);

        
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
}