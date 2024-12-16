<?php
session_start();
require_once 'conect.php';

// Verifica se o usuário está logado e se é administrador
if (!isset($_SESSION['iduser']) || $_SESSION['nivel'] !== 'Administrador') {
    $_SESSION['msg'] = 'Acesso restrito!';
    header('Location: index.php');
    exit;
}
// Consulta para buscar todos os usuários
$sql = "SELECT id, nome, email, nivel FROM usuarios ORDER BY nome";
$result = $conect->query($sql);
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Painel de Administração</title>
    <link rel="stylesheet" href="usuarios.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">
    <link rel="icon" type="image/png" href="img/IF.ico">
</head>
<body>
<header>
    <nav>
        <ul>
            <li>
                <h2>IFTO Connect</h2>
                <a href="home.php">Página Inicial</a>
                <a href="postagem.php">Publicar Algo</a>
                <a href="mypost.php">Minhas Postagens</a>
                <?php if ($_SESSION['nivel'] === 'Administrador'): ?>
                    <a  style=opacity:100%;  href="usuarios.php">Usuários</a>
                <?php endif; ?>
                <a class="sair" href="exit.php">Sair</a>
            </li>
        </ul>
    </nav>
</header>

    <main>
        <div class="postagens">
            <h1>Painel de Administração</h1>
            <?php
            if (isset($_SESSION['msg'])) {
                echo '<p class="aviso">' . $_SESSION['msg'] . '</p>';
                unset($_SESSION['msg']);
            }
            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    echo "<div class='postagem'>
                        <h2>" . $row["nome"] . " (" . $row["nivel"] . ")</h2>
                        <p>Email: " . $row["email"] . "</p>
                        <br>
                    </div>";
                }
            } else {
                echo "<p class='aviso'>Nenhum usuário encontrado</p>";
            }
            ?>
        </div>
    </main>
</body>
</html>
