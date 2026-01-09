<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Ai extends CI_Controller
{

    private $api_key = 'AIzaSyDUspxhTZGgn5wzALtanrKzwh-4005bkBY';

    public function __construct()
    {
        parent::__construct();
        $this->load->library('session');

        if (file_exists(APPPATH . 'models/Dashboard_model.php')) {
            $this->load->model('Dashboard_model');
        }
    }



    public function ask()
    {

        $user_message = $this->input->post('message');

        if (empty($user_message)) {
            echo json_encode(['error' => 'Mensagem vazia']);
            return;
        }

        $history = $this->session->userdata('aquaflow_chat_history') ?? [];

        $context_data = $this->get_context_data();

        $system_prompt = "ATUE COMO: Um assistente do sistema Aquaflow.";
        $system_prompt .= "SUA MISSÃO: Analisar os dados fornecidos e responder dúvidas operacionais da equipe.";

        $system_prompt .= "DIRETRIZES DE COMPORTAMENTO:";
        $system_prompt .= "1. TOM DE VOZ: Profissional, cordial e objetivo. Você é um funcionário exemplar";
        $system_prompt .= "2. ESCOPO: Responda apenas sobre os dados do Aquaflow. Se perguntarem sobre assuntos banais (futebol, receitas, política), diga educadamente: 'Como assistente do Aquaflow, meu foco é nos resultados da empresa. Posso ajudar com algo do painel?'\n";
        $system_prompt .= "3. PRECISÃO: Nunca invente valores. Se a informação não estiver presente no sistemaa, diga que não tem acesso a esse dado no momento.\n\n";

        $system_prompt .= "REGRAS DE FORMATAÇÃO:\n";
        $system_prompt .= "- Valores monetários e numéricos importantes devem estar sempre em **negrito** ex: **R$ 500,00**.";
        $system_prompt .= "- Se o usuário pedir listas, OBRIGATORIAMENTE use Tabelas Markdown para organizar.";
        $system_prompt .= "- Use emojis com moderação para manter a interface amigável";

        $system_prompt .= "CONTEXTO DE DADOS:" . json_encode($context_data, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);

        $system_prompt .= "\n\nHISTÓRICO DA CONVERSA:\n";
        foreach (array_slice($history, -4) as $turn) {
            $system_prompt .= "User: " . $turn['user'] . "\nAI: " . $turn['ai'] . "\n";
        }

        $full_prompt = $system_prompt . "\n\nUser: " . $user_message . "\nAI:";

        $response_text = $this->call_gemini($full_prompt);

        $history[] = ['user' => $user_message, 'ai' => $response_text];
        if (count($history) > 6) array_shift($history);
        $this->session->set_userdata('aquaflow_chat_history', $history);

        header('Content-Type: application/json');
        echo json_encode(['response' => $response_text]);
    }





    private function get_context_data()
    {

        if (!isset($this->Vendas_model)) $this->load->model('Vendas_model');
        if (!isset($this->Produtos_model)) $this->load->model('Produtos_model');
        if (!isset($this->Funcionarios_model)) $this->load->model('Funcionarios_model');

        $context = [];

        if (isset($this->Dashboard_model)) {
            $context['resumo_mes'] = [
                'total_vendas' => $this->Dashboard_model->get_total_vendas_mes() ?? '0',
                'top_produtos' => $this->Dashboard_model->get_produtos_mais_vendidos_mes() ?? [],
                'top_funcionarios' => $this->Dashboard_model->get_top_funcionarios_mes() ?? [],
                'metas_vs_realizado' => $this->Dashboard_model->get_metas_vs_vendas() ?? []
            ];
        }

        $todos_produtos = $this->Produtos_model->get_all();
        $context['produtos_lista'] = array_map(function ($p) {
            return [
                'produto' => $p->nome_produto,
                'preco' => $p->vlr_unitario,
                'estoque' => $p->qtd_estoque
            ];
        }, array_slice($todos_produtos, 0, 30));

        $todas_vendas = $this->Vendas_model->get_all();
        $context['ultimas_vendas'] = array_map(function ($v) {
            return [
                'data' => $v->data_venda,
                'vendedor' => $v->funcionario_vendas,
                'valor' => $v->valor_total_venda,
                'itens' => strip_tags(str_replace('<br>', ', ', $v->lista_produtos))
            ];
        }, array_slice($todas_vendas, 0, 10));

        $funcionarios = $this->Funcionarios_model->get_all();
        $context['equipe'] = array_map(function ($f) {
            return $f->nome;
        }, $funcionarios);

        return $context;
    }





    private function call_gemini($prompt)
    {
        $url = "https://generativelanguage.googleapis.com/v1beta/models/gemini-2.5-flash:generateContent?key=" . $this->api_key;

        $data = [
            'contents' => [
                [
                    'parts' => [['text' => $prompt]]
                ]
            ]
        ];

        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));
        curl_setopt($ch, CURLOPT_HTTPHEADER, ['Content-Type: application/json']);

        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);

        $response = curl_exec($ch);

        if (curl_errno($ch)) {
            return "Erro Interno (cURL): " . curl_error($ch);
        }
        curl_close($ch);

        $json = json_decode($response, true);

        if (isset($json['candidates'][0]['content']['parts'][0]['text'])) {
            return $json['candidates'][0]['content']['parts'][0]['text'];
        } else {
            return "Foi utilizado todos os tokens";
        }
    }
}
