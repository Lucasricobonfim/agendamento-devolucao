<?php

namespace src\models;

use \core\Model;
use core\Database;
use PDO;
use PDOException;
use Throwable;

class Agendamento extends Model{
   
    public function getCd()
    {
        try {
            $sql = Database::getInstance()->prepare("
                select
                         t.idfilial
                        ,concat(t.idfilial, ' - ', t.nome) as descricao
                from filial t where t.idtipofilial = 3
                and t.idsituacao = 1
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

    


    public function cadSolicitar($dados)
    {
        $sql = "
                insert into solicitacoes_agendamentos(idcd, placa, quantidadenota, observacao, idtransportadora, data)
                select
                     :idcd
                    ,':placa'
                    ,:quantidadenota
                    ,':observacao'
                    ,:idtransportadora
                    ,':data'
            
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
                'result' => 'Falha ao solicitar o agendamento ' .$error->getMessage()
            ];
            
                
        }
    }


}