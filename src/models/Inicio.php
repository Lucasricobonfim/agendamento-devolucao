<?php

namespace src\models;

use \core\Model;
use core\Database;
use PDO;
use PDOException;
use Throwable;

class Inicio extends Model
{

    public function getTotalSolicitacoes($dados)
    {

        if($dados['todos'] == 0 &&  $_SESSION['idgrupo'] == 1){
            $sql =  "   SELECT 
                            s.idsituacao
                            ,count(s.idsolicitacao) as qtd
                        FROM solicitacoes_agendamentos s
                        INNER JOIN filial f ON f.idtipofilial = 2 AND f.idfilial = s.idtransportadora
                        inner join filial fd on fd.idtipofilial = 3 and fd.idfilial = s.idcd
                        left join situacao st on st.idsituacao = s.idsituacao
                        group by s.idsituacao";
        }else if($dados['todos'] == 0 &&  $_SESSION['idgrupo'] == 2){

               $sql = '
                      SELECT 
                            s.idsituacao
                            ,count(s.idsolicitacao) as qtd
                        FROM solicitacoes_agendamentos s
                        INNER JOIN filial f ON f.idtipofilial = 2 AND f.idfilial = s.idtransportadora
                        inner join filial fd on fd.idtipofilial = 3 and fd.idfilial = s.idcd
                        left join situacao st on st.idsituacao = s.idsituacao
                        where s.idtransportadora ='.$_SESSION["idfilial"].'
                        group by s.idsituacao';

        }else if ($dados['todos'] == 0 &&  $_SESSION['idgrupo'] == 3 ){
            $sql = '
                    SELECT 
                            s.idsituacao
                           ,count(s.idsolicitacao) as qtd
                    FROM solicitacoes_agendamentos s
                    INNER JOIN filial f ON f.idtipofilial = 2 AND f.idfilial = s.idtransportadora
                    inner join filial fd on fd.idtipofilial = 3 and fd.idfilial = s.idcd
                    left join situacao st on st.idsituacao = s.idsituacao
                    where s.idcd ='.$_SESSION["idfilial"].'
                    group by s.idsituacao';
            
        }else{
            $sql = "
            SELECT 
				 s.idsituacao
                ,count(s.idsolicitacao) as qtd
            FROM solicitacoes_agendamentos s
            INNER JOIN filial f ON f.idtipofilial = 2 AND f.idfilial = s.idtransportadora
            inner join filial fd on fd.idtipofilial = 3 and fd.idfilial = s.idcd
            left join situacao st on st.idsituacao = s.idsituacao
             where  ( :idsituacao = 99 or   s.idsituacao = :idsituacao )
              and s.idcd = :idcd
              and s.idtransportadora = :idtransportadora
              and s.data BETWEEN ':datainicio' and ':datafim' 
            group by s.idsituacao";
        }

      


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
                'result' => 'Falha ao buscar total solicitações: ' . $error->getMessage()
            ];
        }
    }


    public function getSituacao()
    {
        $sql = "
            SELECT
                s.idsituacao
                ,s.situacao
            from situacao s

            UNION ALL

            SELECT
                99  as idsituacao
                ,'TODOS' as situacao

            
            
        ";

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
                'result' => 'Falha ao buscar situações: ' . $error->getMessage()
            ];
        }
    }


    public function getTransportadoraDash($dados)
    {
        $dados['adm'] = $_SESSION['idgrupo'];

        $dados['idfilial'] = $_SESSION['idfilial'];

        $sql = "	
            	select 
	                 f.idfilial as idtransportadora
                    ,f.nome as descricao
                    ,concat(f.idfilial, ' - ', f.nome) as descricao
                from filial f where f.idtipofilial = :idgrupo and f.idsituacao =1
                and (:adm in (1 , 3)   or f.idfilial = :idfilial)
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
                'result' => 'Falha ao buscar transportadora: ' . $error->getMessage()
            ];
        }
    }


    public function getCdDash($dados)
    {
        $dados['adm'] = $_SESSION['idgrupo'];

        $dados['idfilial'] = $_SESSION['idfilial'];

        $sql = "	
            	select 
	                 f.idfilial as idcd
                    ,f.nome as descricao
                    ,concat(f.idfilial, ' - ', f.nome) as descricao
                from filial f where f.idtipofilial = :idgrupo and f.idsituacao =1
                and ( :adm in( 1, 2) or f.idfilial = :idfilial)
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
                'result' => 'Falha ao buscar cd: ' . $error->getMessage()
            ];
        }
    }




    public function getDashBoard($dados)
    {



        if($dados['todos'] == 0 &&  $_SESSION['idgrupo'] == 1){
            $sql =  " SELECT 
                            s.idsolicitacao, 
                            s.idcd, 
                            s.placa, 
                            s.quantidadenota, 
                            s.observacao, 
                            DATE_FORMAT(s.data, '%d/%m/%Y') as data,
                            s.idsituacao,   
                            st.situacao,
                            f.nome AS nome_transportadora,
                            fd.nome as nome_cd,
                            fd.idfilial as idcd,
                            (SELECT COUNT(*) FROM solicitacoes_agendamentos s2  WHERE s2.idsituacao = s.idsituacao) AS qtd_situacao
                        FROM solicitacoes_agendamentos s
                        INNER JOIN filial f ON f.idtipofilial = 2 AND f.idfilial = s.idtransportadora
                        inner join filial fd on fd.idtipofilial = 3 and fd.idfilial = s.idcd
                        left join situacao st on st.idsituacao = s.idsituacao";
        }else if($dados['todos'] == 0 &&  $_SESSION['idgrupo'] == 2){

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
                        f.nome AS nome_transportadora,
                        fd.nome as nome_cd,
                        fd.idfilial as idcd,
                        (SELECT COUNT(*) FROM solicitacoes_agendamentos s2  WHERE s2.idsituacao = s.idsituacao) AS qtd_situacao
                    FROM solicitacoes_agendamentos s
                    INNER JOIN filial f ON f.idtipofilial = 2 AND f.idfilial = s.idtransportadora
                    inner join filial fd on fd.idtipofilial = 3 and fd.idfilial = s.idcd
                    left join situacao st on st.idsituacao = s.idsituacao
                    where s.idtransportadora =".$_SESSION['idfilial'];

        }else if ($dados['todos'] == 0 &&  $_SESSION['idgrupo'] == 3 ){
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
                            f.nome AS nome_transportadora,
                            fd.nome as nome_cd,
                            fd.idfilial as idcd,
                            (SELECT COUNT(*) FROM solicitacoes_agendamentos s2  WHERE s2.idsituacao = s.idsituacao) AS qtd_situacao
                        FROM solicitacoes_agendamentos s
                        INNER JOIN filial f ON f.idtipofilial = 2 AND f.idfilial = s.idtransportadora
                        inner join filial fd on fd.idtipofilial = 3 and fd.idfilial = s.idcd
                        left join situacao st on st.idsituacao = s.idsituacao
                        where s.idcd =".$_SESSION['idfilial'];
            
        }else{
            $sql = 
            "	
               SELECT 
                s.idsolicitacao, 
                s.idcd, 
                s.placa, 
                s.quantidadenota, 
                s.observacao, 
                DATE_FORMAT(s.data, '%d/%m/%Y') as data,
                s.idsituacao,   
                st.situacao,
                f.nome AS nome_transportadora,
                fd.nome as nome_cd,
                fd.idfilial as idcd,
                (SELECT COUNT(*) FROM solicitacoes_agendamentos s2  WHERE s2.idsituacao = s.idsituacao) AS qtd_situacao
            FROM solicitacoes_agendamentos s
            INNER JOIN filial f ON f.idtipofilial = 2 AND f.idfilial = s.idtransportadora
            inner join filial fd on fd.idtipofilial = 3 and fd.idfilial = s.idcd
            left join situacao st on st.idsituacao = s.idsituacao
            where  ( :idsituacao = 99 or   s.idsituacao = :idsituacao )
              and s.idcd = :idcd
              and s.idtransportadora = :idtransportadora
              and s.data BETWEEN ':datainicio' and ':datafim' 
            ";
        }


        
            

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
                'result' => 'Falha ao buscar cd: ' . $error->getMessage()
            ];
        }
    }
}
