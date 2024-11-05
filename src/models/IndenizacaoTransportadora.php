<?php

namespace src\models;

use \core\Model;
use core\Database;
use PDO;
use PDOException;
use Throwable;

class IndenizacaoTransportadora extends Model{

    public function getindenizacao()
    {
        try {
            $sql = Database::getInstance()->prepare("
                
        
                SELECT 
                    si.idsolicitacao,
                    si.idtransportadora,
                    si.numero_nota,
                    si.numero_nota2,
                    si.idnegocio,
                    g.descricao AS nome_negocio, 
                    si.tipo_indenizacao,
                    f.nome AS nome_cd, 
                    si.idcd, 
                    si.observacao,
                    DATE_FORMAT(si.data, '%d/%m/%Y') as data,
                    si.anexo,
                    s.idsituacao,  
                    s.situacao AS descricao_situacao
                from solicitacoes_indenizacao si
                left join filial f ON si.idcd = f.idfilial
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

    public function updateindenizacao($dados){

        $params = [
            "observacao" => $dados['observacao'],
            "idsolicitacao" => $dados['idsolicitacao'],
            "idsituacao" => $dados['idsituacao']
        ];

        $sql = "
          update solicitacoes_indenizacao 
            set idsituacao = :idsituacao
           ,observacao = ':observacao'
          where idsolicitacao = :idsolicitacao
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
