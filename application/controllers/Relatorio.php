<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Relatorio extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->library('pdf'); 
    }


    public function gerar_produto_pdf() {
    $this->load->model('Produtos_model');

    $dados['produtos'] = $this->Produtos_model->get_all(); 

    $html = $this->load->view('modeloPdfProduto_view', $dados, TRUE); 

        $this->pdf->loadHtml($html);
        $this->pdf->setPaper('A4', 'portrait');
        $this->pdf->render();
        $this->pdf->stream("produtos_relatorio.pdf", array("Attachment" => 1));
}

    public function gerar_func_pdf() {
    $this->load->model('Funcionarios_model');

    $dados['funcionario'] = $this->Funcionarios_model->get_all();

    $html = $this->load->view('modeloPdfFunc_view', $dados, TRUE); 

        $this->pdf->loadHtml($html);
        $this->pdf->setPaper('A4', 'portrait');
        $this->pdf->render();
        $this->pdf->stream("funcionarios_relatorio.pdf", array("Attachment" => 1));
}

}