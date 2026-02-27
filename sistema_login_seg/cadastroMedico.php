<?php

session_start();
include 'config.php';
include 'ajudante.php';

verificarLogadoTipo();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $email = validateEmail($_POST['email']);
    $resultadoSenha = validarConfirmacaoSenha($_POST['senha'], $_POST['confirmar_senha']);
    $nome = $_POST['nome'];
    $cpf = $_POST['cpf'];
    $telefone = $_POST['telefone'];
    $crm = $_POST['crm'];
    

    if ($resultadoSenha !== true) {
        $erros[] = $resultadoSenha;
    } else {

        $senha = password_hash($_POST['senha'], PASSWORD_DEFAULT);
    }

    try {

        $verifica = $pdo->prepare("SELECT id FROM medico WHERE email = ?");
        $verifica->execute([$email]);

        if ($verifica->rowCount() > 0) {
            $erros[] = "Este e-mail já está cadastrado!";
        } else {

            $stmt = $pdo->prepare('INSERT INTO medico (email,senha,nome,cpf,telefone,crm) VALUES (?,?,?,?,?,?)');
            $stmt->execute([$email, $senha, $nome, $cpf, $telefone, $crm]);

            $sucesso = "Usuário cadastrado com sucesso!";
        }
    } catch (PDOException $e) {
        $erros[] = "Erro ao cadastrar o usuário: " . $e->getMessage();
    }
}
?>
<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cadastro</title>
</head>

<body>
    <div class="cadastro-container">
        <h2>Cadastro</h2>
        <?php if (!empty($erros)): ?>
            <div class="error">
                <ul>
                    <?php foreach ($erros as $erro): ?>
                        <li><?php echo $erro; ?></li>
                    <?php endforeach; ?>
                </ul>
            </div>
        <?php endif; ?>

        <?php if (isset($sucesso)): ?>
            <p class="successo"><?php echo $sucesso ?></p>
        <?php endif; ?>

        <form action="" method="post">
            <div class="form-group">
                <label for="nome">Nome:</label>
                <input type="text" name="nome" id="usuario" required>
            </div>
            <div class="form-group">
                <label for="email">E-mail:</label>
                <input type="email" name="email" id="usuario" required>
            </div>
            <div class="form-group">
                <label for="senha">Senha:</label>
                <input type="password" name="senha" id="senha" required>
            </div>
            <div class="form-group">
                <label for="confirmar_senha">Confirmar Senha:</label>
                <input type="password" name="confirmar_senha" id="usuario" required>
            </div>
            <div class="form-group">
                <label for="crm">CRM:</label>
                <input type="text" name="crm" id="usuario" required>
            </div>
            <div class="form-group">
                <label for="cpf">CPF:</label>
                <input type="text" name="cpf" id="usuario" required>
            </div>
            <div class="form-group">
                <label for="telefone">Telefone:</label>
                <input type="text" name="telefone" id="usuario" required>
            </div>
            <button type="submit">cadastrar</button>
        </form>
        <div class="register-link">
            <a href="loginMedico.php">Voltar para Login</a>
        </div>
    </div>
</body>

</html>