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
        $this->load->model('Dashboard_model');

        $dados['metas_vs_vendas'] = $this->Dashboard_model->get_metas_vs_vendas();

        $html = $this->load->view('modeloPdfFunc_view', $dados, TRUE);

        $this->pdf->loadHtml($html);
        $this->pdf->setPaper('A4', 'portrait');
        $this->pdf->render();
        $this->pdf->stream("funcionarios_relatorio.pdf", array("Attachment" => 1));
    }

        public function gerar_metas_pdf(){
        $this->load->model('Dashboard_model');

        $dados['metas_vs_vendas'] = $this->Dashboard_model->get_metas_vs_vendas();

        $html = $this->load->view('modeloPdfMetas_view', $dados, TRUE);

        $this->pdf->loadHtml($html);
        $this->pdf->setPaper('A4', 'portrait');
        $this->pdf->render();
        $this->pdf->stream("metas_relatorio.pdf", array("Attachment" => 1));
    }

       public function gerar_csv_metas(){
        $this->load->model('Dashboard_model');
        $funcionarios = $this->Dashboard_model->get_metas_vs_vendas();
        
        $filename = 'relatorio_metas' . '.csv';

        header("Content-Description: File Transfer"); 
        header("Content-Disposition: attachment; filename=$filename"); 
        header("Content-Type: application/csv; charset=UTF-8");

        $file = fopen('php://output', 'w');

        fputs($file, "\xEF\xBB\xBF");

        $header = array("Nome","Meta", "Realizado"); 
        fputcsv($file, $header, ";");

        foreach($funcionarios as $func){
            $linha = array(
                $func->nome,
                'R$ ' . number_format($func->meta, 2, ',', '.') ,
                'R$ ' . number_format($func->realizado, 2, ',', '.')
            );

            fputcsv($file, $linha, ";");
        }
            fclose($file); 
    }

        public function gerar_xlsx_metas(){
        $this->load->model('Dashboard_model');
        $funcionarios = $this->Dashboard_model->get_metas_vs_vendas();
        
        $filename = 'relatorio_metas' . '.xlsx';

        header("Content-Description: File Transfer"); 
        header("Content-Disposition: attachment; filename=$filename"); 
        header("Content-Type: application/csv; charset=UTF-8");

        $file = fopen('php://output', 'w');

        fputs($file, "\xEF\xBB\xBF");

        $header = array("Nome","Meta", "Realizado"); 
        fputcsv($file, $header, ";");

        foreach($funcionarios as $func){
            $linha = array(
                $func->nome,
                'R$ ' . number_format($func->meta, 2, ',', '.') ,
                'R$ ' . number_format($func->realizado, 2, ',', '.') ,
            );

            fputcsv($file, $linha, ";");
        }
            fclose($file); 
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

    public function gerar_csv_produtos(){
        $this->load->model('Produtos_model');
        $produtos = $this->Produtos_model->get_all();

        $filename = 'relatorio_produtos' . '.csv';

        header("Content-Description: File Transfer"); 
        header("Content-Disposition: attachment; filename=$filename"); 
        header("Content-Type: application/csv; charset=UTF-8");

        $file = fopen('php://output', 'w');

        fputs($file, "\xEF\xBB\xBF");

        $header = array("Nome do Produto", "Preço Unitário", "Qtd Estoque"); 
        fputcsv($file, $header, ";");

        foreach ($produtos as $pd) {
            $linha = array(
                $pd->nome_produto,
                'R$ ' . number_format($pd->vlr_unitario, 2, ',', '.') ,
                $pd->qtd_estoque
            );
            
            fputcsv($file, $linha, ";");
        }
        fclose($file); 
        exit; 
    }

    public function gerar_xlsx_produtos(){
    $this->load->model('Produtos_model');
    $produtos = $this->Produtos_model->get_all();

    $filename = 'relatorio_produtos' . '.xlsx';

    header("Content-Description: File Transfer"); 
    header("Content-Disposition: attachment; filename=$filename"); 
    header("Content-Type: application/csv; charset=UTF-8");

    $file = fopen('php://output', 'w');

    fputs($file, "\xEF\xBB\xBF");

    $header = array("Nome do Produto", "Preço Unitário", "Qtd Estoque"); 
    fputcsv($file, $header, ";");

    foreach ($produtos as $pd) {
        $linha = array(
            $pd->nome_produto,
            'R$ ' . number_format($pd->vlr_unitario, 2, ',', '.'),
            $pd->qtd_estoque
        );
        
        fputcsv($file, $linha, ";");
    }
    fclose($file); 
    exit; 
}


    public function gerar_csv_func(){
        $this->load->model('Dashboard_model');
        $funcionarios = $this->Dashboard_model->get_metas_vs_vendas();
        
        $filename = 'relatorio_funcionarios' . '.csv';

        header("Content-Description: File Transfer"); 
        header("Content-Disposition: attachment; filename=$filename"); 
        header("Content-Type: application/csv; charset=UTF-8");

        $file = fopen('php://output', 'w');

        fputs($file, "\xEF\xBB\xBF");

        $header = array("Nome", "Data de contratacao", "Meta", "Realizado"); 
        fputcsv($file, $header, ";");

        foreach($funcionarios as $func){
            $linha = array(
                $func->nome,
                date('d/m/Y', strtotime($func->data_contratacao)),
                'R$ ' . number_format($func->meta, 2, ',', '.') ,
                'R$ ' . number_format($func->realizado, 2, ',', '.')
            );

            fputcsv($file, $linha, ";");
        }
            fclose($file); 
    }

        public function gerar_xlsx_func(){
        $this->load->model('Dashboard_model');
        $funcionarios = $this->Dashboard_model->get_metas_vs_vendas();
        
        $filename = 'relatorio_funcionarios' . '.xlsx';

        header("Content-Description: File Transfer"); 
        header("Content-Disposition: attachment; filename=$filename"); 
        header("Content-Type: application/csv; charset=UTF-8");

        $file = fopen('php://output', 'w');

        fputs($file, "\xEF\xBB\xBF");

        $header = array("Nome", "Data de contratacao", "Meta", "Realizado"); 
        fputcsv($file, $header, ";");

        foreach($funcionarios as $func){
            $linha = array(
                $func->nome,
                date('d/m/Y', strtotime($func->data_contratacao)),
                'R$ ' . number_format($func->meta, 2, ',', '.') ,
                'R$ ' . number_format($func->realizado, 2, ',', '.') ,
            );

            fputcsv($file, $linha, ";");
        }
            fclose($file); 
    }

    public function gerar_csv_vendas() {
        $this->load->model('Vendas_model');
        $vendas = $this->Vendas_model->get_vendas_detalhadas();

        $filename = 'relatorio_vendas' . '.csv';

        header("Content-Description: File Transfer"); 
        header("Content-Disposition: attachment; filename=$filename"); 
        header("Content-Type: application/csv; charset=UTF-8");

        $file = fopen('php://output', 'w');

        fputs($file, "\xEF\xBB\xBF");

        $header = array("Data", "Funcionário", "Produto","Preço" ,"Qtd"); 
        fputcsv($file, $header, ";");

        foreach ($vendas as $vd) {
            
            $linha = array(
                date('d/m/Y', strtotime($vd->data_venda)),
                $vd->nome_funcionario,
                $vd->nome_produto, 
               'R$ ' . number_format($vd->vlr_unitario, 2, ',', '.') ,     
                $vd->qtd_vendido
            );
            
            fputcsv($file, $linha, ";");
        }
        fclose($file); 
        exit; 
    }

        public function gerar_xlsx_vendas() {
        $this->load->model('Vendas_model');
        $vendas = $this->Vendas_model->get_vendas_detalhadas();

        $filename = 'relatorio_vendas' . '.csv';

        header("Content-Description: File Transfer"); 
        header("Content-Disposition: attachment; filename=$filename"); 
        header("Content-Type: application/csv; charset=UTF-8");

        $file = fopen('php://output', 'w');

        fputs($file, "\xEF\xBB\xBF");

        $header = array("Data", "Funcionário", "Produto","Preço" ,"Qtd"); 
        fputcsv($file, $header, ";");

        foreach ($vendas as $vd) {
            
            $linha = array(
                date('d/m/Y', strtotime($vd->data_venda)),
                $vd->nome_funcionario,
                $vd->nome_produto, 
                'R$ ' . number_format($vd->vlr_unitario, 2, ',', '.'),     
                $vd->qtd_vendido
            );
            
            fputcsv($file, $linha, ";");
        }
        fclose($file); 
        exit; 
    }

    public function gerar_csv_geral(){
            $this->load->model('Dashboard_model');

            $data['total_vendas_mes'] = $this->Dashboard_model->get_total_vendas_mes();
            $data['produtos_mais_vendidos'] = $this->Dashboard_model->get_produtos_mais_vendidos_mes();
            $data['top_funcionarios'] = $this->Dashboard_model->get_top_funcionarios_mes();
            $data['recent_sales'] = $this->Dashboard_model->get_recent_sales();
            $data['metas_vs_vendas'] = $this->Dashboard_model->get_metas_vs_vendas();

            $filename = 'relatorio_geral_dashboard'. '.csv';

            header("Content-Description: File Transfer"); 
            header("Content-Disposition: attachment; filename=$filename"); 
            header("Content-Type: application/csv; charset=UTF-8");

            $file = fopen('php://output', 'w');

            fputs($file, "\xEF\xBB\xBF");

    
            fputcsv($file, array("RESUMO DO MÊS (KPIs)"), ";");
            fputcsv($file, array("Vendas do Mês", "Produto Top", "Funcionário Destaque"), ";");


            $nome_top_produto = !empty($data['produtos_mais_vendidos']) ? $data['produtos_mais_vendidos'][0]->nome_produto : 'N/A';
            $nome_top_func = !empty($data['top_funcionarios']) ? $data['top_funcionarios'][0]->nome : 'N/A';

            $linha_kpi = array(
                'R$ ' . number_format($data['total_vendas_mes'], 2, ',', '.'),
                $nome_top_produto,
                $nome_top_func
            );
            fputcsv($file, $linha_kpi, ";");

            fputcsv($file, array(""));

            fputcsv($file, array("METAS DOS FUNCIONÁRIOS"), ";");
            fputcsv($file, array("Funcionário", "Meta", "Realizado", "Status"), ";");

            if(!empty($data['metas_vs_vendas'])){
                foreach ($data['metas_vs_vendas'] as $meta) {
                    $status = ($meta->realizado >= $meta->meta) ? "Atingida" : "Pendente";
                    $linha = array(
                        $meta->nome,
                        number_format($meta->meta, 2, ',', '.'),
                        number_format($meta->realizado, 2, ',', '.'),
                        $status
                    );
                    fputcsv($file, $linha, ";");
                }
            } else {
                fputcsv($file, array("Nenhuma meta encontrada"), ";");
            }

            fputcsv($file, array("")); 

            fputcsv($file, array("PRODUTOS MAIS VENDIDOS"), ";");
            fputcsv($file, array("Produto", "Quantidade Vendida", "Preço", "Valor total"), ";");

            if(!empty($data['produtos_mais_vendidos'])){
                foreach ($data['produtos_mais_vendidos'] as $prod) {
                    $linha = array(
                        $prod->nome_produto,
                        $prod->total_qtd,
                        'R$ ' . number_format($prod->vlr_unitario, 2, ',', '.'),
                        'R$ ' . number_format($prod->total, 2, ',', '.')
                    );
                    fputcsv($file, $linha, ";");
                }
            }

            fputcsv($file, array("")); 

            fputcsv($file, array("VENDAS RECENTES"), ";");
            fputcsv($file, array("Data", "Funcionário", "Valor Total"), ";");

            if(!empty($data['recent_sales'])){
                foreach ($data['recent_sales'] as $sale) {
                    $linha = array(
                        date('d/m/Y', strtotime($sale->data_venda)),
                        $sale->nome,
                        'R$ ' . number_format($sale->total, 2, ',', '.')
                    );
                    fputcsv($file, $linha, ";");
                }
            }

            fclose($file); 
            exit; 
        }
        public function gerar_xlsx_geral(){
        $this->load->model('Dashboard_model');

        $data['total_vendas_mes'] = $this->Dashboard_model->get_total_vendas_mes();
        $data['produtos_mais_vendidos'] = $this->Dashboard_model->get_produtos_mais_vendidos_mes();
        $data['top_funcionarios'] = $this->Dashboard_model->get_top_funcionarios_mes();
        $data['recent_sales'] = $this->Dashboard_model->get_recent_sales();
        $data['metas_vs_vendas'] = $this->Dashboard_model->get_metas_vs_vendas();

        $filename = 'relatorio_geral_dashboard'. '.xlsx';

        header("Content-Description: File Transfer"); 
        header("Content-Disposition: attachment; filename=$filename"); 
        header("Content-Type: application/csv; charset=UTF-8");

        $file = fopen('php://output', 'w');

        fputs($file, "\xEF\xBB\xBF");

 
        fputcsv($file, array("RESUMO DO MÊS (KPIs)"), ";");
        fputcsv($file, array("Vendas do Mês", "Produto Top", "Funcionário Destaque"), ";");


        $nome_top_produto = !empty($data['produtos_mais_vendidos']) ? $data['produtos_mais_vendidos'][0]->nome_produto : 'N/A';
        $nome_top_func = !empty($data['top_funcionarios']) ? $data['top_funcionarios'][0]->nome : 'N/A';

        $linha_kpi = array(
            'R$ ' . number_format($data['total_vendas_mes'], 2, ',', '.'),
            $nome_top_produto,
            $nome_top_func
        );
        fputcsv($file, $linha_kpi, ";");

        fputcsv($file, array(""));

        fputcsv($file, array("METAS DOS FUNCIONÁRIOS"), ";");
        fputcsv($file, array("Funcionário", "Meta", "Realizado", "Status"), ";");

        if(!empty($data['metas_vs_vendas'])){
            foreach ($data['metas_vs_vendas'] as $meta) {
                $status = ($meta->realizado >= $meta->meta) ? "Atingida" : "Pendente";
                $linha = array(
                    $meta->nome,
                    number_format($meta->meta, 2, ',', '.'),
                    number_format($meta->realizado, 2, ',', '.'),
                    $status
                );
                fputcsv($file, $linha, ";");
            }
        } else {
            fputcsv($file, array("Nenhuma meta encontrada"), ";");
        }

        fputcsv($file, array("")); 

        fputcsv($file, array("PRODUTOS MAIS VENDIDOS"), ";");
        fputcsv($file, array("Produto", "Quantidade Vendida", "Preço", "Valor total"), ";");

        if(!empty($data['produtos_mais_vendidos'])){
            foreach ($data['produtos_mais_vendidos'] as $prod) {
                $linha = array(
                    $prod->nome_produto,
                    $prod->total_qtd,
                    $prod->vlr_unitario,
                    'R$ ' . number_format($prod->total, 2, ',', '.')
                );
                fputcsv($file, $linha, ";");
            }
        }

        fputcsv($file, array("")); 

        fputcsv($file, array("VENDAS RECENTES"), ";");
        fputcsv($file, array("Data", "Funcionário", "Valor Total"), ";");

        if(!empty($data['recent_sales'])){
            foreach ($data['recent_sales'] as $sale) {
                $linha = array(
                    date('d/m/Y', strtotime($sale->data_venda)),
                    $sale->nome,
                    'R$ ' . number_format($sale->total, 2, ',', '.')
                );
                fputcsv($file, $linha, ";");
            }
        }

        fclose($file); 
        exit; 
    }
}
