<?php
namespace src\controllers;

use \core\Controller;
use \src\Config;
use \src\models\Login;

class LoginController extends Controller {
    
    
    public function index() {
        $this->render('login', ['base' => Config::BASE_DIR]);
    }

    public function logar() {
        $login = $_POST["login"];
        $senha = $_POST["senha"];

        if($login && $senha){
            $acesso = new Login();
            $result = $acesso->logar($login, $senha);      
        }
              

        
        if ($result['sucesso'] == true) {

             if(!empty($result['result'])){
                 
                $_SESSION['token'] = '123456'; 
                $_SESSION['usuario'] = $result['result'][0]['nome'] ? $result['result'][0]['nome'] : '';
                $_SESSION['idgrupo'] = $result['result'][0]['idgrupo'] ? $result['result'][0]['idgrupo']: '';
             }
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

    public function deslogar(){

        $_SESSION = array();    
        if (ini_get("session.use_cookies")) {
            $params = session_get_cookie_params();
            setcookie(session_name(), '', time() - 42000,
                $params["path"], $params["domain"],
                $params["secure"], $params["httponly"]
            );
        }

        session_destroy();
        $this->render('login', ['base' => Config::BASE_DIR]);
    }

}