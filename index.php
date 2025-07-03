<?php
$db = new PDO('sqlite:banco.db');

$produtos = $db->query("SELECT * FROM produtos");

$total_estoque = 0;
$valor_total_estoque = 0;

foreach ($produtos as $produto) {
    $total_estoque += $produto['estoque'];
    $valor_total_estoque += $produto['estoque'] * $produto['preco'];
}

$produtos = $db->query("SELECT * FROM produtos");
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8" />
    <title>Cadastro de Produtos</title>
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

    <h2>Cadastro de Produtos</h2>
    <form action="salvar.php" method="post">
        <input type="text" name="nome" placeholder="Nome do produto" required />
        <input type="number" step="0.01" name="preco" placeholder="Preço" required />
        <input type="number" name="estoque" placeholder="Quantidade em estoque" required />
        <button type="submit">Cadastrar Produto</button>
    </form>

    <h2>Produtos Cadastrados</h2>
    <table>
        <tr>
            <th>ID</th>
            <th>Nome</th>
            <th>Preço Unitário (R$)</th>
            <th>Estoque</th>
            <th>Valor Em Estoque (R$)</th>
        <th>Ações</th>
        </tr>
        <?php foreach ($produtos as $produto): ?>
            <tr>
                <td><?= $produto['id'] ?></td>
                <td><?= htmlspecialchars($produto['nome']) ?></td>
                <td><?= number_format($produto['preco'], 2, ',', '.') ?></td>
                <td><?= $produto['estoque'] ?></td>
                <td><?= number_format($produto['preco'] * $produto['estoque'], 2, ',', '.') ?></td>
                <td class="celula-acoes">
                    <a href="editar.php?id=<?= $produto['id'] ?>" class="botao-editar">Editar</a>
                    <form action="remover.php" method="post" onsubmit="return confirm('Quer mesmo excluir este produto?');">
                        <input type="hidden" name="id" value="<?= $produto['id'] ?>" />
                        <button type="submit" class="botao-excluir">Excluir</button>
                    </form>
                </td>
            </tr>
<?php endforeach; ?>
    </table>

    <h3>Resumo do Estoque</h3>
    <p><strong>Total de itens em estoque:</strong> <?= $total_estoque ?></p>
    <p><strong>Valor total em estoque:</strong> R$ <?= number_format($valor_total_estoque, 2, ',', '.') ?></p>
</body>
</html>
