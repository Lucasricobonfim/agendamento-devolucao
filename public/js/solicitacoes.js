$(document).ready(function () {
    let idsituacao = 1
    listar(idsituacao);
    // Contar as solicitações para todos os cards ao carregar a página
    contarSolicitacoes();
    console.log(grupoid); // Mostra o ID do grupo
    // Adicionar evento de clique para os cards
    $('.card').on('click', function () {
        const idsituacao = $(this).data('idsituacao');
        listar(idsituacao);
    });

    $('#observacaoact').on('input', function () {
        $(this).removeClass('erro');
    });
})
// Função para contar as solicitações para todos os cards no carregamento
function contarSolicitacoes() {
    // Verifica a contagem de cada tipo de situação (1: pendentes, 2: andamento, etc.)
    [1, 2, 3, 4, 5].forEach(idsituacao => {
        app.callController({
            method: 'GET',
            url: base + '/getsolicitacoes',
            params: { idsituacao: idsituacao },
            onSuccess(res) {
                const dados = res[0].ret;

                // Contar as solicitações para o card específico
                let count = dados.length;

                // Atualizar o contador do card correspondente
                atualizarContador(idsituacao, count);
            },
            onFailure() {
                console.error('Erro ao contar solicitações para a situação:', idsituacao);
            }
        });
    });
}
// Função para atualizar o contador no card específico
function atualizarContador(idsituacao, count) {
    switch (idsituacao) {
        case 1:
            $('#pendentesCount').text(`${count} solicitações pendentes`);
            break;
        case 2:
            $('#andamentoCount').text(`${count} solicitações em andamento`);
            break;
        case 3:
            $('#finalizadasCount').text(`${count} solicitações finalizadas`);
            break;
        case 4:
            $('#recusadasCount').text(`${count} solicitações recusadas`);
            break;
        case 5:
            $('#canceladasCount').text(`${count} solicitações canceladas`);
            break;
    }
}

function listar(idsituacao) {
    app.callController({
        method: 'GET',
        url: base + '/getsolicitacoes',
        params: { idsituacao: idsituacao },
        onSuccess(res) {

            const dados = res[0].ret;
            Table(dados, idsituacao); // Passar também a idsituacao para a tabela
        },
        onFailure(res) {
            Swal.fire({
                icon: "error",
                title: "Atenção!!",
                text: "Erro ao listar Agendamentos!"
            });
            return
        }
    })
}

const Table = function (dados, idsituacao) {

    //var dados = JSON.parse(ret)
    $('#mytable').DataTable({
        dom: 'Bfrtip',
        responsive: true,
        stateSave: true,
        "bDestroy": true,
        language: {
            url: "https://cdn.datatables.net/plug-ins/1.10.25/i18n/Portuguese-Brasil.json"
        },
        buttons: [
            {
                extend: 'copyHtml5',
                exportOptions: {
                    columns: [0, 1, 2, 3, 4, 5, 6] // Exporta somente as colunas escolhidas para planilha 
                }
            },
            {
                extend: 'excelHtml5',
                title: 'SOLICITAÇÕES AGENDAMENTO',
                exportOptions: {
                    columns: [0, 1, 2, 3, 4, 5, 6]
                }
            },
            {
                extend: 'csvHtml5',
                exportOptions: {
                    columns: [0, 1, 2, 3, 4, 5, 6]
                }
            },
            {
                extend: 'pdfHtml5',
                orientation: 'landscape',
                pageSize: 'A3',
                title: 'SOLICITAÇÕES AGENDAMENTO',
                exportOptions: {
                    columns: [0, 1, 2, 3, 4, 5, 6]
                },
                customize: function (doc) {
                    // Reduz as margens da página para expandir a tabela
                    doc.pageMargins = [10, 10, 10, 10];

                    // Centraliza o título
                    doc.content[0].alignment = 'center';

                    // Ajusta o tamanho da fonte do título
                    doc.content[0].fontSize = 14;

                    // Aumenta o tamanho da tabela
                    doc.content[1].layout = {
                        hLineWidth: function () { return 0.5; },
                        vLineWidth: function () { return 0.5; },
                        paddingLeft: function () { return 5; },
                        paddingRight: function () { return 5; },
                        paddingTop: function () { return 5; },
                        paddingBottom: function () { return 5; }
                    };

                    // Define o estilo do cabeçalho da tabela
                    doc.styles.tableHeader = {
                        alignment: 'center',
                        fillColor: '#2D9CDB',
                        color: 'white',
                        bold: true,
                        fontSize: 12
                    };

                    // Ajusta o conteúdo da tabela para centralizar
                    doc.styles.tableBodyEven = { alignment: 'center' };
                    doc.styles.tableBodyOdd = { alignment: 'center' };

                    // Define o alinhamento padrão para todo o conteúdo
                    doc.defaultStyle.alignment = 'center';

                    // Ajusta o tamanho das colunas para preencher mais a página
                    var table = doc.content[1].table;
                    table.widths = Array(table.body[0].length).fill('*'); // Define a largura de todas as colunas para distribuir igualmente
                }
            }
        ],
        lengthMenu: [
            [10, 100, 500, -1],
            [10, 100, 500, "All"]
        ],
        data: dados,
        columns: [
            {
                title: 'Cód Solicitacao',
                data: 'idsolicitacao',
            },
            {
                title: 'CD',
                data: 'nome_cd',
            },
            {
                title: 'Transportadora',
                data: 'nome_transportadora'
            },
            {
                title: 'Placa',
                data: 'placa',
                render: function (data) {
                    const placaMascara = data.replace(/^([A-Z]{3})(\d{1}[A-Z]\d{2})$/, "$1-$2") // Para o formato ABC-1A34
                        .replace(/^([A-Z]{3})(\d{4})$/, "$1-$2"); // Para o formato ABC-1234
                    return placaMascara;
                }
            },
            {
                title: 'Data Agendada',
                data: 'data',
            },
            {
                title: 'QTD Notas',
                data: 'quantidadenota',
            },
            {
                title: 'Situação',
                data: 'situacao',
                render: function (data, type, row) {
                    let statusClass = '';

                    // Usando switch case para definir a classe de acordo com a situação
                    switch (parseInt(row.idsituacao)) {
                        case 1: statusClass = 'status-pendente'; break;
                        case 2: statusClass = 'status-andamento'; break;
                        case 3: statusClass = 'status-finalizado'; break;
                        case 4: statusClass = 'status-recusado'; break;
                        case 5: statusClass = 'status-cancelado'; break;
                        default: statusClass = '';
                    }

                    return `<span class="${statusClass}">${data}</span>`;
                }
            },
            {
                title: 'Observação',
                data: null, // Usamos `null` se não há uma propriedade específica para essa coluna no objeto de dados.
                render: function (data, type, row) {
                    dados = JSON.stringify(row).replace(/"/g, '&quot;');
                    return '<button style="width: 100%; " class="btn btn-primary btn-sm" onclick="abrirModalObs(' + dados + ')">Observação</button> '
                }
            },
            {
                title: 'Ações',
                data: null,
                render: function (data, type, row) {
                    if (grupoid === 1) return ''; // Oculta ações para o administrador (idgrupo = 1)
                    dados = JSON.stringify(row).replace(/"/g, '&quot;');
                    if (idsituacao === 1) {
                        return `
                        <button style="width: 49%; " class="btn btn-success btn-sm" onclick="abrirModalAceitar('${row.idsolicitacao}', 2,${dados})">Aceitar</button>
                        <button style="width: 49%; " class="btn btn-danger btn-sm" onclick="abrirModalAceitar('${row.idsolicitacao}', 4,${dados})">Recusar</button>
                    `;
                    } else if (idsituacao === 2) { // Para "Em Andamento"
                        return `
                            <button style="width: 49%; " class="btn btn-success btn-sm" onclick="abrirModalAceitar('${row.idsolicitacao}', 3,${dados})">Finalizar</button>
                            <button style="width: 49%; " class="btn btn-danger btn-sm" onclick="abrirModalAceitar('${row.idsolicitacao}', 5,${dados})">Cancelar</button>
                        `;
                    }
                    return ''; // Retorna vazio se não houver ações para o estado atual
                },
                visible: grupoid !== 1 && (idsituacao === 1 || idsituacao === 2) // Oculta a coluna inteira se for o administrador
            }
        ],
        columnDefs: [
            {
                targets: [0], // Índice da coluna "Cód Solicitacao"
                width: '1px' // Definindo a largura desejada
            },
            {
                targets: [2], // Índice da coluna "Cód Solicitacao"
                width: '1px' // Definindo a largura desejada
            },
            {
                targets: [4], // Índice da coluna "Cód Solicitacao"
                width: '1px' // Definindo a largura desejada
            }
        ],
        rowCallback: function (row, data) { },
        initComplete: function (settings, json) {
            const column = this.api().column(8); // Índice da coluna "Ações"
            // Define a visibilidade da coluna "Ações"
            column.visible(grupoid !== 1 && (idsituacao === 1 || idsituacao === 2));
        }
    });

    if (!$('#kt_datatable_example_export_menu').data('events-bound')) {
        $('#kt_datatable_example_export_menu').data('events-bound', true);
        var exportButtons = document.querySelectorAll('#kt_datatable_example_export_menu [data-kt-export]');
        exportButtons.forEach(exportButton => {
            exportButton.addEventListener('click', e => {
                e.preventDefault();
                const exportValue = e.target.getAttribute('data-kt-export');
                console.clear()

                const target = document.querySelector('.dt-buttons .buttons-' + exportValue);
                target.click();
            });
        });
    }



}

// Modal Observacao

function abrirModalObs(dados) {
    let observacoes = []
    let situacao_operacao = []
    let dataoperacao = []

    opp = $('.obshist');
    opp.html('');


    if (dados.observacoes) {
        observacoes = dados.observacoes.split('|');
        situacao_operacao = dados.situacao_operacao.split('|');
        dataoperacao = dados.dataoperacao.split('|');
    }

    let registros = observacoes.map((obs, index) => ({
        observacao: obs || '',
        situacao: situacao_operacao[index] || '',
        data: dataoperacao[index] || ''
    }));

    registros.sort((a, b) => {
        let dateA = new Date(a.data.trim().replace(/(\d{2})\/(\d{2})\/(\d{4})/, '$3-$2-$1'));
        let dateB = new Date(b.data.trim().replace(/(\d{2})\/(\d{2})\/(\d{4})/, '$3-$2-$1'));
        return dateA - dateB;
    });


    $('#observacaoModal').modal('show');

    for (let registro of registros) {
        opp.append(
            "<tr><td>" + registro.observacao + "</td><td>" + registro.situacao + "</td><td>" + registro.data + "</td></tr>"
        );
    }
}

function fechaModalObs() {
    $('#conteudo_obs').text('')
    $('#observacaoModal').modal('hide');

}

function abrirModalAceitar(idsolicitacao, idsituacao, dados) {
    let observacoes = []
    let situacao_operacao = []
    let dataoperacao = []

    if (dados.observacoes) {
        observacoes = dados.observacoes.split('|');
        situacao_operacao = dados.situacao_operacao.split('|');
        dataoperacao = dados.dataoperacao.split('|');
    }

    let registros = observacoes.map((obs, index) => ({
        observacao: obs || '',
        situacao: situacao_operacao[index] || '',
        data: dataoperacao[index] || ''
    }));

    registros.sort((a, b) => {
        let dateA = new Date(a.data.trim().replace(/(\d{2})\/(\d{2})\/(\d{4})/, '$3-$2-$1'));
        let dateB = new Date(b.data.trim().replace(/(\d{2})\/(\d{2})\/(\d{4})/, '$3-$2-$1'));
        return dateA - dateB;
    });

    $('#modalAceitacao').modal('show');
    $('#idsolicitacao').val(idsolicitacao);
    $('#idsituacao').val(idsituacao);
    opp = $('.obshist_act');
    opp.html('');
    for (let registro of registros) {
        opp.append(
            "<tr><td>" + registro.observacao + "</td><td>" + registro.situacao + "</td><td>" + registro.data + "</td></tr>"
        );
    }
}

function fechaModalAceitar() {
    $('#observacaoact').val(''); // Limpa o campo de observação ao fechar o modal
    $('#modalAceitacao').modal('hide');
    $('#observacaoact').removeClass('erro'); // Remove a classe 'erro'
}


function confimarSolicitacao() {
    let dados = {
        observacao: $('#observacaoact').val(),
        idsolicitacao: $('#idsolicitacao').val(),
        idsituacao: $('#idsituacao').val()
    }


    // Determina a ação (Aceitar, Recusar, Finalizar ou Cancelar)
    let textoslt;
    if (parseInt(dados.idsituacao) === 2) { // Aceitar
        textoslt = 'Aceitar';
    } else if (parseInt(dados.idsituacao) === 4) { // Cancelar
        textoslt = 'Cancelar';
    } else if (parseInt(dados.idsituacao) === 3) { // Finalizar
        textoslt = 'Finalizar';
    } else { // Recusar
        textoslt = 'Recusar';
    }

    if (!dados.observacao) {
        Swal.fire({
            icon: "warning",
            title: "Atenção!!",
            text: "Preencha com uma Observação!"
        });
        $('#observacaoact').toggleClass('erro');
        return
    }

    app.callController({
        method: 'POST',
        url: base + '/updatesolicitacao',
        params: dados,
        onSuccess(res) {
            fechaModalAceitar()
            listar(1); // Para a tabela de pendentes, ou utilize a situação correta
            contarSolicitacoes(); // Atualiza os contadores após a mudança de estado
            Swal.fire({
                icon: "success",
                title: "Sucesso!",
                text: "Solicitação Confirmada com Sucesso!"
            });
            return
        },
        onFailure(res) {

            Swal.fire({
                icon: "error",
                title: "Atenção!!",
                text: "Erro ao " + textoslt + " Solicitação!"
            });
            return
        }
    })
}







