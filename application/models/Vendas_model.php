<?php

class Vendas_model extends CI_Model
{
    public function get_all()
    {
        $this->db->select("
            tabela_vendas.id,
            tabela_vendas.data_venda,
            tabela_funcionarios.nome AS funcionario_vendas,
            SUM(tabela_vendas_produtos.qtd_vendido) as total_itens,
            SUM(tabela_vendas_produtos.qtd_vendido * tabela_produtos.vlr_unitario) as valor_total_venda,
            GROUP_CONCAT(CONCAT('<small class=\"fw-bold text-primary\">', tabela_vendas_produtos.qtd_vendido, 'x</small> ', tabela_produtos.nome_produto) SEPARATOR '<br>') AS lista_produtos
        ");
        $this->db->from('tabela_vendas');
        $this->db->join('tabela_funcionarios', 'tabela_vendas.funcionario_vendas = tabela_funcionarios.id');
        $this->db->join('tabela_vendas_produtos', 'tabela_vendas.id = tabela_vendas_produtos.id_venda');
        $this->db->join('tabela_produtos', 'tabela_vendas_produtos.id_produto = tabela_produtos.id');
        $this->db->group_by('tabela_vendas.id');
        $this->db->order_by('valor_total_venda', 'DESC');

        $query = $this->db->get();
        return $query->result();
    }

    public function get_funcionarios_ativos()
    {
        $this->db->where('data_demissao IS NULL');
        $this->db->order_by('nome', 'ASC');
        $query = $this->db->get('tabela_funcionarios');
        return $query->result();
    }

    public function get_produtos_estoque()
    {
        $this->db->where('qtd_estoque >', 0);
        $this->db->order_by('nome_produto', 'ASC');
        $query = $this->db->get('tabela_produtos');
        return $query->result();
    }

    public function insert_venda($dados)
    {
        $this->db->insert('tabela_vendas', $dados);
        return $this->db->insert_id();
    }

    public function insert_venda_produto($dados)
    {
        return $this->db->insert('tabela_vendas_produtos', $dados);
    }
}
