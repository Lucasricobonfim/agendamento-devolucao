<?php

namespace src\models;

use \core\Model;
use core\Database;
use PDO;
use PDOException;
use Throwable;

class Transportadora extends Model
{
    public function cadastro($nome, $cnpj_cpf, $email, $telefone, $status)
    {

        try {

            // escrever sql para inserir transportadora na tabela 
            $sql = Database::getInstance()->prepare("insert into transportadoras (nome, cnpj_cpf, email, telefone, status)
                select :nome, :cnpj_cpf, :email, :telefone, :status;

                SELECT 1;
                
            ");
            $sql->bindValue(':nome', $nome);
            $sql->bindValue(':cnpj_cpf', $cnpj_cpf);
            $sql->bindValue(':email', $email);
            $sql->bindValue(':telefone', $telefone);
            $sql->bindValue(':status', $status);
            
            $sql->execute();
            
            return true;

        } catch (Throwable $error) {
            return 'Falha ao cadastrar: ' . $error->getMessage();
        }
    }

    public function verificarCpf_cnpj($cnpj_cpf)
    {

        try {
            $sql = Database::getInstance()->prepare("
                SELECT CASE WHEN EXISTS(select 1 from transportadoras where cnpj_cpf='$cnpj_cpf') then 1 else 0 end as existecpf
           ");
            $sql->execute();
            $result = $sql->fetchAll(PDO::FETCH_ASSOC);
            return $result;
        } catch (Throwable $error) {
            return 'Falha ao cadastrar o transportadora: ' .
                $error->getMessage();
        }
    }


    public function getTransportadoras()
    {

        try {
            $sql = Database::getInstance()->prepare("
                select * from transportadoras
           ");
            $sql->execute();
            $result = $sql->fetchAll(PDO::FETCH_ASSOC);
            return $result;
        } catch (Throwable $error) {
            return 'Falha ao carregar as transportadoras ' .
                $error->getMessage();
        }
    }

}
