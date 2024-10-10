<?php

namespace src\models;

use \core\Model;
use core\Database;
use PDO;
use PDOException;
use Throwable;

class CentroDistribuicao extends Model
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
                    ,3
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
                SELECT CASE WHEN EXISTS(select 1 from filial where cnpj_cpf='$cnpj_cpf') then 1 else 0 end as existecpf
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
                'result' =>'Falha ao verificar Cnpj existente: ' .$error->getMessage()
            ];
        }
    }

    public function getCentroDistribuicao()
    {
        try {
            $sql = Database::getInstance()->prepare("
                select
                  t.*
                 ,case when t.idsituacao = 1 then 'Ativo' else 'Inativo' end as descricao
                from filial t where t.idtipofilial = 3
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
                'result' => 'Falha ao buscar os centros de distribuicao ' .$error->getMessage()
            ];
            
                
        }
    }

    public function editar($idfilial, $nome, $cnpj_cpf, $email, $telefone){

        $idfilial = intval($idfilial);
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
            $result = $sql->fetchAll(PDO::FETCH_ASSOC);
            return [
                'sucesso' => true,
                'result' => $result
            ];
        } catch (Throwable $error) {
            return  [
                'sucesso' => false,
                'result' => 'Falha ao atualizar a Centro de distribuição  ' .$error->getMessage()
            ];
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
}