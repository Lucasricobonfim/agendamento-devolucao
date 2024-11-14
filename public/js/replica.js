$(document).ready(function () {
    let idsituacao = 6
    listar(idsituacao);
    contarIndenizacoes()

    $('.card').on('click', function () {
        const idsituacao = $(this).data('idsituacao');
        //console.log('id clicado: ', idsituacao)
        listar(idsituacao);
    });

    $('#anexo').on('change', function () {
        const fileName = $(this).val().split('\\').pop() || "Nenhum arquivo escolhido";
        $('#file-chosen').text(fileName);
    });


    $('#observacaoReplica').on('input', function() {
        $(this).removeClass('erro');
    });
});

function contarIndenizacoes() {
    [6, 10].forEach(idsituacao => {
        app.callController({
            method: 'GET',
            url: base + '/getreplica',
            params: { idsituacao: idsituacao },
            onSuccess(res) {
                const dados = res[0].ret;
                let count = dados.length;
                //console.log(`Dados retornados para idsituacao ${idsituacao}:`, dados);
                atualizarContador(idsituacao, count);
            },
            onFailure() {
                console.error('Erro ao contar indenizações para a situação:', idsituacao);
            }
        });
    });
}

// Função para atualizar o contador no card específico
function atualizarContador(idsituacao, count) {
    switch (idsituacao) {
        case 6:
            $('#contestadasCount').text(`${count} indenizações contestadas`);
            break;
        case 10:
            $('#canceladasCount').text(`${count} indenizações canceladas`);
            break;
    }
}

function listar(idsituacao) {
    app.callController({
        method: 'GET',
        url: base + '/getreplica',
        params: {idsituacao: idsituacao},
        onSuccess(res) {
            const dados = res[0].ret;
            Table(dados, idsituacao);
            console.log(idsituacao, dados, res)

        },
        onFailure(res) {
            Swal.fire({
                icon: "error",
                title: "Atenção!!",
                text: "Erro ao listar Centro de distribuição!"
            });
        }
    });
}

const Table = function (dados, idsituacao) {
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
                    columns: [0, 1, 2, 3, 4, 5, 6, 7] // Exporta somente as colunas escolhidas para planilha 
                }
            },
            {
                extend: 'excelHtml5',
                title: 'CONTESTAÇÕES',
                exportOptions: {
                    columns: [0, 1, 2, 3, 4, 5, 6, 7]
                }
            },
            {
                extend: 'csvHtml5',
                exportOptions: {
                    columns: [0, 1, 2, 3, 4, 5, 6, 7]
                }
            },
            {
                extend: 'pdfHtml5',
                orientation: 'landscape', 
                pageSize: 'A3', 
                title: 'CONTESTAÇÕES',
                exportOptions: {
                    columns: [0, 1, 2, 3, 4, 5, 6, 7]
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
        data: dados, //dados,
        columns: [
            {
                title: 'ID',
                data: 'idsolicitacao',
            },
            {
                title: 'Negocio',
                data: 'nome_negocio',
            },
            {
                title: 'CD',
                data: 'nome_cd'
            },
            {
                title: 'Transportadora',
                data: 'nome_transportadora'
            },
            {
                title: 'NF',
                data: 'numero_nota',
            },
            {
                title: 'NFD',
                data: 'numero_nota2',
            },
            {
                title: '% Indenização',
                data: 'tipo_indenizacao',
            },
            {
                title: 'Data Solicitação',
                data: 'data',
            },
            {
                title: 'Situação',
                data: 'descricao_situacao',
                render: function (data, type, row) {
                    let statusClass = '';

                    // Usando switch case para definir a classe de acordo com a situação
                    switch (parseInt(row.idsituacao)) {
                        case 6: statusClass = 'status-contestacao'; break;
                        case 10: statusClass = 'status-recusado'; break;
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
                    return '<button style="width: 100%;" class="btn btn-primary btn-sm" onclick="abrirModalObs(' + dados + ')">Detalhes</button> '
                }
            },
            {
                title: 'Anexo',
                data: null, // Usamos `null` se não há uma propriedade específica para essa coluna no objeto de dados.
                render: function (data, type, row) {
                    dados = JSON.stringify(row).replace(/"/g, '&quot;');
                    return '<button style="width: 100%;" class="btn btn-primary btn-sm" onclick="abrirModalAnexo(' + dados + ')">Anexo</button> '
                }
            },
            {
                title: 'Ações',
                data: null, // Usamos `null` se não há uma propriedade específica para essa coluna no objeto de dados.
                render: function (data, type, row) {
                    dados = JSON.stringify(row).replace(/"/g, '&quot;');
                    return `
                            <button style="width: 50%;" class="btn btn-warning btn-sm" onclick="abrirModalReplica('${row.idsolicitacao}', 8)">Replica</button>
                            <button style="width: 50%;" class="btn btn-danger btn-sm" onclick="abrirModalReplica('${row.idsolicitacao}', 10)">Cancelar</button>
                        `;

                },
            },
        ],
        columnDefs: [
            {
                targets: [0], 
                width: '1px' // Definindo a largura desejada
            },
            {
                targets: [2], 
                width: '1px' // Definindo a largura desejada
            },
            {
                targets: [5],
                width: '1px' // Definindo a largura desejada
            },
            {
                targets: [6],
                width: '1px' // Definindo a largura desejada
            }
        ],
        rowCallback: function (row, data) {
            $(row).addClass('linha' + data.idfilial);
        },
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

function abrirModalObs(dados) {
    $('#conteudo_obs').text(dados.observacao)
    $('#observacaoModal').modal('show');
}
function fechaModalObs() {
    $('#conteudo_obs').text('')
    $('#observacaoModal').modal('hide');
}

function abrirModalReplica(idsolicitacao, idsituacao) {
    $('#observacaoReplica').val(''); // Limpa o campo de observação ao abrir o modal
    $('#modalReplica').modal('show');

    if (parseInt(idsituacao) === 8) {
        $('#tituloModalObs').text('Replica - Observação');
    } else {
        $('#tituloModalObs').text('Cancelar - Observação');
    }

    $('#idsolicitacaoReplica').val(idsolicitacao);
    $('#idsituacao').val(idsituacao);
}

// Função para fechar o modal de aceitação/recusa e limpar o campo de observação
function fechaModalAceitar() {
    $('#observacaoReplica').val(''); // Limpa o campo de observação ao fechar o modal
    $('#modalReplica').modal('hide');
}


function confimarReplica() {
    let dados = {
        observacao: $('#observacaoReplica').val(),
        idsolicitacao: $('#idsolicitacaoReplica').val(),
        idsituacao: $('#idsituacao').val()
    }

    console.log(dados)
    // Determina a ação (Aceitar, Recusar, Finalizar ou Cancelar)
    let textoslt;
    if (parseInt(dados.idsituacao) === 8) { // Aceitar
        textoslt = 'Aceitar';
    } else { // Cancelar
        textoslt = 'Cancelar';
    }

    if (!dados.observacao) {
        Swal.fire({
            icon: "warning",
            title: "Atenção!!",
            text: "Preencha com uma Observação!"
        });
        $('#observacaoReplica').toggleClass('erro');
        return
    }

    app.callController({
        method: 'POST',
        url: base + '/updatereplica',
        params: dados,
        onSuccess(res) {
            fechaModalAceitar()
            listar(6); 
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


