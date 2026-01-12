<!DOCTYPE html>
<html>
<head>
    <title>Meu Primeiro Relatório</title>
    <style>
        body { font-family: sans-serif; font-size: 12px; }
        .cabecalho { text-align: center; margin-bottom: 20px; border-bottom: 2px solid #ddd; padding-bottom: 10px; }
        .titulo { font-size: 18px; font-weight: bold; color: #2c3e50; }
        table { width: 100%; border-collapse: collapse; margin-top: 10px; }
        th { background-color: #2c3e50; color: white; padding: 8px; text-align: left; }
        td { border: 1px solid #ddd; padding: 8px; }
        tr:nth-child(even) { background-color: #f2f2f2; }
    </style>
</head>
<body>

    <div class="cabecalho">
        <h1 class="titulo">Relatório de funcionários</h1>
        <p>Gerado em: <?php echo date('d/m/Y H:i'); ?></p>
    </div>

    <table>
        <thead>
            <tr>
                <th>Nome</th>
                <th>Data de contratação</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach($funcionario as $func): ?>
            <tr>

                <td><?= $func->nome ?></td>
                <td><?= $func->data_contratacao ?></td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</body>
</html>