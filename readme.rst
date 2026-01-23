<body>

  <h1 align="center">🌊 AquaFlow</h1>
  <h3 align="center">UNIFAMETRO - Centro Universitário Fametro</h3>
  <p align="center">
    <em>Sistema Integrado de Gestão e Análise de Dados com foco em eficiência operacional e suporte à decisão.</em>
  </p>

  <p align="center">
    <img src="https://img.shields.io/badge/PHP-7.4%2B-777BB4?style=for-the-badge&logo=php&logoColor=white" alt="PHP Version">
    <img src="https://img.shields.io/badge/CodeIgniter-3.x-EF4223?style=for-the-badge&logo=codeigniter&logoColor=white" alt="Framework">
    <img src="https://img.shields.io/badge/MySQL-Database-4479A1?style=for-the-badge&logo=mysql&logoColor=white" alt="Database">
  </p>

  <section>
    <h2>📚 Sobre o Projeto</h2>
    <p>
      O <strong>AquaFlow</strong> é uma solução de software <em>web-based</em> robusta, desenvolvida sob a arquitetura <strong>MVC (Model-View-Controller)</strong>. O sistema visa gerenciar integralmente os fluxos de informação corporativa, mitigando redundâncias e assegurando a integridade dos dados entre setores administrativos e comerciais.
    </p>
    <p>
      Além das operações CRUD essenciais, o projeto inova ao integrar módulos de <strong>Inteligência Artificial</strong> (para suporte via chat) e um motor dedicado de geração de relatórios documentais (PDF), facilitando a análise de métricas e a tomada de decisões estratégicas.
    </p>
  </section>

  <section>
    <h2>🏆 Principais Objetivos e Resultados</h2>
    <ul>
      <li><strong>Centralização da Informação:</strong> Unificação de dados de vendas, estoque e recursos humanos em uma única base.</li>
      <li><strong>Automação Documental:</strong> Geração instantânea de relatórios em PDF (Vendas, Funcionários, Metas) utilizando a biblioteca DOMPDF.</li>
      <li><strong>Suporte Inteligente:</strong> Implementação de um assistente virtual baseado em IA para auxílio operacional.</li>
      <li><strong>Segurança de Dados:</strong> Controle de acesso robusto e validação de sessões de usuário.</li>
      <li><strong>Monitoramento de KPIs:</strong> Visualização clara de metas organizacionais e desempenho de vendas.</li>
    </ul>
  </section>

  <section>
    <h2>✨ Funcionalidades Principais</h2>
    <ul>
      <li>🔐 <strong>Controle de Acesso:</strong> Sistema de Login e gestão de sessões seguras.</li>
      <li>👥 <strong>Gestão de RH:</strong> Cadastro e manutenção do ciclo de vida dos funcionários.</li>
      <li>💰 <strong>Gestão Comercial:</strong> Registro transacional de vendas e controle financeiro.</li>
      <li>📦 <strong>Inventário:</strong> Gerenciamento completo de produtos e estoque.</li>
      <li>📈 <strong>Metas Corporativas:</strong> Definição e acompanhamento de objetivos.</li>
      <li>📄 <strong>Relatórios Dinâmicos:</strong> Exportação de dados críticos para formato PDF.</li>
      <li>🤖 <strong>Módulo IA:</strong> Interface de chat integrada para assistência (Controller <code>Ai.php</code>).</li>
    </ul>
  </section>

  <section>
    <h2>🛠️ Tecnologias Utilizadas</h2>
    <ul>
      <li><strong>Backend:</strong> PHP 7.4+, Framework CodeIgniter 3</li>
      <li><strong>Frontend:</strong> HTML5, CSS3, JavaScript (jQuery, DataTables)</li>
      <li><strong>Banco de Dados:</strong> MySQL (Driver MySQLi/PDO)</li>
      <li><strong>Gerenciamento de Dependências:</strong> Composer</li>
      <li><strong>Relatórios:</strong> DOMPDF</li>
      <li><strong>Testes:</strong> PHPUnit</li>
    </ul>
  </section>

  <section>
    <h2>🚀 Como Executar o Projeto</h2>
    <ol>
      <li><strong>Clone o repositório:</strong>
        <pre><code>git clone https://github.com/shermawns/aquaflow_codeignator.git</code></pre>
      </li>

      <li><strong>Instale as dependências:</strong>
        <p>Na raiz do projeto, execute o Composer para baixar as bibliotecas (DOMPDF, PHPUnit, etc.):</p>
        <pre><code>composer install</code></pre>
      </li>

      <li><strong>Configure o Banco de Dados:</strong>
        <p>Edite o arquivo <code>application/config/database.php</code> com suas credenciais locais:</p>
        <pre><code>$db['default'] = array(
    'dsn'      => '',
    'hostname' => 'localhost',
    'username' => 'seu_usuario',
    'password' => 'sua_senha',
    'database' => 'aquaflow_db',
    // ...
);</code></pre>
      </li>

      <li><strong>Inicie o Servidor:</strong>
        <p>Utilize um servidor Apache/Nginx ou o servidor embutido do PHP:</p>
        <pre><code>php -S localhost:8080</code></pre>
      </li>
    </ol>
  </section>

  <section>
    <h2>🕹️ Estrutura de Módulos (Controllers)</h2>
    <h3>🔑 Acesso</h3>
    <ul>
      <li><code>Login.php</code>: Autenticação de usuários.</li>
      <li><code>Usuarios.php</code>: Gerenciamento de contas de acesso.</li>
    </ul>

    <h3>💼 Operacional</h3>
    <ul>
      <li><code>Vendas.php</code>: Lógica de transações comerciais.</li>
      <li><code>Produtos.php</code>: Controle de inventário.</li>
      <li><code>Funcionarios.php</code>: Gestão de equipe.</li>
    </ul>

    <h3>📊 Estratégico</h3>
    <ul>
      <li><code>Dashboard.php</code>: Visão geral e KPIs.</li>
      <li><code>Metas.php</code>: Definição de objetivos.</li>
      <li><code>Relatorio.php</code>: Geração de documentos PDF.</li>
      <li><code>Ai.php</code>: Integração com inteligência artificial.</li>
    </ul>
  </section>

  <section>
    <h2>🗃️ Estrutura do Banco de Dados (Sugestão)</h2>
    <p>O sistema baseia-se nas seguintes entidades principais (conforme Models):</p>
    <ul>
      <li><code>tb_usuarios</code> — dados de login e administradores.</li>
      <li><code>tb_funcionarios</code> — dados cadastrais da equipe.</li>
      <li><code>tb_produtos</code> — catálogo de itens e estoque.</li>
      <li><code>tb_vendas</code> — registro histórico de transações.</li>
      <li><code>tb_metas</code> — objetivos definidos pela gestão.</li>
    </ul>
  </section>

  <hr>

<footer align="center" style="margin-top: 60px; padding: 30px; background-color: #f5f5f5; border-radius: 12px;">
  <h2>💬 Autoria</h2>
  <p style="max-width: 800px; margin: 10px auto; line-height: 1.6;">
    Este projeto foi desenvolvido aplicando conceitos avançados de Engenharia de Software e arquitetura MVC no contexto acadêmico da <strong>UNIFAMETRO</strong>.
  </p>
  <p style="font-style: italic; color: #555;">
    "A tecnologia a serviço da eficiência corporativa."
  </p>
  <p>
    Desenvolvido por <a href="https://github.com/shermawns" target="_blank"><strong>Shermamm Barbosa Alcântara</strong></a>  
    — Estudante de Análise e Desenvolvimento de Sistemas.
  </p>
</footer>

</body>
