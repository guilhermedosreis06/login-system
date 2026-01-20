<?php
require_once "../includes/auth.php";
checkLogin();
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Dashboard</title>
</head>
<body>

<h2>Bem-vindo, <?php echo $_SESSION["user_name"]; ?>!</h2>

<p>Você está logado.</p>

<a href="logout.php">Sair</a>

</body>
</html>
