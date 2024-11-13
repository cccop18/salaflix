<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require '../conexao/db_connection.php';
require '../vendor/autoload.php'; // Carrega a biblioteca JWT

use \Firebase\JWT\JWT;

$secretKey = "chave_secreta_aqui"; // Altere para uma chave secreta segura

header('Content-Type: application/json'); // Define o tipo de conteúdo como JSON

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = $_POST['login'];
    $senha = $_POST['senha'];

    // Verificar o email no banco de dados
    $sql = "SELECT id_usuario, email_usuario, senha_usuario, funcao_usuario, nome_usuario, nick_usuario, telefone_usuario FROM usuarios WHERE email_usuario = ?";
    $stmt = $conn->prepare($sql);
    $stmt->execute([$email]);

    // Verificar se algum resultado foi encontrado
    $user = $stmt->fetch(PDO::FETCH_ASSOC);
    
    if ($user) {
        $id_usuario = $user['id_usuario'];
        $email_usuario = $user['email_usuario'];
        $senha_hash = $user['senha_usuario'];
        $funcao_usuario = $user['funcao_usuario'];
        $nome_usuario = $user['nome_usuario'];
        $nickname_usuario = $user['nick_usuario'];
        $telefone_usuario = $user['telefone_usuario'];

        // Verificar se a senha foi encontrada (ou se está nula)
        if ($senha_hash && password_verify($senha, $senha_hash)) {
            // Gerar o token JWT
            $payload = [
                "iss" => "localhost", // Emissor
                "aud" => "localhost", // Audiência
                "iat" => time(), // Emitido em
                "exp" => time() + (60 * 10), // Expira em 10 minutos
                "data" => [
                    "id" => $id_usuario,
                    "email" => $email_usuario,
                    "nome" => $nome_usuario,
                    "nickname" => $nickname_usuario,
                    "funcao" => $funcao_usuario,
                    "telefone" => $telefone_usuario
                ]
            ];

            $jwt = JWT::encode($payload, $secretKey, 'HS256');
            setcookie("token", $jwt, time() + (60 * 10), "/");

            // Retornar o token
            echo json_encode([
                "status" => "success",
                "token" => $jwt,
                "redirect" => "./templateshtml/sala.php"
            ]);
        } else {
            echo json_encode([
                "status" => "error",
                "message" => "Usuário ou Senha Inválido"
            ]);
        }
    } else {
        echo json_encode([
            "status" => "error",
            "message" => "Usuário ou Senha Inválido"
        ]);
    }
}
?>
