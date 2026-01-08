<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Dashboard extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('dashboard_model');
        if ($this->session->userdata('logado') !== TRUE) {
            redirect('login');
        }
    }

    public function index()
    {
        $data['total_vendas_mes'] = $this->dashboard_model->get_total_vendas_mes();
        $data['produtos_mais_vendidos'] = $this->dashboard_model->get_produtos_mais_vendidos_mes();
        $data['top_funcionarios'] = $this->dashboard_model->get_top_funcionarios_mes();
        $data['recent_sales'] = $this->dashboard_model->get_recent_sales();
        $data['metas_vs_vendas'] = $this->dashboard_model->get_metas_vs_vendas();

        $this->load->view('./layouts/header_view');
        $this->load->view('dashboard_view', $data);
    }
}
