<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Dashboard_model extends CI_Model
{
    public function get_total_vendas_mes()
    {
        $this->db->select('SUM(tabela_vendas_produtos.qtd_vendido * tabela_produtos.vlr_unitario) as total', FALSE);
        $this->db->from('tabela_vendas');
        $this->db->join('tabela_vendas_produtos', 'tabela_vendas.id = tabela_vendas_produtos.id_venda');
        $this->db->join('tabela_produtos', 'tabela_vendas_produtos.id_produto = tabela_produtos.id');
        $this->db->where('MONTH(tabela_vendas.data_venda)', date('m'));
        $this->db->where('YEAR(tabela_vendas.data_venda)', date('Y'));
        $query = $this->db->get();
        return $query->row()->total ?? 0;
    }

    public function get_produtos_mais_vendidos_mes()
    {
        $this->db->select('tabela_produtos.nome_produto, SUM(tabela_vendas_produtos.qtd_vendido) as total_qtd', FALSE);
        $this->db->from('tabela_vendas_produtos');
        $this->db->join('tabela_vendas', 'tabela_vendas.id = tabela_vendas_produtos.id_venda');
        $this->db->join('tabela_produtos', 'tabela_vendas_produtos.id_produto = tabela_produtos.id');
        $this->db->where('MONTH(tabela_vendas.data_venda)', date('m'));
        $this->db->where('YEAR(tabela_vendas.data_venda)', date('Y'));
        $this->db->group_by('tabela_produtos.id');
        $this->db->order_by('total_qtd', 'DESC');
        $this->db->limit(5);
        $query = $this->db->get();
        return $query->result();
    }

    public function get_top_funcionarios_mes()
    {
        $this->db->select('tabela_funcionarios.nome, SUM(tabela_vendas_produtos.qtd_vendido * tabela_produtos.vlr_unitario) as total_vendido', FALSE);
        $this->db->from('tabela_vendas');
        $this->db->join('tabela_funcionarios', 'tabela_vendas.funcionario_vendas = tabela_funcionarios.id');
        $this->db->join('tabela_vendas_produtos', 'tabela_vendas.id = tabela_vendas_produtos.id_venda');
        $this->db->join('tabela_produtos', 'tabela_vendas_produtos.id_produto = tabela_produtos.id');
        $this->db->where('MONTH(tabela_vendas.data_venda)', date('m'));
        $this->db->where('YEAR(tabela_vendas.data_venda)', date('Y'));
        $this->db->group_by('tabela_funcionarios.id');
        $this->db->order_by('total_vendido', 'DESC');
        $this->db->limit(5);
        $query = $this->db->get();
        return $query->result();
    }

    public function get_recent_sales()
    {
        $this->db->select('tabela_vendas.data_venda, tabela_funcionarios.nome, SUM(tabela_vendas_produtos.qtd_vendido * tabela_produtos.vlr_unitario) as total', FALSE);
        $this->db->from('tabela_vendas');
        $this->db->join('tabela_funcionarios', 'tabela_vendas.funcionario_vendas = tabela_funcionarios.id');
        $this->db->join('tabela_vendas_produtos', 'tabela_vendas.id = tabela_vendas_produtos.id_venda');
        $this->db->join('tabela_produtos', 'tabela_vendas_produtos.id_produto = tabela_produtos.id');
        $this->db->group_by('tabela_vendas.id');
        $this->db->order_by('tabela_vendas.data_venda', 'DESC');
        $this->db->order_by('total', 'DESC');
        $this->db->limit(5);
        $query = $this->db->get();
        return $query->result();
    }

    public function get_metas_vs_vendas()
    {
        $subquery_vendas = "(SELECT funcionario_vendas, SUM(tabela_vendas_produtos.qtd_vendido * tabela_produtos.vlr_unitario) as total_vendido 
                             FROM tabela_vendas 
                             JOIN tabela_vendas_produtos ON tabela_vendas.id = tabela_vendas_produtos.id_venda 
                             JOIN tabela_produtos ON tabela_vendas_produtos.id_produto = tabela_produtos.id 
                             WHERE MONTH(tabela_vendas.data_venda) = " . date('m') . " 
                             AND YEAR(tabela_vendas.data_venda) = " . date('Y') . " 
                             GROUP BY funcionario_vendas) as vendas";

        $this->db->select('tabela_funcionarios.nome, IFNULL(tabela_metas.vlr_meta, 0) as meta, IFNULL(vendas.total_vendido, 0) as realizado', FALSE);
        $this->db->from('tabela_funcionarios');
        $this->db->join('tabela_metas', 'tabela_funcionarios.id = tabela_metas.funcionario_meta AND MONTH(tabela_metas.mes_meta) = ' . date('m') . ' AND YEAR(tabela_metas.mes_meta) = ' . date('Y'), 'left');
        $this->db->join($subquery_vendas, 'tabela_funcionarios.id = vendas.funcionario_vendas', 'left');
        $this->db->where('tabela_funcionarios.data_demissao IS NULL'); 
        $this->db->group_start();
        $this->db->where('tabela_metas.vlr_meta >', 0);
        $this->db->or_where('vendas.total_vendido >', 0);
        $this->db->group_end();

        $query = $this->db->get();
        return $query->result();
    }
}
