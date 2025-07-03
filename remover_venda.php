<?php
if (!isset($_POST['id'])) {
    header('Location: vendas.php');
    exit;
}

$db = new PDO('sqlite:banco.db');

$stmt = $db->prepare("SELECT * FROM vendas WHERE id = ?");
$stmt->execute([$_POST['id']]);
$venda = $stmt->fetch(PDO::FETCH_ASSOC);

if ($venda) {
    $stmtEstoque = $db->prepare("UPDATE produtos SET estoque = estoque + ? WHERE id = ?");
    $stmtEstoque->execute([$venda['quantidade'], $venda['produto_id']]);

    $stmtDelete = $db->prepare("DELETE FROM vendas WHERE id = ?");
    $stmtDelete->execute([$_POST['id']]);
}

header('Location: vendas.php');
exit;
