<?php

class Funcionarios_model extends CI_Model
{
    public function get_all()
    {
        $query = $this->db->get('tabela_funcionarios');
        return $query->result();
    }

    public function insert_func($dados)
    {
        $query = $this->db->insert('tabela_funcionarios', $dados);
        return $query;
    }

    public function get_func($cpf)
    {
        $this->db->where('cpf', $cpf);
        $query = $this->db->get('tabela_funcionarios');
        return $query->row();
    }

    public function get_metas_by_funcionario($id)
    {
        $this->db->where('funcionario_meta', $id);
        $this->db->order_by('mes_meta', 'DESC');
        $query = $this->db->get('tabela_metas');
        return $query->result();
    }

    public function get_vendas_by_funcionario($id)
    {
        return [];
    }

    public function update_func($id, $dados)
    {
        $this->db->where('id', $id);
        return $this->db->update('tabela_funcionarios', $dados);
    }
}
