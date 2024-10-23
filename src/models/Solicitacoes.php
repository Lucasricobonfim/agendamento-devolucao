<?php

namespace src\models;

use \core\Model;
use core\Database;
use PDO;
use PDOException;
use Throwable;

class Solicitacoes extends Model{
   
    public function getsolicitacoes($dados){

        
        
        $params = [
            "idfilial" => $_SESSION['idfilial'],
            "idsituacao" => $dados['idsituacao']
        ];

        $sql = "
            SELECT 
                s.idsolicitacao, 
                s.idcd, 
                s.placa, 
                s.quantidadenota, 
                s.observacao, 
                DATE_FORMAT(s.data, '%d/%m/%Y') as data,
                s.idsituacao,   
                st.situacao,
                f.nome AS nome_transportadora
            FROM solicitacoes_agendamentos s
            INNER JOIN filial f ON f.idtipofilial = 2 AND f.idfilial = s.idtransportadora
            left join situacao st on st.idsituacao = s.idsituacao
            where s.idcd = :idfilial
              and s.idsituacao = :idsituacao
        ";


        $sql = $this->switchParams($sql, $params );
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
                'result' =>'Falha ao buscar solicitações: ' . $error->getMessage()
            ];
        }
    }

    public function updatesolicitacao($dados){

        $params = [
            "observacao" => $dados['observacao'],
            "idsolicitacao" => $dados['idsolicitacao'],
            "idsituacao" => $dados['idsituacao']
        ];

        $sql = "
          update solicitacoes_agendamentos 
            set idsituacao = :idsituacao
           ,observacao = ':observacao'
          where idsolicitacao = :idsolicitacao
        ";
        $sql = $this->switchParams($sql, $params );

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
                'result' =>'Falha ao buscar solicitações: ' . $error->getMessage()
            ];
        }
    }


}
