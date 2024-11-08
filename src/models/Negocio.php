<?php

namespace src\models;

use \core\Model;
use core\Database;
use PDO;
use PDOException;
use Throwable;

class Negocio extends Model
{
    
    public function cadastro($nome, $email, $idtipofilial, $telefone){
        try{
            $sql = Database::getInstance()->prepare("
                insert into filial(nome, email, idtipofilial, telefone, idsituacao) 
                select
                    :nome
                    ,:email
                    ,:idtipofilial
                    ,:telefone
                    ,1
            ");
            $sql->bindParam(':nome', $nome);
            $sql->bindParam(':email', $email);
            $sql->bindParam(':idtipofilial', $idtipofilial);
            $sql->bindParam(':telefone', $telefone);

            $sql->execute();
            $result = $sql->fetchALL(PDO::FETCH_ASSOC);

            return[
                'sucesso' => true,
                'result' => $result
            ];

        }catch(Throwable $error){
            return[
                'sucesso' => false,
                'result' => 'Falha ao cadastrar: ' . $error->getMessage()
            ];
        }           

    }

    public function getnegocio()
    {
        try {
            $sql = Database::getInstance()->prepare("
                select 
                    f.idfilial,
                    f.nome,
                    f.email,
                    f.telefone,
                    f.idsituacao,
                    f.idtipofilial, 
                    case 
                        when f.idsituacao = 1 then 'Ativo' 
                        else 'Inativo' 
                    end as descricao_situacao,
                    g.descricao AS descricao_grupo
                from 
                    filial f
                join 
                    grupos g ON f.idtipofilial = g.idgrupo
                where 
                    f.idtipofilial IN (4, 5, 6, 7);
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

    public function editar($idfilial, $nome, $email, $idtipofilial, $telefone){

        $idfilial = intval($idfilial);
          try {
            $sql = Database::getInstance()->prepare("
                update filial
                    set nome = '$nome',
                    email = '$email',
                    idtipofilial = '$idtipofilial',
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

    public function updatesituacaoNegocio($id, $idsituacao)
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