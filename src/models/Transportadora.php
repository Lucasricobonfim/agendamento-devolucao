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
                    ,2
            ");
            $sql->bindValue(':nome', $nome);
            $sql->bindValue(':cnpj_cpf', $cnpj_cpf);
            $sql->bindValue(':email', $email);
            $sql->bindValue(':telefone', $telefone);

            $sql->execute();
            $result = $sql->fetchAll(PDO::FETCH_ASSOC);

            return [
                'sucesso' => true,
                'result' => $result
            ];
        } catch (Throwable $error) {
            return  [
                'sucesso' => false,
                'result' => 'Falha ao cadastrar: ' . $error->getMessage()         
            ] ;

        }
    }

    public function verificarCpf_cnpj($cnpj_cpf)
    {
        try {
            $sql = Database::getInstance()->prepare("
                SELECT CASE WHEN EXISTS(SELECT 1 FROM filial WHERE cnpj_cpf = :cnpj_cpf) THEN 1 ELSE 0 END AS existecpf
            ");
            $sql->bindValue(':cnpj_cpf', $cnpj_cpf);
            $sql->execute();
            $result = $sql->fetchAll(PDO::FETCH_ASSOC);

            return [
                'sucesso' => true,
                'result' => $result
            ];
        } catch (Throwable $error) {
            return  [
                'sucesso' => false,
                'result' => 'Falha ao verificar CNPJ existente: ' . $error->getMessage()
            ];
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
                where t.idtipofilial = 2
           ");
            $sql->execute();
            $result = $sql->fetchAll(PDO::FETCH_ASSOC);

            return [
                'sucesso' => true,
                'result' => $result
            ];
        } catch (Throwable $error) {
            return  [
                'sucesso' => false,
                'result' => 'Falha ao buscar as transportadoras ' .$error->getMessage()
            ];
            
                
        }
    }

    public function updateSituacao($id, $idsituacao)
    {

         try {
            $sql = Database::getInstance()->prepare("
                update filial
                    set idsituacao = :idsituacao
                where idfilial = :id;
           ");
            $sql->bindValue(':idsituacao', $idsituacao, PDO::PARAM_INT);
            $sql->bindValue(':id', $id, PDO::PARAM_INT);
            
            $sql->execute();
            $result = $sql->fetchAll(PDO::FETCH_ASSOC);
            return [
                'sucesso' => true,
                'result' => $result
            ];
        } catch (Throwable $error) {
            return  [
                'sucesso' => false,
                'result' => 'Falha ao atualizar situacao da transportadora ' .$error->getMessage()
            ];
            
        }
    }

    public function editar($idfilial, $nome, $cnpj_cpf, $email, $telefone)
    {
        try {
            $sql = Database::getInstance()->prepare("
                UPDATE filial
                SET nome = :nome,
                    cnpj_cpf = :cnpj_cpf,
                    email = :email,
                    telefone = :telefone
                WHERE idfilial = :idfilial
            ");
            $sql->bindValue(':nome', $nome);
            $sql->bindValue(':cnpj_cpf', $cnpj_cpf);
            $sql->bindValue(':email', $email);
            $sql->bindValue(':telefone', $telefone);
            $sql->bindValue(':idfilial', $idfilial);

            $sql->execute();
            $result = $sql->fetchAll(PDO::FETCH_ASSOC);
            return [
                'sucesso' => true,
                'result' => $result
            ];
        } catch (Throwable $error) {
            return  [
                'sucesso' => false,
                'result' => 'Falha ao atualizar a transportadora: ' . $error->getMessage()
            ];
        }
    }
}
