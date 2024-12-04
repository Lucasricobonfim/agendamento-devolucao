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
            values 
                (:nome, :login, :senha, :idgrupo, :idfilial, 1)";

        try {
            $sql = Database::getInstance()->prepare($sql);

            $sql->bindParam(':nome', $dados['nome']);
            $sql->bindParam(':login', $dados['login']);
            $sql->bindParam(':senha', $dados['senha']);
            $sql->bindParam(':idgrupo', $dados['idgrupo']);
            $sql->bindParam(':idfilial', $dados['idfilial']);

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
            ];
        }
    }

    public function getusuarios()
    {
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
                ,case when u.idsituacao = 1 then 'Ativo' else 'Inativo' end as descricao
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
                'result' => 'Falha ao cadastrar: ' . $error->getMessage()
            ];
        }
    }

    public function editar($dados)
    {
        try {
            if (!empty($dados['senha'])) {
                $sql = "UPDATE usuarios 
                     SET nome     = :nome,
                         login    = :login,
                         senha    = :senha,
                         idgrupo  = :idgrupo,
                         idfilial = :idfilial
                     WHERE idusuario = :idusuario";
            } else {
                $sql = "UPDATE usuarios 
                     SET nome     = :nome,
                         login    = :login,
                         idgrupo  = :idgrupo,
                         idfilial = :idfilial
                     WHERE idusuario = :idusuario";
            }

            $stmt = Database::getInstance()->prepare($sql);

            $stmt->bindParam(':nome', $dados['nome'], PDO::PARAM_STR);
            $stmt->bindParam(':login', $dados['login'], PDO::PARAM_STR);
            $stmt->bindParam(':idgrupo', $dados['idgrupo'], PDO::PARAM_INT);
            $stmt->bindParam(':idfilial', $dados['idfilial'], PDO::PARAM_INT);
            $stmt->bindParam(':idusuario', $dados['idusuario'], PDO::PARAM_INT);

            if (!empty($dados['senha'])) {
                $stmt->bindParam(':senha', $dados['senha'], PDO::PARAM_STR);
            }

            $stmt->execute();
            $result = $stmt->fetchAll(PDO::FETCH_ASSOC);

            return [
                'sucesso' => true,
                'result' => $result
            ];
        } catch (Throwable $error) {
            return  [
                'sucesso' => false,
                'result' => 'Falha ao atualizar a usuario  ' . $error->getMessage()
            ];
        }
    }

    public function getFilialPorGrupo($dados)
    {
        try {
            $sql = "
            SELECT 
                f.idfilial,
                f.nome AS filial,
                CONCAT(f.idfilial, ' - ', f.nome) AS descricao
            FROM filial f
            WHERE f.idtipofilial = :idgrupo 
            AND f.idsituacao = 1
        ";

            $stmt = Database::getInstance()->prepare($sql);
            $stmt->bindParam(':idgrupo', $dados['idgrupo'], PDO::PARAM_INT);

            $stmt->execute();
            $result = $stmt->fetchAll(PDO::FETCH_ASSOC);

            return [
                'sucesso' => true,
                'result' => $result
            ];
        } catch (Throwable $error) {
            return  [
                'sucesso' => false,
                'result' => 'Falha ao bucar filial  ' . $error->getMessage()
            ];
        }
    }

    public function updateSituacao($id, $idsituacao)
    {
        try {
            $sql = Database::getInstance()->prepare("
            UPDATE usuarios
            SET idsituacao = :idsituacao
            WHERE idusuario = :id
        ");

            $sql->bindParam(':idsituacao', $idsituacao, PDO::PARAM_INT);
            $sql->bindParam(':id', $id, PDO::PARAM_INT);

            $sql->execute();
            $result = $sql->fetchAll(PDO::FETCH_ASSOC);
            return [
                'sucesso' => true,
                'result' => $result
            ];
        } catch (Throwable $error) {
            return [
                'sucesso' => false,
                'result' => 'Falha ao atualizar situação do usuário.' . $error->getMessage()
            ];
        }
    }

    public function verificaLogin($dados)
    {

        try {
            $sql = Database::getInstance()->prepare("select u.idusuario, u.nome, u.idgrupo, u.idfilial, u.senha FROM usuarios u WHERE u.login = :login");
            $sql->bindParam(':login', $dados['login']);
            $sql->execute();
            $result = $sql->fetchAll(PDO::FETCH_ASSOC);
            return [
                'sucesso' => true,
                'result' => $result
            ];
        } catch (Throwable $error) {
            return  [
                'sucesso' => false,
                'result' => 'Falha ao verificar se existe login: ' . $error->getMessage()
            ];
        }
    }
}
