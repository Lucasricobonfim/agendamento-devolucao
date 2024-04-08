<?php

namespace src\models;

use \core\Model;
use core\Database;
use PDO;
use PDOException;
use Throwable;

class Login extends Model
{
    public function logar($login, $senha)
    {

        try {
            $sql = Database::getInstance()->prepare("SELECT * FROM usuarios WHERE login = :login and senha = :senha ");
            $sql->bindValue(':login', $login);
            $sql->bindValue(':senha', $senha);
            $sql->execute();
            $result = $sql->fetchAll(PDO::FETCH_ASSOC);

            if ($result == false) {
                echo json_encode(array([
                    "success" => false,
                    "result" => $result
                ]));
                die;
            }
            echo json_encode(array([
                "success" => true,
                "result" => $result
            ]));
            die;
        } catch (Throwable $error) {
            return 'Falha ao logar ' . $error->getMessage();
        }
    }
}
