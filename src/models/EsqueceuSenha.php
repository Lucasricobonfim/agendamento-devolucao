<?php

namespace src\models;

use \core\Model;
use core\Database;
use PDO;
use PDOException;
use Throwable;

class EsqueceuSenha extends Model
{
    public function verificaemail($dados)
    {       // and senha = ':senha'
        $sql = "select u.idusuario, u.email  FROM usuarios u WHERE u.email = ':email' and u.idsituacao = 1 ";
        $sql= $this->switchParams($sql, $dados);
        try {
            $sql = Database::getInstance()->prepare($sql);
            $sql->execute();
            $result = $sql->fetchAll(PDO::FETCH_ASSOC);
            return [
                'sucesso' => true,
                'result' => $result
            ];

        } catch (Throwable $error) {
            return  [
                'sucesso' => false,
                'result' => 'Falha ao verificar email: ' . $error->getMessage()         
            ] ;
        }
    }

    public function alterarSenha($dados)
    {       // and senha = ':senha'
        // $sql = ;
        // $sql= $this->switchParams($sql, $dados);

        // print_r($sql);exit;
        try {
            $sql = Database::getInstance()->prepare("update usuarios set senha = :senha where idusuario = :idusuario");
            $sql->bindParam(':senha', $dados['senha']);
            $sql->bindParam(':idusuario', $dados['idusuario']);
            $sql->execute();
            $result = $sql->fetchAll(PDO::FETCH_ASSOC);
            return [
                'sucesso' => true,
                'result' => $result
            ];

        } catch (Throwable $error) {
            return  [
                'sucesso' => false,
                'result' => 'Falha ao trocar a senha: ' . $error->getMessage()         
            ] ;
        }
    }
}
