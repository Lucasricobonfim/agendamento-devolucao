<?php

namespace src\models;

use \core\Model;
use core\Database;
use PDO;
use PDOException;
use Throwable;

class Solicitacoes extends Model{
   
    public function getsolicitacoes(){
        try {
            $sql = Database::getInstance()->prepare("
                SELECT 
                    s.idsolicitacao, 
                    s.idcd, 
                    s.placa, 
                    s.quantidadenota, 
                    s.observacao, 
                    s.data, 
                    s.idsituacao, 
                    f.nome AS nome_transportadora
                FROM 
                    solicitacoes_agendamentos s
                LEFT JOIN 
                    filial f ON f.idtipofilial = 2 AND f.idfilial = s.idtransportadora; -- Buscando transportadora
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
                'result' =>'Falha ao buscar solicitações: ' . $error->getMessage()
            ];
        }
    }


}
