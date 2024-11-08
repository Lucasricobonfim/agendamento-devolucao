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



        $sql =
          $_SESSION['idgrupo'] == 1 ?

          "SELECT 
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
                oi.observacoes,
                oi.dataoperacao,
                oi.situacao_operacao,
                s.dataoperacao as dataagendamento
                
            FROM solicitacoes_agendamentos s
            INNER JOIN filial f ON f.idtipofilial = 2 AND f.idfilial = s.idtransportadora
            inner join filial fd on fd.idtipofilial = 3 and fd.idfilial = s.idcd
            left join situacao st on st.idsituacao = s.idsituacao
            left join(
                SELECT
                	ms.idsolicitacao
                	,GROUP_CONCAT(ms.observacao SEPARATOR '|') AS observacoes
                	,GROUP_CONCAT(ms.dataoperacao SEPARATOR '|') AS dataoperacao
                	,GROUP_CONCAT(sos.situacao SEPARATOR '|') AS situacao_operacao
                from  movimento_solicitacoes ms 
                left join situacao sos on sos.idsituacao = ms.idsituacao
                GROUP BY ms.idsolicitacao
            )  AS oi ON  oi.idsolicitacao = s.idsolicitacao
            where s.idsituacao = :idsituacao"
        :
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

                oi.observacoes,
                oi.dataoperacao,
                oi.situacao_operacao,
                s.dataoperacao as dataagendamento
            FROM solicitacoes_agendamentos s
            INNER JOIN filial f ON f.idtipofilial = 2 AND f.idfilial = s.idtransportadora
            inner join filial fd on fd.idtipofilial = 3 and fd.idfilial = s.idcd
            left join situacao st on st.idsituacao = s.idsituacao
            left join(
                SELECT
                	ms.idsolicitacao
                	,GROUP_CONCAT(ms.observacao SEPARATOR '|') AS observacoes
                	,GROUP_CONCAT(ms.dataoperacao SEPARATOR '|') AS dataoperacao
                	,GROUP_CONCAT(sos.situacao SEPARATOR '|') AS situacao_operacao
                from  movimento_solicitacoes ms 
                left join situacao sos on sos.idsituacao = ms.idsituacao
                GROUP BY ms.idsolicitacao
            )  AS oi ON  oi.idsolicitacao = s.idsolicitacao
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
          where idsolicitacao = :idsolicitacao;


          insert into movimento_solicitacoes (idsolicitacao, idsituacao, observacao, dataoperacao )

          SELECT
             :idsolicitacao
            ,:idsituacao
            ,':observacao'
            ,now();
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
                'result' =>'Falha ao buscar solicitações: ' . $error->getMessage()
            ];
        }
    }


    public function teste($dados){
        
        // print_r($dados);exit;
        // $params = [
        //     "idusuario" => $dados['idusuario']
        // ];

        // $sql = "
        //   select * from usuarios a where a.idusuario = :idusuario 
        // ";
        // // $sql = $this->switchParams($sql, $dados );
        // print_r($sql);
        // exit;
        try {
            $sql = Database::getInstance()->prepare('select * from usuarios a where a.idusuario = :idusuario');
            $sql->bindValue(':idusuario', $dados['idusuario']);
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
