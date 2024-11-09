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
                insert into solicitacoes_agendamentos(idcd, placa, quantidadenota, observacao, idtransportadora, data, idsituacao)
                select
                     :idcd
                    ,':placa'
                    ,:quantidadenota
                    ,':observacao'
                    ,:idtransportadora
                    ,':data'
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
       
        $sql = 
        $_SESSION['idgrupo'] == 1 ? 
        "
                select 
                         concat( fcd.idfilial, ' - ', fcd.nome) as centro_distribuicao
                        ,concat( ftr.idfilial, ' - ', ftr.nome) as transportadora
                        ,sa.placa
                        ,sa.quantidadenota
                        ,sa.observacao
                        ,DATE_FORMAT(sa.data, '%d/%m/%Y') as data
                        ,st.idsituacao
                        ,st.situacao as situacao
                        ,sa.idsolicitacao
                        ,oi.observacoes
                        ,oi.dataoperacao
                        ,oi.situacao_operacao
                        ,DATE_FORMAT(sa.dataoperacao, '%d/%m/%Y') as dataagendamento
                from solicitacoes_agendamentos sa 
                left join filial fcd on fcd.idfilial = sa.idcd
                left join filial ftr on ftr.idfilial = sa.idtransportadora
                left join situacao st on st.idsituacao = sa.idsituacao
                left join(
                    SELECT
                        ms.idsolicitacao
                        ,GROUP_CONCAT(ms.observacao SEPARATOR '|') AS observacoes
                        ,GROUP_CONCAT( DATE_FORMAT(ms.dataoperacao, '%d/%m/%Y') SEPARATOR '|') AS dataoperacao
                        ,GROUP_CONCAT(sos.situacao SEPARATOR '|') AS situacao_operacao
                    from  movimento_solicitacoes ms 
                    left join situacao sos on sos.idsituacao = ms.idsituacao
                    GROUP BY ms.idsolicitacao
                )  AS oi ON  oi.idsolicitacao = sa.idsolicitacao
                where sa.idsituacao = :idsituacao
        "
        :
        "                
                select 
                         concat( fcd.idfilial, ' - ', fcd.nome) as centro_distribuicao
                        ,concat( ftr.idfilial, ' - ', ftr.nome) as transportadora
                        ,sa.placa
                        ,sa.quantidadenota
                        ,sa.observacao
                        ,DATE_FORMAT(sa.data, '%d/%m/%Y') as data
                        ,st.idsituacao
                        ,st.situacao as situacao
                        ,sa.idsolicitacao
                        ,oi.observacoes
                        ,oi.dataoperacao
                        ,oi.situacao_operacao
                        ,DATE_FORMAT(sa.dataoperacao, '%d/%m/%Y') as dataagendamento
                from solicitacoes_agendamentos sa 
                left join filial fcd on fcd.idfilial = sa.idcd 
                left join filial ftr on ftr.idfilial = sa.idtransportadora
                left join situacao st on st.idsituacao = sa.idsituacao
                left join(
                    SELECT
                        ms.idsolicitacao
                        ,GROUP_CONCAT(ms.observacao SEPARATOR '|') AS observacoes
                        ,GROUP_CONCAT( DATE_FORMAT(ms.dataoperacao, '%d/%m/%Y') SEPARATOR '|') AS dataoperacao
                        ,GROUP_CONCAT(sos.situacao SEPARATOR '|') AS situacao_operacao
                    from  movimento_solicitacoes ms 
                    left join situacao sos on sos.idsituacao = ms.idsituacao
                    GROUP BY ms.idsolicitacao
                )  AS oi ON  oi.idsolicitacao = sa.idsolicitacao
                where sa.idsituacao = :idsituacao AND sa.idtransportadora = :idtransportadora;
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

    public function reagendar($dados)
    {

       
        try {
            $sql = Database::getInstance()->prepare("
            UPDATE solicitacoes_agendamentos
                set idsituacao = 1,
                data = :data,
                observacao = :observacao,
                dataoperacao = now()
            where idsolicitacao =  :idsolicitacao
            ");

            $sql->bindParam(':idsolicitacao', $dados['idsolicitacao']);
            $sql->bindParam(':data', $dados['data']);
            $sql->bindParam(':observacao', $dados['observacao']);
            $sql->execute();
            $result = $sql->fetchAll(PDO::FETCH_ASSOC);
            return [
                'sucesso' => true,
                'result' => $result
            ];
        } catch (Throwable $error) {
            return  [
                'sucesso' => false,
                'result' => 'Falha ao reagendar' .$error->getMessage()
            ];
            
                
        }
    }


}
