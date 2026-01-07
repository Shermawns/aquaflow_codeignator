<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gerenciar Usuários</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/toastify-js/src/toastify.min.css">
    <link rel="stylesheet" href="<?= base_url('assets/style.css') ?>">  
</head>

<body>
        <div class="container py-5">
        <div class="d-flex justify-content-between align-items-center mb-4 fade-in">
            <div>
                <h2 class="fw-bold mb-1" style="color: #0d6efd;">Usuários</h2>
                <p class="text-muted mb-0">Gerencie o acesso ao sistema</p>
            </div>
            <button type="button" class="btn btn-primary rounded-pill shadow-sm" data-bs-toggle="modal" data-bs-target="#modalCadastrar">
                <i class="fa-solid fa-plus me-2"></i>Cadastrar Usuário
            </button>
        </div>

        <!-- Caixa onde fica os usuários listados-->
         <div class="card border-0 rounded-4 overflow-hidden">
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-hover mb-0 align-middle">
                <thead class="bg-light border-bottom">
                    <tr>
                        <th class="ps-4 py-3 text-secondary border-0">Usuário</th>
                        <th class="pe-4 py-3 text-secondary text-end border-0">Ações</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (!empty($lista_usuarios)): ?>
                        
                        <?php foreach ($lista_usuarios as $user): ?>
                            <tr>
                                <td class="ps-4">
                                    <div class="d-flex align-items-center">
                                        <div class="avatar-circle bg-primary bg-opacity-10 text-primary me-3 rounded-circle d-flex align-items-center justify-content-center" style="width: 40px; height: 40px;">
                                            <i class="fa-regular fa-user"></i>
                                        </div>
                                        <div>
                                            <h6 class="mb-0 fw-semibold"><?= htmlspecialchars($user->usuario) ?></h6>
                                        </div>
                                    </div>
                                </td>

                                <td class="pe-4 text-end">
                                    <button type="button" 
                                        class="btn btn-sm btn-outline-primary rounded-pill me-1" 
                                        title="Editar" 
                                        data-bs-toggle="modal" 
                                        data-bs-target="#modalEditar_func"
                                        data-id="<?= $user->id ?>"
                                        data-usuario="<?= htmlspecialchars($user->usuario) ?>"
                                        onclick="carregarDadosEdicao(this)">
                                        Editar
                                    </button>
                                    
                                    <a href="<?= base_url('usuarios/excluir/' . $user->id) ?>" 
                                       class="btn btn-sm btn-outline-danger rounded-pill">
                                       Excluir
                                    </a>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                        <?php else: ?>
                        <tr>
                            <td colspan="2" class="text-center text-muted py-4">Nenhum usuário cadastrado.</td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

        <!-- Modal de editar usuário -->
        <div class="modal fade" id="modalEditar_func" tabindex="-1" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content rounded-4 border-0 shadow">
                    <div class="modal-header border-bottom-0">
                        <h5 class="modal-title fw-bold">Editar Usuário</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>

                    <!-- Formulário de ediçao -->
                    <div class="modal-body py-4 px-4">
                        <form action="<?= base_url('usuarios/editar') ?>" method="post">
                            <input type="hidden" name="id_edit" id="id_edit">

                            <div class="mb-3 text-start">
                                <label class="form-label text-muted small fw-bold">USUÁRIO</label>
                                <input type="text" class="form-control bg-light" id="usuario_edit" name="usuario_edit" maxlength="50" required>
                            </div>

                            <div class="mb-3 text-start">
                                <label class="form-label text-muted small fw-bold">NOVA SENHA (Deixe vazio para manter)</label>
                                <input type="password" class="form-control bg-light" name="senha_edit" placeholder="Nova senha">
                            </div>

                            <div class="mb-4 text-start">
                                <label class="form-label text-muted small fw-bold">CONFIRMAR NOVA SENHA</label>
                                <input type="password" class="form-control bg-light" name="confirmar_edit" placeholder="Repita a nova senha">
                            </div>

                            <div class="modal-footer border-top-0 justify-content-center">
                                <button type="submit" name="editar_usuario" class="btn btn-primary btn-lg px-5 rounded-pill shadow-sm">Salvar Alterações</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <!-- Modal de cadastro de usuarios  -->
        <div class="modal fade" id="modalCadastrar" tabindex="-1" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content rounded-4 border-0 shadow">
                    <div class="modal-header border-bottom-0">
                        <h5 class="modal-title fw-bold">Cadastrar Usuário</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>

                    <!-- Campo de usuário -->
                    <div class="modal-body py-4 px-4">
                        <form action="<?= base_url('usuarios/cadastrar') ?>" method="post">
                            <div class="mb-3 text-start">
                                <label for="user" class="form-label text-muted small fw-bold">USUÁRIO</label>
                                <div class="input-group">
                                    <span class="input-group-text bg-light border-end-0 text-primary">
                                        <i class="fa-solid fa-user"></i>
                                    </span>
                                    <input type="text" class="form-control bg-light border-start-0 ps-0" id="user" name="usuario" autocomplete="username" required placeholder="Digite o login">
                                </div>
                            </div>


                            <!-- Campo de senha  -->
                            <div class="mb-3 text-start">
                                <label for="pass" class="form-label text-muted small fw-bold">SENHA</label>
                                <div class="input-group">
                                    <span class="input-group-text bg-light border-end-0 text-primary">
                                        <i class="fa-solid fa-lock"></i>
                                    </span>
                                    <input type="password" class="form-control bg-light border-start-0 ps-0" id="pass" name="senha" autocomplete="new-password" required placeholder="Crie uma senha forte">
                                </div>
                            </div>

                            <!-- Campo de confirmar senha -->
                            <div class="mb-4 text-start">
                                <label for="confirm" class="form-label text-muted small fw-bold">CONFIRMAR SENHA</label>
                                <div class="input-group">
                                    <span class="input-group-text bg-light border-end-0 text-primary">
                                        <i class="fa-solid fa-check-double"></i>
                                    </span>
                                    <input type="password" class="form-control bg-light border-start-0 ps-0" id="confirm" name="confirmar" autocomplete="new-password" required placeholder="Repita a senha">
                                </div>
                            </div>

                            <!-- Botão submit -->
                            <div class="modal-footer border-top-0 justify-content-center">
                                <button type="submit" class="btn btn-primary btn-lg px-5 rounded-pill shadow-sm">Cadastrar</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
        <script type="text/javascript" src="https://cdn.jsdelivr.net/npm/toastify-js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>

<script>
    // Função para preencher o modal de edição
    function carregarDadosEdicao(botao) {
        var id = botao.getAttribute('data-id');
        var usuario = botao.getAttribute('data-usuario');

        document.getElementById('id_edit').value = id;
        document.getElementById('usuario_edit').value = usuario;
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