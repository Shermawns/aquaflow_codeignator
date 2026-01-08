<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Vendas extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('vendas_model');
        $this->load->model('produtos_model');
        if ($this->session->userdata('logado') !== TRUE) {
            redirect('login');
        }
    }

    public function index()
    {
        $dados['lista_vendas'] = $this->vendas_model->get_all();
        $dados['lista_funcionarios'] = $this->vendas_model->get_funcionarios_ativos();
        $dados['lista_produtos'] = $this->vendas_model->get_produtos_estoque();

        $this->load->view('./layouts/header_view');
        $this->load->view('vendasListados_view', $dados);
    }

    public function cadastrar()
    {
        $funcionario = $this->input->post('funcionario');
        $data_venda = $this->input->post('data_venda');
        $produtos_json = $this->input->post('produtos_json');

        if (empty($funcionario) || empty($data_venda) || empty($produtos_json)) {
            $this->session->set_flashdata('toast', [
                'mensagem' => 'Erro: Preencha todos os dados da venda.',
                'tipo' => 'erro'
            ]);
            redirect('vendas');
            return;
        }

        $produtos = json_decode($produtos_json, true);
        if (empty($produtos)) {
            $this->session->set_flashdata('toast', [
                'mensagem' => 'Erro: Nenhum produto adicionado.',
                'tipo' => 'erro'
            ]);
            redirect('vendas');
            return;
        }

        $this->db->trans_start();

        $dados_venda = [
            'funcionario_vendas' => $funcionario,
            'data_venda' => $data_venda
        ];

        $id_venda = $this->vendas_model->insert_venda($dados_venda);

        foreach ($produtos as $prod) {
            $dados_item = [
                'id_venda' => $id_venda,
                'id_produto' => $prod['id'],
                'qtd_vendido' => $prod['qtd']
            ];
            $this->vendas_model->insert_venda_produto($dados_item);

            $this->db->set('qtd_estoque', 'qtd_estoque - ' . (int)$prod['qtd'], FALSE);
            $this->db->where('id', $prod['id']);
            $this->db->update('tabela_produtos');
        }

        $this->db->trans_complete();

        if ($this->db->trans_status() === FALSE) {
            $this->session->set_flashdata('toast', [
                'mensagem' => 'Erro ao registrar venda.',
                'tipo' => 'erro'
            ]);
        } else {
            $this->session->set_flashdata('toast', [
                'mensagem' => 'Venda registrada com sucesso!',
                'tipo' => 'sucesso'
            ]);
        }

        redirect('vendas');
    }
}
