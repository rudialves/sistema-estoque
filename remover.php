<?php
$db = new PDO('sqlite:banco.db');

$id = $_POST['id'] ?? 0;

if ($id > 0) {
    $stmt = $db->prepare("DELETE FROM produtos WHERE id = ?");
    $stmt->execute([$id]);
}

header("Location: index.php");
exit;