$(document).ready(function () {
    buscaNegocio()
    buscaTransportadora()
    listar();
    validarCampoNumerico('#nota');
    validarCampoNumerico('#nota2');

    $('#solicitarIndenizacaoModal').modal({
        backdrop: 'static',
        keyboard: false
    });
});

$('#anexo').on('change', function() {
    const fileName = $(this).val().split('\\').pop() || "Nenhum arquivo escolhido";
    $('#file-chosen').text(fileName);
});

$('#solicitar').on('click', function () {
    let dados = {
        numero_nota: $('#nota').val(),
        numero_nota2: $('#nota2').val(),
        idnegocio: $('#idnegocio').val(),
        tipo_indenizacao: $('#tipoindenizacao').val(),
        idfilial: $('#idfilial').val(),
        anexo: $('#anexo').val(),
        data: $('#data').val(),
        observacao: $('#observacao').val()
    }
    console.log(dados)
    if (!app.validarCampos(dados)) {
        Swal.fire({
            icon: "warning",
            title: "Atenção!!",
            text: "Preencha todos os campos!"
        });
        return
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

    solicitar(dados)


})
function validarCampoNumerico(campoId) {
    $(campoId).on('input', function() {
        this.value = this.value.replace(/\D/g, '');
    });
}

function limparCampos() {
    $('#nota').val(''),
    $('#nota2').val(''),
    $('#idnegocio').val(''),
    $('#tipoindenizacao').val(''),
    $('#idfilial').val(''),
    $('#anexo').val('')
    $('#data').val('')
    $('#observacao').val('')
}

function solicitar(dados) {
    app.callController({
        method: 'POST',
        url: base + '/solicitar-indenizacao',
        params: {
            numero_nota: dados.numero_nota,
            numero_nota2: dados.numero_nota2,
            idnegocio: dados.idnegocio,
            tipo_indenizacao: dados.tipo_indenizacao,
            idfilial: dados.idfilial,
            anexo: dados.anexo,
            data: dados.data,
            observacao: dados.observacao
        },
        onSuccess(res) {
            
            let rec = res[0]

            if (rec.success) {
                Swal.fire({
                    icon: "success",
                    title: "Sucesso!",
                    text: "Indenização solicitada com sucesso!"
                });
                limparCampos()
                fechaModalIndenizacao()
                listar()
            } else {
                Swal.fire({
                    icon: "error",
                    title: "Atenção!!",
                    text: "Erro ao solicitar indenizações!"
                });
                limparCampos()
                return
            }
        },
        onFailure(res) {
            console.log(res)
            Swal.fire({
                icon: "error",
                title: "Atenção!!",
                text: "Erro ao solicitar!"
            });
            limparCampos()
            return
        }
    })
}

function buscaNegocio() {
    console.log('chego aq')
    app.callController({
        method: 'GET',
        url: base + '/get-negocio-ativos',
        params: null,
        onSuccess(res) {
            //console.log(res)
            let rec = res[0].ret
            oppp = $('.oppp');
            oppp.html('');
            if (rec != '') {
                oppp.append("<option id='filial' value=''>Selecione</option>")
                $.each(rec, function (i, el) {
                    oppp.append("<option id='filial' value='" + el.idfilial + "' >" + el.descricao + "</option>")
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


function buscaTransportadora() {
    console.log('chego aq')
    app.callController({
        method: 'GET',
        url: base + '/get-transportadora-ativos',
        params: null,
        onSuccess(res) {
            console.log(res)
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

function listar() {
    app.callController({
        method: 'GET',
        url: base + '/get-indenizacao-cd',
        params: null,
        onSuccess(res) {
            console.log(res)
            Table(res[0].ret)
        },
        onFailure(res) {
            Swal.fire({
                icon: "error",
                title: "Atenção!!",
                text: "Erro ao listar indenizações!"
            });
            return;
        }
    });
}

const Table = function(ret){
    var dados = ret
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
                title: 'Indenizacações',
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
                render: function(data) {
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
                        case 7: statusClass = 'status-finalizado'; break;
                        case 6: statusClass = 'status-contestacao'; break;
                        case 9: statusClass = 'status-faturado'; break;
                        case 10: statusClass = 'status-recusado'; break;
                        default: statusClass = '';
                    }

                    return `<span class="${statusClass}">${data}</span>`;
                }
            },
            {
                title: 'Observacao',
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
        ],
        columnDefs: [
            {
                targets: [0], 
                width: '1px' 
            },
            {
                targets: [1], 
                width: '1px' 
            },
            {
                targets: [2], 
                width: '1px' 
            },
            {
                targets: [3], 
                width: '1px' 
            },
            {
                targets: [4], 
                width: '1px'
            },
            {
                targets: [5],
                width: '1px'
            }
            ,
            {
                targets: [6],
                width: '1px'
            }
        ],
        rowCallback: function(row, data) {
            $(row).addClass('linha' + data.idfilial);
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
function fechaModalIndenizacao() {
    $('#solicitarIndenizacaoModal').modal('hide'); // Fecha o modal

    // Limpar campos
    $('#nota').val('');
    $('#nota2').val('');
    $('#idnegocio').val('');
    $('#tipoindenizacao').val('');
    $('#idfilial').val('');
    $('#data').val('');
    $('#observacao').val('');
    $('#anexo').val(''); // Limpar arquivo
    $('#file-chosen').text("Nenhum arquivo escolhido"); // Resetar texto
}

