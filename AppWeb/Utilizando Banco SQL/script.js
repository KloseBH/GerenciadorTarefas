$(document).ready(function () {

    //Quando o Filtro é alterado chama o carregarTarefas()
    $('#situacaoFiltro').change(function () {
        carregarTarefas();
    });
    $('#prioridadeFiltro').change(function () {
        carregarTarefas();
    });

    function carregarTarefas() {
        $.ajax({
            url: 'CarregarTarefas.php', // URL correta para carregar as tarefas
            type: 'GET',
            dataType: 'json',
            success: function (data) {
                var main = $('#main');
                var count = 0;
                var row; // Variável para armazenar a linha atual
                var filtro = {
                    situacao: $('#situacaoFiltro').val(),
                    prioridade: $('#prioridadeFiltro').val()
                };
                main.empty();

                //filtra e ordena as tarefas
                var tarefasFiltradas = data.filter(function (anotacao) {
                    if((filtro.situacao === 'todos' && filtro.prioridade == anotacao[3]) ||
                    (filtro.situacao == anotacao[4] && filtro.prioridade == 'todos') ||
                    (filtro.situacao === 'todos' && filtro.prioridade === 'todos')||
                    (filtro.situacao == anotacao[4] && filtro.prioridade == anotacao[3])){
                        return anotacao;
                    }
                }).sort(function (a, b) {
                    if (a[4] !== b[4]) {
                        if (a[4] === 'aberto') return -1;
                        if (b[4] === 'aberto') return 1;
                        return 0;
                    } else {
                        const prioridadeOrdem = {
                            'urgente': 1,
                            'importante': 2,
                            'fila': 3
                        };
                        return prioridadeOrdem[a[3]] - prioridadeOrdem[b[3]];
                    }
                });

                // Processa os dados recebidos e cria os elementos HTML
                $.each(tarefasFiltradas, function (index, anotacao) {
                    count++;
                    // Cria uma nova linha a cada 3 cards
                    if (count % 3 == 1) {
                        console.log('count: ' + count);
                        row = $('<div>').addClass('row');
                    }

                    var cardCol = $('<div>').addClass('col-md-4');
                    var card = $('<div>').addClass('card').addClass(anotacao[3]).addClass(anotacao[4]).addClass('m-2').attr('data-id', anotacao[0]);
                    var cardHeader = $('<div>').addClass('card-header').text(anotacao[1]);
                    var cardBody = $('<div>').addClass('card-body');
                    var mensagem = $('<p>').addClass('card-text').text(anotacao[2]);
                    var prioridade = $('<p>').addClass('card-text').text('\n' + anotacao[3].toUpperCase() + ' - ' + anotacao[4].toUpperCase());

                    cardHeader.append(prioridade);
                    cardBody.append(mensagem);
                    card.append(cardHeader, cardBody);
                    cardCol.append(card);

                    // Adiciona a coluna ao final da linha
                    row.append(cardCol);

                    // Se completou 3 cards, adiciona a linha ao main e reinicia
                    if (count % 3 == 0 || count == tarefasFiltradas.length) {
                        main.append(row);
                    }

                    // Adiciona um manipulador de clique ao card para abrir o modal
                    card.click(function () {
                        abrirModal(anotacao[0], anotacao[1], anotacao[2], anotacao[3], anotacao[4]);
                    });

                    // Função para salvar as alterações da tarefa
                    $('#btnSalvarTarefa').click(function () {
                        var id = $('#modalIdTarefa').val();
                        var titulo = $('#modalTitulo').val();
                        var mensagem = $('#modalMensagem').val();
                        var prioridade = $('#modalPrioridade').val();
                        var situacao = $('#modalSituacao').val();

                        var dadosTarefa = {
                            id: id,
                            titulo: titulo,
                            mensagem: mensagem,
                            prioridade: prioridade,
                            situacao: situacao
                        };

                        console.log('situacao: ' + situacao);

                        $.ajax({
                            url: 'UpdateTarefa.php', // URL para atualizar a tarefa
                            type: 'POST',
                            data: dadosTarefa,
                            success: function (response) {
                                console.log(response); 
                                $('#modalDetalhesTarefa').modal('hide'); // Fecha o modal
                                carregarTarefas();
                            },
                            error: function (xhr, status, error) {
                                console.error('Erro na requisição AJAX:', error);
                            }
                        });
                    });

                    // Função para deletar a tarefa
                    $('#btnExcluirTarefa').click(function () {
                        var idTarefa = $('#modalIdTarefa').val();

                        $.ajax({
                            url: 'DeleteTarefa.php',
                            type: 'POST',
                            data: { id: idTarefa },
                            success: function (response) {
                                console.log(response);
                                $('#modalDetalhesTarefa').modal('hide');
                                carregarTarefas();
                            },
                            error: function (xhr, status, error) {
                                console.error('Erro na requisição AJAX:', error);
                            }
                        });
                    });
                });
            },
            error: function (xhr, status, error) {
                console.error('Erro na requisição AJAX:', error);
            }
        });
    }

    // Função para abrir o modal e preencher os campos com as informações da tarefa
    function abrirModal(id, titulo, mensagem, prioridade, situacao) {
        $('#modalIdTarefa').val(id);
        $('#modalTitulo').val(titulo);
        $('#modalMensagem').val(mensagem);
        $('#modalPrioridade').val(prioridade);
        $('#modalSituacao').val(situacao);

        var meuModal = new bootstrap.Modal(document.getElementById('modalDetalhesTarefa'), {
            backdrop: 'true', // fecha ao clicar fora
            keyboard: true,    // fecha ao pressionar Esc
            focus: true,        // Foca no primeiro elemento de entrada
            show: false,        // Não mostra imediatamente após inicializar
            backdropClass: 'modal-backdrop-custom', // Classe CSS para o backdrop
            scrollable: true,   // Permite rolagem se o conteúdo exceder a altura do modal
            animation: true,    // Ativa animação de entrada
        });

        meuModal.show();
    }

    carregarTarefas();
});
