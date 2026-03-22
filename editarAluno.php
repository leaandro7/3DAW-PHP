<?php

$nomeEdit = "";
$idadeEdit = "";
$idEdit = "";

// CARREGAR DADOS PARA EDITAR
if(isset($_POST["carregar"])) {
    $nomeEdit = $_POST["nome"];
    $idadeEdit = $_POST["idade"];
    $idEdit = $_POST["id"];
}

// EDITAR
if(isset($_POST["editar"])) {
    $id = $_POST["id"];
    $nome = $_POST["nome"];
    $idade = $_POST["idade"];

    $linhas = file("alunos.txt");
    $linhas[$id] = "$nome;$idade;\n";

    file_put_contents("alunos.txt", implode("", $linhas));
}

// CADASTRAR (só se NÃO estiver editando)
if(isset($_POST["nome"]) && isset($_POST["idade"]) && !isset($_POST["editar"]) && !isset($_POST["carregar"])) {
    $nome = $_POST["nome"];
    $idade = $_POST["idade"];

    $linha = "$nome;$idade;\n";
    file_put_contents("alunos.txt", $linha, FILE_APPEND);
}
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Alunos</title>
</head>
<body>

<h2>Cadastrar / Editar Aluno</h2>

<form method="POST">
    <input type="hidden" name="id" value="<?= $idEdit ?>">

    Nome: <input type="text" name="nome" value="<?= $nomeEdit ?>" required>
    Idade: <input type="number" name="idade" value="<?= $idadeEdit ?>" required>

    <?php if($idEdit !== ""): ?>
        <button name="editar">Salvar edição</button>
    <?php else: ?>
        <button type="submit">Cadastrar aluno</button>
    <?php endif; ?>
</form>

<hr>

<form method="POST">
    <button name="mostrar">Mostrar Alunos</button>
</form>

<?php
// MOSTRAR ALUNOS
if(isset($_POST["mostrar"]) || isset($_POST["carregar"]) || isset($_POST["editar"])) {

    if(file_exists("alunos.txt")) {

        $linhas = file("alunos.txt");

        echo "<table border='1'>";
        echo "<tr><th>Nome</th><th>Idade</th><th>Ação</th></tr>";

        foreach($linhas as $index => $linha) {
            if(trim($linha) != "") {
                $dados = explode(";", $linha);

                echo "<tr>";
                echo "<td>".$dados[0]."</td>";
                echo "<td>".$dados[1]."</td>";

                echo "<td>
                    <form method='POST' style='display:inline'>
                        <input type='hidden' name='id' value='$index'>
                        <input type='hidden' name='nome' value='{$dados[0]}'>
                        <input type='hidden' name='idade' value='{$dados[1]}'>
                        <button name='carregar'>Editar</button>
                    </form>
                </td>";

                echo "</tr>";
            }
        }

        echo "</table>";
    }
}
?>

</body>
</html>