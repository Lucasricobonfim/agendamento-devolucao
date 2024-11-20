<?php
namespace src\controllers;

use \core\Controller;
use \src\Config;
use src\models\EsqueceuSenha;
use \src\models\Login;
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

class EsqueceuSenhaController extends Controller {
    
    
    public function index() {
        $this->render('trocar-senha', ['base' => Config::BASE_DIR]);
    }

    
    public function rendernovasenha() {
        $this->render('nova-senha', ['base' => Config::BASE_DIR]);
    }

  
    public function enviarcod() { // Certifique-se de iniciar a sessão
        session_unset(); // Limpa todas as variáveis da sessão
        session_destroy(); // Destroi a sessão

        if (isset($_POST['email']) && filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)) {
            $email = $_POST['email'];

            $veremail = new EsqueceuSenha();

            $result = $veremail->verificaemail($_POST);
            // print_r($result);exit;

            if(empty($result['result'])){
                echo json_encode(array([
                    "success" => false,
                    "ret" => $result['result']
               ]));
               die;
            }

            // Gerar o código de recuperação (6 dígitos)
            $codigo = rand(100000, 999999);

            // Instanciando o PHPMailer
            $mail = new PHPMailer(true);

            try {
                // Configurações do servidor SMTP
                $mail->isSMTP();                                         // Usar SMTP
                $mail->Host = 'smtp.gmail.com';                     // Servidor SMTP
                $mail->SMTPAuth = true;                                   // Ativar autenticação SMTP
                $mail->Username = 'lucasricobonfim@gmail.com';                // Seu e-mail
                $mail->Password = 'mbnb ludq cleo msfs';                            // Sua senha
                // mbnb ludq cleo msfs
                $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;       // Usar TLS
                $mail->Port = 587;                                        // Porta SMTP (587 para TLS)

                // Remetente e destinatário
                $mail->setFrom('lucasricobonfim@gmail.com', 'Sistema');
                $mail->addAddress($email);                                // E-mail do destinatário

                // Definindo o conteúdo do e-mail
                $mail->isHTML(true);                                      // E-mail em formato HTML
                $mail->Subject = 'Código de Recuperação de Senha sistema';
                //  $mail->Body = "texte";
                $mail->Body ="<a href='http://localhost/agendamento-devolucao/public/nova-senha?codigo=$codigo'>Nova Senha</a>";
                // $mail->Body .="<a href='https://seusite.com/recuperar-senha?codigo=$codigo'></a>";
                // $mail->Body .="Clique aqui para recuperar sua senha</a>";
                // Enviar o e-mail
                $mail->send();

                // Armazenar o código em uma variável de sessão ou banco de dados
                session_start();
                $_SESSION['codigo_recuperacao'] = $codigo;
                $_SESSION['usuario'] = $result['result'][0];

                echo json_encode(array([
                    "success" => true,
                    "ret" => $codigo,
                ]));

                exit;
                // Você pode redirecionar o usuário para uma página onde ele inserirá o código

            } catch (Exception $e) {
                echo json_encode(array([
                    "success" => false,
                    "ret" => "Erro ao enviar o e-mail: {$mail->ErrorInfo}"
                ]));
                exit;
            }
        } else {
            echo json_encode(array([
                "success" => false,
                "ret" => "Email Invalido"
            ]));
            exit;
        }
    


    }

    public function novasenha() {
        $dados = [];

        $dados['idusuario'] = $_SESSION['usuario']['idusuario'];
        $dados['senha'] = md5($_POST['senha']); 

        $upt = new EsqueceuSenha();

        $result = $upt->alterarSenha($dados);

        // print_r($result);exit;
        if($result['sucesso']){
            session_unset(); 
            session_destroy(); 
            echo json_encode(array([
                "success" => true,
                "ret" => $result['result'],
            ]));
          
        }else{
            echo json_encode(array([
                "success" => false,
                "ret" => $result['result'],
            ]));
        }
        // print_r($_POST);
        // print_r($_SESSION);exit;

    }


}

// n g l q o h y a d g a u g k l t
// agendamentodevolucoes@gmail.com'