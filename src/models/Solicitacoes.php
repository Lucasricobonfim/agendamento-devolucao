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

        $sql = $_SESSION['idgrupo'] == 1 ? 
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
                oi.observacoes,
                oi.dataoperacao,
                oi.situacao_operacao,
                DATE_FORMAT(s.dataoperacao, '%d/%m/%Y') as dataagendamento
            FROM solicitacoes_agendamentos s
            INNER JOIN filial f ON f.idtipofilial = 2 AND f.idfilial = s.idtransportadora
            INNER JOIN filial fd ON fd.idtipofilial = 3 AND fd.idfilial = s.idcd
            LEFT JOIN situacao st ON st.idsituacao = s.idsituacao
            LEFT JOIN (
                SELECT
                    ms.idsolicitacao,
                    GROUP_CONCAT(ms.observacao SEPARATOR '|') AS observacoes,
                    GROUP_CONCAT(DATE_FORMAT(ms.dataoperacao, '%d/%m/%Y %H:%i:%s') SEPARATOR '|') AS dataoperacao,
                    GROUP_CONCAT(sos.situacao SEPARATOR '|') AS situacao_operacao
                FROM movimento_solicitacoes ms 
                LEFT JOIN situacao sos ON sos.idsituacao = ms.idsituacao
                GROUP BY ms.idsolicitacao
            ) AS oi ON oi.idsolicitacao = s.idsolicitacao
            WHERE s.idsituacao = :idsituacao
        "
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
                DATE_FORMAT(s.dataoperacao, '%d/%m/%Y') as dataagendamento
            FROM solicitacoes_agendamentos s
            INNER JOIN filial f ON f.idtipofilial = 2 AND f.idfilial = s.idtransportadora
            INNER JOIN filial fd ON fd.idtipofilial = 3 AND fd.idfilial = s.idcd
            LEFT JOIN situacao st ON st.idsituacao = s.idsituacao
            LEFT JOIN (
                SELECT
                    ms.idsolicitacao,
                    GROUP_CONCAT(ms.observacao SEPARATOR '|') AS observacoes,
                    GROUP_CONCAT(DATE_FORMAT(ms.dataoperacao, '%d/%m/%Y %H:%i:%s') SEPARATOR '|') AS dataoperacao,
                    GROUP_CONCAT(sos.situacao SEPARATOR '|') AS situacao_operacao
                FROM movimento_solicitacoes ms 
                LEFT JOIN situacao sos ON sos.idsituacao = ms.idsituacao
                GROUP BY ms.idsolicitacao
            ) AS oi ON oi.idsolicitacao = s.idsolicitacao
            WHERE s.idcd = :idfilial
              AND s.idsituacao = :idsituacao
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
                'result' => 'Falha ao buscar solicitações: ' . $error->getMessage()
            ];
        }
    }

    public function updatesolicitacao($dados){
        // Preparando os parâmetros
        $params = [
            "observacao" => $dados['observacao'],
            "idsolicitacao" => $dados['idsolicitacao'],
            "idsituacao" => $dados['idsituacao']
        ];
    
        // SQL para atualizar a solicitação e inserir na tabela de movimentações
        $sql = "
            UPDATE solicitacoes_agendamentos
            SET idsituacao = :idsituacao,
                observacao = :observacao
            WHERE idsolicitacao = :idsolicitacao;
    
            INSERT INTO movimento_solicitacoes (idsolicitacao, idsituacao, observacao, dataoperacao)
            SELECT
                :idsolicitacao,
                :idsituacao,
                :observacao,
                NOW();
        ";
    
        try {
            // Preparando a query
            $sql = Database::getInstance()->prepare($sql);
    
            // Bind dos parâmetros
            $sql->bindParam(':observacao', $params['observacao'], PDO::PARAM_STR);
            $sql->bindParam(':idsolicitacao', $params['idsolicitacao'], PDO::PARAM_INT);
            $sql->bindParam(':idsituacao', $params['idsituacao'], PDO::PARAM_INT);
    
            // Executando a query
            $sql->execute();
            $result = $sql->fetchAll(PDO::FETCH_ASSOC);
            // Retornando sucesso
            return [
                'sucesso' => true,
                'result' => $result
            ];
    
        } catch (Throwable $error) {
            // Em caso de erro, retornando falha
            return  [
                'sucesso' => false,
                'result' => 'Falha ao atualizar solicitação: ' . $error->getMessage()
            ];
        }
    }

}