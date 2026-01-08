<?php

class Metas_model extends CI_Model
{
    public function get_all()
    {
        $this->db->select('tabela_metas.*, tabela_funcionarios.nome');
        $this->db->from('tabela_metas');
        $this->db->join('tabela_funcionarios', 'tabela_metas.funcionario_meta = tabela_funcionarios.id');
        $this->db->where('tabela_funcionarios.data_demissao IS NULL');
        $this->db->order_by('tabela_metas.mes_meta', 'ASC');
        $query = $this->db->get();
        return $query->result();
    }

    public function get_funcionarios()
    {
        $this->db->where('data_demissao IS NULL');
        $query = $this->db->get('tabela_funcionarios');
        return $query->result();
    }

    public function insert_meta($dados)
    {
        return $this->db->insert('tabela_metas', $dados);
    }

    public function update_meta($id, $dados)
    {
        $this->db->where('id', $id);
        return $this->db->update('tabela_metas', $dados);
    }

    public function delete_meta($id)
    {
        $this->db->where('id', $id);
        return $this->db->delete('tabela_metas');
    }

    public function check_meta_exists($funcionario_id, $mes_meta)
    {
        $this->db->where('funcionario_meta', $funcionario_id);
        $this->db->where('mes_meta', $mes_meta);
        $query = $this->db->get('tabela_metas');

        if ($query->num_rows() > 0) {
            return true;
        } else {
            return false;
        }
    }
}
