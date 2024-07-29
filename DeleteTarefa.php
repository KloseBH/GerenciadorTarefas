<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = $_POST['id'];

    $arquivo = 'tarefas.csv';

    // Lê o arquivo CSV para um array de linhas
    $linhas = file($arquivo, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);

    // Abre o arquivo CSV para escrita temporária
    $handleTemp = fopen('tarefas_temp.csv', 'w');

    if ($handleTemp === false) {
        die("Erro ao abrir o arquivo temporário para escrita.");
    }

    // Percorre as linhas do arquivo CSV
    foreach ($linhas as $linha) {
        $dados = str_getcsv($linha);

        // Se o ID não for o mesmo, mantém a linha
        if ($dados[0] != $id) {
            fputcsv($handleTemp, $dados);
        }
    }

    // Fecha o arquivo temporário após a escrita
    fclose($handleTemp);

    // Substitui o arquivo original pelo temporário
    rename('tarefas_temp.csv', $arquivo);

    echo "Tarefa excluída com sucesso!";
}
?>
