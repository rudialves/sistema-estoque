<?php
$db = new PDO('sqlite:banco.db');

$nome = $_POST['nome'] ?? '';
$preco = $_POST['preco'] ?? 0;
$estoque = $_POST['estoque'] ?? 0;

if ($nome && $preco > 0 && $estoque >= 0) {
    $stmt = $db->prepare("INSERT INTO produtos (nome, preco, estoque) VALUES (?, ?, ?)");
    $stmt->execute([$nome, $preco, $estoque]);
}

header("Location: index.php");
exit;
