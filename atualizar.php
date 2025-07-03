<?php
$db = new PDO('sqlite:banco.db');

$id = $_POST['id'] ?? 0;
$nome = $_POST['nome'] ?? '';
$preco = $_POST['preco'] ?? 0;
$estoque = $_POST['estoque'] ?? 0;

if ($id && $nome && $preco >= 0 && $estoque >= 0) {
    $stmt = $db->prepare("UPDATE produtos SET nome = ?, preco = ?, estoque = ? WHERE id = ?");
    $stmt->execute([$nome, $preco, $estoque, $id]);
}

header("Location: index.php");
exit;