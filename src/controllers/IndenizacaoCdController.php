<?php

namespace src\controllers;

use \core\Controller;
use \src\Config;
use src\models\IndenizacaoCd;

class IndenizacaoCdController extends Controller
{

    public function index()
    {
        $this->render('indenizacao-cd', ['base' => Config::BASE_DIR]);
    }

    public function getTransportadora()
    {
        $agn = new IndenizacaoCd();
        $ret = $agn->getTransportadora();

        if ($ret['sucesso'] == false) {
            echo json_encode(array([
                "success" => false,
                "ret" => $ret['result']
            ]));
            die;
        } else {
            echo json_encode(array([
                "success" => true,
                "ret" => $ret['result']
            ]));
            die;
        }
    }

    public function getNegocio()
    {
        $agn = new IndenizacaoCd();
        $ret = $agn->getNegocio();

        if ($ret['sucesso'] == false) {
            echo json_encode(array([
                "success" => false,
                "ret" => $ret['result']
            ]));
            die;
        } else {
            echo json_encode(array([
                "success" => true,
                "ret" => $ret['result']
            ]));
            die;
        }
    }

    public function solicitar()
    {
        // print_r($_FILES);
        // exit;

        $totalFiles = count($_FILES['anexo']['name']); // Conta o número de arquivos enviados
        $diretorio = dirname(__DIR__) . "/upload/"; // Caminho absoluto
        
        // Verifica se a pasta de upload existe
        if (!is_dir($diretorio)) {
            mkdir($diretorio, 0777, true); // Cria a pasta caso não exista
        }

        // Itera sobre os arquivos enviados
        for ($i = 0; $i < $totalFiles; $i++) {
            $extensao = strtolower(pathinfo($_FILES['anexo']['name'][$i], PATHINFO_EXTENSION));
            $novo_nome = md5(time() . $i) . '.' . $extensao;

            // Move o arquivo para o diretório de upload
            if (move_uploaded_file($_FILES['anexo']['tmp_name'][$i], $diretorio . $novo_nome)) {
                // Insere o nome do arquivo no banco de dados
                // $sql_code = "INSERT INTO anexo (anexo, data) VALUES (:anexo, NOW())";
                // $stmt = $pdo->prepare($sql_code);
                // $stmt->bindParam(':anexo', $novo_nome);

                // if (!$stmt->execute()) {
                //     echo "Erro ao registrar o arquivo no banco de dados.";
                // }
            } else {
                echo "Erro ao mover o arquivo " . $_FILES['anexo']['name'][$i] . " para o diretório de upload.";
            }
        }

        $dados = [];

        $dados['numero_nota'] = $_POST['numero_nota'];
        $dados['numero_nota2'] = $_POST['numero_nota2'];
        $dados['idnegocio'] = $_POST['idnegocio'];
        $dados['tipo_indenizacao'] = $_POST['tipo_indenizacao'];
        $dados['idtransportadora'] = $_POST['idfilial'];
        $dados['anexo'] = $_FILES['anexo'];
        $dados['data'] = $_POST['data'];
        $dados['observacao'] = $_POST['observacao'];
        $dados['idcd'] = $_SESSION['idfilial'];
        

        $agn = new IndenizacaoCd();
        $ret = $agn->solicitar($dados);

        if ($ret['sucesso'] == false) {
            echo json_encode(array([
                "success" => false,
                "ret" => $ret['result']
            ]));
            die;
        } else {
            echo json_encode(array([
                "success" => true,
                "ret" => $ret['result']
            ]));
            die;
        }
    }

    public function getindenizacao()
    {
        $dados['idcd'] = $_SESSION['idfilial'];

        $cad = new IndenizacaoCd();
        $ret = $cad->getindenizacao($dados);

        if ($ret['sucesso'] == true) {
            echo json_encode(array([
                "success" => true,
                "ret" => $ret['result']
            ]));
            die;
        } else {
            echo json_encode(array([
                "success" => false,
                "ret" => $ret['result']
            ]));
            die;
        }
    }

    public function getanexo() {

        $dados['idsolicitacao'] = $_GET['idsolicitacao'];
        // print_r($dados);
        // exit;
    
        $cad = new IndenizacaoCd();
        $ret = $cad->getanexo($dados);

        if ($ret['sucesso'] == true) {
            echo json_encode(array([
                "success" => true,
                "ret" => $ret['result']
            ]));
            die;
        } else {
            echo json_encode(array([
                "success" => false,
                "ret" => $ret['result']
            ]));
            die;
        }
    }
}
