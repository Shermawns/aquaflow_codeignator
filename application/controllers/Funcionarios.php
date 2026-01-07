<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Funcionarios extends CI_Controller {
        public function __construct() {
            parent::__construct();
            $this->load->model('funcionarios_model');
                if ($this->session->userdata('logado') !== TRUE){
                    redirect('login');
                }
    }

    public function index(){
        $dados['lista_funcionarios'] = $this->funcionarios_model->get_all();
        $this->load->view('./layouts/header_view');
        $this->load->view('funcionariosListados_view', $dados);
    }

    public function cadastrar(){
        $cpf = $this->input->post('cpf');
        $nome = $this->input->post('nome');

        if(empty($cpf) || empty($nome)) {
            $this->session->set_flashdata('toast', [
                'mensagem' => 'Erro: Preencha todas as credenciais.',
                'tipo' => 'erro'
            ]);
            redirect('funcionarios');
            return;
        }else{
            $dados = array(
                'cpf' => $cpf,
                'nome' => $nome,
                'data_contratacao' => date('Y-m-d')
            );

            if($this->funcionarios_model->get_func($cpf)){
                $this->session->set_flashdata('toast', [
                    'mensagem' => 'Erro: Este CPF já está cadastrado no sistema.',
                    'tipo' => 'erro'
                ]);
                redirect('funcionarios');
                return;
            }else{
                if($this->funcionarios_model->insert_func($dados)){
                    $this->session->set_flashdata('toast', [
                        'mensagem' => 'Funcionário cadastrado com sucesso!',
                        'tipo' => 'sucesso'
                    ]);
                    redirect('funcionarios');
                    return;
            }else{
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
}