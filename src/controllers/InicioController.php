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
        $ret = $soli->getTotalSolicitacoes();
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
}