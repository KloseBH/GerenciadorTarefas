<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $titulo = $_POST['titulo'];
    $mensagem = $_POST['mensagem'];
    $prioridade = $_POST['prioridade'];
    $situacao = $_POST['situacao']; 
    $id = $_POST['id'];

    $arquivo = 'tarefas.csv';

    $linhas = file($arquivo, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);

    $handleTemp = fopen('tarefas_temp.csv', 'w');

    if ($handleTemp === false) {
        die("Erro ao abrir o arquivo temporário para escrita.");
    }

    $encontrou = false;
    foreach ($linhas as $linha) {
        $dados = str_getcsv($linha);

        if ($dados[0] == $id) {
            $novaLinha = [$id, $titulo, $mensagem, $prioridade, $situacao];
            fputcsv($handleTemp, $novaLinha);
            $encontrou = true;
        } else {
            fputcsv($handleTemp, $dados);
        }
    }

    if (!$encontrou) {
        $novaLinha = [$id, $titulo, $mensagem, $prioridade, $situacao];
        fputcsv($handleTemp, $novaLinha);
    }

    fclose($handleTemp);

    rename('tarefas_temp.csv', $arquivo);

    echo "Tarefa atualizada com sucesso!";
}
?>
