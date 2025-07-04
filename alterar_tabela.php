<?php
$db = new PDO('sqlite:banco.db');

$db->exec("ALTER TABLE vendas ADD COLUMN valor_total REAL");

echo "Coluna valor_total adicionada com sucesso.";
?>
