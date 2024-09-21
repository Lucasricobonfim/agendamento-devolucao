<?php

namespace src\models;

use \core\Model;
use core\Database;
use PDO;
use PDOException;
use Throwable;

class Usuario extends Model
{
    public function cadastro($nome, $login, $senha, $idgrupo)
    {
        try {
            $sql = Database::getInstance()->prepare("
                insert into usuarios (nome, login, senha, idgrupo)
                select 
                    :nome
                    ,:login
                    ,:senha
                    ,:idgrupo;

                
                
            ");
            $sql->bindValue(':nome', $nome);
            $sql->bindValue(':login', $login);
            $sql->bindValue(':senha', $senha);
            $sql->bindValue(':idgrupo', $idgrupo);

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
                SELECT * FROM usuarios;
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

    
}
