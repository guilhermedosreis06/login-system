<?php
session_start();
require_once "../config/database.php";

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $email = trim($_POST["email"]);
    $pass  = $_POST["password"];

    if (empty($email) || empty($pass)) {
        $error = "Preencha todos os campos.";
    } else {
        $stmt = $conn->prepare("SELECT id, name, password FROM users WHERE email = ?");
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows === 1) {
            $user = $result->fetch_assoc();

            if (password_verify($pass, $user["password"])) {
                $_SESSION["user_id"] = $user["id"];
                $_SESSION["user_name"] = $user["name"];
                header("Location: dashboard.php");
                exit;
            } else {
                $error = "Senha incorreta.";
            }
        } else {
            $error = "Usuário não encontrado.";
        }
    }
}
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Login</title>
</head>
<body>

<h2>Login</h2>

<?php if (!empty($error)) echo "<p style='color:red'>$error</p>"; ?>

<form method="POST">
    <input type="email" name="email" placeholder="E-mail"><br><br>
    <input type="password" name="password" placeholder="Senha"><br><br>
    <button type="submit">Entrar</button>
</form>

<p><a href="register.php">Criar conta</a></p>

</body>
</html>
