<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Login extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->load->model('usuarios_model');
    }

    public function index()
    {
        $this->load->view('loginCadastro_view');
    }

    public function autenticar()
    {
        $user = $this->input->post('usuario');
        $senha = $this->input->post('senha');

        if (empty($user) || empty($senha)) {
            $this->session->set_flashdata('toast', [
                'mensagem' => 'Erro: Preencha todos os campos obrigatórios!',
                'tipo' => 'erro'
            ]);
            redirect('login');
            return;
        }

        $usuario_db = $this->usuarios_model->get_usuarios($user);

        if ($usuario_db) {
            if (password_verify($senha, $usuario_db->senha)) {

                $sessao_dados = [
                    'id' => $usuario_db->id,
                    'usuario' => $usuario_db->usuario,
                    'logado' => TRUE
                ];
                $this->session->set_userdata($sessao_dados);

                $this->session->set_flashdata('toast', [
                    'mensagem' => 'Login efetuado com sucesso!',
                    'tipo' => 'sucesso'
                ]);

                redirect('dashboard');
            } else {
                $this->session->set_flashdata('toast', [
                    'mensagem' => 'Erro: Senha incorreta!',
                    'tipo' => 'erro'
                ]);
                redirect('login');
            }
        } else {
            $this->session->set_flashdata('toast', [
                'mensagem' => 'Erro: Usuário não encontrado!',
                'tipo' => 'erro'
            ]);
            redirect('login');
        }
    }

    public function autenticado()
    {
        redirect('dashboard');
    }

    public function logout()
    {
        $this->session->unset_userdata('logado');
        redirect('login');
    }
}
