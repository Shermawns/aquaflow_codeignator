<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Funcionarios extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('funcionarios_model');
        if ($this->session->userdata('logado') !== TRUE) {
            redirect('login');
        }
    }

    public function index()
    {
        $dados['lista_funcionarios'] = $this->funcionarios_model->get_all();
        $this->load->view('./layouts/header_view');
        $this->load->view('funcionariosListados_view', $dados);
    }

    public function cadastrar()
    {
        $cpf = $this->input->post('cpf');
        $nome = $this->input->post('nome');

        if (empty($cpf) || empty($nome)) {
            $this->session->set_flashdata('toast', [
                'mensagem' => 'Erro: Preencha todas as credenciais.',
                'tipo' => 'erro'
            ]);
            redirect('funcionarios');
            return;
        } else {
            $dados = array(
                'cpf' => $cpf,
                'nome' => $nome,
                'data_contratacao' => date('Y-m-d')
            );

            if ($this->funcionarios_model->get_func($cpf)) {
                $this->session->set_flashdata('toast', [
                    'mensagem' => 'Erro: Este CPF já está cadastrado no sistema.',
                    'tipo' => 'erro'
                ]);
                redirect('funcionarios');
                return;
            } else {
                if ($this->funcionarios_model->insert_func($dados)) {
                    $this->session->set_flashdata('toast', [
                        'mensagem' => 'Funcionário cadastrado com sucesso!',
                        'tipo' => 'sucesso'
                    ]);
                    redirect('funcionarios');
                    return;
                } else {
                    $this->session->set_flashdata('toast', [
                        'mensagem' => 'Erro ao cadastrar funcionário',
                        'tipo' => 'erro'
                    ]);
                    redirect('funcionarios');
                    return;
                }
            }
        }
    }

    public function editar()
    {
        $id = $this->input->post('id_edit');
        $nome = $this->input->post('nome_edit');

        if (empty($id) || empty($nome)) {
            $this->session->set_flashdata('toast', [
                'mensagem' => 'Erro: Preencha todos os dados.',
                'tipo' => 'erro'
            ]);
            redirect('funcionarios');
            return;
        }

        $dados = array(
            'nome' => $nome
        );

        if ($this->funcionarios_model->update_func($id, $dados)) {
            $this->session->set_flashdata('toast', [
                'mensagem' => 'Funcionário atualizado com sucesso!',
                'tipo' => 'sucesso'
            ]);
        } else {
            $this->session->set_flashdata('toast', [
                'mensagem' => 'Erro ao atualizar funcionário.',
                'tipo' => 'erro'
            ]);
        }
        redirect('funcionarios');
    }

    public function desligar()
    {
        $id = $this->input->post('id_desligamento');

        if (empty($id)) {
            $this->session->set_flashdata('toast', [
                'mensagem' => 'Erro: ID inválido.',
                'tipo' => 'erro'
            ]);
            redirect('funcionarios');
            return;
        }

        $dados = array(
            'data_demissao' => date('Y-m-d')
        );

        if ($this->funcionarios_model->update_func($id, $dados)) {
            $this->session->set_flashdata('toast', [
                'mensagem' => 'Funcionário desligado com sucesso!',
                'tipo' => 'sucesso'
            ]);
        } else {
            $this->session->set_flashdata('toast', [
                'mensagem' => 'Erro ao desligar funcionário.',
                'tipo' => 'erro'
            ]);
        }
        redirect('funcionarios');
    }

    public function ativar()
    {
        $id = $this->input->post('id_ativar');

        if (empty($id)) {
            $this->session->set_flashdata('toast', [
                'mensagem' => 'Erro: ID inválido.',
                'tipo' => 'erro'
            ]);
            redirect('funcionarios');
            return;
        }

        $dados = array(
            'data_demissao' => NULL
        );

        if ($this->funcionarios_model->update_func($id, $dados)) {
            $this->session->set_flashdata('toast', [
                'mensagem' => 'Funcionário reativado com sucesso!',
                'tipo' => 'sucesso'
            ]);
        } else {
            $this->session->set_flashdata('toast', [
                'mensagem' => 'Erro ao reativar funcionário.',
                'tipo' => 'erro'
            ]);
        }
        redirect('funcionarios');
    }

    public function get_details()
    {
        $id = $this->input->post('id');

        $metas = $this->funcionarios_model->get_metas_by_funcionario($id);
        $vendas = $this->funcionarios_model->get_vendas_by_funcionario($id);

        $total_vendas = 0;
        foreach ($vendas as $venda) {
            $total_vendas += $venda->valor_venda;
        }

        $response = [
            'metas' => $metas,
            'vendas' => $vendas,
            'total_geral' => $total_vendas
        ];

        echo json_encode($response);
    }
}
