<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Produtos extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('produtos_model');
        if ($this->session->userdata('logado') !== TRUE) {
            redirect('login');
        }
    }

    public function index()
    {
        $dados['lista_produtos'] = $this->produtos_model->get_all();
        $this->load->view('./layouts/header_view');
        $this->load->view('produtosListados_view', $dados);
    }

    public function cadastrar()
    {
        $nome = $this->input->post('produto');
        $preco = $this->input->post('preco');
        $qtd = $this->input->post('qtd');

        if (empty($nome) || empty($preco) || empty($qtd)) {
            $this->session->set_flashdata('toast', [
                'mensagem' => 'Erro: Preencha todas as credenciais!',
                'tipo' => 'erro'
            ]);
            redirect('produtos');
        } elseif ($preco < 0) {
            $this->session->set_flashdata('toast', [
                'mensagem' => 'Erro: O preço não pode ser negativo!',
                'tipo' => 'erro'
            ]);
            redirect('produtos');
        } elseif ($qtd < 0) {
            $this->session->set_flashdata('toast', [
                'mensagem' => 'Erro: A quantidade não pode ser negativa!',
                'tipo' => 'erro'
            ]);
            redirect('produtos');
        } else {

            $dados = array(
                'nome_produto' => $nome,
                'vlr_unitario' => $preco,
                'qtd_estoque' => $qtd
            );

            $query = $this->produtos_model->insert_prod($dados);

            if ($query) {
                $this->session->set_flashdata('toast', [
                    'mensagem' => 'Produto cadastrado com sucesso!',
                    'tipo' => 'sucesso'
                ]);
                redirect('produtos');
            } else {
                $this->session->set_flashdata('toast', [
                    'mensagem' => 'Erro ao cadastrar produto.',
                    'tipo' => 'erro'
                ]);
                redirect('produtos');
            }
        }
    }


    public function editar()
    {
        $id = $this->input->post('id');
        $nome = $this->input->post('produto');
        $preco = $this->input->post('preco');
        $qtd = $this->input->post('qtd');

        if (empty($id) || empty($nome) || empty($preco) || empty($qtd)) {
            $this->session->set_flashdata('toast', [
                'mensagem' => 'Erro: Preencha todos os campos!',
                'tipo' => 'erro'
            ]);
            redirect('produtos');
            return;
        }

        if ($preco < 0) {
            $this->session->set_flashdata('toast', [
                'mensagem' => 'Erro: O preço não pode ser negativo!',
                'tipo' => 'erro'
            ]);
            redirect('produtos');
            return;
        }

        if ($qtd < 0) {
            $this->session->set_flashdata('toast', [
                'mensagem' => 'Erro: A quantidade não pode ser negativa!',
                'tipo' => 'erro'
            ]);
            redirect('produtos');
            return;
        }

        $dados = array(
            'nome_produto' => $nome,
            'vlr_unitario' => $preco,
            'qtd_estoque' => $qtd
        );

        if ($this->produtos_model->edit_prod($id, $dados)) {
            $this->session->set_flashdata('toast', [
                'mensagem' => 'Produto atualizado com sucesso!',
                'tipo' => 'sucesso'
            ]);
        } else {
            $this->session->set_flashdata('toast', [
                'mensagem' => 'Erro ao atualizar produto.',
                'tipo' => 'erro'
            ]);
        }
        redirect('produtos');
    }
}
