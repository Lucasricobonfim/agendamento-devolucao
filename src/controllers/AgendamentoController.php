<?php
namespace src\controllers;

use \core\Controller;
use \src\Config;
use src\models\Agendamento;

class AgendamentoController extends Controller {

    public function index() {
        $this->render('agendamento', ['base' => Config::BASE_DIR]);        
    }


    public function getCd() {

        $cd = new Agendamento();

        $ret = $cd->getCd();
        
      
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


    
    public function solicitar() {

        $dados = [];

        $dados['idcd'] = $_POST['idfilial'];
        $dados['placa'] = $_POST['placa'];
        $dados['data'] = $_POST['data'];
        $dados['quantidadenota'] = $_POST['quantidadenota'];
        $dados['observacao'] = $_POST['observacao'];
        $dados['idtransportadora'] = $_SESSION['idfilial'];

        
        $cd = new Agendamento();
        $cd->cadSolicitar($dados);

        

        


    }

}