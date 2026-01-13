<!DOCTYPE html>
<html>
<head>
    <title>Relatório Geral - Dashboard</title>
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
            margin-top: 25px;
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

        .text-right { text-align: right; }
        .text-center { text-align: center; }
        .status-ok { color: green; font-weight: bold; }
        .status-danger { color: red; font-weight: bold; }
    </style>
</head>
<body>

    <div class="cabecalho">
        <h1 class="titulo">Relatório Geral do Dashboard</h1>
        <p>Gerado em: <?php echo date('d/m/Y H:i'); ?></p>
    </div>

    <h3>Resumo do Mês (KPIs)</h3>
    <table>
        <thead>
            <tr>
                <th>Vendas do Mês</th>
                <th>Produto Top</th>
                <th>Funcionário Destaque</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td>R$ <?= number_format($total_vendas_mes, 2, ',', '.') ?></td>
                <td><?= !empty($produtos_mais_vendidos) ? $produtos_mais_vendidos[0]->nome_produto : 'N/A' ?></td>
                <td><?= !empty($top_funcionarios) ? $top_funcionarios[0]->nome : 'N/A' ?></td>
            </tr>
        </tbody>
    </table>

    <h3>Metas dos Funcionários</h3>
    <table>
        <thead>
            <tr>
                <th>Funcionário</th>
                <th>Meta</th>
                <th>Realizado</th>
                <th>Status</th>
            </tr>
        </thead>
        <tbody>
            <?php if (!empty($metas_vs_vendas)): ?>
                <?php foreach ($metas_vs_vendas as $meta): ?>
                    <tr>
                        <td><?= $meta->nome ?></td>
                        <td>R$ <?= number_format($meta->meta, 2, ',', '.') ?></td>
                        <td>R$ <?= number_format($meta->realizado, 2, ',', '.') ?></td>
                        <td>
                            <?php if ($meta->realizado >= $meta->meta): ?>
                                <span class="status-ok">Atingida</span>
                            <?php else: ?>
                                <span class="status-danger">Pendente</span>
                            <?php endif; ?>
                        </td>
                    </tr>
                <?php endforeach; ?>
            <?php else: ?>
                <tr>
                    <td colspan="4" class="text-center">Nenhum dado de meta encontrado.</td>
                </tr>
            <?php endif; ?>
        </tbody>
    </table>

    <h3>Produtos Mais Vendidos</h3>
    <table>
        <thead>
            <tr>
                <th>Produto</th>
                <th class="text-right">Quantidade Vendida</th>
            </tr>
        </thead>
        <tbody>
            <?php if (!empty($produtos_mais_vendidos)): ?>
                <?php foreach ($produtos_mais_vendidos as $prod): ?>
                    <tr>
                        <td><?= $prod->nome_produto ?></td>
                        <td class="text-right"><?= $prod->total_qtd ?></td>
                    </tr>
                <?php endforeach; ?>
            <?php else: ?>
                <tr>
                    <td colspan="2" class="text-center">Nenhum produto vendido.</td>
                </tr>
            <?php endif; ?>
        </tbody>
    </table>

    <h3>Vendas Recentes</h3>
    <table>
        <thead>
            <tr>
                <th>Data</th>
                <th>Funcionário</th>
                <th class="text-right">Valor Total</th>
            </tr>
        </thead>
        <tbody>
            <?php if (!empty($recent_sales)): ?>
                <?php foreach ($recent_sales as $sale): ?>
                    <tr>
                        <td><?= date('d/m/Y', strtotime($sale->data_venda)) ?></td>
                        <td><?= $sale->nome ?></td>
                        <td class="text-right">R$ <?= number_format($sale->total, 2, ',', '.') ?></td>
                    </tr>
                <?php endforeach; ?>
            <?php else: ?>
                <tr>
                    <td colspan="3" class="text-center">Nenhuma venda recente.</td>
                </tr>
            <?php endif; ?>
        </tbody>
    </table>

</body>
</html>