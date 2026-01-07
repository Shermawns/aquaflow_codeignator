<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Aquaflow - Login</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/toastify-js/src/toastify.min.css">
    <link rel="stylesheet" href="<?= base_url('assets/style.css') ?>">  
</head>

<body>
    <div class="d-flex align-items-center justify-content-center min-vh-100">
        <div class="card shadow-lg border-0 rounded-4 p-4" style="max-width: 400px; width: 100%;">
            <div class="card-body">
                <div class="text-center mb-4">
                    <img src="<?= base_url('assets/imgs/Gemini_Generated_Image_3y2rqt3y2rqt3y2r.png') ?>"  alt="Logo AquaFlow" class="img-fluid mb-2" style="max-width: 300px;">
                    <h2 class="h5 text-primary">Acesse sua conta</h2>
                </div>

                <form action="<?= base_url("login/autenticar") ?>" method="post">
                    <div class="mb-3">
                        <label for="user" class="form-label">Usuário <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" id="user" name="usuario" autocomplete="username" maxlength="50" placeholder="Digite seu usuário" required>
                    </div>

                    <div class="mb-5">
                        <label for="pass" class="form-label">Senha <span class="text-danger">*</span></label>
                        <input type="password" class="form-control" id="pass" name="senha" autocomplete="current-password" required placeholder="Digite sua senha">
                    </div>

                    <div class="d-grid">
                        <input type="submit" class="btn btn-primary btn-lg" value="Entrar">
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script type="text/javascript" src="https://cdn.jsdelivr.net/npm/toastify-js"></script>
</body>

</html>

<script>
    <?php 
    $toast = $this->session->flashdata('toast'); 
    ?>

    var mensagem = "<?= $toast['msg'] ?? '' ?>";
    var tipo = "<?= $toast['tipo'] ?? '' ?>";

    if (mensagem) {
        var corFundo = tipo === "sucesso" ?
            "linear-gradient(to right, #11998e, #38ef7d)" : // Verde (Sucesso)
            "linear-gradient(to right, #ff416c, #ff4b2b)"; // Vermelho (Erro)

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