<?php 
session_start();
require_once 'conect.php';
require_once 'funcoes.php'; // Inclui o arquivo de funções

// Verifica se o usuário está logado
if (!isset($_SESSION['iduser'])) {
    $_SESSION['msg'] = 'Login Necessário!';
    header('location: index.php');
    exit;
}

// Obtém as informações da sessão
$username = isset($_SESSION['username']);
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="mypost.css">
    <link rel="icon" type="image/png" href="img/IF.ico">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">
    <title>Página Inicial</title>
</head>

<body>
<header>
    <nav>
        <ul>
            <li>
                <h2>IFTO Connect</h2>
                <a  style=opacity:100%; href="home.php":>Página Inicial</a>
                <a href="postagem.php">Publicar Algo</a>
                <a href="mypost.php">Minhas Postagens</a>
                <?php if ($_SESSION['nivel'] === 'Administrador'): ?>
                    <a href="usuarios.php">Usuários</a>
                <?php endif; ?>
                <a class="sair" href="exit.php">Sair</a>
            </li>
        </ul>
    </nav>
</header>


    <main>
        <div class="postagens">
            <?php
            // Consulta para exibir as postagens de alunos, professores e admins
            $sql = "
            SELECT postagens.*, 
                COALESCE(usuarios.nome) AS nome, usuarios.nivel AS nivel 
                FROM postagens 
                LEFT JOIN usuarios ON postagens.usuarioid = usuarios.id
                ORDER BY postagens.data DESC;";

            $result = mysqli_query($conect, $sql);

            // Verifica se há postagens
            if (mysqli_num_rows($result) > 0) {
                while ($row = mysqli_fetch_assoc($result)) {
                    echo '<div class="postagem">';
                    echo '<h2>@' . ($row['nome']) .  '(' . ($row['nivel']) . ') </h2>';
                    echo '<p class="conteudo">' . ($row['descricao']) . '</p>';
                    echo '<p class="hora">' . tempoDesde($row['data']) . '</p>'; // Usa a função para formatar a data
                    echo '</div>';
                }
            } else {
                echo "<p class='aviso'>Nenhuma postagem encontrada.</p>";
            }

            // Fecha a conexão
            mysqli_close($conect);
            ?>
        </div>
    </main>
</body>
</html>
