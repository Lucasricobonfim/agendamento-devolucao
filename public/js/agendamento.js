$(document).ready(function () {
    buscaCd()
    let idsituacao = 1;
    listar(idsituacao);
    // Contar as solicitações para todos os cards ao carregar a página
    contarSolicitacoes();
    $('.card').on('click', function () {
        const idsituacao = $(this).data('idsituacao');

        listar(idsituacao);
    });

    $('#idfilial').on('input', function () {
        $(this).removeClass('erro');
    });
    $('#placa').on('input', function () {
        $(this).removeClass('erro');
    });
    $('#data').on('input', function () {
        $(this).removeClass('erro');
    });
    $('#qtdnota').on('input', function () {
        $(this).removeClass('erro');
    });
    $('#observacao').on('input', function () {
        $(this).removeClass('erro');
    });
})
$("#placa").inputmask({
    mask: ["AAA-9*99"], // Formato Mercosul
    definitions: {
        'A': {
            validator: "[A-Za-z]", // Aceita somente letras
            casing: "upper" // Força para maiúsculas
        },
        '9': {
            validator: "[0-9]" // Aceita somente números
        },
        '*': {
            validator: "[A-Za-z0-9]", // Aceita letras e números
            casing: "upper" // Força para maiúsculas
        }
    },
    autoUnmask: true, // Remove a máscara ao enviar o formulário
});



$('#solicitar').on('click', function () {

    let dados = {
        idfilial: $('#idfilial').val(),
        placa: $('#placa').val(),
        data: $('#data').val(),
        quantidadenota: $('#qtdnota').val(),
        observacao: $('#observacao').val()
    }
    if (!app.validarCampos(dados)) {
        Swal.fire({
            icon: "warning",
            title: "Atenção!!",
            text: "Preencha todos os campos!"
        });
        return
    }

    // Validação de placa
    if (!validarPlaca(dados.placa)) {
        Swal.fire({
            icon: "warning",
            title: "Placa inválida!",
            text: "Por favor, insira uma placa válida nos formatos ABC-1234 ou ABC1D23."
        });
        return;
    }
    // validar se a data da solicitacao e menor que dia de HOJE
    let dataSolicitacao = new Date(dados.data + 'T00:00:00'); // Garante a conversão correta da string para Date
    let hoje = new Date();
    hoje.setHours(0, 0, 0, 0); // Zera as horas para comparar apenas a data

    if (dataSolicitacao < hoje) {
        Swal.fire({
            icon: "warning",
            title: "Atenção!!",
            text: "A data da solicitação não pode ser anterior à data de hoje!"
        });
        return;
    }

     // Verifica se a quantidade de notas é negativa
     if (dados.quantidadenota < 0) {
        Swal.fire({
            icon: "warning",
            title: "Atenção!!",
            text: "O número de notas não pode ser negativo!"
        });
        return;
    }

    // Verifica se a quantidade de notas tem mais de 4 dígitos
    if (dados.quantidadenota.length > 4) {
        Swal.fire({
            icon: "warning",
            title: "Atenção!!",
            text: "O número de notas não pode ter mais de 4 dígitos!"
        });
        return;
    }

    // Calcular a data limite (30 dias a partir de hoje)
    let dataLimite = new Date(hoje);
    dataLimite.setDate(hoje.getDate() + 30); // Adiciona 30 dias

    // Validar se a data escolhida é maior que a data limite
    if (dataSolicitacao > dataLimite) {
        Swal.fire({
            icon: "warning",
            title: "Atenção!!",
            text: "A data da solicitação não pode ser superior a 30 dias a partir de hoje!"
        });
        return;
    }

    solicitar(dados)


})


function validarPlaca(placa) {
    placa = placa.replace(/\s+/g, '');
    const padraoAntigo = /^[A-Z]{3}-?[0-9]{4}$/;
    const padraoMercosul = /^[A-Z]{3}-?[0-9]{1}[A-Z]{1}[0-9]{2}$/;
    return padraoAntigo.test(placa) || padraoMercosul.test(placa);
}

function limparCampos() {
    $('#idfilial').val(''),
    $('#placa').val(''),
    $('#data').val(''),
    $('#qtdnota').val(''),
    $('#observacao').val('')
}

function solicitar(dados) {
    app.callController({
        method: 'POST',
        url: base + '/solicitar-agendamento',
        params: {
            idfilial: dados.idfilial,
            placa: dados.placa,
            data: dados.data,
            quantidadenota: dados.quantidadenota,
            observacao: dados.observacao
        },
        onSuccess(res) {
            let rec = res[0]


            if (rec.success) {
                Swal.fire({
                    icon: "success",
                    title: "Sucesso!",
                    text: "Agendamento Solicitado com sucesso!"
                });
                limparCampos()
            } else {
                Swal.fire({
                    icon: "error",
                    title: "Atenção!!",
                    text: "Erro ao solicitar agendamento!"
                });
                limparCampos()
                return
            }
        },
        onFailure(res) {
            let rec = res[0].ret[0]


            if (rec.existeplaca == 1) {
                Swal.fire({
                    icon: "warning",
                    title: "Atenção!!",
                    text: "Já existe um agendamento para essa data com essa Placa"
                });
                return;
            }

            Swal.fire({
                icon: "error",
                title: "Atenção!!",
                text: "Erro ao solicitar!"
            });
            return
        }
    })
}



function buscaCd() {
    app.callController({
        method: 'GET',
        url: base + '/getcentro-distribuicao-ativos',
        params: null,
        onSuccess(res) {
            let rec = res[0].ret
            opp = $('.opp');
            opp.html('');
            if (rec != '') {
                opp.append("<option id='filial' value=''>Selecione</option>")
                $.each(rec, function (i, el) {
                    opp.append("<option id='filial' value='" + el.idfilial + "' >" + el.descricao + "</option>")
                })
            }
        },
        onFailure(res) {
            Swal.fire({
                icon: "error",
                title: "Atenção!!",
                text: "Erro ao buscar Filial!"
            });
            return
        }
    })
}

// fim cadastro


// listagem 


function listar(idsituacao) {
    //console.log('id que esta vindo:', idsituacao);
    app.callController({
        method: 'GET',
        url: base + '/get-agendamento',
        params: { idsituacao: idsituacao },
        onSuccess(res) {
            //console.log('Resposta do servidor:', res);
            const dados = res[0].ret;
            Table(dados, idsituacao)

        },
        onFailure(res) {
            Swal.fire({
                icon: "error",
                title: "Atenção!!",
                text: "Erro ao listar Agendamentos!"
            });
            return;
        }
    });
}


const Table = function (dados, idsituacao) {

    //var dados = JSON.parse(ret)
    $('#mytable').DataTable({
        responsive: true,
        stateSave: true,
        "bDestroy": true,
        language: {
            url: "https://cdn.datatables.net/plug-ins/1.10.25/i18n/Portuguese-Brasil.json"
        },
        select: true,
        dom: 'Bfrtip',
        buttons: [
            {
                extend: 'copyHtml5',
                exportOptions: {
                    columns: [0, 1, 2, 3, 4, 5, 6] // Exporta somente as colunas escolhidas para planilha 
                }
            },
            {
                extend: 'excelHtml5',
                title: 'AGENDAMENTO',
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
                title: 'AGENDAMENTO',
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
                title: 'ID',
                data: 'idsolicitacao',
            },
            {
                title: 'CD',
                data: 'centro_distribuicao'
            },
            {
                title: 'Transportadaora',
                data: 'transportadora'
            },
            {
                title: 'Placa',
                data: 'placa',
                render: function(data) {
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
                    return '<button style="width: 100%;" class="btn btn-primary btn-sm" onclick="abrirModalObs(' + dados + ')">Observação</button> '
                }
            },
            {
                title: 'Ações',
                data: null, // Usamos `null` se não há uma propriedade específica para essa coluna no objeto de dados.
                render: function (data, type, row) {
                    dados = JSON.stringify(row).replace(/"/g, '&quot;');
                   
                    return '<button style="width: 100%;" class="btn btn-primary btn-sm" onclick="abriModalReagendar(' + dados + ')">Reagendar</button> '
                },
                visible: idsituacao === 4 || idsituacao ===5  
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
        rowCallback: function (row, data) {
            $(row).addClass('linha' + data.idfilial);
        },
        initComplete: function(settings, json) {
            const column = this.api().column(8); // Índice da coluna "Ações"
            // Define a visibilidade da coluna "Ações"
            column.visible(idsituacao === 4 || idsituacao === 5);
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

    opp = $('.obshist');
    opp.html('');

    if(parseInt(dados.idsituacao) == 1){
        $('#observacaoModal').modal('show');
        opp.append("<tr><td>" + dados.observacao + "</td><td>" + dados.situacao + "</td><td>" + dados.dataagendamento + "</td></tr>");
        return
    }

    if(dados.observacoes){
        observacoes =       dados.observacoes.split('|');
        situacao_operacao = dados.situacao_operacao.split('|');
        dataoperacao        = dados.dataoperacao.split('|');
   }
       
   $('#observacaoModal').modal('show');
    
   for (let i = 0; i < observacoes.length; i++) {
       
       let observacao = observacoes[i] ? observacoes[i] : '';
       let situacao = situacao_operacao[i] ? situacao_operacao[i] : '';
       let data = dataoperacao[i] ? dataoperacao[i] : '';
       opp.append("<tr><td>" + observacao + "</td><td>" + situacao + "</td><td>" + data + "</td></tr>");
   }
}

function fechaModalObs() {
    $('#conteudo_obs').text('')
    $('#observacaoModal').modal('hide');

}

// Função para contar as solicitações para todos os cards no carregamento
function contarSolicitacoes() {
    // Verifica a contagem de cada tipo de situação (1: pendentes, 2: andamento, etc.)
    [1, 2, 3, 4, 5].forEach(idsituacao => {
        app.callController({
            method: 'GET',
            url: base + '/get-agendamento',
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
            $('#canceladasCount').text(`${count} solicitações recusadas`);
            break;
    }
}



function abriModalReagendar(dados) {
    $('#modalReagendar').modal('show');
    $('#idsolicitacao').val(dados.idsolicitacao);

}

function fecharModalReagendar(){
    $('#idsolicitacao').val('');
    $('#dataReagendamento').val('');
    $('#modalReagendar').modal('hide');
}


function reagendar(){

    let dados = {
        idsolicitacao: $('#idsolicitacao').val(),
        dataReagendamento: $('#dataReagendamento').val(),
        observacao: $('#observacao').val(),

    }
    
    if (!app.validarCampos(dados)) {
        Swal.fire({
            icon: "warning",
            title: "Atenção!!",
            text: "Preencha todos os campos!"
        });
        return
    }
    
    let dataReagendar = new Date(dados.dataReagendamento + 'T00:00:00'); 
    let hoje = new Date();
    hoje.setHours(0, 0, 0, 0); 

    if (dataReagendar < hoje) {
        Swal.fire({
            icon: "warning",
            title: "Atenção!!",
            text: "A data do Reagendamento não pode ser anterior à data de hoje!"
        });
        return;
    }

    let dataLimite = new Date(hoje);
    dataLimite.setDate(hoje.getDate() + 30);

    if (dataReagendar > dataLimite) {
        Swal.fire({
            icon: "warning",
            title: "Atenção!!",
            text: "A data do Reagendamento não pode ser superior a 30 dias a partir de hoje!"
        });
        return;
    }

    let dataFormatada = app.formatarData(dados.dataReagendamento);

    Swal.fire({
        title: "Tem certeza?",
        text: "Deseja Reagendar essa solicitação para a data " + dataFormatada+ " ?",
        icon: "warning",
        showCancelButton: true,
        confirmButtonColor: "#3085d6",
        cancelButtonColor: "#d33",
        confirmButtonText: "Sim, Reagendar!"
      }).then((result) => {
        if (result.isConfirmed) {
         
            app.callController({
                method: 'POST',
                url: base + '/reagendar',
                params: { idsolicitacao: dados.idsolicitacao, data: dados.dataReagendamento, observacao: dados.observacao },
                onSuccess(res) {
                    listar(1)
                    Swal.fire({
                        title: "Sucesso!",
                        text: "Solicitação Reagendada com Sucesso!",
                        icon: "success"
                    });
                    fecharModalReagendar()
                    contarSolicitacoes()
        
                },
                onFailure(res) {
                    Swal.fire({
                        icon: "error",
                        title: "Atenção!!",
                        text: "Erro ao Reagendar!"
                    });
                    return;
                }
            });
        


         
       
        }
      })

}