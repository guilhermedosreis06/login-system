<?php
require_once "../config/database.php";

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $name  = trim($_POST["name"]);
    $email = trim($_POST["email"]);
    $pass  = $_POST["password"];

    if (empty($name) || empty($email) || empty($pass)) {
        $error = "Preencha todos os campos.";
    } else {
        $check = $conn->prepare("SELECT id FROM users WHERE email = ?");
        $check->bind_param("s", $email);
        $check->execute();
        $check->store_result();

        if ($check->num_rows > 0) {
            $error = "Este e-mail já está cadastrado.";
        } else {
            $password = password_hash($pass, PASSWORD_DEFAULT);

            $stmt = $conn->prepare(
                "INSERT INTO users (name, email, password) VALUES (?, ?, ?)"
            );
            $stmt->bind_param("sss", $name, $email, $password);

            if ($stmt->execute()) {
                header("Location: login.php");
                exit;
            } else {
                $error = "Erro ao cadastrar usuário.";
            }
        }
    }
}
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Cadastro</title>
</head>
<body>

<h2>Criar conta</h2>

<?php if (!empty($error)): ?>
    <p style="color: red;"><?= $error ?></p>
<?php endif; ?>

<form method="POST">
    <input type="text" name="name" placeholder="Nome"><br><br>
    <input type="email" name="email" placeholder="E-mail"><br><br>
    <input type="password" name="password" placeholder="Senha"><br><br>
    <button type="submit">Cadastrar</button>
</form>

<p><a href="login.php">Já tenho conta</a></p>

</body>
</html>
