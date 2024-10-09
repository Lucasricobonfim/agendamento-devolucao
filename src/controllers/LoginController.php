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

        $dados = [];
        $dados['login'] = $_POST["login"];
        $dados['senha'] = $_POST["senha"];  

        
        if($dados['login'] && $dados['senha']){
            $acesso = new Login();
            $result = $acesso->logar($dados);      
        }

        if ($result['sucesso'] == true) { 

            if(!empty($result['result'])){
                    if (md5($dados['senha']) === $result['result'][0]['senha']) {
                        
                        $_SESSION['token'] = '123456'; 
                        $_SESSION['usuario'] = $result['result'][0]['nome'] ? $result['result'][0]['nome'] : '';
                        $_SESSION['idgrupo'] = $result['result'][0]['idgrupo'] ? $result['result'][0]['idgrupo']: '';
                        echo json_encode(array([
                            "success" => true,
                            "ret" => $result['result'],
                            "idtipo" => 1
                        ]));
                        die;

                    }else{
                        echo json_encode(array([
                            "success" => true,
                            "ret" => $result['result'],
                            "idtipo" => 2 
                        ]));
                        die;
                    }
                   
                
            }else{
                echo json_encode(array([
                    "success" => true,
                    "ret" => $result['result'],
                    "idtipo" => 2 
                ]));
                die;
            }         
        }else{
            echo json_encode(array([
                "success" => false,
                "ret" => $result['result'],
                "idtipo" => 3
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