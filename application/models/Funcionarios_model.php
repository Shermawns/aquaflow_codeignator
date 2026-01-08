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
        $this->db->select('tabela_vendas.data_venda, tabela_produtos.nome_produto, tabela_vendas_produtos.qtd_vendido, (tabela_vendas_produtos.qtd_vendido * tabela_produtos.vlr_unitario) as valor_venda');
        $this->db->from('tabela_vendas');
        $this->db->join('tabela_vendas_produtos', 'tabela_vendas.id = tabela_vendas_produtos.id_venda');
        $this->db->join('tabela_produtos', 'tabela_vendas_produtos.id_produto = tabela_produtos.id');
        $this->db->where('tabela_vendas.funcionario_vendas', $id);
        $this->db->order_by('tabela_vendas.data_venda', 'DESC');
        $this->db->limit(10); // Limit to recent sales
        $query = $this->db->get();
        return $query->result();
    }

    public function update_func($id, $dados)
    {
        $this->db->where('id', $id);
        return $this->db->update('tabela_funcionarios', $dados);
    }
}
