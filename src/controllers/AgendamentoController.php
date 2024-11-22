<?php
namespace src\controllers;

use \core\Controller;
use \src\Config;
use src\models\Agendamento;

class AgendamentoController extends Controller {


    public function __construct(){
        if (!isset($_SESSION['token']) || $_SESSION['idgrupo'] != 2) {
            header("Location: " . Config::BASE_DIR . '/');
            exit();
        }
    }

    public function index() {
        $this->render('agendamento', ['base' => Config::BASE_DIR]);        
    }

    public function listagem() {
        $this->render('lista-agendamento', ['base' => Config::BASE_DIR]);
    }

    public function getCd() {
        $agn = new Agendamento();
        $ret = $agn->getCd();
      
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

    public function existePlaca($dados){

        $agn = new Agendamento();
        $rec = $agn->verificaPlaca($dados);
        return $rec;

    }

    public function solicitar() {

        $dados = [];

        $dados['idcd'] = $_POST['idfilial'];
        $dados['placa'] = $_POST['placa'];
        $dados['data'] = $_POST['data'];
        $dados['quantidadenota'] = $_POST['quantidadenota'];
        $dados['observacao'] = $_POST['observacao'];
        $dados['idtransportadora'] = $_SESSION['idfilial'];


        $existe = $this->existePlaca($dados);
        if($existe['result'][0]['existeplaca'] == 1){
            echo json_encode(array([
                "success" => false,
                "ret" => $existe['result']
            ]));
        die;
        }
        
        $agn = new Agendamento();
        $ret = $agn->cadSolicitar($dados);

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

    // fim cadastro //


    // listagem


    public function getAgendamento() {
        $dados['idtransportadora'] = $_SESSION['idfilial'];
        $dados['idsituacao'] = $_GET['idsituacao'] ? $_GET['idsituacao'] : 1;
        
        $agn = new Agendamento();

        $ret = $agn->getAgendamentos($dados);

        
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

    public function reagendar() {
      
        $dados= $_POST;
        
        $agn = new Agendamento();

        $ret = $agn->reagendar($dados);

        
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