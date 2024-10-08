<?php

namespace src\models;

use \core\Model;
use core\Database;
use PDO;
use PDOException;
use Throwable;

class Usuario extends Model
{
    public function cadastro($dados)
    {

        $sql = "insert into usuarios (nome, login, senha, idgrupo, idfilial, idsituacao)
                select 
                     ':nome'
                    ,':login'
                    ,':senha'
                    ,:idgrupo
                    ,:idfilial
                    ,1
                    ";
        $sql = $this->switchParams($sql, $dados);       
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
                'result' => 'Falha ao cadastrar: ' . $error->getMessage()         
            ] ;
        }
    }

    public function getusuarios(){
        try {
            $sql = Database::getInstance()->prepare("
            select 
                 u.idusuario
                ,u.nome
                ,u.login
                ,u.senha
                ,u.idgrupo
                ,u.idfilial
                ,g.descricao as grupo
                ,u.idsituacao
                ,case when u.idsituacao = 1 then '1 - Ativo' else '2 - Inativo' end as situacao
                ,coalesce( f.nome, 'Filial não cadastrada') as filial
            from usuarios u 
            left join grupos g on g.idgrupo = u.idgrupo
            left join filial f on f.idfilial = u.idfilial;
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
                'result' =>'Falha ao cadastrar: ' . $error->getMessage()
            ] ;
        }
    }

    public function editar($dados){


        $sql = "update usuarios 
                     set nome     = ':nome'
                        ,login    = ':login'
                        ,senha    = ':senha'
                        ,idgrupo  = :idgrupo
                        ,idfilial = :idfilial
                where idusuario =:idusuario";

        $sql = $this->switchParams($sql, $dados);

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
                'result' => 'Falha ao atualizar a usuario  ' .$error->getMessage()
            ];
        }
    }

    public function getFilialPorGrupo($dados){

          $sql = "select 
	                 f.idfilial
                    ,f.nome as filial
                   ,concat(f.idfilial, ' - ', f.nome) as descricao
                from filial f where f.idtipofilial = :idgrupo";

          $sql = $this->switchParams($sql, $dados);

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
                'result' => 'Falha ao bucar filial  ' .$error->getMessage()
            ];
        }
    }

    public function updateSituacao($id, $idsituacao)
    {

         try {
            $sql = Database::getInstance()->prepare("
                update usuarios
                    set idsituacao = $idsituacao
                where idusuario = $id;
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
                'result' => 'Falha ao atualizar situacao do usuario ' .$error->getMessage()
            ];
            
        }
    }

    
}
