<?php
namespace src\controllers;

use \core\Controller;
use \src\Config;
use \src\models\Login;

class LoginController extends Controller {
    
    
    public function index() {
        // phpinfo();die;
        $this->render('login', ['base' => Config::BASE_DIR]);
    }

    public function logar() {
        $login = $_POST["login"];
        $senha = $_POST["senha"];

        
        $acesso = new Login();
        $acesso->logar($login, $senha);

        var_dump($acesso);

    }

}