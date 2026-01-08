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

    public function update_func($id, $dados)
    {
        $this->db->where('id', $id);
        return $this->db->update('tabela_funcionarios', $dados);
    }
}
