<?php

namespace src\models;

use \core\Model;
use core\Database;
use PDO;
use PDOException;
use Throwable;

class Transportadora extends Model
{
    public function cadastro($nome, $cnpj_cpf, $email, $telefone)
    {

        try {
            // escrever sql para inserir transportadora na tabela 
            $sql = Database::getInstance()->prepare("");
            $sql->bindValue(':nome', $nome);
            $sql->bindValue(':cnpj_cpf', $cnpj_cpf);
            $sql->bindValue(':email', $email);
            $sql->bindValue(':telefone', $telefone);
            $sql->execute();
            $result = $sql->fetchAll(PDO::FETCH_ASSOC);

            return $result;

        } catch (Throwable $error) {
            return 'Falha ao logar ' . $error->getMessage();
        }
    }
}
