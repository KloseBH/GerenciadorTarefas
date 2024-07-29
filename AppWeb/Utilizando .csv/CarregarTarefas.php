<?php
$arquivo_csv = 'tarefas.csv'; // Define the file path correctly

if (!file_exists($arquivo_csv)) {
    die("Arquivo não encontrado: $arquivo_csv");
}

// Abrir o arquivo CSV para leitura
$arquivo = fopen($arquivo_csv, 'r');

// Verificar se o arquivo foi aberto com sucesso
if ($arquivo !== false) {
    // Array para armazenar os dados do CSV
    $dados = [];

    // Ler linha por linha do arquivo CSV
    while (($linha = fgetcsv($arquivo)) !== false) {
        // Adicionar linha ao array de dados
        $dados[] = $linha;
    }

    // Fechar o arquivo CSV
    fclose($arquivo);

    // Converter os dados para JSON
    $dados_json = json_encode($dados);

    // Retornar os dados como JSON
    echo $dados_json;
} else {
    echo "Não foi possível abrir o arquivo CSV para leitura.";
}
?>
