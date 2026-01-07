<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Login extends CI_Controller {

    public function index()
    {
        $this->load->view('loginCadastro_view');
    }

    public function autenticar(){
        $user = $this->input->post('usuario');
        $senha = $this->input->post('senha');
    
        if(empty($user) || empty($senha)){
            $this->session->set_flashdata('toast', [
                'msg' => 'Erro: Preencha todos os campos obrigatórios!',
                'tipo' => 'erro'
            ]);
            redirect('login');
            return;
        }

        $usuario_db = $this->LoginCadastro_model->get_usuarios($user);

        if($usuario_db) {
            if($senha == $usuario_db->senha) { 
                
                $sessao_dados = [
                    'usuario' => $usuario_db->usuario,
                    'logado' => TRUE
                ];
                $this->session->set_userdata($sessao_dados);

                $this->session->set_flashdata('toast', [
                    'msg' => 'Login efetuado com sucesso!',
                    'tipo' => 'sucesso'
                ]);
                
                echo "Login OK! (Redireciona para o painel aqui)";

            } else {
                $this->session->set_flashdata('toast', [
                    'msg' => 'Erro: Senha incorreta!',
                    'tipo' => 'erro'
                ]);
                redirect('login');
            }
        } else {
            $this->session->set_flashdata('toast', [
                'msg' => 'Erro: Utilizador não encontrado!',
                'tipo' => 'erro'
            ]);
            redirect('login');
        }
    }
}