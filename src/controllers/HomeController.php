<?php
namespace src\controllers;

use \core\Controller;
use \src\Config;

class HomeController extends Controller {

    public function index() {
        $this->render('home', ['base' => Config::BASE_DIR]);
    }

    public function sobre() {
        
        // $dados = ['id' => 1, 'nome' => 'lucas'];
        // echo json_encode([
        //     "sucesso" => 'true',
        //     "message" => 'chegou top' ,
        //     "dados" => $dados
        // ]);


        $this->render('sobre');
    }

    public function sobreP($args) {
        print_r($args);
    }

}