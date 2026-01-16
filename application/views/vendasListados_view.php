<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gerenciar Vendas - AquaFlow</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/toastify-js/src/toastify.min.css">
    <link rel="stylesheet" href="<?= base_url('assets/css/style.css') ?>">
    <link href="https://cdn.datatables.net/v/bs5/dt-1.13.4/datatables.min.css" rel="stylesheet" />
</head>

<body>

    <div class="container py-5">
        <div class="d-flex justify-content-between align-items-center mb-4 fade-in">
            <div>
                <h2 class="fw-bold mb-1" style="color: #0d6efd;">Vendas</h2>
                <p class="text-muted mb-0">Gerenciamento de vendas</p>
            </div>

            <div class="d-flex flex-column gap-2">
                <button type="button" class="btn btn-primary rounded-pill shadow-sm" data-bs-toggle="modal" data-bs-target="#modalCadastrar_venda" <?= empty($lista_funcionarios) ? 'disabled              style="cursor: not-allowed; pointer-events: auto;"' : '' ?>>
                    <i class="fa-solid fa-plus me-2"></i>Registrar Venda
                </button>

                <div>
                    <a href="<?= site_url('relatorio/gerar_vendas_pdf') ?>">
                        <button type="button" class="btn btn-danger btn-sm">
                            <i class="fa-solid fa-file-pdf me-2"></i>PDF
                        </button>
                    </a>
                    <a href="<?= site_url('relatorio/gerar_csv_vendas') ?>">
                        <button type="button" class="btn btn-success btn-sm">
                            <i class="fa-solid fa-file-csv me-2"></i>CSV
                        </button>
                    </a>
                    <a href="<?= site_url('relatorio/gerar_xlsx_vendas') ?>">
                        <button type="button" class="btn btn-success btn-sm">
                            <i class="fa-solid fa-file-excel me-2"></i>XLSX
                        </button>
                    </a>
                </div>
            </div>
        </div>

        <?php if (empty($lista_funcionarios)) : ?>
            <div class="alert alert-warning d-flex align-items-center mb-4 fade-in rounded-4 shadow-sm" role="alert">
                <i class="fa-solid fa-triangle-exclamation me-2 fs-5"></i>
                <div>
                    <strong>Atenção!</strong> É necessário ter pelo menos um funcionário ativo para registrar as vendas.
                </div>
            </div>
        <?php endif; ?>

        <div class="card border-0 rounded-4 overflow-hidden">
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-hover mb-0 align-middle" id="tabelaVendas">
                        <thead class="bg-light border-bottom">
                            <tr>
                                <th class="ps-4 py-3 text-secondary border-0" style="width: 35%;">Funcionário</th>
                                <th class="py-3 text-secondary border-0" style="width: 20%;">Data</th>
                                <th class="py-3 text-secondary border-0" style="width: 25%;">Produtos</th>
                                <th class="pe-4 py-3 text-secondary border-0">Valor Total</th>
                            </tr>
                        </thead>
                        <tbody>

                            <?php if (!empty($lista_vendas)) : ?>
                                <?php foreach ($lista_vendas as $venda) : ?>
                                    <tr>
                                        <td class="align-middle ps-4">
                                            <div class="d-flex align-items-center">
                                                <div class="bg-primary bg-opacity-10 text-primary rounded-circle d-flex align-items-center justify-content-center flex-shrink-0" style="width: 40px; height: 40px;">
                                                    <i class="fa-regular fa-user"></i>
                                                </div>
                                                <div class="ms-3">
                                                    <h6 class="mb-0 fw-semibold text-dark"><?= htmlspecialchars($venda->funcionario_vendas) ?></h6>
                                                </div>
                                            </div>
                                        </td>

                                        <td class="align-middle text-muted fw-medium">
                                            <i class="fa-regular fa-calendar me-1"></i> <?= date('d/m/Y', strtotime($venda->data_venda)) ?>
                                        </td>

                                        <td class="align-middle text-muted fw-medium">
                                            <span class="d-block text-dark" style="line-height: 1.6;"><?= $venda->lista_produtos ?></span>
                                        </td>

                                        <td class="align-middle pe-4">
                                            <small class="text-muted">R$</small>
                                            <span class="fw-bold text-success"><?= number_format($venda->valor_total_venda, 2, ',', '.') ?></span>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            <?php else : ?>
                                <tr>
                                    <td colspan="4" class="text-center p-3">Nenhuma venda registrada.</td>
                                </tr>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>


    <div class="modal fade" id="modalCadastrar_venda" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-dialog modal-dialog-centered modal-lg">
                <div class="modal-content rounded-4 border-0 shadow">
                    <div class="modal-header border-bottom-0">
                        <h5 class="modal-title fw-bold">Registrar Venda</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>

                    <div class="modal-body py-4 px-4">
                        <form action="<?= base_url('vendas/cadastrar') ?>" method="post" id="formVenda" onsubmit="return prepararEnvio()">
                            <input type="hidden" name="produtos_json" id="produtos_json">

                            <div class="row">
                                <div class="col-md-6 mb-3 text-start">
                                    <label for="func_venda" class="form-label text-muted small fw-bold">FUNCIONÁRIO <span class="text-danger">*</span></label>
                                    <div class="input-group">
                                        <select class="form-select bg-light border-start-0 ps-0" id="func_venda" name="funcionario" required>
                                            <option value="" selected disabled>Selecione...</option>
                                            <?php if (!empty($lista_funcionarios)) : ?>
                                                <?php foreach ($lista_funcionarios as $func) : ?>
                                                    <option value="<?= $func->id ?>"><?= htmlspecialchars($func->nome) ?></option>
                                                <?php endforeach; ?>
                                            <?php endif; ?>
                                        </select>
                                    </div>
                                </div>

                                <div class="col-md-6 mb-3 text-start">
                                    <label for="data_venda" class="form-label text-muted small fw-bold">DATA DA VENDA <span class="text-danger">*</span></label>
                                    <div class="input-group">
                                        <input type="date" class="form-control bg-light border-start-0 ps-0" id="data_venda" name="data_venda" value="<?php echo date('Y-m-d'); ?>" required>
                                    </div>
                                </div>
                            </div>

                            <hr>
                            <h6 class="text-start fw-bold text-primary">Adicionar Itens</h6>

                            <div class="row align-items-end mb-3">

                                <div class="col-md-6 text-start">
                                    <label for="prod_venda" class="form-label text-muted small fw-bold">PRODUTO <span class="text-danger">*</span></label>
                                    <select class="form-select bg-light" id="prod_venda">
                                        <option value="" selected disabled>Selecione...</option>
                                        <?php if (!empty($lista_produtos)) : ?>
                                            <?php foreach ($lista_produtos as $prod) : ?>
                                                <option value="<?= $prod->id ?>" data-nome="<?= htmlspecialchars($prod->nome_produto) ?>" data-estoque="<?= $prod->qtd_estoque ?>"><?= htmlspecialchars($prod->nome_produto) ?> (Estoque: <?= $prod->qtd_estoque ?>)</option>
                                            <?php endforeach; ?>
                                        <?php endif; ?>
                                    </select>
                                </div>
                                
                                <div class="col-md-3 text-start">
                                    <label for="qtd_venda" class="form-label text-muted small fw-bold">QTD <span class="text-danger">*</span></label>
                                    <input type="number" class="form-control bg-light" id="qtd_venda" min="1" placeholder="0" style="position: relative; z-index: 10;">
                                </div>
                                <div class="col-md-3">
                                    <button type="button" class="btn btn-success w-100 rounded-pill" onclick="adicionarProduto()">
                                        <i class="fa-solid fa-plus me-1"></i> Add
                                    </button>
                                </div>
                            </div>

                            <div class="table-responsive mb-3" style="max-height: 150px; overflow-y: auto;">
                                <table class="table table-sm table-bordered" id="tabelaItens">
                                    <thead class="table-light">
                                        <tr>
                                            <th>Produto</th>
                                            <th style="width: 80px;">Qtd</th>
                                            <th style="width: 50px;"></th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                    </tbody>
                                </table>
                            </div>

                            <div class="modal-footer border-top-0 justify-content-center">
                                <button type="submit" name="registrar_venda" class="btn btn-primary btn-lg px-5 rounded-pill shadow-sm">Registrar Venda</button>
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
                $('#tabelaVendas').DataTable({
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

<script>
    let listaProdutos = [];

    function adicionarProduto() {
        const selectProd = document.getElementById('prod_venda');
        const inputQtd = document.getElementById('qtd_venda');

        const idProd = selectProd.value;
        const nomeProd = selectProd.options[selectProd.selectedIndex].getAttribute('data-nome');
        const estoque = parseInt(selectProd.options[selectProd.selectedIndex].getAttribute('data-estoque'));
        const qtd = parseInt(inputQtd.value);

        if (!idProd || !qtd || qtd <= 0) {
            Toastify({
                text: "Erro: Selecione um produto e uma quantidade válida.",
                duration: 3000,
                close: true,
                gravity: "top",
                position: "right",
                stopOnFocus: true,
                style: {
                    background: "linear-gradient(to right, #ff5f6d, #ffc371)",
                }
            }).showToast();
            return;
        }

        // Verificar se a quantidade excede o estoque 
        const existe = listaProdutos.find(p => p.id === idProd);
        let qtdTotal = qtd;
        if (existe) {
            qtdTotal += existe.qtd;
        }

        if (qtdTotal > estoque) {
            Toastify({
                text: "Erro: Quantidade excede o estoque disponível (" + estoque + ").",
                duration: 3000,
                close: true,
                gravity: "top",
                position: "right",
                stopOnFocus: true,
                style: {
                    background: "linear-gradient(to right, #ff5f6d, #ffc371)",
                }
            }).showToast();
            return;
        }

        if (existe) {
            existe.qtd += qtd;
        } else {
            listaProdutos.push({
                id: idProd,
                nome: nomeProd,
                qtd: qtd
            });
        }

        atualizarTabela();

        selectProd.value = "";
        inputQtd.value = "";
    }

    function removerProduto(index) {
        listaProdutos.splice(index, 1);
        atualizarTabela();
    }

    function atualizarTabela() {
        const tbody = document.querySelector('#tabelaItens tbody');
        tbody.innerHTML = "";

        listaProdutos.forEach((p, index) => {
            let row = `<tr>
                <td>${p.nome}</td>
                <td>${p.qtd}</td>
                <td><button type="button" class="btn btn-sm btn-danger py-0 px-2" onclick="removerProduto(${index})">&times;</button></td>
            </tr>`;
            tbody.innerHTML += row;
        });
    }

    function prepararEnvio() {
        if (listaProdutos.length === 0) {
            Toastify({
                text: "Erro: Adicione pelo menos um produto à venda!",
                duration: 3000,
                close: true,
                gravity: "top",
                position: "right",
                stopOnFocus: true,
                style: {
                    background: "linear-gradient(to right, #ff5f6d, #ffc371)",
                }
            }).showToast();
            return false;
        }
        document.getElementById('produtos_json').value = JSON.stringify(listaProdutos);
        return true;
    }
</script>