<?php
namespace src\controllers;

use \core\Controller;
use \src\Config;
use src\models\Inicio;

class InicioController extends Controller {

    
    public function __construct(){
        if (!isset($_SESSION['token'])) {
            header("Location: " . Config::BASE_DIR . '/');
            exit();
        }
    }

    public function index() {
        $this->render('inicio', ['base' => Config::BASE_DIR]);
    }

    public function getTotalSolicitaces() {
        $soli = new Inicio();
        $dados = [];

     

        if(!empty($_GET['dados'])){
            $dados['idtransportadora'] = $_GET['dados']['idtransportadora'];
            $dados['idcd'] = $_GET['dados']['idcd'];
            $dados['datainicio'] = $_GET['dados']['datainicio'];
            $dados['datafim'] = $_GET['dados']['datafim'];
            $dados['idsituacao'] = $_GET['dados']['idsituacao'];
            $dados['todos'] = $_GET['todos'];
        }

        $dados['todos'] = $_GET['todos'];

        $ret = $soli->getTotalSolicitacoes($dados);
        if ($ret['sucesso'] == true) {
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

    public function getSituacao() {
        $soli = new Inicio();
        $ret = $soli->getSituacao();
        if ($ret['sucesso'] == true) {
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

    public function getTransportadoraDash() {
        $soli = new Inicio();

        $dados['idgrupo'] = $_GET['idgrupo'];

        $ret = $soli->getTransportadoraDash($dados);

        if ($ret['sucesso'] == true) {
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


    public function getCdDash() {
        $soli = new Inicio();

        $dados['idgrupo'] = $_GET['idgrupo'];

        $ret = $soli->getCdDash($dados);
        if ($ret['sucesso'] == true) {
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

    
    public function getDashBoard() {
        $soli = new Inicio();
        $dados = [];


        if(!empty($_GET['dados'])){
            $dados['idtransportadora'] = $_GET['dados']['idtransportadora'];
            $dados['idcd'] = $_GET['dados']['idcd'];
            $dados['datainicio'] = $_GET['dados']['datainicio'];
            $dados['datafim'] = $_GET['dados']['datafim'];
            $dados['idsituacao'] = $_GET['dados']['idsituacao'];
            $dados['todos'] = $_GET['todos'];
        }

        $dados['todos'] = $_GET['todos'];    

        $ret = $soli->getDashBoard($dados);
        if ($ret['sucesso'] == true) {
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