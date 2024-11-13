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
            /*
            {
                extend: 'copyHtml5',
                className: 'btn btn-primary'
            },
            {
                extend: 'excelHtml5',
                className: 'btn btn-primary'
            },
            {
                extend: 'csvHtml5',
                className: 'btn btn-primary'
            },
            {
                extend: 'pdfHtml5',
                className: 'btn btn-primary'
            },
            {
                extend: 'print',
                className: 'btn btn-primary'
            },
            {
                extend: 'colvis',
                className: 'btn btn-primary'
            }
            */
        ],
        lengthMenu: [
            [10, 100, 500, -1],
            [10, 100, 500, "All"]
        ],
        data: dados, //dados,
        columns: [
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
        rowCallback: function(row, data) {
            $(row).addClass('linha' + data.idfilial);
        }
    });

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

