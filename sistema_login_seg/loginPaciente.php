<?php
session_start();
require 'config.php';
include 'ajudante.php';

verificarLogadoTipo();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $email = $_POST['email'];
    $senha = $_POST['senha'];

    $stmt = $pdo->prepare('SELECT * FROM paciente WHERE email = ?');
    $stmt->execute([$email]);
    $user = $stmt->fetch();

    if ($user && password_verify($senha, $user['senha'])) {
        $_SESSION['user_id'] = $user['id'];
        $_SESSION['user_tipo'] = $user['tipo'];
        $_SESSION['user_email'] = $user['email'];
        
        switch ($user['tipo']) {
            case 'paciente':
                header("Location: usuario.php");
                break;

            default:
                header("Location: index.php");
                break;
        }
        exit();
    } else {
        $erro = "Usuário ou senha inválidos!";
    }
}
?>
<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
</head>

<body>
    <div class="login-container">
        <h2>Login</h2>
        <?php if (isset($erro)): ?>
            <p class="error"><?php echo $erro ?></p>
        <?php endif; ?>

        <form action="" method="post">
            <div class="form-group">
                <label for="email">Usuário:</label>
                <input type="email" name="email" id="usuario" required>
            </div>
            <div class="form-group">
                <label for="senha">Senha:</label>
                <input type="password" name="senha" id="senha" required>
            </div>
            <button type="submit">Entrar</button>
        </form>
        <div class="register-link">
            <a href="cadastroPaciente.php">Criar uma conta</a>
        </div>
    </div>
</body>

</html>