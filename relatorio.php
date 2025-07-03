<?php
$db = new PDO('sqlite:banco.db');

$data_inicio = $_GET['inicio'] ?? '';
$data_fim = $_GET['fim'] ?? '';

$consulta = "SELECT vendas.*, produtos.nome 
             FROM vendas 
             JOIN produtos ON produtos.id = vendas.produto_id";

$parametros = [];

if ($data_inicio && $data_fim) {
    $consulta .= " WHERE date(data_venda) BETWEEN ? AND ?";
    $parametros[] = $data_inicio;
    $parametros[] = $data_fim;
    $consulta .= " ORDER BY data_venda DESC";
}

$stmt = $db->prepare($consulta);
$stmt->execute($parametros);
$vendas_filtradas = $stmt->fetchAll(PDO::FETCH_ASSOC);

$estoque_baixo = $db->query("SELECT * FROM produtos WHERE estoque < 5")->fetchAll(PDO::FETCH_ASSOC);

$total_por_produto = $db->query("
    SELECT produtos.nome, SUM(vendas.quantidade) as total_vendido, SUM(vendas.valor_total) as valor_total
    FROM vendas
    JOIN produtos ON produtos.id = vendas.produto_id
    GROUP BY produtos.nome
    ORDER BY valor_total DESC
")->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8" />
    <title>Relatórios</title>
    <link rel="stylesheet" href="style.css" />
</head>
<body>
<header>
    <div class="container">
        <div class="logo">
            <h1>Mercado</h1>
        </div>
        <nav>
            <a href="index.php">Cadastro de Produtos</a>
            <a href="vendas.php">Registrar Venda</a>
            <a href="relatorios.php">Relatórios</a>
        </nav>
    </div>
</header>

<h2>Relatório de Vendas por Período</h2>
<form method="get">
    <input type="date" name="inicio" value="<?= htmlspecialchars($data_inicio) ?>" required />
    <input type="date" name="fim" value="<?= htmlspecialchars($data_fim) ?>" required />
    <button type="submit">Filtrar</button>
</form>

<?php if ($data_inicio && $data_fim): ?>
    <table>
        <tr>
            <th>Produto</th>
            <th>Quantidade</th>
            <th>Data</th>
            <th>Valor da Venda (R$)</th>
        </tr>
        <?php foreach ($vendas_filtradas as $v): ?>
            <tr>
                <td><?= htmlspecialchars($v['nome']) ?></td>
                <td><?= $v['quantidade'] ?></td>
                <td><?= $v['data_venda'] ?></td>
                <td><?= number_format($v['valor_total'], 2, ',', '.') ?></td>
            </tr>
        <?php endforeach; ?>
    </table>
<?php endif; ?>

<h2>Produtos com Estoque Baixo (menos de 5 unidades)</h2>
<table>
    <tr>
        <th>Produto</th>
        <th>Estoque Atual</th>
    </tr>
    <?php foreach ($estoque_baixo as $p): ?>
        <tr>
            <td><?= htmlspecialchars($p['nome']) ?></td>
            <td><?= $p['estoque'] ?></td>
        </tr>
    <?php endforeach; ?>
</table>

<h2>Total Vendido por Produto</h2>
<table>
    <tr>
        <th>Produto</th>
        <th>Qtd Total Vendida</th>
        <th>Valor Total (R$)</th>
    </tr>
    <?php foreach ($total_por_produto as $t): ?>
        <tr>
            <td><?= htmlspecialchars($t['nome']) ?></td>
            <td><?= $t['total_vendido'] ?></td>
            <td><?= number_format($t['valor_total'], 2, ',', '.') ?></td>
        </tr>
    <?php endforeach; ?>
</table>
</body>
</html>
