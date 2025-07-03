<?php
$db = new PDO('sqlite:banco.db');

$produto_id = $_POST['produto_id'] ?? 0;
$quantidade = $_POST['quantidade'] ?? 0;

if ($produto_id > 0 && $quantidade > 0) {
    // Busca preço e estoque do produto
    $stmt = $db->prepare("SELECT preco, estoque FROM produtos WHERE id = ?");
    $stmt->execute([$produto_id]);
    $produto = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($produto && $produto['estoque'] >= $quantidade) {
        // Calcula valor total da venda
        $valor_total = $produto['preco'] * $quantidade;

        // Atualiza o estoque
        $novo_estoque = $produto['estoque'] - $quantidade;
        $stmt = $db->prepare("UPDATE produtos SET estoque = ? WHERE id = ?");
        $stmt->execute([$novo_estoque, $produto_id]);

        // Insere a venda com valor_total
        $stmt = $db->prepare("INSERT INTO vendas (produto_id, quantidade, data_venda, valor_total) VALUES (?, ?, ?, ?)");
        $stmt->execute([$produto_id, $quantidade, date('Y-m-d H:i:s'), $valor_total]);
    }
}

header("Location: vendas.php");
exit;