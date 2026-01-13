<!DOCTYPE html>
<html>

<head>
    <title>Relatório de Vendas</title>
    <style>
        body {
            font-family: sans-serif;
            font-size: 12px;
            color: #333;
        }

        .cabecalho {
            text-align: center;
            margin-bottom: 20px;
            border-bottom: 2px solid #ddd;
            padding-bottom: 10px;
        }

        .titulo {
            font-size: 18px;
            font-weight: bold;
            color: #2c3e50;
        }

        h3 {
            color: #2c3e50;
            border-bottom: 1px solid #2c3e50;
            padding-bottom: 5px;
            margin-bottom: 10px;
            font-size: 14px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 10px;
        }

        th {
            background-color: #2c3e50;
            color: white;
            padding: 8px;
            text-align: left;
        }

        td {
            border: 1px solid #ddd;
            padding: 8px;
        }

        tr:nth-child(even) {
            background-color: #f2f2f2;
        }

        .text-right {
            text-align: right;
        }

        .text-center {
            text-align: center;
        }

        .text-success {
            color: green;
            font-weight: bold;
        }
    </style>
</head>

<body>

    <div class="cabecalho">
        <h1 class="titulo">Relatório de Vendas</h1>
        <p>Gerado em: <?php echo date('d/m/Y H:i'); ?></p>
    </div>

    <h3>Listagem de Vendas</h3>
    <table>
        <thead>
            <tr>
                <th>Funcionário</th>
                <th>Data</th>
                <th>Produtos</th>
                <th class="text-right">Valor Total</th>
            </tr>
        </thead>
        <tbody>
            <?php if (!empty($lista_vendas)): ?>
                <?php foreach ($lista_vendas as $venda): ?>
                    <tr>
                        <td><?= $venda->funcionario_vendas ?></td>
                        <td><?= date('d/m/Y', strtotime($venda->data_venda)) ?></td>
                        <td><?= $venda->lista_produtos ?></td>
                        <td class="text-right text-success">R$ <?= number_format($venda->valor_total_venda, 2, ',', '.') ?></td>
                    </tr>
                <?php endforeach; ?>
            <?php else: ?>
                <tr>
                    <td colspan="4" class="text-center">Nenhuma venda registrada.</td>
                </tr>
            <?php endif; ?>
        </tbody>
    </table>

</body>

</html>