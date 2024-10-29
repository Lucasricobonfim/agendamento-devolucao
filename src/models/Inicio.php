<?php

namespace src\models;

use \core\Model;
use core\Database;
use PDO;
use PDOException;
use Throwable;

class Inicio extends Model{
   
    public function getTotalSolicitacoes(){

        
        
        $params = [
            "idfilial" => $_SESSION['idfilial']
        ];



        $sql =
          $_SESSION['idgrupo'] == 1 ?
            "   
            
            SELECT 
               count(1) as total
               ,1 as idtipofilial
            FROM solicitacoes_agendamentos s
            INNER JOIN filial f ON f.idtipofilial = 2 AND f.idfilial = s.idtransportadora
            inner join filial fd on fd.idtipofilial = 3 and fd.idfilial = s.idcd
            left join situacao st on st.idsituacao = s.idsituacao
            
        "
        :
        "
            SELECT 
                count(1) as total
                ,fd.idtipofilial
            FROM solicitacoes_agendamentos s
            INNER JOIN filial f ON f.idtipofilial = 2 AND f.idfilial = s.idtransportadora
            inner join filial fd on fd.idtipofilial = 3 and fd.idfilial = s.idcd
            left join situacao st on st.idsituacao = s.idsituacao
            where s.idcd = :idfilial
            

            
            union all
            
            SELECT 
                count(1) as total
                ,f.idtipofilial
            FROM solicitacoes_agendamentos s
            INNER JOIN filial f ON f.idtipofilial = 2 AND f.idfilial = s.idtransportadora
            inner join filial fd on fd.idtipofilial = 3 and fd.idfilial = s.idcd
            left join situacao st on st.idsituacao = s.idsituacao
            where s.idtransportadora = :idfilial
            
            
        ";


        $sql = $this->switchParams($sql, $params );
        // print_r($sql);exit;
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
                'result' =>'Falha ao buscar total solicitações: ' . $error->getMessage()
            ];
        }
    }

}
