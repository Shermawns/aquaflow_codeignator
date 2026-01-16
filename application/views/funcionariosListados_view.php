<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gerenciar Funcionários - AquaFlow</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/toastify-js/src/toastify.min.css">
    <link rel="stylesheet" href="<?= base_url('assets/css/style.css') ?>">
    <link href="https://cdn.datatables.net/v/bs5/dt-1.13.4/datatables.min.css" rel="stylesheet" />
</head>

<body>
    <div class="container py-5">
        <div class="d-flex justify-content-between align-items-center mb-4 fade-in">
            <div>
                <h2 class="fw-bold mb-1" style="color: #0d6efd;">Funcionários</h2>
                <p class="text-muted mb-0">Controler de colaboradores</p>
            </div>

            <div class="d-flex flex-column gap-2">
                <button type="button" class="btn btn-primary rounded-pill shadow-sm" data-bs-toggle="modal" data-bs-target="#modalCadastrar">
                    <i class="fa-solid fa-plus me-2"></i>Cadastrar funcionário
                </button>

                <div>
                    <a href="<?= site_url('relatorio/gerar_func_pdf') ?>">
                        <button type="button" class="btn btn-danger btn-sm">
                            <i class="fa-solid fa-file-pdf me-2"></i>PDF
                        </button>
                    </a>
                    <a href="<?= site_url('relatorio/gerar_csv_func') ?>">
                        <button type="button" class="btn btn-success btn-sm">
                            <i class="fa-solid fa-file-csv me-2"></i>CSV
                        </button>
                    </a>
                    <a href="<?= site_url('relatorio/gerar_xlsx_func') ?>">
                        <button type="button" class="btn btn-success btn-sm">
                            <i class="fa-solid fa-file-excel me-2"></i>XLSX
                        </button>
                    </a>
                </div>
            </div>
        </div>

        <div class="card border-0 rounded-4 overflow-hidden">
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-hover mb-0 align-middle" id="tabelaFuncionarios">
                        <thead class="bg-light border-bottom">
                            <tr>
                                <th class="ps-4 py-3 text-secondary border-0">Funcionário</th>
                                <th class="pe-4 py-3 text-secondary text-end border-0">Ações</th>
                            </tr>
                        </thead>

                        <tbody>
                            <?php if (!empty($lista_funcionarios)) : ?>

                                <?php foreach ($lista_funcionarios as $func) : ?>
                                    <tr>
                                        <td class="ps-4">
                                            <div class="d-flex align-items-center">
                                                <div class="avatar-circle bg-primary bg-opacity-10 text-primary me-3 rounded-circle d-flex align-items-center justify-content-center" style="width: 40px;height: 40px;">
                                                    <i class="fa-regular fa-user"></i>
                                                </div>
                                                <div>
                                                    <h6 class="mb-0 fw-semibold"><?= htmlspecialchars($func->nome) ?></h6>
                                                </div>
                                            </div>
                                        </td>

                                        <td class="pe-4 text-end">
                                            <button type="button"
                                                class="btn btn-sm btn-outline-info rounded-pill me-1"
                                                title="Visualizar"
                                                data-bs-toggle="modal"
                                                data-bs-target="#modalVisualizar"
                                                data-id="<?= $func->id ?>"
                                                data-nome="<?= htmlspecialchars($func->nome) ?>"
                                                data-cpf="<?= htmlspecialchars($func->cpf) ?>"
                                                data-contratacao="<?= date('d/m/Y', strtotime($func->data_contratacao)) ?>"
                                                onclick="carregarDadosVisualizacao(this)">
                                                Visualizar
                                            </button>

                                            <button type="button"
                                                class="btn btn-sm btn-outline-primary rounded-pill me-1"
                                                title="Editar"
                                                data-bs-toggle="modal"
                                                data-bs-target="#modalEditar_func"
                                                data-id="<?= $func->id ?>"
                                                data-nome="<?= htmlspecialchars($func->nome) ?>"
                                                onclick="carregarDadosEdicao(this)">
                                                Editar
                                            </button>

                                            <?php if ($func->data_demissao == null) : ?>
                                                <button type="button"
                                                    class="btn btn-sm btn-outline-danger rounded-pill me-1"
                                                    title="Desligar"
                                                    data-bs-toggle="modal"
                                                    data-bs-target="#modalDesligar_func"
                                                    data-id="<?= $func->id ?>"
                                                    data-nome="<?= htmlspecialchars($func->nome) ?>"
                                                    onclick="confirmarDesligamento(this)">
                                                    Desligar
                                                </button>
                                            <?php else : ?>
                                                <button type="button"
                                                    class="btn btn-sm btn-success rounded-pill me-1"
                                                    title="Ativar"
                                                    data-bs-toggle="modal"
                                                    data-bs-target="#modalReativar_func"
                                                    data-id="<?= $func->id ?>"
                                                    data-nome="<?= htmlspecialchars($func->nome) ?>"
                                                    onclick="confirmarAtivacao(this)">
                                                    Ativar
                                                </button>
                                            <?php endif; ?>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>

                            <?php else : ?>
                                <tr>
                                    <td colspan="2" class="text-center text-muted py-4">Nenhum funcionário cadastrado.</td>
                                </tr>
                            <?php endif; ?>
                        </tbody>

                    </table>
                </div>
            </div>
        </div>
    </div>


    <!-- Modal de visualização -->
    <div class="modal fade" id="modalVisualizar" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg">
            <div class="modal-content rounded-4 border-0 shadow">
                <div class="modal-header border-bottom-0">
                    <h5 class="modal-title fw-bold">Detalhes do Funcionário</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body py-4 px-4">
                    <div class="row">
                        <div class="col-md-4 mb-3 text-start">
                            <label class="form-label text-muted small fw-bold">NOME</label>
                            <input type="text" class="form-control bg-light" id="visualizar_nome" readonly>
                        </div>
                        <div class="col-md-4 mb-3 text-start">
                            <label class="form-label text-muted small fw-bold">CPF</label>
                            <input type="text" class="form-control bg-light" id="visualizar_cpf" readonly>
                        </div>
                        <div class="col-md-4 mb-3 text-start">
                            <label class="form-label text-muted small fw-bold">ADMISSÃO</label>
                            <input type="text" class="form-control bg-light" id="visualizar_contratacao" readonly>
                        </div>
                    </div>

                    <hr class="my-4">

                    <h6 class="fw-bold text-primary mb-3">Últimas Metas</h6>
                    <div class="table-responsive mb-4" style="max-height: 200px; overflow-y: auto;">
                        <table class="table table-sm table-hover" id="tabela_metas_func">
                            <thead>
                                <tr>
                                    <th>Mês</th>
                                    <th>Valor</th>
                                </tr>
                            </thead>
                            <tbody></tbody>
                        </table>
                    </div>

                    <h6 class="fw-bold text-primary mb-3">Últimas Vendas</h6>
                    <div class="table-responsive" style="max-height: 200px; overflow-y: auto;">
                        <table class="table table-sm table-hover" id="tabela_vendas_func">
                            <thead>
                                <tr>
                                    <th>Data</th>
                                    <th>Produto</th>
                                    <th>Qtd</th>
                                    <th>Valor</th>
                                </tr>
                            </thead>
                            <tbody></tbody>
                        </table>
                    </div>

                </div>
            </div>
        </div>
    </div>

    <!-- Modal de Edição -->
    <div class="modal fade" id="modalEditar_func" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content rounded-4 border-0 shadow">
                <div class="modal-header border-bottom-0">
                    <h5 class="modal-title fw-bold">Editar Funcionário</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body py-4 px-4">
                    <form action="<?= base_url('funcionarios/editar') ?>" method="post">
                        <input type="hidden" name="id_edit" id="id_edit">

                        <div class="mb-3 text-start">
                            <label for="funcionario_edit" class="form-label text-muted small fw-bold">NOME COMPLETO <span class="text-danger">*</span></label>
                            <input type="text" class="form-control bg-light" id="funcionario_edit" name="nome_edit" required>
                        </div>

                        <div class="modal-footer border-top-0 justify-content-center">
                            <button type="submit" name="editar_funcionario" class="btn btn-primary btn-lg px-5 rounded-pill shadow-sm">Salvar Alterações</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>


    <!-- Modal de desligamento -->
    <div class="modal fade" id="modalDesligar_func" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content rounded-4 border-0 shadow">
                <div class="modal-header border-bottom-0 justify-content-center position-relative">
                    <h5 class="modal-title fw-bold text-danger fs-4">DESLIGAMENTO</h5>
                    <button type="button" class="btn-close position-absolute end-0 me-3" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>

                <div class="modal-body py-4 px-4">
                    <div class="mb-3 text-start">
                        <label class="form-label text-muted small fw-bold">Você tem certeza que quer desligar o funcionário abaixo?</label>
                        <input type="text" class="form-control bg-light" id="conf" readonly>
                    </div>
                </div>
                <div class="modal-footer border-top-0 justify-content-center gap-3">
                    <button type="button" class="btn btn-secondary btn-lg px-5 rounded-pill shadow-sm" data-bs-dismiss="modal">Não</button>
                    <form action="<?= base_url('funcionarios/desligar') ?>" method="post">
                        <input type="hidden" name="id_desligamento" id="id_desligamento">
                        <button type="submit" class="btn btn-danger btn-lg px-5 rounded-pill shadow-sm" name="desligar-funcionario">Sim</button>
                    </form>
                </div>
            </div>
        </div>
    </div>


    <!-- Modal de Ativação -->
    <div class="modal fade" id="modalReativar_func" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content rounded-4 border-0 shadow">
                <div class="modal-header border-bottom-0 justify-content-center position-relative">
                    <h5 class="modal-title fw-bold text-success fs-4">ATIVAÇÃO</h5>
                    <button type="button" class="btn-close position-absolute end-0 me-3" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>

                <div class="modal-body py-4 px-4">
                    <div class="mb-3 text-start">
                        <label class="form-label text-muted small fw-bold">Você tem certeza que quer ativar o funcionário abaixo?</label>
                        <input type="text" class="form-control bg-light" id="confativ" readonly>
                    </div>
                </div>
                <div class="modal-footer border-top-0 justify-content-center gap-3">
                    <button type="button" class="btn btn-secondary btn-lg px-5 rounded-pill shadow-sm" data-bs-dismiss="modal">Não</button>
                    <form action="<?= base_url('funcionarios/ativar') ?>" method="post">
                        <input type="hidden" name="id_ativar" id="id_ativar">
                        <button type="submit" class="btn btn-success btn-lg px-5 rounded-pill shadow-sm" name="ativar-funcionario">Sim</button>
                    </form>
                </div>
            </div>
        </div>
    </div>


    <!-- Modal de cadastrar funcionário -->
    <div class="modal fade" id="modalCadastrar" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content rounded-4 border-0 shadow">
                <div class="modal-header border-bottom-0">
                    <h5 class="modal-title fw-bold">Cadastrar Funcionário</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>

                <div class="modal-body py-4 px-4">
                    <form action="<?= base_url('funcionarios/cadastrar') ?>" method="post">
                        <div class="mb-3 text-start">
                            <label for="cpf" class="form-label text-muted small fw-bold">CPF <span class="text-danger">*</span></label>
                            <div class="input-group">
                                <span class="input-group-text bg-light border-end-0 text-primary">
                                    <i class="fa-regular fa-file"></i>
                                </span>
                                <input type="text" oninput="mascara(this)" class="form-control bg-light border-start-0 ps-0" id="cpf" name="cpf" minlength="11" required placeholder="Digite o CPF">
                            </div>
                        </div>

                        <div class="mb-3 text-start">
                            <label for="name" class="form-label text-muted small fw-bold">NOME COMPLETO <span class="text-danger">*</span></label>
                            <div class="input-group">
                                <span class="input-group-text bg-light border-end-0 text-primary">
                                    <i class="fa-solid fa-user"></i>
                                </span>
                                <input type="text" class="form-control bg-light border-start-0 ps-0" id="name" name="nome" maxlength="100" placeholder="Digite seu nome completo">
                            </div>
                        </div>

                        <div class="modal-footer border-top-0 justify-content-center">
                            <button type="submit" class="btn btn-primary btn-lg px-5 rounded-pill shadow-sm">Cadastrar</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.7.0.min.js"></script>
    <script src="https://cdn.datatables.net/v/bs5/dt-1.13.4/datatables.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script type="text/javascript" src="https://cdn.jsdelivr.net/npm/toastify-js"></script>
        <script>
            $(document).ready(function() {
                $('#tabelaFuncionarios').DataTable({
                    "lengthChange": false,
                    "info": false,
                    "dom": 'frtp',
                    
                    "language": {
                        "sEmptyTable": "Nenhum registro encontrado",
                        "sSearch": "Pesquisar",
                        "oPaginate": {
                            "sNext": "Próximo",
                            "sPrevious": "Anterior",
                            "sFirst": "Primeiro",
                            "sLast": "Último"
                        }
                    }
                });
            });
        </script>
</body>

</html>

<script>
    // Função para preencher o modal de edição
    function carregarDadosEdicao(botao) {
        var id = botao.getAttribute('data-id');
        var funcionario = botao.getAttribute('data-nome');

        document.getElementById('id_edit').value = id;
        document.getElementById('funcionario_edit').value = funcionario;
    }

    // Função para preencher o modal de visualização
    function carregarDadosVisualizacao(botao) {
        var nome = botao.getAttribute('data-nome');
        var cpf = botao.getAttribute('data-cpf');
        var contratacao = botao.getAttribute('data-contratacao');

        var id = botao.getAttribute('data-id');

        document.getElementById('visualizar_nome').value = nome;
        document.getElementById('visualizar_cpf').value = cpf;
        document.getElementById('visualizar_contratacao').value = contratacao ? contratacao : "";

        const tbodyMetas = document.querySelector('#tabela_metas_func tbody');
        const tbodyVendas = document.querySelector('#tabela_vendas_func tbody');

        const formData = new FormData();
        formData.append('id', id);

        fetch('<?= base_url("funcionarios/get_details") ?>', {
                method: 'POST',
                body: formData
            })
            .then(response => response.json())
            .then(data => {
                tbodyMetas.innerHTML = '';
                tbodyVendas.innerHTML = '';

                let containerTotal = document.getElementById('total_vendas_container');
                if (!containerTotal) {
                    const h6 = document.createElement('h6');
                    h6.id = 'total_vendas_container';
                    h6.className = 'fw-bold text-success mt-3';
                    document.querySelector('#tabela_vendas_func').parentNode.after(h6);
                    containerTotal = h6;
                }
                containerTotal.innerHTML = `Total das vendas: R$ ${parseFloat(data.total_geral).toLocaleString('pt-BR', {minimumFractionDigits: 2})}`;


                // Preencher Metas
                if (data.metas.length > 0) {
                    data.metas.forEach(meta => {
                        let row = `<tr>
                        <td>${new Date(meta.mes_meta).toLocaleDateString('pt-BR', {timeZone: 'UTC', month:'2-digit', year:'numeric'})}</td>
                        <td class="text-success fw-bold">R$ ${parseFloat(meta.vlr_meta).toLocaleString('pt-BR', {minimumFractionDigits: 2})}</td>
                    </tr>`;
                        tbodyMetas.innerHTML += row;
                    });
                } else {
                    tbodyMetas.innerHTML = '<tr><td colspan="2" class="text-center text-muted">Nenhuma meta recente.</td></tr>';
                }


                // Preencher Vendas
                if (data.vendas.length > 0) {
                    data.vendas.forEach(venda => {
                        let row = `<tr>
                        <td>${new Date(venda.data_venda).toLocaleDateString('pt-BR', {timeZone: 'UTC'})}</td>
                        <td>${venda.nome_produto}</td>
                         <td>${venda.qtd_vendido}</td>
                         <td>R$ ${parseFloat(venda.valor_venda).toLocaleString('pt-BR', {minimumFractionDigits: 2})}</td>
                    </tr>`;
                        tbodyVendas.innerHTML += row;
                    });
                } else {
                    tbodyVendas.innerHTML = '<tr><td colspan="4" class="text-center text-muted">Nenhuma venda recente.</td></tr>';
                }
            })

    }

    // Função para confirmar desligamento do funcionario
    function confirmarDesligamento(botao) {
        var id = botao.getAttribute('data-id');
        var nome = botao.getAttribute('data-nome');

        document.getElementById('conf').value = nome;
        document.getElementById('id_desligamento').value = id;
    }

    // Função para confirmar ativacao do funcionario
    function confirmarAtivacao(botao) {
        var id = botao.getAttribute('data-id');
        var nome = botao.getAttribute('data-nome');

        document.getElementById('confativ').value = nome;
        document.getElementById('id_ativar').value = id;
    }

    // Funcao para formatar para modelo de cpf
    function mascara(i) {
        var v = i.value;

        if (isNaN(v[v.length - 1])) {
            i.value = v.substring(0, v.length - 1);
            return;
        }

        i.setAttribute("maxlength", "14");
        i.setAttribute("maxlength", "14");
        if (v.length == 3 || v.length == 7) i.value += ".";
        if (v.length == 11) i.value += "-";
    }
</script>

<script>
    <?php
    $toast = $this->session->flashdata('toast');

    $mensagem = isset($toast['mensagem']) ? $toast['mensagem'] : '';
    $tipo = isset($toast['tipo']) ? $toast['tipo'] : '';
    ?>

    var mensagem = "<?php echo $mensagem; ?>";
    var tipo = "<?php echo $tipo; ?>";

    if (mensagem) {
        var corFundo = (tipo === "sucesso") ?
            "linear-gradient(to right, #00b09b, #96c93d)" :
            "linear-gradient(to right, #ff5f6d, #ffc371)";

        Toastify({
            text: mensagem,
            duration: 3000,
            close: true,
            gravity: "top",
            position: "right",
            stopOnFocus: true,
            style: {
                background: corFundo,
            }
        }).showToast();
    }
</script>

</html>

<script>
    // Função para preencher o modal de edição
    function carregarDadosEdicao(botao) {
        var id = botao.getAttribute('data-id');
        var funcionario = botao.getAttribute('data-nome');

        document.getElementById('id_edit').value = id;
        document.getElementById('funcionario_edit').value = funcionario;
    }

    // Função para preencher o modal de visualização
    function carregarDadosVisualizacao(botao) {
        var nome = botao.getAttribute('data-nome');
        var cpf = botao.getAttribute('data-cpf');
        var contratacao = botao.getAttribute('data-contratacao');

        var id = botao.getAttribute('data-id');

        document.getElementById('visualizar_nome').value = nome;
        document.getElementById('visualizar_cpf').value = cpf;
        document.getElementById('visualizar_contratacao').value = contratacao ? contratacao : "";

        const tbodyMetas = document.querySelector('#tabela_metas_func tbody');
        const tbodyVendas = document.querySelector('#tabela_vendas_func tbody');
        tbodyMetas.innerHTML = '<tr><td colspan="2" class="text-center"><div class="spinner-border spinner-border-sm" role="status"></div> Carregando...</td></tr>';
        tbodyVendas.innerHTML = '<tr><td colspan="3" class="text-center"><div class="spinner-border spinner-border-sm" role="status"></div> Carregando...</td></tr>';


        const formData = new FormData();
        formData.append('id', id);

        fetch('<?= base_url("funcionarios/get_details") ?>', {
                method: 'POST',
                body: formData
            })
            .then(response => response.json())
            .then(data => {
                tbodyMetas.innerHTML = '';
                tbodyVendas.innerHTML = '';

                let containerTotal = document.getElementById('total_vendas_container');
                if (!containerTotal) {
                    const h6 = document.createElement('h6');
                    h6.id = 'total_vendas_container';
                    h6.className = 'fw-bold text-success mt-3';
                    document.querySelector('#tabela_vendas_func').parentNode.after(h6);
                    containerTotal = h6;
                }
                containerTotal.innerHTML = `Total das vendas: R$ ${parseFloat(data.total_geral).toLocaleString('pt-BR', {minimumFractionDigits: 2})}`;


                // Preencher Metas
                if (data.metas.length > 0) {
                    data.metas.forEach(meta => {
                        let row = `<tr>
                        <td>${new Date(meta.mes_meta).toLocaleDateString('pt-BR', {timeZone: 'UTC', month:'2-digit', year:'numeric'})}</td>
                        <td class="text-success fw-bold">R$ ${parseFloat(meta.vlr_meta).toLocaleString('pt-BR', {minimumFractionDigits: 2})}</td>
                    </tr>`;
                        tbodyMetas.innerHTML += row;
                    });
                } else {
                    tbodyMetas.innerHTML = '<tr><td colspan="2" class="text-center text-muted">Nenhuma meta recente.</td></tr>';
                }

                // Preencher Vendas
                if (data.vendas.length > 0) {
                    data.vendas.forEach(venda => {
                        let row = `<tr>
                        <td>${new Date(venda.data_venda).toLocaleDateString('pt-BR', {timeZone: 'UTC'})}</td>
                        <td>${venda.nome_produto}</td>
                         <td>${venda.qtd_vendido}</td>
                         <td>R$ ${parseFloat(venda.valor_venda).toLocaleString('pt-BR', {minimumFractionDigits: 2})}</td>
                    </tr>`;
                        tbodyVendas.innerHTML += row;
                    });
                } else {
                    tbodyVendas.innerHTML = '<tr><td colspan="4" class="text-center text-muted">Nenhuma venda recente.</td></tr>';
                }
            })
            .catch(error => {
                console.error('Erro:', error);
                tbodyMetas.innerHTML = '<tr><td colspan="2" class="text-center text-danger">Erro ao carregar.</td></tr>';
                tbodyVendas.innerHTML = '<tr><td colspan="4" class="text-center text-danger">Erro ao carregar.</td></tr>';
            });

    }

    // Função para confirmar desligamento do funcionario
    function confirmarDesligamento(botao) {
        var id = botao.getAttribute('data-id');
        var nome = botao.getAttribute('data-nome');

        document.getElementById('conf').value = nome;
        document.getElementById('id_desligamento').value = id;
    }

    // Função para confirmar ativacao do funcionario
    function confirmarAtivacao(botao) {
        var id = botao.getAttribute('data-id');
        var nome = botao.getAttribute('data-nome');

        document.getElementById('confativ').value = nome;
        document.getElementById('id_ativar').value = id;
    }

    // Funcao para formatar para modelo de cpf
    function mascara(i) {
        var v = i.value;

        if (isNaN(v[v.length - 1])) {
            i.value = v.substring(0, v.length - 1);
            return;
        }

        i.setAttribute("maxlength", "14");
        i.setAttribute("maxlength", "14");
        if (v.length == 3 || v.length == 7) i.value += ".";
        if (v.length == 11) i.value += "-";
    }
</script>

<script>
    <?php
    $toast = $this->session->flashdata('toast');

    $mensagem = isset($toast['mensagem']) ? $toast['mensagem'] : '';
    $tipo = isset($toast['tipo']) ? $toast['tipo'] : '';
    ?>

    var mensagem = "<?php echo $mensagem; ?>";
    var tipo = "<?php echo $tipo; ?>";

    if (mensagem) {
        var corFundo = (tipo === "sucesso") ?
            "linear-gradient(to right, #00b09b, #96c93d)" :
            "linear-gradient(to right, #ff5f6d, #ffc371)";

        Toastify({
            text: mensagem,
            duration: 3000,
            close: true,
            gravity: "top",
            position: "right",
            stopOnFocus: true,
            style: {
                background: corFundo,
            }
        }).showToast();
    }
</script>