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
            $sql = Database::getInstance()->prepare("
                insert into filial (nome, cnpj_cpf, email, telefone, idsituacao, idtipofilial)
                select 
                    :nome
                    ,:cnpj_cpf
                    ,:email
                    ,:telefone
                    ,1
                    ,2;

                SELECT 1;
                
            ");
            $sql->bindValue(':nome', $nome);
            $sql->bindValue(':cnpj_cpf', $cnpj_cpf);
            $sql->bindValue(':email', $email);
            $sql->bindValue(':telefone', $telefone);

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
                SELECT CASE WHEN EXISTS(select 1 from filial where cnpj_cpf='$cnpj_cpf') then 1 else 0 end as existecpf
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
                select
                  t.*
                 ,case when t.idsituacao = 1 then 'Ativo' else 'Inativo' end as descricao
                from filial t
           ");
            $sql->execute();
            $result = $sql->fetchAll(PDO::FETCH_ASSOC);
            return $result;
        } catch (Throwable $error) {
            return 'Falha ao carregar as transportadoras ' .
                $error->getMessage();
        }
    }

    public function updateSituacao($id, $idsituacao)
    {

         try {
            $sql = Database::getInstance()->prepare("
                update filial
                    set idsituacao = $idsituacao
                where idfilial = $id;
           ");
            
            $sql->execute();
           
            return true;
        } catch (Throwable $error) {
            return 'Falha ao deletar a transportadora ' .
            $error->getMessage();
        }
    }

    public function editar($idfilial, $nome, $cnpj_cpf, $email, $telefone){

        $idfilial =  intval($idfilial);
          try {
            $sql = Database::getInstance()->prepare("
                update filial
                    set nome = '$nome',
                    cnpj_cpf = '$cnpj_cpf',
                    email = '$email',
                    telefone = '$telefone'
                where idfilial = $idfilial;
            ");
            $sql->execute();
            return true;
        } catch (Throwable $error) {
            return 'Falha ao atualizar a transportadora ' .
            $error->getMessage();
        }
    }
}
