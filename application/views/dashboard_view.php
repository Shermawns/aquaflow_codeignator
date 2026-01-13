<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard - AquaFlow</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="<?= base_url('assets/css/style.css') ?>">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <style>
        .card-start {
            background-color: #212529;
            background-color: #ffffff;
            border: none;
            border-radius: 15px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.05);
            transition: transform 0.2s;
        }

        .card-start:hover {
            transform: translateY(-5px);
        }

        .icon-box {
            width: 50px;
            height: 50px;
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 24px;
        }

        .chart-container {
            position: relative;
            height: 300px;
            width: 100%;
        }

        body {
            background-color: #f8f9fa;
        }
    </style>
</head>

<body>

    <div class="container py-5">
        <div class="row mb-4 fade-in">
            <div class="col-12">
                <h2 class="fw-bold text-primary mb-1">Dashboard</h2>
                <p class="text-muted">Visão geral do mês</p>
            </div>
            <div class="d-flex justify-content-end gap-2">
                <a href="<?= site_url('relatorio/gerar_geral_pdf') ?>">
                    <button type="button" class="btn btn-danger btn-sm">
                        <i class="fa-solid fa-file-pdf me-2"></i>PDF
                    </button>
                </a>
                <a href="<?= site_url('relatorio/dashboard_csv') ?>">
                    <button type="button" class="btn btn-success btn-sm">
                        <i class="fa-solid fa-file-csv me-2"></i>CSV
                    </button>
                </a>
                <a href="<?= site_url('relatorio/dashboard_xlsx') ?>">
                    <button type="button" class="btn btn-success btn-sm">
                        <i class="fa-solid fa-file-excel me-2"></i>XLSX
                    </button>
                </a>
            </div>
        </div>


        <div class="row g-4 mb-5 fade-in">
            <div class="col-md-4">
                <div class="card card-start h-100 p-3">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <p class="text-muted mb-1 small fw-bold text-uppercase">Vendas do Mês</p>
                            <h4 class="fw-bold text-dark mb-0">R$ <?= number_format($total_vendas_mes, 2, ',', '.') ?></h4>
                        </div>
                        <div class="icon-box bg-primary bg-opacity-10 text-primary">
                            <i class="fa-solid fa-chart-line"></i>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-md-4">
                <div class="card card-start h-100 p-3">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <p class="text-muted mb-1 small fw-bold text-uppercase">Produto mais vendido</p>
                            <h5 class="fw-bold text-dark mb-0 text-truncate" style="max-width: 250px;">
                                <?= !empty($produtos_mais_vendidos) ? $produtos_mais_vendidos[0]->nome_produto : 'N/A' ?>
                            </h5>
                        </div>
                        <div class="icon-box bg-success bg-opacity-10 text-success">
                            <i class="fa-solid fa-box"></i>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-md-4">
                <div class="card card-start h-100 p-3">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <p class="text-muted mb-1 small fw-bold text-uppercase">Vendedor destaque do mês</p>
                            <h5 class="fw-bold text-dark mb-0 text-truncate" style="max-width: 150px;">
                                <?= !empty($top_funcionarios) ? $top_funcionarios[0]->nome : 'N/A' ?>
                            </h5>
                        </div>
                        <div class="icon-box bg-warning bg-opacity-10 text-warning">
                            <i class="fa-solid fa-trophy"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="row g-4 mb-4 fade-in">

            <!-- Funcinarios q mais venderam em relação a meta atrivuida -->

            <div class="col-md-8">
                <div class="card card-start p-4">
                    <h5 class="fw-bold mb-4">Meta dos funcionários</h5>
                    <div class="chart-container">
                        <canvas id="productsChart"></canvas>
                    </div>
                </div>
            </div>

            <!-- Produtos tooooops vendidos -->

            <div class="col-md-4">
                <div class="card card-start p-4">
                    <h5 class="fw-bold mb-4">Produtos mais vendidos</h5>
                    <div class="chart-container" style="height: 300px;">
                        <canvas id="topProductsChart"></canvas>
                    </div>
                </div>
            </div>
        </div>

        <!-- Vendas mais recentes -->
        <div class="row fade-in">
            <div class="col-12">
                <div class="card card-start p-4">
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <h5 class="fw-bold mb-0">Vendas Recentes</h5>
                    </div>
                    <div class="table-responsive">
                        <table class="table table-hover align-middle">
                            <thead class="table-light">
                                <tr>
                                    <th class="border-0 rounded-start">Data</th>
                                    <th class="border-0">Funcionário</th>
                                    <th class="border-0">Valor Total</th>
                                    <th class="border-0 rounded-end text-end">Ação</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php if (!empty($recent_sales)) : ?>
                                    <?php foreach ($recent_sales as $sale) : ?>
                                        <tr>
                                            <td><?= date('d/m/Y', strtotime($sale->data_venda)) ?></td>
                                            <td>
                                                <div class="d-flex align-items-center">
                                                    <div class="bg-primary bg-opacity-10 text-primary rounded-circle d-flex align-items-center justify-content-center me-2" style="width: 30px; height: 30px; font-size: 12px;">
                                                        <i class="fa-solid fa-user"></i>
                                                    </div>
                                                    <?= htmlspecialchars($sale->nome) ?>
                                                </div>
                                            </td>
                                            <td class="fw-bold text-success">R$ <?= number_format($sale->total, 2, ',', '.') ?></td>
                                            <td class="text-end">
                                                <a href="<?= base_url('vendas') ?>" class="btn btn-sm btn-primary rounded-3 px-3">Detalhes</a>
                                            </td>
                                        </tr>
                                    <?php endforeach; ?>
                                <?php else : ?>
                                    <tr>
                                        <td colspan="4" class="text-center text-muted py-4">Nenhuma venda recente.</td>
                                    </tr>
                                <?php endif; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

    <script>
        const metaData = {
            labels: [<?= implode(',', array_map(function ($m) {
                            return "'" . addslashes($m->nome) . "'";
                        }, $metas_vs_vendas)) ?>],
            datasets: [{
                    label: 'Meta',
                    data: [<?= implode(',', array_map(function ($m) {
                                return $m->meta;
                            }, $metas_vs_vendas)) ?>],
                    backgroundColor: 'rgba(220, 53, 69, 0.7)',
                    borderColor: 'rgba(220, 53, 69, 1)',
                    borderWidth: 1,
                    borderRadius: 5,
                    barPercentage: 0.6,
                },
                {
                    label: 'Realizado',
                    data: [<?= implode(',', array_map(function ($m) {
                                return $m->realizado;
                            }, $metas_vs_vendas)) ?>],
                    backgroundColor: 'rgba(25, 135, 84, 0.7)',
                    borderColor: 'rgba(25, 135, 84, 1)',
                    borderWidth: 1,
                    borderRadius: 5,
                    barPercentage: 0.6,
                }
            ]
        };

        const metaConfig = {
            type: 'bar',
            data: metaData,
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        position: 'top'
                    },
                    tooltip: {
                        mode: 'index',
                        intersect: false,
                    }
                },
                scales: {
                    y: {
                        beginAtZero: true,
                        grid: {
                            color: '#f0f0f0'
                        },
                        ticks: {
                            callback: function(value) {
                                return 'R$ ' + value;
                            }
                        }
                    },
                    x: {
                        grid: {
                            display: false
                        }
                    }
                }
            }
        };

        new Chart(document.getElementById('productsChart'), metaConfig);

        const topProductsData = {
            labels: [<?= implode(',', array_map(function ($p) {
                            return "'" . addslashes($p->nome_produto) . "'";
                        }, $produtos_mais_vendidos)) ?>],
            datasets: [{
                label: 'Qtd Vendida',
                data: [<?= implode(',', array_map(function ($p) {
                            return $p->total_qtd;
                        }, $produtos_mais_vendidos)) ?>],
                backgroundColor: [
                    'rgba(13, 110, 253, 0.8)',
                    'rgba(25, 135, 84, 0.8)',
                    'rgba(255, 193, 7, 0.8)',
                    'rgba(13, 202, 240, 0.8)',
                    'rgba(220, 53, 69, 0.8)'
                ],
                borderWidth: 0,
                hoverOffset: 4
            }]
        };

        const topProductsConfig = {
            type: 'doughnut',
            data: topProductsData,
            options: {
                responsive: true,
                maintainAspectRatio: false,
                cutout: '70%',
                plugins: {
                    legend: {
                        position: 'bottom',
                        labels: {
                            usePointStyle: true,
                            padding: 20
                        }
                    }
                }
            }
        };

        new Chart(document.getElementById('topProductsChart'), topProductsConfig);
    </script>
    <?php
    $this->load->view('chat_widget_view');
    ?>
</body>

</html>