<?php defined('BASEPATH') or exit('No direct script access allowed');

class Relatorio extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->load->library('pdf');
    }


    public function gerar_produto_pdf()
    {
        $this->load->model('Produtos_model');

        $dados['produtos'] = $this->Produtos_model->get_all();

        $html = $this->load->view('modeloPdfProduto_view', $dados, TRUE);

        $this->pdf->loadHtml($html);
        $this->pdf->setPaper('A4', 'portrait');
        $this->pdf->render();
        $this->pdf->stream("produtos_relatorio.pdf", array("Attachment" => 1));
    }

    public function gerar_func_pdf()
    {
        $this->load->model('Funcionarios_model');

        $dados['funcionario'] = $this->Funcionarios_model->get_all();

        $html = $this->load->view('modeloPdfFunc_view', $dados, TRUE);

        $this->pdf->loadHtml($html);
        $this->pdf->setPaper('A4', 'portrait');
        $this->pdf->render();
        $this->pdf->stream("funcionarios_relatorio.pdf", array("Attachment" => 1));
    }

    public function gerar_geral_pdf()
    {
        $this->load->model('Dashboard_model');

        $data['total_vendas_mes'] = $this->Dashboard_model->get_total_vendas_mes();
        $data['produtos_mais_vendidos'] = $this->Dashboard_model->get_produtos_mais_vendidos_mes();
        $data['top_funcionarios'] = $this->Dashboard_model->get_top_funcionarios_mes();
        $data['recent_sales'] = $this->Dashboard_model->get_recent_sales();
        $data['metas_vs_vendas'] = $this->Dashboard_model->get_metas_vs_vendas();

        $html = $this->load->view('modeloPdfGeral_view', $data, TRUE);

        $this->pdf->loadHtml($html);
        $this->pdf->setPaper('A4', 'portrait');
        $this->pdf->render();
        $this->pdf->stream("relatorio_geral_dashboard.pdf", array("Attachment" => 1));
    }

    public function gerar_vendas_pdf()
    {
        $this->load->model('Vendas_model');

        $data['lista_vendas'] = $this->Vendas_model->get_all();

        $html = $this->load->view('modeloPdfVendas_view', $data, TRUE);

        $this->pdf->loadHtml($html);
        $this->pdf->setPaper('A4', 'portrait');
        $this->pdf->render();
        $this->pdf->stream("relatorio_vendas.pdf", array("Attachment" => 1));
    }
}
