<?php

namespace app\models;
use app\core\Model;
use app\helpers\model\QueryHelper;

class Imovel extends Model{
    public function __construct() {
        parent::__construct();
        $this->table = "imoveis";
    }

    public function existe($data){
        $sql = "SELECT * FROM $this->table WHERE endereco = :endereco";
        $sqlParams = array("endereco" => $data['endereco']);
        $stmt = $this->db->prepare($sql);
        $stmt->execute($sqlParams);
        $result = $stmt->fetchAll(\PDO::FETCH_ASSOC);
        if(count($result) > 0)
            return true;

        return false;
    }

    public function all($offset, $limit){
        $sqlTotal = $this->db->query("SELECT count(imoveis.id) as total
                       FROM imoveis
                       INNER JOIN proprietarios ON proprietarios.id = imoveis.proprietario_id
                       INNER JOIN agenciadores ON agenciadores.id = imoveis.agenciador_id
                       ");
        $total = $sqlTotal->fetch(\PDO::FETCH_ASSOC);
        //$totalPages = $total['total'] / $limit;
        $paginas = QueryHelper::queryStringURL($total['total'], $offset, $limit);


        $sql = "SELECT imoveis.id as id,
                       imoveis.endereco as endereco,
                       proprietarios.email as proprietario,
                       agenciadores.email as agenciador
                       FROM imoveis
                       INNER JOIN proprietarios ON proprietarios.id = imoveis.proprietario_id
                       INNER JOIN agenciadores ON agenciadores.id = imoveis.agenciador_id LIMIT $limit OFFSET $offset";
        $query = $this->db->query($sql);
        $dados['dados'] = $query->fetchAll(\PDO::FETCH_ASSOC);
        return array_merge($dados, $paginas);
    }

    public function listagemDesafio(){
        $sql = "SELECT imoveis.id as id,
                       imoveis.endereco as endereco,
                       proprietarios.email as proprietario,
                       agenciadores.email as agenciador,
                       proprietarios.uf as uf_proprietario
                       FROM imoveis
                       INNER JOIN proprietarios ON proprietarios.id = imoveis.proprietario_id
                       INNER JOIN agenciadores ON agenciadores.id = imoveis.agenciador_id 
                       where imoveis.endereco like '%RJ%' and proprietarios.uf = 'SC'";
        $query = $this->db->query($sql);
        $dados['dados'] = $query->fetchAll(\PDO::FETCH_ASSOC);
        return $dados;
    }

}