<?php
require '../vendor/autoload.php';
use \Firebase\JWT\JWT;
use \Firebase\JWT\Key;

$secretKey = "chave_secreta_aqui"; // A mesma chave usada para gerar o token

// Função para proteger a página
function proteger_pagina() {
    global $secretKey; // Tornar a chave secreta acessível dentro da função
    
    if (!isset($_COOKIE['token'])) {
        header('Location: ../index.php');
        exit();
    }

    $token = $_COOKIE['token'];

    try {
        // Usando a nova forma de passar a chave com 'Key' em vez de string direta
        $decoded = JWT::decode($token, new Key($secretKey, 'HS256'));

        // Verifique se o token ainda é válido
        if ($decoded->exp < time()) {
            header('Location: login.php');
            exit();
        }

        // Caso o token seja válido, você pode acessar as informações do usuário
        return $decoded->data;

    } catch (Exception $e) {
        // Caso o token seja inválido ou tenha expirado
        header('Location: ./sala.php');
        exit();
    }
}

function proteger_pagina_funcionario_ou_adm() {
    $usuario = proteger_pagina(); // Verifica se o usuário está logado

    if ($usuario->funcao !== 'funcionario' && $usuario->funcao !== 'adm') {
        header('Location: ./sala.php'); // Redireciona se não for funcionário ou administrador
        exit();
    }

    return $usuario; // Usuário tem a função permitida
}

function proteger_pagina_adm() {
    $usuario = proteger_pagina(); // Verifica se o usuário está logado

    if ($usuario->funcao !== 'adm') {
        header('Location: ./sala.php'); // Redireciona se não for administrador
        exit();
    }

    return $usuario; // Usuário é administrador
}

//$usuario = proteger_pagina_funcionario_ou_adm();
//$usuario = proteger_pagina_adm();

// Usar a função proteger_pagina no início do arquivo que deseja proteger
//$usuario = proteger_pagina();
?>