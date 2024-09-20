<<<<<<< HEAD
<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = $_POST['id'];

    $arquivo = 'tarefas.csv';

    $linhas = file($arquivo, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);

    $handleTemp = fopen('tarefas_temp.csv', 'w');

    if ($handleTemp === false) {
        die("Erro ao abrir o arquivo temporário para escrita.");
    }

    foreach ($linhas as $linha) {
        $dados = str_getcsv($linha);

        if ($dados[0] != $id) {
            fputcsv($handleTemp, $dados);
        }
    }

    fclose($handleTemp);

    rename('tarefas_temp.csv', $arquivo);

    echo "Tarefa excluída com sucesso!";
}
?>
=======
<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = $_POST['id'];

    $arquivo = 'tarefas.csv';

    $linhas = file($arquivo, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);

    $handleTemp = fopen('tarefas_temp.csv', 'w');

    if ($handleTemp === false) {
        die("Erro ao abrir o arquivo temporário para escrita.");
    }

    foreach ($linhas as $linha) {
        $dados = str_getcsv($linha);

        if ($dados[0] != $id) {
            fputcsv($handleTemp, $dados);
        }
    }

    fclose($handleTemp);

    rename('tarefas_temp.csv', $arquivo);

    echo "Tarefa excluída com sucesso!";
}
?>
>>>>>>> 372a888615a22f72b88a2f8ee25eafe1192da021
