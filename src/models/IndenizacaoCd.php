<?php

namespace src\models;

use \core\Model;
use core\Database;
use PDO;
use PDOException;
use Throwable;

class IndenizacaoCd extends Model{
   
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
                'result' => 'Falha ao buscar os centros de distribuicao ' .$error->getMessage()
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
                'result' => 'Falha ao buscar os centros de distribuicao ' .$error->getMessage()
            ];
            
                
        }
    }

    public function solicitar($dados)
    {
        $sql = "
                insert into solicitacoes_indenizacao(idcd, numero_nota, numero_nota2, idnegocio, tipo_indenizacao, idtransportadora, anexo, data, observacao, idsituacao)
                select
                     :idcd
                    ,:numero_nota
                    ,:numero_nota2
                    ,:idnegocio
                    ,':tipo_indenizacao'
                    ,:idtransportadora
                    ,':anexo'
                    ,':data'
                    ,':observacao'
                    ,8

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

    public function getindenizacao()
    {
        try {
            $sql = Database::getInstance()->prepare("
                
        
                SELECT 
                    si.idsolicitacao,
                    si.numero_nota,
                    si.numero_nota2,
                    si.idnegocio,
                    g.descricao AS nome_negocio, 
                    si.tipo_indenizacao,
                    f.nome AS nome_transportadora, 
                    si.idtransportadora, 
                    si.observacao,
                    DATE_FORMAT(si.data, '%d/%m/%Y') as data,
                    si.anexo,
                    s.idsituacao,  
                    s.situacao AS descricao_situacao
                from solicitacoes_indenizacao si
                left join filial f ON si.idtransportadora = f.idfilial
                left join filial fn ON si.idnegocio = fn.idfilial -- Filial correspondente ao idnegocio
                left join grupos g ON g.idgrupo = fn.idtipofilial -- Pega a descrição do grupo correto
                left join situacao s ON s.idsituacao = si.idsituacao;
                
        
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
    

    

}
