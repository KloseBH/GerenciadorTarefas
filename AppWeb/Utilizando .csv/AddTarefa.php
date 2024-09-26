<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $titulo = $_POST['titulo'];
    $mensagem = $_POST['mensagem'];
    $prioridade = $_POST['prioridade'];
    $situacao = "aberto";

    $arquivo = 'tarefas.csv';

    $handle = fopen($arquivo, 'a+');

    if ($handle === false) {
        die("Erro ao abrir o arquivo CSV para escrita.");
    }

    $id = 1;
    $linhas = file($arquivo);
    if (!empty($linhas)) {
        $ultimaLinha = end($linhas);
        $dadosUltimaLinha = str_getcsv($ultimaLinha);
        $id = intval($dadosUltimaLinha[0]) + 1;
    }

    $novaLinha = [$id, $titulo, $mensagem, $prioridade, $situacao];

    fputcsv($handle, $novaLinha);

    fclose($handle);

    echo "Tarefa adicionada com sucesso! ID: $id";
    header('Location: Tarefas.html');
    exit;
}
?>
