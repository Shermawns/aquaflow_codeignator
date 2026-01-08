<?php

class Produtos_model extends CI_Model
{

    public function get_all()
    {
        $this->db->order_by('qtd_estoque', 'DESC');
        $query = $this->db->get('tabela_produtos');
        return $query->result();
    }

    public function insert_prod($dados){
        $query = $this->db->insert('tabela_produtos', $dados);
        return $query;
    }

    public function edit_prod($id, $dados){
        $this->db->where('id', $id);
        return $this->db->update('tabela_produtos', $dados);
    }
}
