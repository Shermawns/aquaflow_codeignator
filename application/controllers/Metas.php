<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Metas extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('metas_model');
        if ($this->session->userdata('logado') !== TRUE) {
            redirect('login');
        }
    }

    public function index()
    {
        $dados['lista_metas'] = $this->metas_model->get_all();
        $dados['lista_funcionarios'] = $this->metas_model->get_funcionarios();
        $this->load->view('./layouts/header_view');
        $this->load->view('metasListadas_view', $dados);
    }

    public function cadastrar()
    {
        $funcionario = $this->input->post('funcionario');
        $mes = $this->input->post('mes');
        $meta = $this->input->post('meta');

        $meta = str_replace('.', '', $meta);
        $meta = str_replace(',', '.', $meta);

        if (empty($funcionario) || empty($mes) || empty($meta)) {
            $this->session->set_flashdata('toast', [
                'mensagem' => 'Erro: Preencha todas as credenciais!',
                'tipo' => 'erro'
            ]);
            redirect('metas');
            return;
        }

        $ano_meta = explode('-', $mes)[0];
        $ano_atual = date('Y');

        if ($ano_meta < $ano_atual) {
            $this->session->set_flashdata('toast', [
                'mensagem' => 'Erro: Não é permitido cadastrar metas para anos anteriores!',
                'tipo' => 'erro'
            ]);
            redirect('metas');
            return;
        }

        if ($this->metas_model->check_meta_exists($funcionario, $mes . '-01')) {
            $this->session->set_flashdata('toast', [
                'mensagem' => 'Erro: Este funcionário já possui uma meta para este mês!',
                'tipo' => 'erro'
            ]);
            redirect('metas');
            return;
        }

        if ($meta < 0) {
            $this->session->set_flashdata('toast', [
                'mensagem' => 'Erro: O valor da meta não pode ser negativo!',
                'tipo' => 'erro'
            ]);
            redirect('metas');
            return;
        }

        $dados = array(
            'funcionario_meta' => $funcionario,
            'mes_meta' => $mes . '-01',
            'vlr_meta' => $meta
        );

        if ($this->metas_model->insert_meta($dados)) {
            $this->session->set_flashdata('toast', [
                'mensagem' => 'Meta cadastrada com sucesso!',
                'tipo' => 'sucesso'
            ]);
        } else {
            $this->session->set_flashdata('toast', [
                'mensagem' => 'Erro ao cadastrar meta.',
                'tipo' => 'erro'
            ]);
        }
        redirect('metas');
    }

    public function editar()
    {
        $id = $this->input->post('id');
        $valor = $this->input->post('vlr');

        $valor = str_replace('.', '', $valor);
        $valor = str_replace(',', '.', $valor);


        if (empty($id) || empty($valor)) {
            $this->session->set_flashdata('toast', [
                'mensagem' => 'Erro: Preencha todos os campos!',
                'tipo' => 'erro'
            ]);
            redirect('metas');
            return;
        }

        if ($valor < 0) {
            $this->session->set_flashdata('toast', [
                'mensagem' => 'Erro: O valor da meta não pode ser negativo!',
                'tipo' => 'erro'
            ]);
            redirect('metas');
            return;
        }

        $dados = array(
            'vlr_meta' => $valor
        );

        if ($this->metas_model->update_meta($id, $dados)) {
            $this->session->set_flashdata('toast', [
                'mensagem' => 'Meta atualizada com sucesso!',
                'tipo' => 'sucesso'
            ]);
        } else {
            $this->session->set_flashdata('toast', [
                'mensagem' => 'Erro ao atualizar meta.',
                'tipo' => 'erro'
            ]);
        }
        redirect('metas');
    }

    public function excluir($id = null)
    {
        if (!$id) {
            redirect('metas');
            return;
        }

        if ($this->metas_model->delete_meta($id)) {
            $this->session->set_flashdata('toast', [
                'mensagem' => 'Meta excluída com sucesso!',
                'tipo' => 'sucesso'
            ]);
        } else {
            $this->session->set_flashdata('toast', [
                'mensagem' => 'Erro ao excluir meta.',
                'tipo' => 'erro'
            ]);
        }
        redirect('metas');
    }
}
