$(document).ready(function () {
    let idsituacao = 8
    listar(idsituacao);
    contarIndenizacoes()

    $('#cnpj').mask('00.000.000/0000-00', { placeholder: '__.___.___/____-__' });

    $('.card').on('click', function () {
        const idsituacao = $(this).data('idsituacao');
        //console.log('id clicado: ', idsituacao)
        listar(idsituacao);
    });

    $('#anexo').on('change', function () {
        const fileName = $(this).val().split('\\').pop() || "Nenhum arquivo escolhido";
        $('#file-chosen').text(fileName);
    });

    $('#cnpj').on('input', function() {
        $(this).removeClass('erro');
    });

    $('#observacaoContestar').on('input', function() {
        $(this).removeClass('erro');
    });

});

function contarIndenizacoes() {
    [6, 7, 8, 9].forEach(idsituacao => {
        app.callController({
            method: 'GET',
            url: base + '/getindenizacao-transportadora',
            params: { idsituacao: idsituacao },
            onSuccess(res) {
                const dados = res[0].ret;
                let count = dados.length;
                //console.log(`Dados retornados para idsituacao ${idsituacao}:`, dados);
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
        case 8:
            $('#pendentesCount').text(`${count} indenizações pendentes`);
            break;
        case 7:
            $('#autorizadasCount').text(`${count} indenizações autorizadas`);
            break;
        case 6:
            $('#contestadasCount').text(`${count} indenizações contestadas`);
            break;
        case 9:
            $('#faturadasCount').text(`${count} indenizações faturadas`);
            break;
    }
}

function listar(idsituacao) {
    app.callController({
        method: 'GET',
        url: base + '/getindenizacao-transportadora',
        params: { idsituacao: idsituacao },
        onSuccess(res) {
            const dados = res[0].ret;
            Table(dados, idsituacao); // Atualiza a tabela com os novos dados
            //console.log(idsituacao, dados)
        },
        onFailure(res) {
            Swal.fire({
                icon: "error",
                title: "Atenção!!",
                text: "Erro ao listar Indenizações!"
            });
            return;
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
                title: 'INDENIZAÇÕES',
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
                title: 'INDENIZAÇÕES',
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
                render: function (data) {
                    // Aplicando máscara no CNPJ
                    const cnpjMascara = data.replace(/^(\d{2})(\d{3})(\d{3})(\d{4})(\d{2})$/, "$1.$2.$3/$4-$5");
                    return cnpjMascara;
                }
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
                        case 8: statusClass = 'status-pendente'; break;
                        case 6: statusClass = 'status-contestacao'; break;
                        case 7: statusClass = 'status-finalizado'; break;
                        case 9: statusClass = 'status-faturado'; break;
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
                    if (idsituacao === 8 || idsituacao === 6) {
                        return `
                            <button style="width: 50%;" class="btn btn-success btn-sm" onclick="abrirModalAceitar('${row.idsolicitacao}', 7)">Autorizar</button>
                            <button style="width: 50%;" class="btn btn-warning btn-sm" onclick="abrirModalContestar('${row.idsolicitacao}', 6)">Contestar</button>
                        `;
                    } else {
                        return ''; // Retorna vazio se não houver ações para o estado atual
                    }
                },
                visible: idsituacao === 8 // <--- Esta linha foi adicionada
            },
        ],
        columnDefs: [
            {
                targets: [0], // Índice da coluna "Cód Solicitacao"
                width: '1px' // Definindo a largura desejada
            },
            {
                targets: [4], // Índice da coluna "Cód Solicitacao"
                width: '1px' // Definindo a largura desejada
            },
            {
                targets: [5], // Índice da coluna "Cód Solicitacao"
                width: '1px' // Definindo a largura desejada
            }
        ],
        rowCallback: function (row, data) {
            $(row).addClass('linha' + data.idfilial);
        },
        initComplete: function(settings, json) {
            const column = this.api().column(10);
            column.visible(idsituacao === 8);
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

function abrirModalObs(dados) {
    $('#conteudo_obs').text(dados.observacao)
    $('#observacaoModal').modal('show');
}
function fechaModalObs() {
    $('#conteudo_obs').text('')
    $('#observacaoModal').modal('hide');
}

// Função para fechar o modal de aceitação/recusa e limpar o campo de observação
function fechaModalAceitar() {
    $('#observacaoAutorizar').val(''); // Limpa o campo de observação ao fechar o modal
    $('#cnpj').removeClass('erro'); // Remove a classe 'erro'
    $('#cnpj').val(''); // Limpa o campo de observação ao abrir o modal
    $('#modalAutorizar').modal('hide');
}
function fechaModalContestar() {
    $('#observacaoContestar').val(''); // Limpa o campo de observação ao fechar o modal
    $('#idtipofilial').val(''); // Limpa o campo de observação ao abrir o modal
    $('#observacaoContestar').removeClass('erro'); // Remove a classe 'erro'
    $('#modalContestar').modal('hide');
}

function abrirModalAceitar(idsolicitacao, idsituacao) {
    $('#observacaoAutorizar').val(''); // Limpa o campo de observação ao abrir o modal
    $('#cnpj').removeClass('erro'); // Remove a classe 'erro'
    $('#cnpj').val(''); // Limpa o campo de observação ao abrir o modal
    $('#modalAutorizar').modal('show');

    if (parseInt(idsituacao) === 7) {
        $('#tituloModalObs').text('Autorizar Solicitação');
    } else{
        $('#tituloModalObs').text('Contestar Solicitação');
    }

    $('#idsolicitacaoAutorizar').val(idsolicitacao);
    $('#idsituacao').val(idsituacao);
}
function abrirModalContestar(idsolicitacao, idsituacao) {
    $('#observacaoContestar').val(''); // Limpa o campo de observação ao abrir o modal
    $('#idtipofilial').val(''); // Limpa o campo de observação ao abrir o modal
    $('#modalContestar').modal('show');
    $('#observacaoContestar').removeClass('erro'); // Remove a classe 'erro'

    if (parseInt(idsituacao) === 6) {
        $('#tituloModalObs').text('Autorizar Solicitação');
    } else{
        $('#tituloModalObs').text('Contestar Solicitação');
    }

    $('#idsolicitacaoContestar').val(idsolicitacao);
    $('#idsituacao').val(idsituacao);
}
// Função para confirmar autorização
function confirmarAutorizar() {
    let dados = {
        idsolicitacao: $('#idsolicitacaoAutorizar').val(),
        idsituacao: $('#idsituacao').val(),
        observacao: $('#observacaoAutorizar').val(),
        cnpj: $('#cnpj').val().replace(/[^\d]/g, ''), // Removendo máscara antes de enviar
    };

    //console.log(dados)

    if (!dados.cnpj) {
        Swal.fire({
            icon: "warning",
            title: "Atenção!",
            text: "Por favor, insira o CNPJ."
        });
        $('#cnpj').toggleClass('erro');// Adiciona a classe 'erro' se o CNPJ estiver vazio
        return;
    }
    if (!app.validarCNPJ(dados.cnpj)) {
        Swal.fire({
            icon: "warning",
            title: "Atenção!!",
            text: "CNPJ Inválido!"
        });
        return false;
    }

    app.callController({
        method: 'POST',
        url: base + '/updateindenizacao-transportadora',
        params: dados,
        onSuccess(res) {
            fechaModalAceitar()
            listar(8)
            contarIndenizacoes()
            Swal.fire({
                icon: "success",
                title: "Sucesso!",
                text: "Solicitação autorizada com sucesso!"
            });
        },
        onFailure(res) {
            Swal.fire({
                icon: "error",
                title: "Erro!",
                text: "Falha ao autorizar a solicitação."
            });
        }
    });
}

// Função para confirmar autorização
function confirmarContestar() {
    let dados = {
        idsolicitacao: $('#idsolicitacaoContestar').val(),
        idsituacao: $('#idsituacao').val(),
        observacao: $('#observacaoContestar').val(),
    };

    console.log(dados)

    
    if (!dados.observacao) {
        Swal.fire({
            icon: "warning",
            title: "Atenção!",
            text: "Por favor, insira o motivo da contestação."
        });
        $('#observacaoContestar').toggleClass('erro');
        return;
    }

    app.callController({
        method: 'POST',
        url: base + '/updateindenizacao-transportadora',
        params: dados,
        onSuccess(res) {
            fechaModalContestar()
            listar(8)
            contarIndenizacoes()
            Swal.fire({
                icon: "success",
                title: "Sucesso!",
                text: "Solicitação contestada com sucesso!"
            });
        },
        onFailure(res) {
            Swal.fire({
                icon: "error",
                title: "Erro!",
                text: "Falha ao contestar a solicitação."
            });
        }
    });
}

