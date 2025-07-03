# Sistema de Controle de Estoque em PHP

Este é um sistema simples de controle de estoque desenvolvido em PHP com SQLite. Ele permite cadastrar, editar, remover e listar produtos, e também permite o registro e exclusão de vendas.

## Funcionalidades

- Cadastro de produtos (nome, preço, quantidade em estoque)
- Editar produtos
- Remover produtos
- Registro de vendas (com atualização automática do estoque)
- Remoção de vendas (com reposição do estoque)
- Geração de relatório de produtos
- Interface simples com HTML e CSS

## Tecnologias utilizadas

- PHP
- SQLite
- HTML/CSS
- Git e GitHub

## Estrutura de Arquivos

- `index.php` – Tela inicial com listagem dos produtos
- `editar.php` – Formulário para edição de produtos
- `salvar.php` – Salva novos produtos
- `atualizar.php` – Atualiza produtos existentes
- `remover.php` – Remove um produto
- `vendas.php` – Tela para registrar vendas
- `salvar_venda.php` – Salva uma nova venda
- `remover_venda.php` – Remove uma venda e repõe o estoque
- `relatorio.php` – Gera um relatório dos produtos
- `setup.php` – Cria as tabelas do banco de dados
- `banco.db` – Banco de dados SQLite

## Como executar

1. Clone este repositório:
git clone https://github.com/rudialves/sistema-estoque.git

2. Copie a pasta clonada para o diretório do XAMPP:
C:\xampp\htdocs\

3. Abra o XAMPP e inicie o Apache.

4. Crie as tabelas necessárias acessando no navegador:
http://localhost/sistema-estoque/setup.php

5. Acesse o sistema:
http://localhost/sistema-estoque/index.php
