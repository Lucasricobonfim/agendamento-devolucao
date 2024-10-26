$(document).ready(function () {
    let idsituacao = 1
    listar(idsituacao);
    // Contar as solicitações para todos os cards ao carregar a página
    contarSolicitacoes();

    // Adicionar evento de clique para os cards
    $('.card').on('click', function () {
        const idsituacao = $(this).data('idsituacao');

        console.log('aaa', idsituacao)
        listar(idsituacao);
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
            $('#canceladasCount').text(`${count} solicitações canceladas`);
            break;
        case 5:
    }
}

function listar(idsituacao) {
    -
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
        buttons: [{
            extend: 'copyHtml5',
        },
        {
            extend: 'excelHtml5',
            title: 'solicitacoes',
        },
        {
            extend: 'csvHtml5',
        },
        {
            extend: 'pdfHtml5',
            orientation: 'landscape', // Export in landscape mode
            pageSize: 'A3', // Use A4 page size
            title: 'solicitacoes',
            exportOptions: {
                columns: ':visible'
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
                data: 'placa'
            },
            {
                title: 'Data Agendada',
                data: 'data',
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
                    dados = JSON.stringify(row).replace(/"/g, '&quot;');
                    if (idsituacao === 1) {
                        return `
                        <button class="btn btn-success btn-sm" onclick="abrirModalAceitar('${row.idsolicitacao}', 2)">Aceitar</button>
                        <button class="btn btn-danger btn-sm" onclick="abrirModalAceitar('${row.idsolicitacao}', 4)">Recusar</button>
                    `;
                    } else if (idsituacao === 2) { // Para "Em Andamento"
                        return `
                            <button class="btn btn-success btn-sm" onclick="abrirModalAceitar('${row.idsolicitacao}', 3)">Finalizar</button>
                            <button class="btn btn-danger btn-sm" onclick="abrirModalAceitar('${row.idsolicitacao}', 4)">Cancelar</button>
                        `;
                    }
                    return ''; // Retorna vazio se não houver ações para o estado atual
                },
                visible: idsituacao === 1 || idsituacao === 2 // <--- Esta linha foi adicionada
            }
        ],
        rowCallback: function (row, data) { },
        initComplete: function(settings, json) {
            const column = this.api().column(7); // Índice da coluna "Ações"
            // Define a visibilidade da coluna "Ações"
            column.visible(idsituacao === 1 || idsituacao === 2);
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

    $('#conteudo_obs').text(dados.observacao)
    $('#observacaoModal').modal('show');
}

function fechaModalObs() {
    $('#conteudo_obs').text('')
    $('#observacaoModal').modal('hide');

}

function abrirModalAceitar(idsolicitacao, idsituacao) {
    $('#observacaoact').val(''); // Limpa o campo de observação ao abrir o modal
    $('#modalAceitacao').modal('show');

    if (parseInt(idsituacao) === 2) {
        $('#tituloModalObs').text('Aceitar Solicitação - Observação');
    } else if(parseInt(idsituacao) === 4){
        $('#tituloModalObs').text('Recusar Solicitação - Observação');
    } else if(parseInt(idsituacao) === 3){
        $('#tituloModalObs').text('Finalizar Solicitação - Observação');
    }

    $('#idsolicitacao').val(idsolicitacao);
    $('#idsituacao').val(idsituacao);
}

// Função para fechar o modal de aceitação/recusa e limpar o campo de observação
function fechaModalAceitar() {
    $('#observacaoact').val(''); // Limpa o campo de observação ao fechar o modal
    $('#modalAceitacao').modal('hide');
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







