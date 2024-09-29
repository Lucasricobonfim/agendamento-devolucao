<?php
namespace src\controllers;

use \core\Controller;
use \src\Config;
use src\models\Inicio;

class InicioController extends Controller {

    public function index() {
        $this->render('inicio', ['base' => Config::BASE_DIR]);
    }

}