<?php
namespace src\controllers;

use \core\Controller;
use \src\Config;

class DashboardController extends Controller {

    public function index() {
        $this->render('drawer', ['base' => Config::BASE_DIR]);
    }

}