<<<<<<< HEAD
<?php
$arquivo_csv = 'tarefas.csv';

if (!file_exists($arquivo_csv)) {
    die("Arquivo não encontrado: $arquivo_csv");
}

$arquivo = fopen($arquivo_csv, 'r');

if ($arquivo !== false) {
    $dados = [];

    while (($linha = fgetcsv($arquivo)) !== false) {
        $dados[] = $linha;
    }

    fclose($arquivo);

    $dados_json = json_encode($dados);

    echo $dados_json;
} else {
    echo "Não foi possível abrir o arquivo CSV para leitura.";
}
?>
=======
<?php
$arquivo_csv = 'tarefas.csv';

if (!file_exists($arquivo_csv)) {
    die("Arquivo não encontrado: $arquivo_csv");
}

$arquivo = fopen($arquivo_csv, 'r');

if ($arquivo !== false) {
    $dados = [];

    while (($linha = fgetcsv($arquivo)) !== false) {
        $dados[] = $linha;
    }

    fclose($arquivo);

    $dados_json = json_encode($dados);

    echo $dados_json;
} else {
    echo "Não foi possível abrir o arquivo CSV para leitura.";
}
?>
>>>>>>> 372a888615a22f72b88a2f8ee25eafe1192da021
