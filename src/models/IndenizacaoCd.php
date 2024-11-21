<?php

namespace src\models;

use \core\Model;
use core\Database;
use PDO;
use PDOException;
use Throwable;

class IndenizacaoCd extends Model
{

    public function getTransportadora()
    {
        try {
            $sql = Database::getInstance()->prepare("
                select
                         t.idfilial
                        ,concat(t.idfilial, ' - ', t.nome) as descricao
                from filial t where t.idtipofilial = 2
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
                'result' => 'Falha ao buscar os centros de distribuicao ' . $error->getMessage()
            ];
        }
    }

    public function getNegocio()
    {
        try {
            $sql = Database::getInstance()->prepare("
                select
                    t.idfilial,
                    concat(t.idfilial, ' - ', t.nome) as descricao
                from
                    filial t
                where
                    t.idtipofilial IN (4, 5)
                    and t.idsituacao = 1;
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
                'result' => 'Falha ao buscar os centros de distribuicao ' . $error->getMessage()
            ];
        }
    }

    public function solicitar($dados)
    {
        try {
            // Inicia a transação
            $db = Database::getInstance();
            $db->beginTransaction();

            // SQL para a primeira inserção
            $sql1 = "
            INSERT INTO solicitacoes_indenizacao (idcd, numero_nota, numero_nota2, idnegocio, tipo_indenizacao, idtransportadora, data, observacao, idsituacao) 
            VALUES (:idcd, :numero_nota, :numero_nota2, :idnegocio, :tipo_indenizacao, :idtransportadora, :data, :observacao, 8)
        ";

            $stmt1 = $db->prepare($sql1);
            $stmt1->execute([
                ':idcd' => $dados['idcd'],
                ':numero_nota' => $dados['numero_nota'],
                ':numero_nota2' => $dados['numero_nota2'],
                ':idnegocio' => $dados['idnegocio'],
                ':tipo_indenizacao' => $dados['tipo_indenizacao'],
                ':idtransportadora' => $dados['idtransportadora'],
                ':data' => $dados['data'],
                ':observacao' => $dados['observacao'],
            ]);

            // Obtém o idsolicitacao gerado (correto)
            $idsolicitacao = $db->lastInsertId();

            // SQL para a segunda inserção (anexo)
            $sql2 = "
            INSERT INTO anexo (idsolicitacao, idsituacao, anexo, data)
            VALUES (:idsolicitacao, :idsituacao, :anexo, NOW())
        ";

            // Prepara e executa a segunda query
            $stmt2 = $db->prepare($sql2);
            // Itera sobre cada anexo e executa a inserção
            foreach ($dados['anexo']['name'] as $index => $nomeArquivo) {
                $stmt2->execute([
                    ':idsolicitacao' => $idsolicitacao, // Usa o idsolicitacao correto
                    ':idsituacao' => 8,
                    ':anexo' => $nomeArquivo,
                ]);
            }

            // SQL para a terceira inserção
            $sql3 = "
            INSERT INTO movimento_solicitacoes (idsolicitacao, idsituacao, observacao, dataoperacao)
            VALUES (:idsolicitacao, :idsituacao, :observacao, NOW())
        ";

            $stmt3 = $db->prepare($sql3);
            $stmt3->execute([
                ':idsolicitacao' => $idsolicitacao, 
                ':idsituacao' => 8,
                ':observacao' => $dados['observacao'],
            ]);

            // Confirma a transação
            $db->commit();

            return [
                'sucesso' => true,
                'result' => 'Solicitação de indenização realizada com sucesso!'
            ];
        } catch (Throwable $error) {
            if (isset($db)) {
                $db->rollBack();
            }

            return [
                'sucesso' => false,
                'result' => 'Falha ao solicitar indenização: ' . $error->getMessage()
            ];
        }
    }

    public function getanexo($dados)
    {
        try {
            $sql = Database::getInstance()->prepare("SELECT anexo FROM anexo WHERE idsolicitacao = :idsolicitacao");
            $sql->bindParam(':idsolicitacao', $dados['idsolicitacao'], PDO::PARAM_INT);  // Assume que você vai passar o id da solicitação
            $sql->execute();

            $imagens = [];
            while ($result = $sql->fetch(PDO::FETCH_ASSOC)) {
                // Adiciona o caminho completo para cada imagem
                $imagens[] = "upload/" . $result['anexo'];
            }

            if (empty($imagens)) {
                return [
                    'sucesso' => false,
                    'result' => 'Nenhum anexo encontrado para a solicitação fornecida.'
                ];
            }

            return [
                'sucesso' => true,
                'result' => $imagens
            ];
        } catch (Throwable $error) {
            return [
                'sucesso' => false,
                'result' => 'Falha ao buscar os anexos: ' . $error->getMessage()
            ];
        }
    }



    public function getindenizacao($dados)
    {
        $sql =
            "

                SELECT 
                    CONCAT(fc.idfilial, ' - ', fc.nome) AS centro_distribuicao,
                    CONCAT(f.idfilial, ' - ', f.nome) AS transportadora,
                    si.idcd,
                    si.idsolicitacao,
                    si.numero_nota,
                    si.numero_nota2,
                    si.idnegocio,
                    g.descricao AS nome_negocio,
                    si.tipo_indenizacao,
                    si.idtransportadora, 
                    si.observacao,
                    DATE_FORMAT(si.data, '%d/%m/%Y') AS data,
                    s.idsituacao,  
                    s.situacao AS descricao_situacao,
                    oi.observacoes,
                    oi.dataoperacao,
                    oi.situacao_operacao
                FROM 
                    solicitacoes_indenizacao si
                LEFT JOIN 
                    filial fc ON si.idcd = fc.idfilial
                LEFT JOIN 
                    filial f ON si.idtransportadora = f.idfilial
                LEFT JOIN 
                    filial fn ON si.idnegocio = fn.idfilial -- Filial correspondente ao idnegocio
                LEFT JOIN 
                    grupos g ON g.idgrupo = fn.idtipofilial -- Pega a descrição do grupo correto
                LEFT JOIN 
                    situacao s ON s.idsituacao = si.idsituacao
                LEFT JOIN (
                    SELECT
                        ms.idsolicitacao,
                        GROUP_CONCAT(ms.observacao SEPARATOR '|') AS observacoes,
                        GROUP_CONCAT(DATE_FORMAT(ms.dataoperacao, '%d/%m/%Y %H:%i:%s') SEPARATOR '|') AS dataoperacao,
                        GROUP_CONCAT(s.situacao SEPARATOR '|') AS situacao_operacao
                    FROM  
                        movimento_solicitacoes ms
                    LEFT JOIN 
                        situacao s ON s.idsituacao = ms.idsituacao
                    GROUP BY 
                        ms.idsolicitacao
                ) AS oi ON oi.idsolicitacao = si.idsolicitacao
                WHERE 
                    si.idsituacao IN (4,6,7,8,9,10) AND idcd = :idcd
        ";
        $sql = $this->switchParams($sql, $dados);
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
                'result' => 'Falha ao buscar os centros de distribuicao ' . $error->getMessage()
            ];
        }
    }
}
