<?php

namespace src\controllers;

use \core\Controller;
use \src\Config;
use \src\models\Login;

class LoginController extends Controller
{


    public function index()
    {
        $this->render('login', ['base' => Config::BASE_DIR]);
    }
    public function logar()
    {
        $dados = [];
        $dados['login'] = filter_input(INPUT_POST, 'login', FILTER_SANITIZE_STRING);
        $dados['senha'] = filter_input(INPUT_POST, 'senha', FILTER_SANITIZE_STRING);
        // print_r($dados);
        // exit;

        if ($dados['login'] && $dados['senha']) {
            $acesso = new Login();
            $result = $acesso->logar($dados);

            if ($result['sucesso'] && !empty($result['result'])) {
                error_log('Login encontrado para usuário: ' . $dados['login']);
                $senhaBanco = $result['result'][0]['senha'];

                // Verifica se a senha está em MD5
                if ($senhaBanco === md5($dados['senha'])) {
                    // Atualiza a senha para o formato password_hash
                    $novaSenhaHash = password_hash($dados['senha'], PASSWORD_DEFAULT);
                    $acesso->atualizarSenha($dados['login'], $novaSenhaHash);
                    $senhaBanco = $novaSenhaHash; // Atualiza o hash para a verificação

                }
                if (password_verify($dados['senha'], $senhaBanco)) { //password_verify() para verificar se uma senha corresponde ao hash armazenado.
                    // Continua o fluxo normal
                    $_SESSION['token'] = bin2hex(random_bytes(32));
                    $_SESSION['usuario'] = $result['result'][0]['nome'] ?? '';
                    $_SESSION['idgrupo'] = $result['result'][0]['idgrupo'] ?? '';
                    $_SESSION['idfilial'] = $result['result'][0]['idfilial'];

                    echo json_encode(array([
                        "success" => true,
                        "idgrupo" => $_SESSION['idgrupo'],
                        "idtipo" => 1
                    ]));
                    die;
                } else {
                    echo json_encode(array([
                        "success" => true,
                        "idtipo" => 2
                    ]));
                    die;
                }
            } else {
                echo json_encode(array([
                    "success" => true,
                    "idtipo" => 2
                ]));
                die;
            }
        } else {
            echo json_encode(array([
                "success" => false,
                "idtipo" => 3
            ]));
            die;
        }
    }
    public function deslogar()
    {

        $_SESSION = array();
        if (ini_get("session.use_cookies")) {
            $params = session_get_cookie_params();
            setcookie(
                session_name(),
                '',
                time() - 42000,
                $params["path"],
                $params["domain"],
                $params["secure"],
                $params["httponly"]
            );
        }

        session_destroy();
        $this->render('login', ['base' => Config::BASE_DIR]);
    }
}
