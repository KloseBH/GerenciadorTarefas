<?php
$arquivo_csv = 'tarefas.csv'; // Define o arquivo

if (!file_exists($arquivo_csv)) {
    die("Arquivo não encontrado: $arquivo_csv");
}

$arquivo = fopen($arquivo_csv, 'r');

// Verificar se o arquivo foi aberto com sucesso
if ($arquivo !== false) {
    $dados = [];

    while (($linha = fgetcsv($arquivo)) !== false) {
        $dados[] = $linha;
    }

    fclose($arquivo);

    // Converter os dados para JSON
    $dados_json = json_encode($dados);

    echo $dados_json;
} else {
    echo "Não foi possível abrir o arquivo CSV para leitura.";
}
?>
