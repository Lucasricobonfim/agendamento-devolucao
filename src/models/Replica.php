<?php

namespace src\models;

use \core\Model;
use core\Database;
use PDO;
use PDOException;
use Throwable;

class Replica extends Model{

    public function getreplica($dados)
    {
        $sql = $_SESSION['idgrupo'] == 1 ?
        "
            SELECT 
                si.idsolicitacao,
                si.numero_nota,
                si.numero_nota2,
                si.idnegocio,
                si.idtransportadora,
                fn.nome AS nome_negocio, 
                si.tipo_indenizacao,
                fc.nome AS nome_cd,
                ft.nome AS nome_transportadora,
                si.observacao,
                DATE_FORMAT(si.data, '%d/%m/%Y') AS data,
                s.idsituacao,
                oi.observacoes,
                oi.dataoperacao,
                oi.situacao_operacao,  
                s.situacao AS descricao_situacao
            FROM solicitacoes_indenizacao si
            LEFT JOIN filial fc ON si.idcd = fc.idfilial
            left join filial ft ON si.idtransportadora = ft.idfilial
            LEFT JOIN filial fn ON si.idnegocio = fn.idfilial -- Junção para pegar o idtipofilial
            LEFT JOIN grupos g ON g.idgrupo = fn.idtipofilial -- Pega a descrição do grupo correto
            LEFT JOIN situacao s ON s.idsituacao = si.idsituacao
            left join(
                    SELECT
                        ms.idsolicitacao
                        ,GROUP_CONCAT(ms.observacao SEPARATOR '|') AS observacoes
                        ,GROUP_CONCAT( DATE_FORMAT(ms.dataoperacao, '%d/%m/%Y %H:%i:%s') SEPARATOR '|') AS dataoperacao
                        ,GROUP_CONCAT(sos.situacao SEPARATOR '|') AS situacao_operacao
                    from  movimento_solicitacoes ms 
                    left join situacao sos on sos.idsituacao = ms.idsituacao
                    GROUP BY ms.idsolicitacao
                )  AS oi ON  oi.idsolicitacao = si.idsolicitacao
            where s.idsituacao = :idsituacao
        "
        :
        "
            SELECT 
                si.idsolicitacao,
                si.numero_nota,
                si.numero_nota2,
                si.idnegocio,
                si.idtransportadora,
                fn.nome AS nome_negocio, 
                si.tipo_indenizacao,
                fc.nome AS nome_cd,
                ft.nome AS nome_transportadora,
                si.observacao,
                DATE_FORMAT(si.data, '%d/%m/%Y') AS data,
                s.idsituacao,
                oi.observacoes,
                oi.dataoperacao,
                oi.situacao_operacao,  
                s.situacao AS descricao_situacao
            FROM solicitacoes_indenizacao si
            LEFT JOIN filial fc ON si.idcd = fc.idfilial
            left join filial ft ON si.idtransportadora = ft.idfilial
            LEFT JOIN filial fn ON si.idnegocio = fn.idfilial -- Junção para pegar o idtipofilial
            LEFT JOIN grupos g ON g.idgrupo = fn.idtipofilial -- Pega a descrição do grupo correto
            LEFT JOIN situacao s ON s.idsituacao = si.idsituacao
            left join(
                    SELECT
                        ms.idsolicitacao
                        ,GROUP_CONCAT(ms.observacao SEPARATOR '|') AS observacoes
                        ,GROUP_CONCAT( DATE_FORMAT(ms.dataoperacao, '%d/%m/%Y %H:%i:%s') SEPARATOR '|') AS dataoperacao
                        ,GROUP_CONCAT(sos.situacao SEPARATOR '|') AS situacao_operacao
                    from  movimento_solicitacoes ms 
                    left join situacao sos on sos.idsituacao = ms.idsituacao
                    GROUP BY ms.idsolicitacao
                )  AS oi ON  oi.idsolicitacao = si.idsolicitacao
            where s.idsituacao = :idsituacao AND si.idnegocio = :idnegocio
        "
        ;
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
            return [
                'sucesso' => false,
                'result' => 'Falha ao buscar os centros de distribuicao ' . $error->getMessage()
            ];
        }
    }

    public function updatereplica($dados){

        $params = [
            "observacao" => $dados['observacao'],
            "idsolicitacao" => $dados['idsolicitacao'],
            "idsituacao" => $dados['idsituacao']
        ];

        $sql = "
          update solicitacoes_indenizacao 
          set idsituacao = :idsituacao,
             observacao = ':observacao'               
          WHERE idsolicitacao = :idsolicitacao;

          insert into movimento_solicitacoes (idsolicitacao, idsituacao, observacao, dataoperacao )

          SELECT
             :idsolicitacao
            ,:idsituacao
            ,':observacao'
            ,now();
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
