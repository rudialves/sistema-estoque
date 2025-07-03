<?php
$db = new PDO('sqlite:banco.db');

$db->exec("CREATE TABLE IF NOT EXISTS produtos (
    id INTEGER PRIMARY KEY AUTOINCREMENT,
    nome TEXT,
    preco REAL,
    estoque INTEGER
)");

$db->exec("CREATE TABLE IF NOT EXISTS vendas (
    id INTEGER PRIMARY KEY AUTOINCREMENT,
    produto_id INTEGER,
    quantidade INTEGER,
    data_venda TEXT,
    FOREIGN KEY(produto_id) REFERENCES produtos(id)
)");

echo "Tabelas criadas/confirmadas.";
?>