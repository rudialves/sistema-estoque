<?php
$db = new PDO('sqlite:banco.db');

$totalVendidos = $db->query("SELECT SUM(quantidade) AS total_itens, SUM(valor_total) AS total_valor FROM vendas");
$totais = $totalVendidos->fetch(PDO::FETCH_ASSOC);

$total_itens_vendidos = $totais['total_itens'] ?? 0;
$valor_total_vendido = $totais['total_valor'] ?? 0.0;

$produtos = $db->query("SELECT * FROM produtos WHERE estoque > 0");

$vendas = $db->query("SELECT vendas.id, produtos.nome, vendas.quantidade, vendas.data_venda, vendas.valor_total
                      FROM vendas 
                      JOIN produtos ON vendas.produto_id = produtos.id
                      ORDER BY vendas.data_venda DESC");
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8" />
    <title>Registrar Venda</title>
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
        <a href="relatorio.php">Relatórios</a>
    </nav>
    </div>
    </header>

    <h2>Registrar Venda</h2>
    <form action="salvar_venda.php" method="post">
        <select name="produto_id" required>
            <option value="">Selecione o produto</option>
            <?php foreach ($produtos as $produto): ?>
                <option value="<?= $produto['id'] ?>">
                    <?= htmlspecialchars($produto['nome']) ?> (Estoque: <?= $produto['estoque'] ?>)
                </option>
            <?php endforeach; ?>
        </select>
        <input type="number" name="quantidade" placeholder="Quantidade" min="1" required />
        <button type="submit">Registrar Venda</button>
    </form>

    <h2>Vendas Realizadas</h2>
    <table>
    <tr>
        <th>ID</th>
        <th>Produto</th>
        <th>Quantidade</th>
        <th>Data</th>
        <th>Valor da Venda (R$)</th>
        <th>Ações</th>
    </tr>
    <?php foreach ($vendas as $venda): ?>
    <tr>
        <td><?= $venda['id'] ?></td>
        <td><?= htmlspecialchars($venda['nome']) ?></td>
        <td><?= $venda['quantidade'] ?></td>
        <td><?= $venda['data_venda'] ?></td>
        <td><?= number_format($venda['valor_total'], 2, ',', '.') ?></td>
        <td>
            <form action="remover_venda.php" method="post" onsubmit="return confirm('Tem certeza que deseja excluir esta venda?');">
                <input type="hidden" name="id" value="<?= $venda['id'] ?>">
                <button type="submit" class="botao-excluir">Excluir</button>
            </form>
        </td>
    </tr> 
    <?php endforeach; ?>
    </table>

    <h3>Resumo de Vendas</h3>
    <p>
        <strong>Total de itens vendidos:</strong> <?= $total_itens_vendidos ?>
    </p>
    <p>
        <strong>Valor total vendido:</strong> R$ <?= number_format($valor_total_vendido, 2, ',', '.') ?>
    </p>
</body>
</html>
