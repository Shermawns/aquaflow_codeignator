<!DOCTYPE html>
<html>
<head>
    <title>Relatório de metas</title>
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
        <h1 class="titulo">Relatório de metas</h1>
        <p>Gerado em: <?php echo date('d/m/Y H:i'); ?></p>
    </div>

    <table>
        <thead>
            <tr>
                <th>Nome</th>
                <th>Meta</th>
                <th>Realizado</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach($metas_vs_vendas as $meta): ?>
            <tr>
                <td><?= $meta->nome ?></td>
                <td><?= 'R$ ' . number_format($meta->meta, 2, ',', '.') ?></td>
                <td><?= 'R$ ' . number_format($meta->realizado, 2, ',', '.') ?></td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</body>
</html>