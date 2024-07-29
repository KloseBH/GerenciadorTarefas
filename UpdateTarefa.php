<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Recebe os dados do formulário
    $titulo = $_POST['titulo'];
    $mensagem = $_POST['mensagem'];
    $prioridade = $_POST['prioridade'];
    $situacao = $_POST['situacao']; 
    $id = $_POST['id'];

    $arquivo = 'tarefas.csv';

    // Lê todas as linhas do arquivo CSV em um array
    $linhas = file($arquivo, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);

    // Abre o arquivo CSV para escrita temporária
    $handleTemp = fopen('tarefas_temp.csv', 'w');

    if ($handleTemp === false) {
        die("Erro ao abrir o arquivo temporário para escrita.");
    }

    // Processa cada linha do arquivo
    $encontrou = false;
    foreach ($linhas as $linha) {
        $dados = str_getcsv($linha);

        // Verifica se encontrou a linha correspondente ao ID da tarefa
        if ($dados[0] == $id) {
            // Atualiza os dados da tarefa
            $novaLinha = [$id, $titulo, $mensagem, $prioridade, $situacao];
            fputcsv($handleTemp, $novaLinha);
            $encontrou = true;
        } else {
            // Mantém as outras linhas como estão
            fputcsv($handleTemp, $dados);
        }
    }

    // Se o ID não foi encontrado, adiciona a nova tarefa
    if (!$encontrou) {
        $novaLinha = [$id, $titulo, $mensagem, $prioridade, $situacao];
        fputcsv($handleTemp, $novaLinha);
    }

    // Fecha o arquivo temporário após a escrita
    fclose($handleTemp);

    // Substitui o arquivo original pelo temporário
    rename('tarefas_temp.csv', $arquivo);

    echo "Tarefa atualizada com sucesso!";
}
?>
