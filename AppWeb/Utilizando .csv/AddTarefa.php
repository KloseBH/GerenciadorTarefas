<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $titulo = $_POST['titulo'];
    $mensagem = $_POST['mensagem'];
    $prioridade = $_POST['prioridade'];
    $situacao = "aberto";

    $arquivo = 'tarefas.csv';

    // Abre o arquivo CSV para leitura e escrita
    $handle = fopen($arquivo, 'a+');

    if ($handle === false) {
        die("Erro ao abrir o arquivo CSV para escrita.");
    }

    // Lê o conteúdo do arquivo para obter o último ID e ajustar o ponteiro do arquivo
    $id = 1; // Valor padrão para o primeiro ID
    $linhas = file($arquivo);
    if (!empty($linhas)) {
        // Obtém o último ID incrementando 1
        $ultimaLinha = end($linhas);
        $dadosUltimaLinha = str_getcsv($ultimaLinha);
        $id = intval($dadosUltimaLinha[0]) + 1;
    }

    // Monta a linha com os dados da tarefa
    $novaLinha = [$id, $titulo, $mensagem, $prioridade, $situacao];

    // Escreve a linha no final do arquivo CSV
    fputcsv($handle, $novaLinha);

    // Fecha o arquivo após a escrita
    fclose($handle);

    echo "Tarefa adicionada com sucesso! ID: $id";
    header('Location: Tarefas.html');
    exit;
}
?>
