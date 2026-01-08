<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Usuarios extends CI_Controller {
    public function __construct() {
        parent::__construct();
        $this->load->model('usuarios_model');
        if ($this->session->userdata('logado') !== TRUE) {
            redirect('login');
        }
    }
    
    public function index(){
        $this->load->view('./layouts/header_view');
        $dados['lista_usuarios'] = $this->usuarios_model->list_all_users();
        $this->load->view('usuariosListados_view', $dados);
    }

    public function cadastrar(){
        $usuario = $this->input->post('usuario');
        $senha = $this->input->post('senha');
        $confirmar = $this->input->post('confirmar');

        $buscar = $this->usuarios_model->get_usuarios($usuario);

        if($buscar){
            $this->session->set_flashdata('toast', [
                    'mensagem' => 'Erro: Usuário já cadastrado!',
                    'tipo' => 'erro'
            ]);
            redirect('usuarios'); 

        }elseif(empty($usuario) || empty($senha) || empty($confirmar) ){
            $this->session->set_flashdata('toast', [
                'mensagem' => 'Erro: Preencha todas as credenciais!',
                'tipo' => 'erro'
            ]);
            redirect('usuarios');
        } elseif($senha !== $confirmar){
            $this->session->set_flashdata('toast', [
                'mensagem' => 'Erro: As senhas não conferem',
                'tipo' => 'erro'
            ]);
            redirect('usuarios');
            
        } else {
            $dados = array(
                'usuario' => $usuario,
                'senha'   => password_hash($senha, PASSWORD_DEFAULT)
            );
            
            if($this->usuarios_model->insert_user($dados)){
                $this->session->set_flashdata('toast', [
                    'mensagem' => 'Usuário cadastrado com sucesso!',
                    'tipo' => 'sucesso' 
                ]);
                redirect('usuarios');
            } else {
                $this->session->set_flashdata('toast', [
                    'mensagem' => 'Erro: Falha ao cadastrar usuário',
                    'tipo' => 'erro'
                ]);
                redirect('usuarios'); 
            }
        }
}

    public function excluir($id){
        $id_logado = $this->session->userdata('id');

        if($id == $id_logado){
            $this->usuarios_model->delete_user($id);
            redirect('login');
            return;
        }

        if($this->usuarios_model->delete_user($id)){
            $this->session->set_flashdata('toast', [
                'mensagem' => 'Usuário deletado com sucesso!',
                'tipo' => 'sucesso'
            ]);
        } else {
            $this->session->set_flashdata('toast', [
                'mensagem' => 'Erro ao tentar excluir o usuário.',
                'tipo' => 'erro'
            ]);
        }

        redirect('usuarios');
    }


    public function editar() {

        $id = $this->input->post('id_edit');
        $usuario = $this->input->post('usuario_edit');
        $senha_nova = $this->input->post('senha_edit');
        $confirmar = $this->input->post('confirmar_edit');

        if (empty($id) || empty($usuario)) {
            $this->session->set_flashdata('toast', [
                'mensagem' => 'Erro: ID ou Usuário inválidos.',
                'tipo' => 'erro'
            ]);
            redirect('usuarios');
            return;
        }

        $dados = array(
            'usuario' => $usuario
        );


        if (!empty($senha_nova)) {

            if ($senha_nova !== $confirmar) {
                $this->session->set_flashdata('toast', [
                    'mensagem' => 'Erro: As senhas não conferem!',
                    'tipo' => 'erro'
                ]);
                redirect('usuarios');
                return;
            }
            $dados['senha'] = password_hash($senha_nova, PASSWORD_DEFAULT);
        }

        if ($this->usuarios_model->edit_user($id, $dados)) {
            $this->session->set_flashdata('toast', [
                'mensagem' => 'Usuário atualizado com sucesso!',
                'tipo' => 'sucesso'
            ]);
        } else {
            $this->session->set_flashdata('toast', [
                'mensagem' => 'Erro ao atualizar no banco.',
                'tipo' => 'erro'
            ]);
        }
        redirect('usuarios');
    }

}