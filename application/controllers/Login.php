<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Login extends CI_Controller {

	public function index()
	{
		$this->load->view('loginCadastro_view');
		$this->load->model('LoginCadastro_model');		
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
		}
	}
}
