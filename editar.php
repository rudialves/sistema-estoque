<?php
$db = new PDO('sqlite:banco.db');

$id = $_GET['id'] ?? 0;

$stmt = $db->prepare("SELECT * FROM produtos WHERE id = ?");
$stmt->execute([$id]);
$produto = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$produto) {
    echo "Produto não encontrado.";
    exit;
}
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8" />
    <title>Editar Produto</title>
    <link rel="stylesheet" href="style.css" />
</head>
<body>
    <h2>Editar Produto</h2>

    <form action="atualizar.php" method="post">
        <input type="hidden" name="id" value="<?= $produto['id'] ?>" />
        <input type="text" name="nome" value="<?= htmlspecialchars($produto['nome']) ?>" required />
        <input type="number" step="0.01" name="preco" value="<?= $produto['preco'] ?>" required />
        <input type="number" name="estoque" value="<?= $produto['estoque'] ?>" required />
        <button type="submit">Salvar Alterações</button>
    </form>

    <a href="index.php">← Voltar</a>
</body>
</html>
