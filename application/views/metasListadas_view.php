<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gerenciar Metas - AquaFlow</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/toastify-js/src/toastify.min.css">
    <link rel="stylesheet" href="<?= base_url('assets/css/style.css') ?>">
</head>

<body>
    <div class="container py-5">
        <div class="d-flex justify-content-between align-items-center mb-4 fade-in">
            <div>
                <h2 class="fw-bold mb-1" style="color: #0d6efd;">Metas</h2>
                <p class="text-muted mb-0">Gerenciamento de metas</p>
            </div>
            <button type="button" class="btn btn-primary rounded-pill shadow-sm" data-bs-toggle="modal" data-bs-target="#modalCadastrar_meta" <?= empty($lista_funcionarios) ? 'disabled' : '' ?>>
                <i class="fa-solid fa-plus me-2"></i>Definir meta
            </button>
        </div>

        <?php if (empty($lista_funcionarios)) : ?>
            <div class="alert alert-warning d-flex align-items-center mb-4 fade-in rounded-4 shadow-sm" role="alert">
                <i class="fa-solid fa-triangle-exclamation me-2 fs-5"></i>
                <div>
                    <strong>Atenção!</strong> É necessário ter pelo menos um funcionário ativo para definir metas.
                </div>
            </div>
        <?php endif; ?>

        <div class="card border-0 rounded-4 overflow-hidden">
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-hover mb-0 align-middle">
                        <thead class="bg-light border-bottom">
                            <tr>
                                <th class="ps-4 py-3 text-secondary border-0" style="width: 28%;">Funcionário</th>
                                <th class="py-3 text-secondary border-0 " style="width: 15%;">Mês</th>
                                <th class="py-3 text-secondary border-0 ">Valor R$</th>
                                <th class="pe-4 py-3 text-secondary text-end border-0">Ações</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if (!empty($lista_metas)) : ?>
                                <?php foreach ($lista_metas as $meta) : ?>
                                    <tr>
                                        <td class="align-middle ps-4">
                                            <div class="d-flex align-items-center">
                                                <div class="bg-primary bg-opacity-10 text-primary rounded-circle d-flex align-items-center justify-content-center flex-shrink-0" style="width: 40px; height: 40px;">
                                                    <i class="fa-regular fa-user"></i>
                                                </div>
                                                <div class="ms-3">
                                                    <span class="d-block fw-semibold text-dark"><?= htmlspecialchars($meta->nome) ?></span>
                                                </div>
                                            </div>
                                        </td>

                                        <td class="align-middle text-muted fw-medium">
                                            <i class="fa-regular fa-calendar me-1"></i> <?= date('d/m/Y', strtotime($meta->mes_meta)) ?>
                                        </td>

                                        <td class="align-middle">
                                            <small class="text-muted">R$</small>
                                            <span class="fw-bold text-success"><?= number_format($meta->vlr_meta, 2, ',', '.') ?></span>
                                        </td>

                                        <td class="align-middle text-end pe-4">
                                            <button type="button"
                                                class="btn btn-sm btn-outline-primary rounded-pill"
                                                title="Editar"
                                                data-bs-toggle="modal"
                                                data-bs-target="#modalEditar_meta"
                                                data-id="<?= $meta->id ?>"
                                                data-valor="<?= $meta->vlr_meta ?>"
                                                onclick="carregarDados(this)">
                                                Editar
                                            </button>

                                            <a href="<?= base_url('metas/excluir/' . $meta->id) ?>"
                                                class="btn btn-sm btn-outline-danger rounded-pill"
                                                title="Excluir">
                                                Excluir
                                            </a>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            <?php else : ?>
                                <tr>
                                    <td colspan="4" class="text-center p-3">Nenhuma meta cadastrada.</td>
                                </tr>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>


    <!-- Modal de cadastrar metas -->
    <div class="modal fade" id="modalCadastrar_meta" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content rounded-4 border-0 shadow">
                <div class="modal-header border-bottom-0">
                    <h5 class="modal-title fw-bold">Definir Nova Meta</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>

                <div class="modal-body py-4 px-4">
                    <form action="<?= base_url('metas/cadastrar') ?>" method="post">
                        <div class="mb-3 text-start">
                            <label class="form-label text-muted small fw-bold" for="id_funcionario">FUNCIONÁRIO <span class="text-danger">*</span></label>
                            <select class="form-select form-select-sm bg-light" id="id_funcionario" name="funcionario" required>
                                <option value="" selected disabled>Selecione...</option>
                                <?php if (!empty($lista_funcionarios)) : ?>
                                    <?php foreach ($lista_funcionarios as $func) : ?>
                                        <option value="<?= $func->id ?>"><?= htmlspecialchars($func->nome) ?></option>
                                    <?php endforeach; ?>
                                <?php endif; ?>
                            </select>
                        </div>

                        <div class="mb-3 text-start">
                            <label class="form-label text-muted small fw-bold" for="mes_meta">MÊS <span class="text-danger">*</span></label>
                            <input type="month" class="form-control bg-light" id="mes_meta" name="mes" required>
                        </div>

                        <div class="mb-3 text-start">
                            <label class="form-label text-muted small fw-bold" for="vlr_meta">VALOR DA META (R$) <span class="text-danger">*</span></label>
                            <input type="text" class="form-control bg-light" id="vlr_meta" name="meta" placeholder="0,00" required>
                        </div>

                        <div class="modal-footer border-top-0 justify-content-center">
                            <button type="submit" name="cadastrar_meta" class="btn btn-primary btn-lg px-5 rounded-pill shadow-sm">
                                Salvar Meta
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>


    <!-- Modal de editar metas -->
    <div class="modal fade" id="modalEditar_meta" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content rounded-4 border-0 shadow">
                <div class="modal-header border-bottom-0">
                    <h5 class="modal-title fw-bold">Editar meta</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body py-4 px-4">
                    <form action="<?= base_url('metas/editar') ?>" method="post">
                        <input type="hidden" name="id" id="id_edit">

                        <div class="mb-3 text-start">
                            <label class="form-label text-muted small fw-bold">VALOR DA META <span class="text-danger">*</span></label>
                            <input type="number" step="0.01" class="form-control bg-light" id="vlr_edit" name="vlr" required>
                        </div>

                        <div class="modal-footer border-top-0 justify-content-center">
                            <button type="submit" name="editar_meta" class="btn btn-primary btn-lg px-5 rounded-pill shadow-sm">Salvar Alterações</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script type="text/javascript" src="https://cdn.jsdelivr.net/npm/toastify-js"></script>

</body>

</html>

<script>
    function carregarDados(botao) {
        var id = botao.getAttribute('data-id');
        var vlr = botao.getAttribute('data-valor');

        document.getElementById('id_edit').value = id;
        document.getElementById('vlr_edit').value = vlr;
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