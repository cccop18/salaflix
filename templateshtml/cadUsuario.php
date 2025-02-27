<?php
// Importa a função para proteger a página
require '../login/proteger_pagina.php';

// Protege a página e obtém os dados do usuário logado
$usuario = proteger_pagina_funcionario_ou_adm();

$permissao_adm = ($usuario->funcao === 'adm');
$permissao_funcionario = ($usuario->funcao === 'funcionario' || $usuario->funcao === 'adm');

?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SGS</title>
    <link rel="stylesheet" href="../styles/style.css">
    <link rel="shortcut icon" href="../imagens/favicon-32x32.png" type="image/x-icon">
    <script src="../scripts/javascript.js" defer></script>
    <style>
        .btncad {
            padding: 10px;
            background-color: #00a900;
            font-weight: bold;
            font-size: 1.2em;
            border: solid 1px white;
            border-radius: 5px;
            cursor: pointer;
            color: white;
            margin: 0px 20px;
        }

        .del {
            background-color: #e50000;
        }

        .btncad:hover {
            background-color: #007a00;
        }

        .del:hover {
            background-color: #aa0f00;
        }
        header {
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100px; /* Defina a altura que desejar */
        }

        .header-container {
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .logo {
            width: 50px; /* Ajuste o tamanho da logo conforme necessário */
            height: auto;
            margin-right: 10px; /* Espaço entre a logo e o título */
        }
    </style>
</head>
<body>
<header>
    <div class="header-container">
        <img class="logo" src="../imagens/logo.png" alt="Logo">
        <h1><b>SalaFlix</b></h1>
    </div>
</header>
<hr>
<hr>
<main>
    <form action="../cadastros/cadastro_usuario.php" method="POST" id="formulario">
        <h2>Cadastro de Usuário</h2>
        <br>
        <div class="cadastro">
            <label for="nome_usuario">Nome Completo:</label>
            <input type="text" id="nome_usuario" name="nome_usuario" required>

            <label for="nick_usuario">Nome de Usuário (Nickname):</label>
            <input type="text" id="nick_usuario" name="nick_usuario" required>

            <label for="email_usuario">Email:</label>
            <input type="email" id="email_usuario" name="email_usuario" required>

            <label for="telefone_usuario">Telefone:</label>
            <input type="number" name="telefone_usuario" id="telefone_usuario" require>

            <label for="senha_usuario">Senha:</label>
            <input type="password" id="senha_usuario" name="senha_usuario" required>


            <?php if ($permissao_adm): ?>
                <label for="funcao_usuario">Função:</label>
                <select id="funcao_usuario" name="funcao_usuario" required>
                    <option value="cliente">Cliente</option>
                    <option value="funcionario">Funcionário</option>
                    <option value="adm">Administrador</option>
                </select>
            <?php endif; ?>
            <br><br>
        </div>
        <div class="bot">
            <a href="./usuarios.php" class="btncad del">Cancelar</a>
            <button id="botcad" class="btncad">Cadastrar</button>
        </div>
    </form>
</main>

<footer><br>
    <div id="info-rodape">
        <h4>SalaFlix - Central de Negócios Compartilhados</h4>
        <p>Rua Floriano Peixoto, n° 883 Papouco &curren; 699000-090 &curren; Rio Branco - AC, Brasil</p>
        <p>Tel: (66) 3223-4618 &curren; E-mail: <a href="mailto:cnc.acre@gmail.com">cnc.acre&#64;gmail.com</a></p>
    </div><br>
</footer>

</body>
</html>