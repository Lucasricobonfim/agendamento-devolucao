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

    
    public function verificaPlaca($dados)
    {
        $sql = "
                SELECT CASE WHEN EXISTS ( select 1 from solicitacoes_agendamentos sa where sa.placa = ':placa'and sa.data = ':data') then 1 else 0 end existeplaca
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
                'result' => 'Falha ao verificar se existe o mesmo caminhão para o mesmo dia ' .$error->getMessage()
            ];
            
                
        }
    }
    // fim cadastro

    public function getAgendamentos($dados)
    {
        $sql = "                
                select 
                         concat( fcd.idfilial, ' - ', fcd.nome) as centro_distribuicao
                        ,concat( ftr.idfilial, ' - ', ftr.nome) as transportadora
                        ,sa.placa
                        ,sa.quantidadenota
                        ,sa.observacao
                        ,DATE_FORMAT(sa.data, '%d/%m/%Y') as data
                        ,st.idsituacao
                        ,concat( st.idsituacao ,' - ',st.situacao) as situacao
                        ,sa.idsolicitacao
                from solicitacoes_agendamentos sa 
                left join filial fcd on fcd.idfilial = sa.idcd
                left join filial ftr on ftr.idfilial = sa.idtransportadora
                left join situacao st on  st.idsituacao = sa.idsituacao
                #where sa.idtransportadora = :idtransportadora
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
                'result' => 'Falha ao buscar os agendamentos' .$error->getMessage()
            ];
            
                
        }
    }


}
