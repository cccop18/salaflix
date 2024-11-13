<?php
// Iniciar a sessão
session_start();

// Remover o cookie do token
setcookie("token", "", time() - 3600, "/"); // Define o cookie com valor vazio e expira no passado

// Destruir a sessão (opcional, caso você esteja usando sessões)
session_destroy();

// Redirecionar o usuário para a página de login ou home
header("Location: ../index.php");
exit();
?>
